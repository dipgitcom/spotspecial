<?php

namespace App\Http\Controllers\Dynamic;

use App\Models\DynamicPage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class DynamicPageController extends Controller
{
    // Display listing page or JSON for DataTables AJAX
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DynamicPage::latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="page-checkbox" value="' . $row->id . '">';
                })
                ->editColumn('content', function ($row) {
                    return Str::limit(strip_tags($row->content), 20);
                })
                ->editColumn('status', function ($row) {
                    $statusText = $row->status == 1 ? 'Published' : 'Draft';
                    $badgeClass = $row->status == 1 ? 'success' : 'secondary';

                    return '<span class="badge bg-' . $badgeClass . '">' . $statusText . '</span>';
                })

                ->addColumn('action', function ($row) {

                    $statusRoute = route('dynamic-pages.toggleStatus', [$row->id, $row->status == 1 ? 0 : 1]);
                    $checked = $row->status == 1 ? 'checked' : '';
                    return '
                            <div class="d-flex align-items-center gap-2">

                         <!-- Status Switcher with <a> -->
                            <a href="' . $statusRoute . '"
                            class="btn btn-ghost btn-icon btn-sm rounded-circle texttooltip status-link"
                            data-template="statusToggle"
                            title="Toggle Status">
                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input" type="checkbox" role="switch" ' . $checked . ' disabled>
                                </div>
                                <div id="statusToggle" class="d-none">
                                    <span>Status</span>
                                </div>
                            </a>

                                <!-- Edit Button -->
                                <a href="' . route('dynamic-pages.edit', $row->id) . '"
                                    class="btn btn-ghost btn-icon btn-sm rounded-circle texttooltip"
                                    data-template="edit">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="feather feather-edit icon-xs" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                    <div id="edit" class="d-none"><span>Edit</span></div>
                                </a>

                                <!-- Delete Button -->
                                <button type="button"
                                    data-url="' . route('dynamic-pages.delete', $row->id) . '"
                                    class="btn-delete btn btn-ghost btn-icon btn-sm rounded-circle texttooltip"
                                    data-template="trashTwo">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="feather feather-trash-2 icon-xs" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4
                                            a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                    <div id="trashTwo" class="d-none"><span>Delete</span></div>
                                </button>

                            </div>
                        ';
                })

                ->rawColumns(['checkbox', 'status', 'action'])
                ->make(true);
        }

        // Normal page load
        return view('backend.layouts.dynamic.index');
    }

    // Show create form - if you have separate page (optional)
    public function create()
    {
        return view('backend.layouts.dynamic.create');
    }

    // Store new dynamic page
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        DynamicPage::create([
            'slug' => Str::slug($request->title),
            'title' => $request->title,
            'content' => $request->content,

        ]);

        return redirect()->route('dynamic-pages.index')->with('success', 'Dynamic page created successfully.');
    }



    // Show edit form
    public function edit($id)
    {
        $dynamicPage = DynamicPage::findOrFail($id);
        return view('backend.layouts.dynamic.index', compact('dynamicPage'));
    }

    // Update existing page
    public function update(Request $request, $id)
    {
        $dynamicPage = DynamicPage::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'nullable|in:draft,published',
        ]);

        $dynamicPage->update([
            'slug' => Str::slug($request->title),
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('dynamic-pages.index')->with('success', 'Dynamic page updated successfully.');
    }

    // Delete page
    public function destroy($id)
    {
        $dynamicPage = DynamicPage::findOrFail($id);
        $dynamicPage->delete();

        return redirect()->route('dynamic-pages.index')->with('success', 'Dynamic page deleted successfully.');
    }

    // Toggle status
    public function pageSatus($id, $status)
    {
        $dynamicPage = DynamicPage::findOrFail($id);
        $dynamicPage->status = $status;
        $dynamicPage->save();

        return back()->with('success', 'Blog status updated successfully');
    }
}
