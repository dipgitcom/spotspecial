<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Models\ContactArea;
use App\Models\ContactCard;
use App\Models\ContactField;
use App\Models\ContactSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactSectionController extends Controller
{
    public function edit()
    {
        $section = ContactSection::first();
        $fields = ContactField::orderBy('order')->get();
        $areas = ContactArea::orderBy('order')->get();
        $card = ContactCard::first();

        return view('backend.layouts.contact_section.index', compact('section', 'fields', 'areas', 'card'));
    }

    public function updateSection(Request $request, $id)
    {
        $section = ContactSection::findOrFail($id);
        $section->update($request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]));

        return redirect()->back()->with('section_success', 'Section updated successfully.');
    }

    // Only allow label/placeholder/type/required/order to be edited
    public function updateField(Request $request, $id)
    {
        $field = ContactField::findOrFail($id);
        $validated = $request->validate([
            'label' => 'required|string|max:191',
            'placeholder' => 'nullable|string|max:191',
            'button_text' => 'required|string|max:191',
           
            'type' => 'required|string|max:50',
            'required' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ]);
        $validated['required'] = ! empty($validated['required']);
        if ($validated['type'] !== 'button') {
            // $validated['button_text'] = null;
           
        }
        // dd($validated);
        $field->update($validated);

        return redirect()->back()->with('success', 'Field updated successfully.');
    }

    public function storeField(Request $request)
    {
        $fields = $request->input('fields', []);
        $messages = [];
        foreach ($fields as $field) {
            $validator = Validator::make($field, [
                'key' => 'required|string|unique:contact_fields,key',
                'label' => 'required|string|max:191',
                'placeholder' => 'nullable|string|max:191',
                'button_text' => 'nullable|string|max:191',
               
                'type' => 'required|string|max:50',
                'required' => 'nullable|boolean',
                'order' => 'nullable|integer',
            ]);
            if ($validator->fails()) {
                $messages[] = $validator->errors()->all();

                continue;
            }
            // dd($validator->getData(), $request->all());
            $field['required'] = ! empty($field['required']);
            if ($field['type'] !== 'button') {
                // $field['button_text'] = null;
                
            }
            $model = ContactField::create($field);
            $model->button_text = $request->button_text;
            $model->save();
        }

        return redirect()->back()->with('success', 'All valid fields added successfully.');
    }

    public function destroyField($id)
    {
        ContactField::destroy($id);

        return redirect()->route('contact-section.edit')->with('success', 'Field deleted successfully.');
    }

    // AREA CRUD
    public function updateArea(Request $request, $id)
    {
        $area = ContactArea::findOrFail($id);
        $area->update($request->validate([
            'value' => 'required|string|max:191',
            'order' => 'nullable|integer',
        ]));

        return redirect()->back()->with('success', 'Area updated successfully.');
    }

    public function storeArea(Request $request)
    {
        $validated = $request->validate([
            'value' => 'required|string|max:191',
            'order' => 'nullable|integer',
        ]);
        ContactArea::create($validated);

        return redirect()->back()->with('success', 'Area added successfully.');
    }

    public function destroyArea($id)
    {
        ContactArea::destroy($id);

        return redirect()->back()->with('success', 'Area deleted successfully.');
    }

    // CARD (sidebar) update
    public function updateCard(Request $request, $id)
    {
        $card = ContactCard::findOrFail($id);
        $card->update($request->validate([
            'title' => 'required|string|max:191',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:191',
            'address' => 'nullable|string|max:191',
            'hours' => 'nullable|string|max:100',
            'pill_text' => 'nullable|string|max:100',
            'disclaimer' => 'nullable|string|max:255',
        ]));

        return redirect()->back()->with('success', 'Contact card updated successfully.');
    }
}
