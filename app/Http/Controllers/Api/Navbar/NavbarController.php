<?php

namespace App\Http\Controllers\Api\Navbar;

use App\Http\Controllers\Controller;
use App\Models\NavbarSetting;
use App\Models\NavItem;

class NavbarController extends Controller
{
    public function show()
    {
        // Fetch the settings (including logo full URL if set)
        $navbar = NavbarSetting::first();
        $items = NavItem::orderBy('order')->get();

        // Prepend asset() so logo has full url, or null
        $logoUrl = $navbar && $navbar->logo ? asset('storage/' . $navbar->logo) : null;

        return response()->json([
            'settings' => [
                'logo' => $logoUrl,
                'name' => $navbar->name ?? '',
                'phone' => $navbar->phone ?? '',
            ],
            'items' => $items
        ]);
    }
}
