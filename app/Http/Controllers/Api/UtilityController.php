<?php

namespace App\Http\Controllers\Api;

use App\Models\Social;
use App\Models\Wishlist;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DynamicPage;
use App\Models\System;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UtilityController extends Controller
{
    use ApiResponse;

    public function getLogo()
    {
        $logo = System::select('logo')->first();
        if (!$logo) {
            return $this->error([], 'Logo not found', 404);
        }
        return $this->success(['logo' => asset($logo->logo)], 'Logo fetched successfully', 200);
    }


    public function getFavicon()
    {
        $favicon = System::select('favicon')->first();
        if (!$favicon) {
            return $this->error([], 'Favicon not found', 404);
        }
        return $this->success(['favicon' => asset($favicon->favicon)], 'Favicon fetched successfully', 200);
    }


    public function getAllDynamicPage()
    {
        $dynamicPages = DynamicPage::select('id', 'title')->get();
        if (!$dynamicPages) {
            return $this->error([], 'Dynamic pages not found', 404);
        }
        return $this->success($dynamicPages, 'Dynamic pages fetched successfully', 200);
    }


    public function getDynamicPageContent($id)
    {
        if (!$id) {
            return $this->error([], 'Dynamic page ID is required', 400);
        }

        $dynamicPage = DynamicPage::find($id);

        if (!$dynamicPage) {
            return $this->error([], 'Dynamic page not found', 404);
        }

        $data = [
            'id'      => $dynamicPage->id,
            'title'   => $dynamicPage->title,
            'content' => $dynamicPage->content,
        ];

        return $this->success($data, 'Dynamic single page content fetched successfully', 200);
    }

    public function social()
    {
        $social = Social::select('name', 'url')->get();
        if (!$social) {
            return $this->success([], 'Social url not found', 200);
        }
        return $this->success($social, 'Social url fetched successfully', 200);
    }



    public function wishList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 'Validation Error', 422);
        }

        $wishlist  = Wishlist::updateOrCreate(
            [
                'product_id' => $request->product_id,
                'user_id' => Auth::user()->id,
            ],
            [
                'product_id' => $request->product_id,
                'user_id' => Auth::user()->id,
            ]
        );

        if ($wishlist) {

            $response = [
                'id' => $wishlist->id,
                'product_id' => $wishlist->product_id,
                'user_id' => $wishlist->user_id,
            ];
            return $this->success($response, 'Product added to wishlist successfully', 200);
        }
        return $this->success((object)[], 'Product not added to wishlist', 200);
    }




    public function getWishlist(Request $request)
    {
        $userId = Auth::guard('api')->id();

        $wishlist = Wishlist::with('product')
            ->where('user_id', $userId)
            ->get();


        $data = $wishlist->map(function ($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->product_name ?? null,
                'regular_price' => $item->product->regular_price ?? null,
                'discount_price' => $item->product->discount_price ?? null,
                'product_image' => asset($item->product->product_image) ?? null,

            ];
        });

        return $this->success($data, 'Wishlist fetched successfully', 200);
    }
}
