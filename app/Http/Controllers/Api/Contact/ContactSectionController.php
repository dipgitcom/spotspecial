<?php
namespace App\Http\Controllers\Api\Contact;

use App\Http\Controllers\Controller;
use App\Models\ContactArea;
use App\Models\ContactCard;
use App\Models\ContactField;
use App\Models\ContactSection;

class ContactSectionController extends Controller
{
    public function index()
{
    $section = ContactSection::first();
    $areas = ContactArea::orderBy('order')->pluck('value');
    $card = ContactCard::first();

    $button = ContactField::where('type', 'button')->first();

    return response()->json([
        'section' => [
            'title' => $section->title ?? '',
            'subtitle' => $section->subtitle ?? '',
            'description' => $section->description ?? '',
        ],
        'placeholders' => [
            'name'        => 'Name',
            'phone'       => 'Telephone',
            'email'       => 'Email',
            'area'        => 'Area in Copenhagen',
            'spots'       => 'Number of spots (circa)',
            'description' => 'Brief description of the task',
        ],
        'areas' => $areas,
        'button' => [
            'text' => $button?->button_text ?? 'Få pris',
            
        ],
        'card' => [
            'title' => $card->title ?? '',
            'phone' => $card->phone ?? '',
            'email' => $card->email ?? '',
            'address' => $card->address ?? '',
            'hours' => $card->hours ?? '',
            'pill_text' => $card->pill_text ?? '',
            'disclaimer' => $card->disclaimer ?? '',
        ],
    ]);
}

}
