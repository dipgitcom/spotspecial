<?php

namespace App\Http\Controllers\Settings;

use App\Models\AdminSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminSettingsController extends Controller
{
    function index()
    {
        $admin = AdminSetting::first(); // Fetch the first admin setting record
        return view('backend.layouts.settings.admin_setting.index', [
            'admin' => $admin,
        ]);
    }

    public function adminSettingUpdate(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'email' => 'nullable|email',
            'logo' => 'nullable|image',
            'favicon' => 'nullable|image',
            'copyright' => 'nullable|string',
            'hotline' => 'nullable|string',
            'address' => 'nullable|string', // ✅ Added
        ]);

        $admin_setting = AdminSetting::first();
        if (!$admin_setting) {
            $admin_setting = new AdminSetting();
        }

        $data = [
            'title' => $request->title,
            'email' => $request->email,
            'copyright' => $request->copyright,
            'hotline' => $request->hotline,
            'address' => $request->address, // ✅ Added
        ];

        // logo handle
        $logoPath = $this->uploadImage($request->logo, $admin_setting->logo, 'uploads/adminlogo');
        $data['logo'] = $logoPath;

        // favicon handle
        $faviconPath = $this->uploadImage($request->favicon, $admin_setting->favicon, 'uploads/adminfavicon');
        $data['favicon'] = $faviconPath;

        if ($admin_setting->exists) {
            $admin_setting->update($data);
        } else {
            AdminSetting::create($data);
        }

        return redirect()->route('admin.setting.index')->with('success', 'Admin Setting updated successfully');
    }
}
