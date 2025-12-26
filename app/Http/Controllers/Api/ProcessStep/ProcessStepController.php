<?php

namespace App\Http\Controllers\Api\ProcessStep;

use App\Http\Controllers\Controller;

class ProcessStepController extends Controller
{
    public function index()
    {
        $section = \App\Models\ProcessStepSection::first();
        $steps = \App\Models\ProcessStep::orderBy('step_number')->get();

        return response()->json([
            'section' => $section,
            'steps' => $steps,
        ]);
    }
}
