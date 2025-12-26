<?php

namespace App\Http\Controllers\Faq;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqSection;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index() {
        $section = FaqSection::first();
        $faqs = Faq::orderBy('order')->get();
        return view('backend.layouts.faqs.index', compact('section', 'faqs'));
    }

    public function store(Request $request) {
        $request->validate([
            'question' => 'required|string',
            'answer'   => 'required|string',
            'order'    => 'nullable|integer',
        ]);
        Faq::create($request->all());
        return redirect()->back()->with('success', 'FAQ added');
    }
    public function update(Request $request, Faq $faq) {
        $request->validate([
            'question' => 'required|string',
            'answer'   => 'required|string',
            'order'    => 'nullable|integer',
        ]);
        $faq->update($request->all());
        return redirect()->back()->with('success', 'FAQ updated');
    }
    public function destroy(Faq $faq) {
        $faq->delete();
        return redirect()->back()->with('success', 'FAQ deleted');
    }
}
