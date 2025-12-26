<?php

namespace App\Http\Controllers\Footer;


use App\Http\Controllers\Controller;
use App\Models\FooterSetting;
use Illuminate\Http\Request;
use App\Models\FooterLink;


class FooterController extends Controller
{
    public function edit()
    {
        $footer = FooterSetting::first();
        return view('backend.layouts.footer.edit', compact('footer'));
    }
    public function update(Request $request, $id)
    {
        $footer = FooterSetting::findOrFail($id);
        $footer->update([
            'copyright' => $request->input('copyright'),
            'right_links' => $request->input('right_links'),
        ]);
        return redirect()->back()->with('success', 'Footer updated.');
    }

    public function links()
{
    $footer = FooterSetting::first();
    $links = FooterLink::orderBy('order')->get();
    return view('backend.layouts.footer.edit', compact('footer', 'links'));
}

public function storeLink(Request $request)
{
    FooterLink::create($request->validate([
        'label'=>'required|string',
        'url'=>'required|string',
        'order'=>'nullable|integer'
    ]));
    return back()->with('success', 'Footer link added.');
}

public function updateLink(Request $request, FooterLink $link)
{
    $link->update($request->validate([
        'label'=>'required|string',
        'url'=>'required|string',
        'order'=>'nullable|integer'
    ]));
    return back()->with('success', 'Footer link updated.');
}

public function destroyLink(FooterLink $link)
{
    $link->delete();
    return back()->with('success', 'Footer link deleted.');
}

}

