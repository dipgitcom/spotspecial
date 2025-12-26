<?php

namespace App\Http\Controllers\Api\Navbar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NavItem;

class NavItemController extends Controller
{
    public function index() {
        return NavItem::orderBy('order')->get();
    }

    public function store(Request $request) {
        $data = $request->validate([
            'title' => 'required|string',
            'url' => 'required|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);
        $navItem = NavItem::create($data);
        return response()->json($navItem);
    }

    public function update(Request $request, NavItem $navItem) {
        $data = $request->validate([
            'title' => 'required|string',
            'url' => 'required|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);
        $navItem->update($data);
        return response()->json($navItem);
    }

    public function destroy(NavItem $navItem) {
        $navItem->delete();
        return response()->json(['message' => 'deleted']);
    }
}
