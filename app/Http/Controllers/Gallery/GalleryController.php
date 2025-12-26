<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::orderBy('order')->get();
        $section = \App\Models\GallerySection::first();

        return view('backend.layouts.gallery.index', compact('galleries', 'section'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'caption' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'order' => 'nullable|integer',
        ]);
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('galleries', 'public');
        }
        Gallery::create($validated);

        return redirect()->route('galleries.index')->with('success', 'Gallery item added');
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'caption' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'order' => 'nullable|integer',
        ]);
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('galleries', 'public');
        }
        $gallery->update($validated);

        return redirect()->route('galleries.index')->with('success', 'Gallery item updated');
    }

    public function destroy(Gallery $gallery)
    {
        // Optionally: Storage::disk('public')->delete($gallery->image);
        $gallery->delete();

        return redirect()->route('galleries.index')->with('success', 'Gallery item deleted');
    }
}
