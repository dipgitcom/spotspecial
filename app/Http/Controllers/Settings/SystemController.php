<?php

namespace App\Http\Controllers\Settings;

use App\Models\Social;
use App\Models\System;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SystemController extends Controller
{
    /**
     * Display the system settings page.
     *
     * @return \Illuminate\View\View
     */
    function index()
    {
        $system = System::first();
        $instagram = Social::where('id', '1')->first();
        $facebook = Social::where('id', '2')->first();
        $twitter = Social::where('id', '3')->first();
        $tiktok = Social::where('id', '4')->first();

        return view('backend.layouts.settings.system.index', [
            'system' => $system,
            'instagram' => $instagram,
            'facebook' => $facebook,
            'twitter' => $twitter,
            'tiktok' => $tiktok
        ]);
    }


    /**
     * Update system settings.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */

    public function systemupdate(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'email' => 'nullable|email',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,svg',
            'favicon' => 'nullable|image|mimes:jpeg,jpg,png,',
            'copyright' => 'nullable|string',
        ]);

        $system = System::first();
        if (!$system) {
            $system = new System();
        }

        $data = [
            'title' => $request->title,
            'email' => $request->email,
            'copyright' => $request->copyright,
        ];

        // logo handle
        $logoPath =  $this->uploadImage($request->logo, $system->logo, 'uploads/logo');
        $data['logo'] = $logoPath ?? 'uploads/default.png';

        //favicon handle
        $faviconPath =  $this->uploadImage($request->favicon, $system->favicon, 'uploads/favicon');
        $data['favicon'] = $faviconPath ?? 'uploads/default.png';

        if ($system->exists) {
            $system->update($data);
        } else {
            System::create($data);
        }

        return redirect()->route('system.index')->with('success', 'System settings updated successfully');
    }


    public function updateSocials(Request $request)
    {
        $section = $request->submit_section; // e.g., 'instagram', 'facebook', etc.

        $socialData = [
            'instagram' => [
                'id' => 1,
                'name' => $request->instagram_title,

                'url' => $request->instagram_url,
            ],
            'facebook' => [
                'id' => 2,
                'name' => $request->facebook_title,

                'url' => $request->facebook_url,
            ],
            'twitter' => [
                'id' => 3,
                'name' => $request->twitter_title,

                'url' => $request->twitter_url,
            ],
            'tiktok' => [
                'id' => 4,
                'name' => $request->tiktok_title,

                'url' => $request->tiktok_url,
            ],
        ];

        if (array_key_exists($section, $socialData)) {
            $data = $socialData[$section];

            DB::table('socials')
                ->where('id', $data['id'])
                ->update([
                    'name' => $data['name'],

                    'url' => $data['url'],
                    'updated_at' => now(),
                ]);
        }

        return redirect()->back()->with('success', ucfirst($section) . ' updated successfully!');
    }
}
