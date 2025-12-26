<?php

namespace App\Http\Controllers\Api\Gallery;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GallerySection;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $section = GallerySection::first();

        $images = Gallery::orderBy('order')->get()->map(function ($gallery) {
            $imageUrl = $gallery->image;
            if (! empty($imageUrl) && ! filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                // Always prepend /storage/ if not already present
                if (strpos($imageUrl, '/storage/') !== 0) {
                    $imageUrl = '/storage/'.ltrim($imageUrl, '/');
                }
                $path = str_replace('/storage/', '', $imageUrl);
                if (Storage::disk('public')->exists($path)) {
                    $imageUrl = url($imageUrl); // full domain + /storage/...
                }
            }

            return [
                'id' => $gallery->id,
                'caption' => $gallery->caption,
                'image' => $imageUrl,
                'order' => $gallery->order,
            ];
        });

        return response()->json([
            'section' => [
                'title' => $section->title ?? '',
                'subtitle' => $section->subtitle ?? '',
            ],
            'images' => $images,
        ]);
    }
}
