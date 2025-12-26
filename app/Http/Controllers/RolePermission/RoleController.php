<?php

namespace App\Http\Controllers\RolePermission;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        // Logic to list roles
        $roles  = Role::select('id', 'name')->get();
        return view('backend.layouts.role_permission.role.index', compact('roles'));
    }


    public function store(Request $request)
    {
        // Validate and store the role
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Logic to create a new role
        $role = Role::updateOrCreate(
            ['name' => $request->name],
            [
                'name' => $request->name,
                'guard_name' => 'web'
            ]
        );

        return redirect()->route('role.index')->with('success', 'Role created successfully.');
    }

    public function  edit($id)
    {
        $roles = Role::all();
        $role = Role::findOrFail($id);
        return view('backend.layouts.role_permission.role.index', compact('role', 'roles'));
    }


    public function update(Request $request, $id)
    {
        // Validate and store the role
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Logic to create a new role
        $role = Role::findOrFail($id);

        $role->update(
            ['name' => $request->name],
            [
                'name' => $request->name,
                'guard_name' => 'web'
            ]
        );

        return redirect()->route('role.index')->with('success', 'Role Updated successfully.');
    }


    public function editPermission($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('backend.layouts.role_permission.permission.edit_permission', compact('permissions', 'role'));
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('role.index')->with('success', 'Role Deleted successfully.');
    }
}
