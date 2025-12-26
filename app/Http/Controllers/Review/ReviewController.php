<?php

namespace App\Http\Controllers\Review;

use App\Models\User;
use App\Models\Review;
use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserReview;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    use ApiResponse;
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Review::latest();

            return DataTables::of($data)
                ->addColumn('checkbox', function ($row) {
                    return '<div class="form-check text-center">
                    <input type="checkbox" class="form-check-input rowCheckbox" value="' . $row->id . '">
                </div>';
                })
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    if ($search = $request->input('search.value')) {
                        $query->where(function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%")
                                ->orWhere('profession', 'like', "%{$search}%")
                                ->orWhere('review_content', 'like', "%{$search}%")
                                ->orWhere('rating_point', 'like', "%{$search}%");
                        });
                    }
                })

                ->addColumn('name', function ($row) {
                    return '<span>' . $row->name ?? 'N/A' . '</span>';
                })

                ->addColumn('profession', function ($row) {
                    return '<span>' . $row->profession ?? 'N/A' . '</span>';
                })

                ->addColumn('photo', function ($row) {
                    $url = asset($row->photo) ?? asset('uploads/user.png');
                    return '<img src="' . $url . '" class="rounded-circle" width="30">';
                })

                ->addColumn('review_content', function ($row) {
                    return '<div>' . Str::limit(strip_tags($row->review_content), 60) . '</div>';
                })

                ->addColumn('rating_point', function ($row) {
                    return '<span class="badge bg-info">' . $row->rating_point . ' ⭐</span>';
                })

                ->addColumn('status', function ($row) {
                    return $row->status == '1'
                        ? '<span class="badge bg-success">Approved</span>'
                        : '<span class="badge bg-secondary">Pending</span>';
                })

                ->addColumn('action', function ($row) {
                    return '
                        <td>
                            <a href="' . route('review.show', $row->id) . '"
                                class="btn btn-ghost btn-icon btn-sm rounded-circle texttooltip"
                                data-template="eyeTwo">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-eye icon-xs">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <div id="eyeTwo" class="d-none"><span>View</span></div>
                            </a>

                            <a href="' . route('review.edit', $row->id) . '"
                                class="btn btn-ghost btn-icon btn-sm rounded-circle texttooltip"
                                data-template="edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-edit icon-xs">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                                <div id="edit" class="d-none"><span>Edit</span></div>
                            </a>

                            <button type="button" data-url="' . route('review.delete', $row->id) . '"
                                class="btn-delete btn btn-ghost btn-icon btn-sm rounded-circle texttooltip"
                                data-template="trashTwo">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-trash-2 icon-xs">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6
                                            m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                    </path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                                <div id="trashTwo" class="d-none"><span>Delete</span></div>
                            </button>



                             <a href="#" class="btn btn-ghost btn-icon btn-sm rounded-circle texttooltip"
                        data-bs-toggle="dropdown"
                        data-template="statusDropdownTooltip' . $row->id . '"
                        aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-more-vertical icon-xs">
                                <circle cx="12" cy="5" r="1"></circle>
                                <circle cx="12" cy="12" r="1"></circle>
                                <circle cx="12" cy="19" r="1"></circle>
                            </svg>
                            <div id="statusDropdownTooltip' . $row->id . '" class="d-none">
                                <span>Change Status</span>
                            </div>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="statusDropdownTooltip' . $row->id . '">
                            <li>
                                <a class="dropdown-item change-status" href="#"
                                data-id="' . $row->id . '" data-status="1">
                                    <i data-feather="check-circle" class="me-1 text-success"></i> Approve
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item change-status" href="#"
                                data-id="' . $row->id . '" data-status="0">
                                    <i data-feather="clock" class="me-1 text-warning"></i> Pending
                                </a>
                            </li>
                        </ul>

                        </div>
                    </td>';
                })

                ->rawColumns(['checkbox', 'name', 'profession', 'photo', 'review_content', 'rating_point', 'status', 'action'])
                ->make(true);
        }

        return view('backend.layouts.review.index');
    }

    public function userReview(Request $request)
    {
        if ($request->ajax()) {
            $data = UserReview::latest();

            return DataTables::of($data)
                ->addColumn('checkbox', function ($row) {
                    return '<div class="form-check text-center">
                    <input type="checkbox" class="form-check-input rowCheckbox" value="' . $row->id . '">
                </div>';
                })
                ->addIndexColumn()

                ->filter(function ($query) use ($request) {
                    if ($search = $request->input('search.value')) {
                        $query->where(function ($q) use ($search) {
                            $q->where('review_content', 'like', "%{$search}%")
                                ->orWhere('rating_point', 'like', "%{$search}%")
                                ->orWhereHas('user', function ($userQuery) use ($search) {
                                    $userQuery->where('name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('product', function ($productQuery) use ($search) {
                                    $productQuery->where('product_name', 'like', "%{$search}%");
                                });
                        });
                    }
                })
                ->addColumn('user', function ($row) {
                    return '<span>' . ($row->user->name ?? 'N/A') . '</span>';
                })

                ->addColumn('product', function ($row) {
                    return '<span>' .  $row->product?->product_name ?? 'N/A'  . '</span>';
                })

                ->addColumn('review_content', function ($row) {
                    return '<div>' . Str::limit(strip_tags($row->review_content), 60) . '</div>';
                })

                ->addColumn('rating_point', function ($row) {
                    return '<span class="badge bg-info">' . $row->rating_point . ' ⭐</span>';
                })

                ->addColumn('status', function ($row) {
                    return $row->status == '1'
                        ? '<span class="badge bg-success">Approved</span>'
                        : '<span class="badge bg-secondary">Pending</span>';
                })

                ->addColumn('action', function ($row) {
                    return '
                        <a href="' . route('user-review.show', $row->id) . '"
                                class="btn btn-ghost btn-icon btn-sm rounded-circle texttooltip"
                                data-template="eyeTwo">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-eye icon-xs">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <div id="eyeTwo" class="d-none"><span>View</span></div>
                        </a>

                        <a href="#" class="btn btn-ghost btn-icon btn-sm rounded-circle texttooltip"
                        data-bs-toggle="dropdown"
                        data-template="statusDropdownTooltip' . $row->id . '"
                        aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-more-vertical icon-xs">
                                <circle cx="12" cy="5" r="1"></circle>
                                <circle cx="12" cy="12" r="1"></circle>
                                <circle cx="12" cy="19" r="1"></circle>
                            </svg>
                            <div id="statusDropdownTooltip' . $row->id . '" class="d-none">
                                <span>Change Status</span>
                            </div>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="statusDropdownTooltip' . $row->id . '">
                            <li>
                                <a class="dropdown-item change-status" href="#"
                                data-id="' . $row->id . '" data-status="1">
                                    <i data-feather="check-circle" class="me-1 text-success"></i> Approve
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item change-status" href="#"
                                data-id="' . $row->id . '" data-status="0">
                                    <i data-feather="clock" class="me-1 text-warning"></i> Pending
                                </a>
                            </li>
                        </ul>';
                })

                ->rawColumns(['checkbox', 'user', 'product',  'review_content', 'rating_point', 'status', 'action'])
                ->make(true);
        }

        $users =  User::select('id', 'name')->get();
        $products = Product::select('id', 'product_name')->get();
        return view('backend.layouts.review.userReview', compact('users', 'products'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'            => 'required|string|max:255',
            'profession'      => 'required|string|max:255',
            'Photo'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'review_content'  => 'required|string|max:255',
            'rating_point'    => 'required|numeric|min:0|max:5',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $review = Review::create([
            'name'            => $request->name,
            'profession'      => $request->profession,
            'review_content'  => $request->review_content,
            'rating_point'    => $request->rating_point,

        ]);

        if ($request->file('photo')) {
            $image = $request->file('photo');
            $image_path = $this->uploadImage($image, null, 'uploads/review', 150, 150);
            $review->update(['photo' => $image_path]);
        }

        return redirect()->route('review.index')->with('success', 'Review created successfully.');
    }

    public function edit(string $id)
    {

        if (!Review::find($id)) {
            return redirect()
                ->route('review.index')
                ->with('error', 'Review not found');
        }
        $review = Review::find($id);
        return view('backend.layouts.review.index', compact('review'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required | string | max:255',
            'profession' => 'required | string | max:255',
            'review_content' => 'required | string | max:255',
            'rating_point' => 'required | numeric | min:2 | max:5',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator);
        };

        $review = Review::find($id);

        if ($request->file('photo')) {
            $image = $request->file('photo');
            $image_path = $this->uploadImage($image, $review->photo, 'uploads/review', 150, 150);
            $review->update(['photo' => $image_path]);
        }
        // Save to database
        Review::find($id)->update([
            'name' => $request->name,
            'profession' => $request->profession,
            'review_content' => $request->review_content,
            'rating_point' => $request->rating_point,
        ]);



        return redirect()->route('review.index')->with('success', 'Review updated successfully.');
    }


    public function destroy(Request $request, string $id)
    {
        $review = Review::find($id);

        if (!$review) {
            return redirect()->back()->with('error', 'Review not found.');
        }

        $review->delete();

        return redirect()
            ->route('review.index')
            ->with('success', 'Review deleted successfully');
    }


    public function changeStatus(Request $request)
    {
        $review = Review::find($request->review_id);
        $review->status = $request->status;
        $review->save();
        // Return flash message in JSON
        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.'
        ]);
    }


    public function changeUserStatus(Request $request)
    {
        $review = UserReview::find($request->review_id);
        $review->status = $request->status;
        $review->save();
        // Return flash message in JSON
        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.'
        ]);
    }


    public function show(string $id)
    {
        $review = Review::find($id);
        return view('backend.layouts.review.show', compact('review'));
    }

    public function showUserReview(string $id)
    {
        $review = UserReview::with('user')->find($id);
        return view('backend.layouts.review.showUserReview', compact('review'));
    }
}
