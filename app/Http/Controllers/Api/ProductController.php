<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use ApiResponse;


    public function featuredProducts(Request $request)
    {
        $products = Product::where('product_type', 'featured')->where('status', 1)->select('id', 'product_name', 'product_image', 'regular_price')->get();

        collect($products)->each(function ($product) {
            $product->product_image = asset($product->product_image);
        });

        if ($products->count() > 0) {
            return $this->success($products, 'Featured Products retrieved successfully', 200);
        }
        return $this->success([], 'Featured Products not found', 200);
    }


    public function  allProducts(Request $request)
    {
        $products = Product::where('product_type', 'featured')->where('status', 1)->select('id', 'product_name', 'product_image', 'regular_price', 'discount_price')->get();
        collect($products)->each(function ($product) {
            $product->product_image = asset($product->product_image);
        });
        if ($products->count() > 0) {
            return $this->success($products, 'All Products retrieved successfully', 200);
        }
        return $this->success([], 'Any Products not Available', 200);
    }


    public function  productDetails(Request $request)
    {

        $product = Product::with([
            'inventory',
            'galleries'
        ])->find($request->id);

        if (!$product) {
            return $this->success([], 'Product Details not available', 200);
        }


        $product->product_image = asset($product->product_image);


        $galleryImages = $product->galleries->map(function ($image) {
            return ['image_path' => asset($image->image_path)];
        })->toArray();


        $allImages = array_merge(
            [['image_path' => $product->product_image, 'type' => 'feature_image']],
            $galleryImages
        );

        $product->gallery_images = $allImages;

        return $this->success($product, 'Product retrieved successfully', 200);
    }



    public function relatedProduct(Request $request)
    {
        $product = Product::find($request->id);

        if (!$product) {
            return $this->success([], 'Related Product not available', 200);
        }

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->get();

        if ($relatedProducts->count() > 0) {
            $formattedProducts = $relatedProducts->map(function ($product) {
                return [
                    'id' => $product->id,
                    'product_name' => $product->product_name,
                    'product_image' => asset($product->product_image),
                    'regular_price' => $product->regular_price,
                    'discount_price' => $product->discount_price,
                ];
            });

            return $this->success($formattedProducts, 'Related Products retrieved successfully', 200);
        }

        return $this->success([], 'Related Products not found', 200);
    }


    public function getCartItems(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|array',
        ]);

        if ($validator->fails()) {
            return $this->success($validator->errors(), 'Cart Items Id Array required', 200);
        }
        if (is_array($request->id)) {
            $cartItems = Product::whereIn('id', $request->id)->get();

            $formattedProducts = $cartItems->map(function ($cartItem) {
                return [
                    'id' => $cartItem->id,
                    'product_name' => $cartItem->product_name,
                    'product_image' => asset($cartItem->product_image),
                    'product_code' => $cartItem->product_code,
                    'weight' => $cartItem->weight,
                    'regular_price' => $cartItem->regular_price,
                    'discount_price' => $cartItem->discount_price,
                ];
            });

            return $this->success($formattedProducts, 'Cart Items retrieved successfully', 200);
        } else {
            return $this->success($request->id, 'Cart Items retrieved successfully', 200);
        }
    }

    public function searchProduct(Request $request)
    {
        $searchValue = $request->search_value;

        $products = Product::where('product_name', 'like', '%' . $searchValue . '%')->get();

        foreach ($products as $product) {

            return [
                'id' => $product->id,
                'product_name' => $product->product_name,
                'product_image' => asset($product->product_image),
                'regular_price' => $product->regular_price,
                'discount_price' => $product->discount_price,
            ];
        }
        if (!$products) {
            return $this->success([], 'Products not available', 200);
        }

        return $this->success($products, 'Products retrieved successfully', 200);
    }
}
