<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Models\Department;
use App\Http\Resources\DepartmentResource;
use Illuminate\Validation\ValidationException;
use Exception;

class DepartmentController extends BaseMasterController
{
    /**
     * Search departments with filters and pagination
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

            $query = $this->applyFilters(Department::query(), $request);
            $perPage = $request->input('per_page', 10);
            $departments = $query->paginate($perPage);

            return $this->successResponse('Departments retrieved successfully', $departments);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return $this->errorResponse('Failed to search departments: ' . $e->getMessage());
        }
    }

    /**
     * Get all departments without pagination
     *
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
        try {
            $departments = Department::orderBy('name')->get();

            return $this->successResponse('Departments retrieved successfully', 
                DepartmentResource::collection($departments));
        } catch (Exception $e) {
            return $this->errorResponse('Failed to fetch departments: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created department
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $this->validateDepartment($request);
            
            $department = Department::create($validated);

            return $this->successResponse('Department created successfully', 
                new DepartmentResource($department), 201);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return $this->errorResponse('Failed to create department: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified department
     *
     * @param Request $request
     * @param Department $department
     * @return JsonResponse
     */
    public function update(Request $request, Department $department): JsonResponse
    {
        try {
            $validated = $this->validateDepartmentUpdate($request);
            
            $department->update($validated);
            
            // Get only the changed attributes
            $changes = array_intersect_key(
                $department->getChanges(),
                $validated
            );

            return $this->successResponse('Department updated successfully', [
                'id' => $department->id,
                'changes' => $changes,
                'department' => new DepartmentResource($department)
            ]);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return $this->errorResponse('Failed to update department: ' . $e->getMessage());
        }
    }

    /**
     * Delete a department
     *
     * @param Department $department
     * @return JsonResponse
     */
    public function destroy(Department $department): JsonResponse
    {
        try {
            // Check if department has users
            if ($department->users()->exists()) {
                return $this->errorResponse('Cannot delete department with associated users', 422);
            }

            $department->delete();

            return $this->successResponse('Department deleted successfully');
        } catch (Exception $e) {
            return $this->errorResponse('Failed to delete department: ' . $e->getMessage());
        }
    }

    /**
     * Get all location codes
     *
     * @return JsonResponse
     */
    public function getCurLocs(): JsonResponse
    {
        try {
            $cur_locs = Department::select('id', 'location_code')
                ->whereNotNull('location_code')
                ->distinct()
                ->orderBy('location_code')
                ->get();

            $formattedLocs = $cur_locs->map(function ($loc) {
                return [
                    'id' => $loc->id,
                    'location_code' => $loc->location_code
                ];
            });

            return $this->successResponse('Location codes retrieved successfully', $formattedLocs);
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve location codes: ' . $e->getMessage());
        }
    }

    /**
     * Apply filters to the department query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applyFilters($query, Request $request)
    {
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        
        if ($request->has('project')) {
            $query->where('project', 'like', '%' . $request->project . '%');
        }
        
        if ($request->has('location_code')) {
            $query->where('location_code', 'like', '%' . $request->location_code . '%');
        }
        
        if ($request->has('transit_code')) {
            $query->where('transit_code', 'like', '%' . $request->transit_code . '%');
        }
        
        if ($request->has('akronim')) {
            $query->where('akronim', 'like', '%' . $request->akronim . '%');
        }
        
        if ($request->has('sap_code')) {
            $query->where('sap_code', 'like', '%' . $request->sap_code . '%');
        }

        return $query;
    }

    /**
     * Validate department creation data
     *
     * @param Request $request
     * @return array
     */
    protected function validateDepartment(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:100',
            'project' => 'nullable|string|max:10',
            'location_code' => 'nullable|string|max:30',
            'transit_code' => 'nullable|string|max:30',
            'akronim' => 'nullable|string|max:10',
            'sap_code' => 'nullable|string|max:10'
        ]);
    }

    /**
     * Validate department update data
     *
     * @param Request $request
     * @return array
     */
    protected function validateDepartmentUpdate(Request $request): array
    {
        return $request->validate([
            'name' => 'sometimes|string|max:100',
            'project' => 'nullable|string|max:10',
            'location_code' => 'nullable|string|max:30',
            'transit_code' => 'nullable|string|max:30',
            'akronim' => 'nullable|string|max:10',
            'sap_code' => 'nullable|string|max:10'
        ]);
    }
}
