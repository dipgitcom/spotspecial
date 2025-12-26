<?php

namespace App\Http\Controllers\Api\Footer;

use App\Http\Controllers\Controller;
use App\Models\FooterSetting;
use App\Models\FooterLink;

class FooterController extends Controller
{
    public function index()
    {
        $footer = FooterSetting::first();
        $links = FooterLink::orderBy('order')->get()->map(function ($link) {
            return [
                'label' => $link->label,
                'url'   => $link->url,
                'order' => $link->order,
            ];
        });

        return response()->json([
            'copyright' => $footer->copyright ?? '',
            'links'     => $links,
        ]);
    }
}
