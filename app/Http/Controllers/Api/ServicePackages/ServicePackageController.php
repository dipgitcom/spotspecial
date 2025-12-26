<?php

namespace App\Http\Controllers\Api\ServicePackages;

use App\Http\Controllers\Controller;
use App\Models\ServicePackage;
use Illuminate\Http\Request;

class ServicePackageController extends Controller
{
    public function index()
    {
        $section = \App\Models\ServicePackageSection::first();
        $packages = ServicePackage::all()->map(function ($package) {
            return [
                'id' => $package->id,
                'title' => $package->title,
                'price' => $package->price,
                'subtitle' => $package->subtitle,
                // Laravel casts it as array automatically if set in model
                'features' => is_array($package->features) ? $package->features : json_decode($package->features, true),
                'button_text' => $package->button_text,
                'button_url' => $package->button_url,
                'type' => $package->type,
            ];
        });

        return response()->json([
        'section' => $section,
        'packages' => $packages,
    ]);
    }

   public function show($id)
{
    $package = ServicePackage::findOrFail($id);

    return response()->json([
        'id' => $package->id,
        'title' => $package->title,
        'price' => $package->price,
        'subtitle' => $package->subtitle,
        'features' => $package->features, // already cast to array
        'button_text' => $package->button_text,
        'button_url' => $package->button_url,
        'type' => $package->type,
    ]);
}

public function store(Request $request)
{
    $data = $request->validate([
        'title' => 'required|string|max:100',
        'price' => 'required|string|max:40',
        'subtitle' => 'nullable|string',
        'features' => 'required|array',
        'features.*' => 'required|string',
        'button_text' => 'nullable|string|max:60',
        'button_url' => 'nullable|string|max:255',
        'type' => 'nullable|string',
    ]);
    $data['features'] = json_encode($data['features']);
    $package = ServicePackage::create($data);
    return response()->json($package, 201);
}

public function update(Request $request, $id)
{
    $package = ServicePackage::findOrFail($id);
    $data = $request->validate([
        'title' => 'required|string|max:100',
        'price' => 'required|string|max:40',
        'subtitle' => 'nullable|string',
        'features' => 'required|array',
        'features.*' => 'required|string',
        'button_text' => 'nullable|string|max:60',
        'button_url' => 'nullable|string|max:255',
        'type' => 'nullable|string',
    ]);
    $data['features'] = json_encode($data['features']);
    $package->update($data);
    return response()->json($package);
}
public function destroy($id)
{
    $package = ServicePackage::findOrFail($id);
    $package->delete();
    return response()->json(null, 204);
}

}
