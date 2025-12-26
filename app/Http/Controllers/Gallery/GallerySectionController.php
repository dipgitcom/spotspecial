<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use App\Models\GallerySection;
use Illuminate\Http\Request;

class GallerySectionController extends Controller
{
    public function edit()
{
    // Do NOT use this anymore or just redirect to gallery index
    return redirect()->route('galleries.index');
}

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title'    => 'required|string|max:100',
            'subtitle' => 'nullable|string|max:255',
        ]);
        $section = GallerySection::first();
        $section->update($validated);
        return redirect()->route('galleries.index')->with('section_success', 'Section updated');;
    }
}
