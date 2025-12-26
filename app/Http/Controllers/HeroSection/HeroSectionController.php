<?php

namespace App\Http\Controllers\HeroSection;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;

class HeroSectionController extends Controller
{
    // Show the edit form
    public function edit()
    {
        $section = HeroSection::where('section_key', 'main')->first();
        return view('backend.layouts.hero_section.edit', compact('section'));
    }

    // Handle the update logic
    public function update(Request $request)
    {
        $data = $request->validate([
            'badge' => 'nullable|string|max:255',
            'headline' => 'required|string|max:255',
            'description' => 'nullable|string|max:800',
            'rating' => 'nullable|string|max:100',
            'features' => 'array',
            'features.*.icon' => 'nullable|file|image|max:2048',
            'features.*.icon_old' => 'nullable|string',
            'features.*.text' => 'required|string|max:120',
            'buttons' => 'array',
            'buttons.*.text' => 'required|string|max:50',
            'buttons.*.type' => 'nullable|string|max:20',
            'buttons.*.url' => 'nullable|string|max:255',
            'panel.kicker' => 'nullable|string|max:120',
            'panel.shots' => 'array',
            'panel.shots.*.caption' => 'required|string|max:80',
            'panel.shots.*.image' => 'nullable|file|image|max:2048',
            'panel.shots.*.image_old' => 'nullable|string',
        ]);

        $panel = $data['panel'] ?? [];
        $shots = $panel['shots'] ?? [];

        // Handle panel shots upload
        foreach ($shots as $i => &$shot) {
            if ($request->hasFile("panel.shots.$i.image")) {
                // Delete old image if exists
                if (!empty($shot['image_old']) && file_exists(public_path($shot['image_old']))) {
                    unlink(public_path($shot['image_old']));
                }

                $imgFile = $request->file("panel.shots.$i.image");
                $destination = public_path('hero_section/panel');
                if (!file_exists($destination)) {
                    mkdir($destination, 0755, true);
                }
                $filename = time() . '_' . $imgFile->getClientOriginalName();
                $imgFile->move($destination, $filename);

                $shot['image'] = 'hero_section/panel/' . $filename;
            } else {
                $shot['image'] = $shot['image_old'] ?? ($shot['image'] ?? '');
            }
            unset($shot['image_old']);
        }

        $features = $data['features'] ?? [];

        // Handle feature icon upload
        foreach ($features as $i => &$feature) {
            if ($request->hasFile("features.$i.icon")) {
                // Delete old image if exists
                if (!empty($feature['icon_old']) && file_exists(public_path($feature['icon_old']))) {
                    unlink(public_path($feature['icon_old']));
                }

                $iconFile = $request->file("features.$i.icon");
                $destination = public_path('hero_section/features');
                if (!file_exists($destination)) {
                    mkdir($destination, 0755, true);
                }
                $filename = time() . '_' . $iconFile->getClientOriginalName();
                $iconFile->move($destination, $filename);

                $feature['icon'] = 'hero_section/features/' . $filename;
            } else {
                $feature['icon'] = $feature['icon_old'] ?? null;
            }
            unset($feature['icon_old']);
        }

        $panel['shots'] = $shots;

        
        HeroSection::updateOrCreate(
            ['section_key' => 'main'],
            [
                'badge' => $data['badge'] ?? '',
                'headline' => $data['headline'],
                'description' => $data['description'] ?? '',
                'features' => json_encode($features) ?? [],
                'buttons' => $data['buttons'] ?? [],
                'rating' => $data['rating'] ?? '',
                'panel' => $panel,
            ]
        );

        return redirect()->back()->with('success', 'Hero Section updated!');
    }
}
