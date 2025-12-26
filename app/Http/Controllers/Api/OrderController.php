<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Order;
use App\Models\Inventory;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Models\OrderItemDetail;
use App\Models\OrderBillingInfo;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    use ApiResponse;
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required',
            'email'             => 'required|email',
            'phone'             => 'required',
            'address'           => 'required',
            'town'              => 'required',
            'state'             => 'required',
            'zipcode'           => 'required',
            'cart'              => 'required|array',
            'cart.*.product_id' => 'required|integer|exists:products,id',
            'cart.*.quantity'   => 'required|integer|min:1',
            'subtotal'          => 'required|numeric',
            'charge'            => 'required|numeric',
            'total'             => 'required|numeric',
            'payment_method'    => 'required|in:cod,stripe',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 'Error in Validation', 422);
        }

        DB::beginTransaction();

        try {
            $cart = $request->cart;

            // Generate unique order number
            // $orderNumber = 'ORD-' . strtoupper(Str::random(10));

            function generateOrderNumber()
            {
                $lastOrder = Order::latest()->first();
                $nextNumber = $lastOrder
                    ? ((int) str_replace('ORD-', '', $lastOrder->order_number)) + 1
                    : 1;

                return 'ORD-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
            }


            $order = Order::create([
                'user_id'         => Auth::id(),
                'order_number'    => generateOrderNumber(),
                'payment_method'  => $request->payment_method,
                'sub_total'       => $request->subtotal,
                'shipping_cost'   => $request->charge,
                'total_amount'    => $request->total,
                'placed_at'       => now(),
                'is_paid'         => $request->payment_method === 'cod' ? false : true,
                'payment_status'  => $request->payment_method === 'cod' ? 'pending' : 'completed',
            ]);

            // Save billing info
            OrderBillingInfo::create([
                'order_id' => $order->id,
                'name'     => $request->name,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'address'  => $request->address,
                'town'     => $request->town,
                'state'    => $request->state,
                'zipcode'  => $request->zipcode,
            ]);

            foreach ($cart as $item) {
                $inventory = Inventory::find($item['product_id']);

                if (!$inventory) {
                    return $this->error([], 'Inventory not found for product ID: ' . $item['product_id'], 404);
                }

                if ($item['quantity'] > $inventory->quantity) {
                    return $this->error([], 'Product quantity out of stock for product ID: ' . $item['product_id'], 404);
                }
            }


            foreach ($cart as $item) {
                OrderItemDetail::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                ]);

                $inventory = Inventory::find($item['product_id']);
                $inventory->quantity -= $item['quantity'];
                $inventory->save();
            }


            DB::commit();

            return $this->success([], 'Order created successfully', 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->error([], $e->getMessage(), 500);
        }
    }


    public function orderHistory(Request $request)
    {
        $orders = Order::with('items.product', 'billing')
            ->where('user_id', Auth::guard('api')->id())
            ->get();


        $data = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'total_amount' => $order->total_amount,
                'status' => $order->status,
                'items' => $order->items->map(function ($item) {
                    return [
                        'product_id' => $item->product_id,
                        'name' => $item->product->product_name,
                        'thumbnail' => $item->product->product_image,
                    ];
                }),
                'billing' => [
                    'name' => $order->billing->name,
                    'email' => $order->billing->email,
                    'phone' => $order->billing->phone,
                    'address' => $order->billing->address,
                    'town' => $order->billing->town,
                    'state' => $order->billing->state,
                    'zipcode' => $order->billing->zipcode,
                ],
            ];
        });

        return $this->success($data, 'Order history', 200);
    }
}
