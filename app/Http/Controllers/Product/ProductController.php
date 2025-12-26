<?php

namespace App\Http\Controllers\Product;

use App\Models\Size;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Newsletter;
use App\Jobs\NewsletterJob;
use Illuminate\Support\Str;
use App\Models\ImageGallery;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProductStoreRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Product::with('category')->latest();
            return DataTables::of($data)
                ->addColumn('checkbox', function ($row) {
                    return '<div class="form-check text-start">
                                <input type="checkbox" class="form-check-input rowCheckbox" value="' . $row->id . '">
                            </div>';
                })
                ->addIndexColumn()
                ->addColumn('product_name', function ($row) {
                    return '<div class="d-flex align-items-start">
                                <strong>' . e($row->product_name) . '</strong>
                          </div>';
                })

                ->filter(function ($query) use ($request) {
                    if ($search = $request->input('search.value')) {
                        $query->where(function ($q) use ($search) {
                            $q->where('product_name', 'like', "%{$search}%")
                                ->orWhere('slug', 'like', "%{$search}%")
                                ->orWhereHas('category', function ($catQuery) use ($search) {
                                    $catQuery->where('name', 'like', "%{$search}%");
                                });
                        });
                    }
                })
                ->addColumn('product_image', function ($row) {
                    if ($row->product_image) {
                        return '<img src="' . asset($row->product_image) . '" class="img-thumbnail" width="50">';
                    }
                    return '<span class="text-muted">No image</span>';
                })


                ->addColumn('quantity', function ($row) {
                    return '<div class="d-flex text-start"">

                                <strong>' . e($row->inventory->quantity) . '</strong>
                          </div>';
                })


                ->addColumn('category_id', function ($row) {
                    return '<div class="d-flex align-items-start">

                                <strong>' . e($row->category->name) . '</strong>
                          </div>';
                })


                ->addColumn('reqular_price', function ($row) {
                    return '<div class="d-flex text-start"">

                                <img src="' . asset($row->product_image) . '" >
                          </div>';
                })



                ->addColumn('status', function ($row) {
                    if ($row->status == '1') {
                        return '<span class="badge badge-success-soft">Published</span>';
                    } else  if ($row->status == '0') {
                        return '<span class="badge badge-danger-soft">Unpublished</span>';
                    } else if ($row->status == '2') {
                        return '<span class="badge badge-warning-soft">Draft</span>';
                    }
                })

                ->addColumn('action', function ($row) {
                    return '
                            <td>
                                <a href="' . route('product.show', $row->id) . '"
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

                                <a href="' . route('product.edit', $row->id) . '"
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

                                <button type="button" data-url="' . route('product.destroy', $row->id) . '"
                                    class="btn-delete btn btn-ghost btn-icon btn-sm rounded-circle texttooltip"
                                    data-template="trashTwo">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-trash-2 icon-xs">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                    <div id="trashTwo" class="d-none"><span>Delete</span></div>
                                </button>

                                <!-- Dropdown for status actions -->
                                <div class="dropdown d-inline">
                                    <button class="btn btn-sm btn-icon btn-ghost rounded-circle Z-index " type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            ' . ($row->status != 1 ? '
                                                <a class="dropdown-item btn-status" href="' . route('product.status', ['id' => $row->id, 'status' => 1]) . '">
                                                    <i class="fas fa-upload text-success me-2"></i> Publish
                                                </a>
                                            ' : '') . '
                                        </li>
                                        <li>
                                            ' . ($row->status != 2 ? '
                                                <a class="dropdown-item btn-status" href="' . route('product.status', ['id' => $row->id, 'status' => 2]) . '">
                                                    <i class="fas fa-pencil-alt text-warning me-2"></i> Draft
                                                </a>
                                            ' : '') . '
                                        </li>
                                        <li>
                                            ' . ($row->status != 0 ? '
                                                <a class="dropdown-item btn-status" href="' . route('product.status', ['id' => $row->id, 'status' => 0]) . '">
                                                    <i class="fas fa-ban text-danger me-2"></i> Unpublish
                                                </a>
                                            ' : '') . '
                                        </li>

                                    </ul>
                                </div>
                            </td>';
                })

                ->rawColumns(['action', 'checkbox', 'status', 'product_name', 'category_id', 'reqular_price', 'quantity', 'product_image'])
                ->make(true);
        }

        return view('backend.layouts.product.index');
    }

    public function create()
    {
        $democolor = [
            [
                'name' => 'Red',
                'code' => '#FF0000',
            ],
            [
                'name' => 'Green',
                'code' => '#00FF00',
            ],
            [
                'name' => 'Blue',
                'code' => '#0000FF',
            ],
            [
                'name' => 'Yellow',
                'code' => '#FFFF00',
            ],
            [
                'name' => 'Black',
                'code' => '#000000',
            ],
            [
                'name' => 'White',
                'code' => '#FFFFFF',
            ],
        ];
        $demosize = [
            [
                'name' => 'Small',
            ],
            [
                'name' => 'Medium',
            ],
            [
                'name' => 'Large',
            ],
            [
                'name' => 'Extra Large',
            ],

        ];

        $colors = Color::select('id', 'name', 'code')->get();
        $sizes = Size::select('id', 'name',)->get();
        $categories = Category::select('id', 'name')->get();
        return view('backend.layouts.product.create', compact('categories', 'colors', 'sizes'));
    }

    public function store(ProductStoreRequest $request)
    {
        $data = $request->validated();

        // dd($data['featured_image']);
        DB::beginTransaction();

        try {

            // Feature image upload
            $feature_image = $data['featured_image'];
            $feature_image_path = $this->uploadImage(
                $feature_image,
                null,
                'uploads/product',
                150,
                150
            );

            if (!$feature_image_path) {
                return back()->with(['error' => 'Feature image upload failed'], 404);
            }

            // Create Product
            $product = Product::create($data);

            // Gallery images upload
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $key => $image) {
                    $gallery_path = $this->uploadImage(
                        $image,
                        null,
                        'uploads/gallery',
                        150,
                        150,
                        'gallery-'
                    );

                    if ($gallery_path) {
                        ImageGallery::create([
                            'product_id' => $product->id,
                            'image_path' => $gallery_path,
                        ]);
                    }
                }
            }


            // Inventory create
            $inventory = Inventory::where('product_id', $product->id)->first();
            if ($inventory) {
                $inventory->update([
                    'quantity' => $request->quantity + $inventory->quantity,
                ]);
            }

            Inventory::create([
                'product_id' => $product->id,
                'variation_id' => $variation ? $variation->id : null,
                'quantity' => $request->quantity,
            ]);

            DB::commit();
            if ($request->send_to_newsletter == '1') {
                $newsletters = Newsletter::pluck('email')->toArray();
                dispatch(new NewsletterJob($newsletters, $product->id));
            }

            return redirect()
                ->route('product.index')
                ->with('success', 'Product created successfully.')
                ->with('email_success', 'Newsletter emails have been sent successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput();
        }
    }

    public function show($id)
    {
        $product = Product::with('inventory', 'category', 'galleries')->find($id);

        if (!$product) {
            return back()->with(['error' => 'Product not found'], 404);
        }

        return view('backend.layouts.product.show', compact('product'));
    }

    public function edit($id)
    {
        $colors = Color::select('id', 'name', 'code')->get();
        $sizes = Size::select('id', 'name',)->get();
        $product =  Product::with('inventory', 'galleries')->find($id);

        if (!$product) {
            return back()->with(['error' => 'Product not found'], 404);
        }
        $inventory = Inventory::where('product_id', $product->id)->first();

        if (!$inventory) {
            return back()->with(['error' => 'Inventory not found'], 404);
        }

        if (!$colors || !$sizes) {
            return back()->with(['error' => 'Variation not found'], 404);
        }

        $variation = ProductVariation::find($inventory->variation_id);


        $categories = Category::select('id', 'name')->get();

        return view('backend.layouts.product.create', compact('product', 'categories', 'inventory', 'colors', 'sizes', 'variation'));
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'product_name' => 'required|string|min:3',
            'product_code' => 'required|string|min:3',
            'featured_image' => 'image|mimes:jpeg,png,jpg,webp,gif|max:2048',
            'short_description' => 'required|max:1000',
            'regular_price' => 'required',
            'quantity' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator);
        }


        if ("yes" == $request->has_weight) {
            $weight = $request->weight;
            $weight_unit = $request->weight_unit;
        }

        // feature image upload
        $product =  Product::find($id);
        $feature_image_path = $product->product_image;

        if ($request->file('featured_image')) {
            $feature_image = $request->file('featured_image');
            $feature_image_path = $this->uploadImage(
                $feature_image,
                $product->product_image,
                'uploads/product',
                150,
                150,

            );
        }

        $product =  Product::find($id)->update([
            'category_id' => $request->category_id,
            'product_name' => $request->product_name,
            'slug' => Str::slug($request->product_name),
            'brand' => $request->brand,
            'product_code' => $request->product_code ?? uniqid('pr-'),
            'product_type' => $request->product_type,
            "product_version_type" => $request->product_version_type,
            "weight" => $weight ?? null,
            "weight_unit" => $weight_unit ?? 'kg',
            "description" => $request->description,
            "additional_description" => $request->additional_description,
            "discount_price" => $request->discount_price,
            "short_description" => $request->short_description,
            "regular_price" => $request->regular_price,
            'product_image' => $feature_image_path,
        ]);



        if ($request->file('gallery_images')) {


            $product = Product::find($id);

            $oldGalleryImages = ImageGallery::where('product_id', $product->id)->get();

            foreach ($oldGalleryImages as $oldImage) {

                $this->deleteImage($oldImage->image_path);

                $oldImage->delete();
            }

            foreach ($request->file('gallery_images') as $key => $image) {
                $gallery_path =  $this->uploadImage(
                    $image,
                    null,
                    'uploads/gallery',
                    150,
                    150,
                    'gallery-' . $key
                );

                $imageGallery = new ImageGallery();
                $imageGallery->product_id = $id;
                $imageGallery->image_path = $gallery_path;
                $imageGallery->save();
            }
        }

        $productInventory = Inventory::where('product_id', $id)->first();

        if (!$productInventory) {
            return redirect()
                ->route('product.index')
                ->with('error', 'Product Inventory not found');
        }

        if ($productInventory->variation_id) {
            ProductVariation::find($productInventory->variation_id)->update([
                'color' => $request->color,
                'size' => $request->size,
            ]);
        }



        Inventory::find($productInventory->id)->update([
            'product_id' =>  $id,
            'variation_id' => $productInventory->variation_id ?? null,
            'quantity' => $request->quantity,
        ]);

        return redirect()
            ->route('product.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $this->deleteImage($product->product_image);
        $product->delete();
        return redirect()
            ->route('product.index')
            ->with('success', 'Product deleted successfully');
    }


    // status change
    public function changeStatus($id, $status)
    {
        $product = Product::findOrFail($id);
        $product->status = $status;
        $product->save();

        return back()->with('success', 'Product status updated successfully');
    }


    // gallery image delete
    public function productImageDestroy($id)
    {
        $imageId = ImageGallery::find($id);
        $this->deleteImage($imageId->image_path);
        $imageId->delete();
        return redirect()->back()->with('success', 'Product image deleted successfully');
    }
}
