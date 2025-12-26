<?php

namespace App\Http\Controllers\Testimonial;


use App\Http\Controllers\Controller;
use App\Models\TestimonialSection;
use Illuminate\Http\Request;

class TestimonialSectionController extends Controller
{
    public function update(Request $request) {
    $section = TestimonialSection::first();
    if (!$section) {
        $section = TestimonialSection::create([
            'title' => $request->input('title', 'Testimonials'),
            'subtitle' => $request->input('subtitle', ''),
        ]);
    } else {
        $section->update($request->validate([
            'title' => 'required|string|max:120',
            'subtitle' => 'nullable|string|max:255',
        ]));
    }
    return redirect()->back()->with('section_success', 'Section updated');
}

}
