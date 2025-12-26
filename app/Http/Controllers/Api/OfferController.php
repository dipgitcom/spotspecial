<?php

namespace App\Http\Controllers\Api;

use App\Models\Offer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;

class OfferController extends Controller
{
    use ApiResponse;
    public function  allOffer(Request $request)
    {
        $offers = Offer::where('status', 1)->select('offer_name', 'image')->get();
        collect($offers)->each(function ($offer) {
            $offer->image = asset($offer->image);
        });
        if ($offers->count() > 0) {
            return $this->success($offers, 'All Available Offers retrieved successfully', 200);
        }
        return $this->success([], ' Offer not available', 200);
    }
}
