<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $projects = Project::orderBy('code', 'asc');
            return DataTables::of($projects)
                ->addColumn('actions', function ($project) {
                    return view('master.projects.actions', compact('project'))->render();
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('master.projects.index');
    }

    public function create()
    {
        return view('master.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10',
            'owner' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        Project::create($validated);

        return response()->json([
            'message' => 'Project created successfully.'
        ]);
    }

    public function edit(Project $project)
    {
        return response()->json($project);
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10',
            'owner' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $project->update($validated);

        return response()->json([
            'message' => 'Project updated successfully.'
        ]);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json([
            'message' => 'Project deleted successfully.'
        ]);
    }
} 