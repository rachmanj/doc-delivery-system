<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $departments = Department::orderBy('name', 'asc');
            return DataTables::of($departments)
                ->addColumn('actions', function ($department) {
                    return view('master.departments.actions', compact('department'))->render();
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('master.departments.index');
    }

    public function create()
    {
        return view('master.departments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:100',
            'project' => 'nullable|string|max:10',
            'location_code' => 'nullable|string|max:30',
            'transit_code' => 'nullable|string|max:30',
            'akronim' => 'nullable|string|max:10',
            'sap_code' => 'nullable|string|max:10',
        ]);

        Department::create($validated);

        return response()->json([
            'message' => 'Department created successfully.'
        ]);
    }

    public function edit(Department $department)
    {
        return response()->json($department);
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:100',
            'project' => 'nullable|string|max:10',
            'location_code' => 'nullable|string|max:30',
            'transit_code' => 'nullable|string|max:30',
            'akronim' => 'nullable|string|max:10',
            'sap_code' => 'nullable|string|max:10',
        ]);

        $department->update($validated);

        return response()->json([
            'message' => 'Department updated successfully.'
        ]);
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return response()->json([
            'message' => 'Department deleted successfully.'
        ]);
    }
} 