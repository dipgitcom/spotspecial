<?php

namespace App\Http\Controllers\ProcessStep;

use App\Http\Controllers\Controller;
use App\Models\ProcessStep;
use Illuminate\Http\Request;

class ProcessStepController extends Controller
{
    public function index()
    {
        $steps = ProcessStep::orderBy('step_number')->get();

        return view('backend.layouts.process_steps.index', compact('steps'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'step_number' => 'required|integer',
        ]);
        ProcessStep::create($request->all());

        return redirect()->back()->with('success', 'Process step added');
    }

    public function update(Request $request, ProcessStep $processStep)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'step_number' => 'required|integer',
        ]);
        $processStep->update($request->all());

        return redirect()->back()->with('success', 'Process step updated');
    }

    public function destroy(ProcessStep $processStep)
    {
        $processStep->delete();

        return redirect()->back()->with('success', 'Process step deleted');
    }

    public function sectionEdit()
    {
        $section = \App\Models\ProcessStepSection::first();

        return view('backend.layouts.process_steps.index', compact('section'));
    }

    public function sectionUpdate(Request $request)
    {
        $section = \App\Models\ProcessStepSection::first();
        $validated = $request->validate([
            'title' => 'required|string|max:120',
            'subtitle' => 'nullable|string|max:200',
        ]);
        if ($section) {
            $section->update($validated);
        } else {
            \App\Models\ProcessStepSection::create($validated);
        }

        return redirect()->back()->with('success', 'Section title/subtitle updated.');
    }
}
