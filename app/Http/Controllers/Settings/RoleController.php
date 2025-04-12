<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of all roles.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::with('permissions');
            return DataTables::of($roles)
                ->addColumn('permissions', function ($role) {
                    $badges = $role->permissions->map(function($permission) {
                        return '<span class="badge badge-primary mr-1">' . $permission->name . '</span>';
                    })->implode('');
                    return $badges;
                })
                ->addColumn('created_at', function ($role) {
                    return $role->created_at->format('Y-m-d H:i');
                })
                ->addColumn('actions', function ($role) {
                    return '
                        <a href="' . route('roles.edit', $role->id) . '" class="btn btn-warning btn-xs">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="' . route('roles.destroy', $role->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm(\'Are you sure you want to delete this role?\')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    ';
                })
                ->rawColumns(['permissions', 'actions'])
                ->make(true);
        }

        return view('settings.roles.index');
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('settings.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles'],
            'permissions' => ['required', 'array'],
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully');
    }

    /**
     * Display the specified role.
     */
    public function show(Role $role)
    {
        $role->load('permissions');
        return view('settings.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        
        return view('settings.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name,' . $role->id],
            'permissions' => ['required', 'array'],
        ]);

        $role->name = $request->name;
        $role->save();
        
        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role)
    {
        // Check if role is being used by any users
        if ($role->users()->count() > 0) {
            return redirect()->route('roles.index')
                ->with('error', 'Cannot delete role as it is assigned to users');
        }
        
        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully');
    }
} 