<?php

namespace App\Http\Controllers\Api;

use App\Models\Banner;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerControlller extends Controller
{
    use ApiResponse;

    public function getBanner()
    {
        $banner  = Banner::where('status', 1)->select('banner_title', 'banner_subtitle', 'button_text', 'button_url', 'banner_image')->first();

        if ($banner) {
            $banner->banner_image = asset($banner->banner_image);
            return $this->success($banner, 'Banner retrieved successfully', 200);
        }
        return $this->success((object)[], 'Banner not found', 200);
    }
}
