<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of all permissions.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $permissions = Permission::query();
            return DataTables::of($permissions)
                ->addColumn('created_at', function ($permission) {
                    return $permission->created_at->format('Y-m-d H:i');
                })
                ->addColumn('actions', function ($permission) {
                    return '
                        <a href="' . route('permissions.edit', $permission->id) . '" class="btn btn-warning btn-xs">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="' . route('permissions.destroy', $permission->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm(\'Are you sure you want to delete this permission?\')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('settings.permissions.index');
    }

    /**
     * Show the form for creating a new permission.
     */
    public function create()
    {
        return view('settings.permissions.create');
    }

    /**
     * Store a newly created permission in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions'],
        ]);

        Permission::create(['name' => $request->name]);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission created successfully');
    }

    /**
     * Display the specified permission.
     */
    public function show(Permission $permission)
    {
        return view('settings.permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified permission.
     */
    public function edit(Permission $permission)
    {
        return view('settings.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified permission in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name,' . $permission->id],
        ]);

        $permission->name = $request->name;
        $permission->save();

        return redirect()->route('permissions.index')
            ->with('success', 'Permission updated successfully');
    }

    /**
     * Remove the specified permission from storage.
     */
    public function destroy(Permission $permission)
    {
        // Check if permission is being used by any roles
        if ($permission->roles()->count() > 0) {
            return redirect()->route('permissions.index')
                ->with('error', 'Cannot delete permission as it is assigned to roles');
        }
        
        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('success', 'Permission deleted successfully');
    }
} 