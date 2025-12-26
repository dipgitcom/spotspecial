<?php

namespace App\Http\Controllers\ServicePackages;

use App\Http\Controllers\Controller;
use App\Models\ServicePackage;
use Illuminate\Http\Request;

class ServicePackageController extends Controller
{
    public function index()
    {
        $packages = ServicePackage::orderBy('id', 'desc')->get();

        return view('backend.layouts.service_packages.index', compact('packages'));
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

        ServicePackage::create($data);

        return redirect()->route('admin.service-packages.index')->with('success', 'Package created');
    }

    public function update(Request $request, ServicePackage $servicePackage)
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
        $servicePackage->update($data);

        return redirect()->route('admin.service-packages.index')->with('success', 'Package updated');
    }

    public function destroy(ServicePackage $servicePackage)
    {
        $servicePackage->delete();

        return redirect()->route('admin.service-packages.index')->with('success', 'Package deleted');
    }

    public function sectionEdit()
    {
        $section = \App\Models\ServicePackageSection::first();

        return view('backend.layouts.service_packages.index', compact('section'));
    }

    public function sectionUpdate(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:120',
            'subtitle' => 'nullable|string|max:255',
        ]);
        $section = \App\Models\ServicePackageSection::first();
        if ($section) {
            $section->update($data);
        } else {
            \App\Models\ServicePackageSection::create($data);
        }

        return redirect()->back()->with('success', 'Section updated');
    }
}
