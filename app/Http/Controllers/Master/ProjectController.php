<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Models\Project;
use Illuminate\Validation\ValidationException;
use Exception;

class ProjectController extends BaseMasterController
{
    /**
     * Get all projects without pagination
     *
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
        try {
            $projects = Project::select('id', 'code')
                ->orderBy('code')
                ->get();

            return $this->successResponse('Projects retrieved successfully', $projects);
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve projects: ' . $e->getMessage());
        }
    }

    /**
     * Search projects with pagination
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'per_page' => 'nullable|integer|min:1|max:100',
            ]);

            $query = $this->applyFilters(Project::query(), $request);
            $perPage = $request->input('per_page', 10);
            $projects = $query->paginate($perPage);

            return $this->successResponse('Projects retrieved successfully', $projects);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return $this->errorResponse('Failed to search projects: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created project
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $this->validateProject($request);
            
            $project = Project::create($validated);
            
            return $this->successResponse('Project created successfully', $project, 201);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return $this->errorResponse('Failed to create project: ' . $e->getMessage());
        }
    }

    /**
     * Get project by ID
     *
     * @param Project $project
     * @return JsonResponse
     */
    public function show(Project $project): JsonResponse
    {
        try {
            return $this->successResponse('Project retrieved successfully', $project);
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve project: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified project
     *
     * @param Request $request
     * @param Project $project
     * @return JsonResponse
     */
    public function update(Request $request, Project $project): JsonResponse
    {
        try {
            $validated = $this->validateProjectUpdate($request, $project->id);
            
            $project->update($validated);
            
            // Get only the changed attributes
            $changes = array_intersect_key(
                $project->getChanges(),
                $validated
            );
            
            return $this->successResponse('Project updated successfully', [
                'id' => $project->id,
                'changes' => $changes,
                'project' => $project
            ]);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return $this->errorResponse('Failed to update project: ' . $e->getMessage());
        }
    }

    /**
     * Delete a project
     *
     * @param Project $project
     * @return JsonResponse
     */
    public function destroy(Project $project): JsonResponse
    {
        try {
            // Check if project is in use
            if ($project->invoices()->exists() || $project->documents()->exists()) {
                return $this->errorResponse('Cannot delete project that is in use', 422);
            }
            
            $project->delete();
            
            return $this->successResponse('Project deleted successfully');
        } catch (Exception $e) {
            return $this->errorResponse('Failed to delete project: ' . $e->getMessage());
        }
    }

    /**
     * Apply filters to the project query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applyFilters($query, Request $request)
    {
        if ($request->has('code')) {
            $query->where('code', 'like', '%' . $request->code . '%');
        }
        
        if ($request->has('owner')) {
            $query->where('owner', 'like', '%' . $request->owner . '%');
        }
        
        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        return $query;
    }

    /**
     * Validate project creation data
     *
     * @param Request $request
     * @return array
     */
    protected function validateProject(Request $request): array
    {
        return $request->validate([
            'code' => 'required|unique:projects',
            'owner' => 'nullable|string',
            'location' => 'nullable|string',
        ]);
    }

    /**
     * Validate project update data
     *
     * @param Request $request
     * @param int $id
     * @return array
     */
    protected function validateProjectUpdate(Request $request, int $id): array
    {
        return $request->validate([
            'code' => 'required|unique:projects,code,' . $id,
            'owner' => 'nullable|string',
            'location' => 'nullable|string',
        ]);
    }
}
