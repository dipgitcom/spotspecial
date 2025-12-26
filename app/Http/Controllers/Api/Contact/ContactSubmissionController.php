<?php

namespace App\Http\Controllers\Api\Contact;

use App\Http\Controllers\Controller;
use App\Mail\ContactSubmissionMail;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactSubmissionController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:191',
            'phone' => 'nullable|string|max:40',
            'email' => 'required|email|max:191',
            'area' => 'required|string|max:100',
            'spots' => 'nullable|numeric|min:0',
            'description' => 'required|string|max:2000',
        ];

        $validated = $request->validate($rules);

        // 1) DB te save
        ContactSubmission::create(['data' => $validated]);

        // 2) Admin ke mail
        $adminEmail = config('mail.site.admin.address');
        
       
        Mail::to($adminEmail)->send(new ContactSubmissionMail($validated));

        return response()->json(['message' => 'Submitted Contact Field!'], 200);
    }
}
