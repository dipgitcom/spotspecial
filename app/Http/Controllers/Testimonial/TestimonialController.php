<?php

namespace App\Http\Controllers\Testimonial;


use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\TestimonialSection;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index() {
        $section = TestimonialSection::first();
        $testimonials = Testimonial::orderBy('order')->get();
        return view('backend.layouts.testimonials.index', compact('section', 'testimonials'));
    }
    public function store(Request $request) {
        $request->validate([
            'quote' => 'required|string',
            'author' => 'required|string|max:60',
            'location' => 'nullable|string|max:60',
            'order' => 'nullable|integer',
        ]);
        Testimonial::create($request->all());
        return redirect()->back()->with('success','Testimonial added');
    }
    public function update(Request $request, Testimonial $testimonial) {
        $request->validate([
            'quote' => 'required|string',
            'author' => 'required|string|max:60',
            'location' => 'nullable|string|max:60',
            'order' => 'nullable|integer',
        ]);
        $testimonial->update($request->all());
        return redirect()->back()->with('success','Testimonial updated');
    }
    public function destroy(Testimonial $testimonial) {
        $testimonial->delete();
        return redirect()->back()->with('success','Testimonial deleted');
    }
}
