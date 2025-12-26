<?php

namespace App\Http\Controllers\Api;

use App\Models\GetInTouch;
use App\Models\Newsletter;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminSetting;
use Illuminate\Support\Facades\Validator;

class AboutUsController extends Controller
{
    use ApiResponse;

    public function contactUs()
    {
        $contactAddrr = AdminSetting::select('email', 'hotline', 'address')->first();
        if (!$contactAddrr) {
            return $this->error('No Data Found', 200);
        }
        return $this->success($contactAddrr, 'About Us', 200);
    }


    public function storeNewsletter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                'unique:newsletters',
                'email:rfc,dns,filter',
                'max:255',
            ],
        ]);

        if ($validator->fails()) {
            return $this->error(['errors' => $validator->errors()], 422);
        }

        Newsletter::create(
            [
                'email' => $request->email,
            ]
        );
        return $this->success('Newsletter Subscribed Successfully', 200);
    }


    public function getInTouch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|min:3|max:100',
            'subject' => 'required|string|max:255',
            'email_address' => [
                'required',
                'email',
                'max:255',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'comment' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 'Validation Error', 422);
        }

        try {
            // Step 2: Check if email already submitted
            $existing = GetInTouch::where('email_address', $request->email_address)->first();

            if ($existing) {
                return $this->error(
                    null,
                    'You have already submitted a message. Only one submission is allowed per user.',
                    409
                );
            }

            // Step 3: Store new submission
            $getInTouch = new GetInTouch();
            $getInTouch->full_name = $request->full_name;
            $getInTouch->subject = $request->subject;
            $getInTouch->email_address = $request->email_address;
            $getInTouch->comment = $request->comment;
            $getInTouch->save();

            return $this->success($getInTouch, 'Message Sent Successfully', 200);
        } catch (\Exception $e) {

            return $this->error($e->getMessage(), 'Something went wrong in server', 500);
        }
    }
}
