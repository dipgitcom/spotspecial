<?php

namespace App\Http\Controllers\Api\Faq;

use App\Http\Controllers\Controller;
use App\Models\FaqSection;
use App\Models\Faq;
use App\Traits\ApiResponse;

class FaqController extends Controller
{
    use ApiResponse;
    public function index()
    {
        $section = FaqSection::first();
        $faqs = Faq::orderBy('order')->get()->map(function ($faq) {
            return [
                'id' => $faq->id,
                'question' => $faq->question,
                'answer' => $faq->answer,
                'order' => $faq->order,
            ];
        });

        return response()->json([
            'section' => [
                'title' => $section->title ?? '',
                'subtitle' => $section->subtitle ?? '',
            ],
            'faqs' => $faqs,
        ]);
    }
    
}
