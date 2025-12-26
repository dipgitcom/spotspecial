<?php

namespace App\Http\Controllers\Api;


use App\Models\Review;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserReview;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{

    use ApiResponse;
    public function getReview(Request $request)
    {
        $reviews = UserReview::with('user', 'product')->where('status', 1)->select('id', 'user_id', 'product_id',  'review_content', 'rating_point')->get();

        return response()->json($reviews);
        if ($reviews->count() > 0) {
            return $this->success($reviews, 'Review retrieved successfully', 200);
        }
        return $this->success([], 'Review not found', 200);
    }


    public function storeReview(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'review_content' => 'required | string | max:512',
            'rating_point' => 'required | numeric | min:2 | max:5',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 'Validation Error', 422);
        };

        $review = UserReview::create([
            'user_id' => Auth::user()->id,
            'product_id' => $request->product_id,
            'review_content' => $request->review_content,
            'rating_point' => $request->rating_point
        ]);

        return $this->success($review, 'Review created successfully', 200);
    }

    public function getAdminReview(Request $request)
    {
        $reviews = Review::where('status', 1)->select('id',  'name', 'profession', 'photo',  'review_content', 'rating_point')->get();

        $reviews->map(function ($review) {
            $review->photo = asset($review->photo);
        });

        if ($reviews->count() > 0) {
            return $this->success($reviews, 'Review retrieved successfully', 200);
        }
        return $this->success([], 'Review not found', 200);
    }
}
