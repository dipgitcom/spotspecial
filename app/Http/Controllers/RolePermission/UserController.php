<?php

namespace App\Http\Controllers\RolePermission;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::whereDoesntHave('roles', function ($q) {
            $q->where('name', 'super Admin');
        })->get();

        $roles = Role::where('name', '!=', 'super Admin')->get();
        if ($request->ajax()) {

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<div class="form-check text-center">
                        <input type="checkbox" class="form-check-input rowCheckbox" value="' . $row->id . '">
                    </div>';
                })
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('email', function ($row) {
                    return $row->email;
                })

                ->addColumn('action', function ($row) {
                    $viewUrl = route('user.show', $row->id);
                    $editUrl = route('user.edit', $row->id);
                    $changeRole = route('user.role.change', $row->id);
                    return '
                    <a href="' . $viewUrl . '" class="btn btn-sm btn-info">View</a>
                    <a href="' . $editUrl . '" class="btn btn-sm btn-primary">Edit</a>
                    <a href="' . $changeRole . '" class="btn btn-sm btn-secondary">Assign Role</a>
                    <button type="button"  data-url="' . route('user.destroy', $row->id) . '"
                            class="btn-delete ms-3 btn btn-ghost btn-icon btn-sm rounded-circle texttooltip"
                            data-template="trashTwo">

                        <div class = "btn btn-sm  btn-danger "><span>Delete</span></div>
                    </button>';
                })
                ->rawColumns(['checkbox', 'name', 'email', 'action'])
                ->make(true);
        }

        return view('backend.layouts.role_permission.user.index', compact('roles'));
    }



    public function store(Request $request)
    {


        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Handle file upload if a photo is provided
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $this->uploadImage($request->file('photo'), null, 'uploads/profilePhoto', 150, 150);
            }


            DB::beginTransaction();
            $user  = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'profile_photo' => $photoPath ? $photoPath : 'uploads/default.png',
            ]);

            // assign user role
            if ($request->roles) {
                foreach ($request->roles as $roleId) {
                    $role = Role::find($roleId);
                    if ($role) {
                        $user->assignRole($role->name);
                    }
                }
            }





            DB::commit();
            return redirect()->route('user.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {


            DB::rollback();
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $userRole = $user->roles->pluck('id')->toArray();
        return view('backend.layouts.role_permission.user.index', compact('user', 'userRole'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Handle file upload if a photo is provided
        if ($request->hasFile('photo')) {
            $photoPath = $this->uploadImage($request->file('photo'), $user->photo, 'uploads/profilePhoto', 150, 150);
            $user->photo = $photoPath;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }


    public function ChangeRole($id)
    {
        $user =  User::where('id', $id)->first();
        $roles = Role::where('name', '!=', 'super Admin')->get();
        $userRoles = $user->roles->pluck('id')->toArray();
        return view('backend.layouts.role_permission.user.edit_role', compact('userRoles', 'roles', 'user'));
    }

    public function assignRoleUpate(Request $request, $id)
    {
        if (!$request->roles && $request->roles == null) {
            return redirect()->route('user.index')->with('error', 'User Role Must Assign');
        }
        $user = User::findOrFail($id);
        $roles = Role::whereIn('id', $request->roles)->pluck('name')->toArray();


        $user->syncRoles($roles);
        return redirect()->route('user.index')->with('success', 'User Role Update Successfull');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return  view('backend.layouts.role_permission.user.show', compact('user'));
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (!$user) {
            return back()->with('success', 'User Not Available In System');
        }
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User Deleted Successfull');
    }
}
