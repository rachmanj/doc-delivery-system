<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;
use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('roles', 'department');
            return DataTables::of($users)
                ->addColumn('roles', function ($user) {
                    return $user->roles->pluck('name')->implode(', ');
                })
                ->addColumn('department', function ($user) {
                    return $user->department ? $user->department->name : 'N/A';
                })
                ->addColumn('status', function ($user) {
                    return $user->is_active ? 'Active' : 'Inactive';
                })
                ->addColumn('actions', function ($user) {
                    $actions = '<a href="' . route('users.show', $user->id) . '" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ';
                    $actions .= '<a href="' . route('users.edit', $user->id) . '" class="btn btn-warning btn-xs"><i class="fas fa-edit"></i></a> ';
                    if (auth()->id() !== $user->id) {
                        $actions .= '<form action="' . route('users.destroy', $user->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm(\'Are you sure you want to delete this user?\')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>';
                    }
                    return $actions;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('settings.users.index');
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::all();
        $departments = Department::all();
        $projects = Project::all();
        return view('settings.users.create', compact('roles', 'departments', 'projects'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'nik' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'department_id' => ['required', 'exists:departments,id'],
            'project' => ['nullable', 'string', 'max:255'],
            'roles' => ['required', 'array'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'nik' => $request->nik,
            'password' => Hash::make($request->password),
            'department_id' => $request->department_id,
            'project' => $request->project,
            'is_active' => $request->has('is_active'),
        ]);

        // Use role names directly since the form now submits role names
        $user->syncRoles($request->roles);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load('roles', 'department');
        return view('settings.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $departments = Department::all();
        $projects = Project::all();
        $userRoles = $user->roles->pluck('id')->toArray();
        
        return view('settings.users.edit', compact('user', 'roles', 'departments', 'projects', 'userRoles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'nik' => ['nullable', 'string', 'max:255'],
            'department_id' => ['required', 'exists:departments,id'],
            'project' => ['nullable', 'string', 'max:255'],
            'roles' => ['required', 'array'],
        ]);

        // Only validate password if it's provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Password::defaults()],
            ]);
            
            $user->password = Hash::make($request->password);
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->nik = $request->nik;
        $user->department_id = $request->department_id;
        $user->project = $request->project;
        $user->is_active = $request->has('is_active');
        $user->save();

        // Use role names directly since the form now submits role names
        $user->syncRoles($request->roles);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')
                ->with('error', 'You cannot delete your own account');
        }
        
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
} 