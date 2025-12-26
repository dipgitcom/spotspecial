<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;

class HeroSectionController extends Controller
{
    // API endpoint to get hero section data with full URLs for images
    public function show($key = 'main')
    {
        $section = HeroSection::where('section_key', $key)->first();

        if (! $section) {
            return response()->json(['message' => 'Hero section not found'], 404);
        }

        // HeroSection model e jodi casts thake:
        // 'features' => 'array', 'buttons' => 'array', 'panel' => 'array'
        // tahole toArray() diye already array pabe.
        $data = $section->toArray();

        // ensure features is plain indexed array
        if (! empty($data['features'] ?? [])) {
            $data['features'] = array_values($data['features']);

            // Convert feature icon images to full URLs
            foreach ($data['features'] as &$feature) {
                if (! empty($feature['icon'])) {
                    $feature['icon'] = asset($feature['icon']);
                }
            }
        }

        // ensure panel.shots is plain indexed array
        if (! empty($data['panel']['shots'] ?? [])) {
            $data['panel']['shots'] = array_values($data['panel']['shots']);

            // Convert panel shots images to full URLs
            foreach ($data['panel']['shots'] as &$shot) {
                if (! empty($shot['image'])) {
                    $shot['image'] = asset($shot['image']);
                }
            }
        }

        return response()->json($data);
    }

    // API endpoint to update hero section data including file uploads
    public function update(Request $request, $key = 'main')
    {
        $data = $request->validate([
            'badge'                    => 'nullable|string|max:255',
            'headline'                 => 'required|string|max:255',
            'description'              => 'nullable|string|max:800',
            'rating'                   => 'nullable|string|max:100',

            'features'                 => 'array',
            'features.*.icon'          => 'nullable|file|image|max:2048',
            'features.*.icon_old'      => 'nullable|string',
            'features.*.text'          => 'required|string|max:5000', // allow more length for HTML

            'buttons'                  => 'array',
            'buttons.*.text'           => 'required|string|max:50',
            'buttons.*.type'           => 'nullable|string|max:20',
            'buttons.*.url'            => 'nullable|string|max:255',

            'panel.kicker'             => 'nullable|string|max:120',
            'panel.shots'              => 'array',
            'panel.shots.*.caption'    => 'required|string|max:80',
            'panel.shots.*.image'      => 'nullable|file|image|max:2048',
            'panel.shots.*.image_old'  => 'nullable|string',
        ]);

        /*
         * FEATURES
         */
        $features = $data['features'] ?? [];

        foreach ($features as $index => &$feature) {
            if ($request->hasFile("features.$index.icon")) {

                // Delete old file if exists
                if (! empty($feature['icon_old']) && file_exists(public_path($feature['icon_old']))) {
                    @unlink(public_path($feature['icon_old']));
                }

                $file = $request->file("features.$index.icon");
                $destination = public_path('hero_section/features');

                if (! file_exists($destination)) {
                    mkdir($destination, 0755, true);
                }

                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move($destination, $filename);

                $feature['icon'] = 'hero_section/features/' . $filename;
            } else {
                // keep old path
                $feature['icon'] = $feature['icon_old'] ?? ($feature['icon'] ?? null);
            }

            unset($feature['icon_old']);
        }

        // Remove fully empty features
        $features = array_values(
            array_filter($features, fn ($f) => ! empty($f['icon']) || ! empty($f['text']))
        );

        /*
         * PANEL + SHOTS
         */
        $panel = $data['panel'] ?? [];
        $shots = $panel['shots'] ?? [];

        foreach ($shots as $i => &$shot) {
            if ($request->hasFile("panel.shots.$i.image")) {

                if (! empty($shot['image_old']) && file_exists(public_path($shot['image_old']))) {
                    @unlink(public_path($shot['image_old']));
                }

                $file = $request->file("panel.shots.$i.image");
                $destination = public_path('hero_section/panel');

                if (! file_exists($destination)) {
                    mkdir($destination, 0755, true);
                }

                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move($destination, $filename);

                $shot['image'] = 'hero_section/panel/' . $filename;
            } else {
                $shot['image'] = $shot['image_old'] ?? ($shot['image'] ?? '');
            }

            unset($shot['image_old']);
        }

        // reindex shots: [0 => ..., 1 => ...]
        $panel['shots'] = array_values($shots);

        /*
         * SAVE
         */
        $heroSection = HeroSection::updateOrCreate(
            ['section_key' => $key],
            [
                'badge'       => $data['badge'] ?? '',
                'headline'    => $data['headline'],
                'description' => $data['description'] ?? '',
                // store as JSON / array depending on casts
                'features'    => $features,
                'buttons'     => $data['buttons'] ?? [],
                'rating'      => $data['rating'] ?? '',
                'panel'       => $panel,
            ]
        );

        return response()->json([
            'message' => 'Hero Section updated!',
            'data'    => $heroSection->fresh(),
        ]);
    }
}
