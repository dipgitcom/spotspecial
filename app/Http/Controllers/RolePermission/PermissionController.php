<?php

namespace App\Http\Controllers\RolePermission;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function index()
    {

        $permissions = Permission::all();
        $roles = Role::select('id', 'name')->get();
        return view('backend.layouts.role_permission.permission.index', compact('permissions', 'roles'));
    }


    public function store(Request $request)
    {

        // Validate and store the role
        $validator = Validator::make($request->all(), [
            'permission' => 'required|string|max:255|unique:permissions,name',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        Permission::updateOrCreate(
            ['name' => $request->permission],
            [
                'name' => $request->permission,
                'guard_name' => 'web'
            ]
        );

        return redirect()->route('permission.index')->with('success', 'Permission created successfully.');
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('backend.layouts.role_permission.permission.index', compact('permission'));
    }



    public function UpdatePermissionByRole(Request $request, $id)
    {
        if (!$request->permissions) {
            return back()->with('error', 'Permission is required for update ');
        }

        $allPermission = Permission::whereIn('id', $request->permissions)->get();

        $role = Role::findOrFail($id);
        $role->syncPermissions($allPermission);

        return back()->with('suc    cess', 'Permissions assigned successfully');
    }
}
