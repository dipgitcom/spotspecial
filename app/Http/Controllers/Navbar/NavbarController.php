<?php
namespace App\Http\Controllers\Navbar;

use App\Http\Controllers\Controller;
use App\Models\NavbarSetting;
use App\Models\NavItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NavbarController extends Controller
{
   public function index()
    {
        $navbarSetting = NavbarSetting::first();
        $navItems = NavItem::orderBy('order')->get();

        $recentNavbarSetting = NavbarSetting::orderBy('updated_at', 'desc')->first();
        $recentNavItems = NavItem::orderBy('updated_at', 'desc')->take(5)->get();

        return view('backend.layouts.navbar.index', compact(
            'navbarSetting',
            'navItems',
            'recentNavbarSetting',
            'recentNavItems'
        ));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'logo' => 'nullable|image',
        ]);

        $navbarSetting = NavbarSetting::first() ?? new NavbarSetting();

        if ($request->hasFile('logo')) {
            if ($navbarSetting->logo) {
                \Storage::disk('public')->delete($navbarSetting->logo);
            }
            $filePath = $request->file('logo')->store('logos', 'public');
            $navbarSetting->logo = $filePath;
        }

        $navbarSetting->name = $data['name'];
        $navbarSetting->phone = $data['phone'];

        $navbarSetting->save();

        return redirect()->route('admin.navbar.index')->with('success', 'Navbar settings updated successfully.');
    }
    // NavItem CRUD actions below:

    public function navItems()
    {
        return NavItem::orderBy('order')->get();
    }

    public function navItemStore(Request $request)
{
    $data = $request->validate([
        'title' => 'required|string',
        'url' => 'required|string',
        'order' => 'nullable|integer',
        'is_active' => 'required|boolean',
    ]);
    NavItem::create($data);
    return redirect()->route('admin.navbar.index')->with('success', 'Nav item added successfully.');
}


    public function navItemUpdate(Request $request, $id)
{
    $navItem = NavItem::findOrFail($id);
    $data = $request->validate([
        'title' => 'required|string',
        'url' => 'required|string',
        'order' => 'nullable|integer',
        'is_active' => 'required|boolean',
    ]);
    $navItem->update($data);
    return redirect()->route('admin.navbar.index')->with('success', 'Nav item updated successfully.');
}


   public function navItemDelete($id)
{
    $navItem = NavItem::findOrFail($id);
    $navItem->delete();

    return redirect()->route('admin.navbar.index')
        ->with('success', 'Nav item deleted successfully.');
}

}
