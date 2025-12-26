<?php

namespace App\Http\Controllers\WhyUsPanel;

use App\Http\Controllers\Controller;
use App\Models\WhyUsPanel;
use Illuminate\Http\Request;

class WhyUsPanelController extends Controller
{
    public function index()
    {
        $panels = WhyUsPanel::orderBy('order')->get();
        return view('backend.layouts.why_us_panels.index', compact('panels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'order' => 'nullable|integer'
        ]);
        WhyUsPanel::create($request->all());
        return redirect()->back()->with('success', 'Panel added');
    }

    public function update(Request $request, WhyUsPanel $whyUsPanel)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'order' => 'nullable|integer'
        ]);
        $whyUsPanel->update($request->all());
        return redirect()->back()->with('success', 'Panel updated');
    }

    public function destroy(WhyUsPanel $whyUsPanel)
    {
        $whyUsPanel->delete();
        return redirect()->back()->with('success', 'Panel deleted');
    }
}
