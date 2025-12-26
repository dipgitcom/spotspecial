<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use App\Models\ContactField;

class ContactSubmissionAdminController extends Controller
{
    public function index()
    {
        $fields = ContactField::orderBy('order')->get();
        $submissions = ContactSubmission::orderBy('created_at', 'desc')->get();
        return view('backend.layouts.contact_section.data', compact('fields', 'submissions'));
    }
}
