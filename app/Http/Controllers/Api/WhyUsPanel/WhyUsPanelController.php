<?php

namespace App\Http\Controllers\Api\WhyUsPanel;

use App\Http\Controllers\Controller;
use App\Models\WhyUsPanel;
use Illuminate\Http\Request;

class WhyUsPanelController extends Controller
{
    public function index()
    {
        return response()->json(WhyUsPanel::orderBy('order')->get());
    }
}

