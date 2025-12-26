<?php 


namespace App\Http\Controllers\Faq;
use App\Http\Controllers\Controller;
use App\Models\FaqSection;
use Illuminate\Http\Request;

class FaqSectionController extends Controller
{
    public function update(Request $request) {
        $validated = $request->validate([
            'title'    => 'required|string|max:120',
            'subtitle' => 'nullable|string|max:255',
        ]);
        $section = FaqSection::first();
        if ($section) {
            $section->update($validated);
        } else {
            FaqSection::create($validated);
        }
        return redirect()->back()->with('section_success', 'Section updated');
    }
}
