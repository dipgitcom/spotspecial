<?php

namespace App\Http\Controllers\Api\Testimonial;

use App\Http\Controllers\Controller;
use App\Models\TestimonialSection;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index()
    {
        $section = TestimonialSection::first();
        $testimonials = Testimonial::orderBy('order')->get()->map(function ($testimonial) {
            return [
                'id'       => $testimonial->id,
                'quote'    => $testimonial->quote,
                'author'   => $testimonial->author,
                'location' => $testimonial->location,
                'order'    => $testimonial->order,
            ];
        });

        return response()->json([
            'section' => [
                'title'    => $section->title ?? '',
                'subtitle' => $section->subtitle ?? '',
            ],
            'testimonials' => $testimonials,
        ]);
    }
}
