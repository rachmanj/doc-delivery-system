<?php

namespace App\Http\Controllers\Master;

use App\Models\AdditionalDocumentType;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\ValidationException;
use Exception;

class AdditionalDocumentTypeController extends BaseMasterController
{
    /**
     * Search document types with pagination
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

            $query = $this->applyFilters(AdditionalDocumentType::query(), $request);
            $perPage = $request->input('per_page', 10);
            $types = $query->paginate($perPage);

            return $this->successResponse('Document types retrieved successfully', $types);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return $this->errorResponse('Failed to search document types: ' . $e->getMessage());
        }
    }

    /**
     * Get all document types without pagination
     *
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
        try {
            $types = AdditionalDocumentType::select('id', 'type_name')
                ->orderBy('type_name', 'asc')
                ->get();

            return $this->successResponse('Document types retrieved successfully', $types);
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve document types: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created document type
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $this->validateDocumentType($request);
            
            $type = AdditionalDocumentType::create($validated);
            
            return $this->successResponse('Document type created successfully', $type, 201);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return $this->errorResponse('Failed to create document type: ' . $e->getMessage());
        }
    }

    /**
     * Get document type by ID
     *
     * @param AdditionalDocumentType $additionalDocumentType
     * @return JsonResponse
     */
    public function show(AdditionalDocumentType $additionalDocumentType): JsonResponse
    {
        try {
            return $this->successResponse('Document type retrieved successfully', $additionalDocumentType);
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve document type: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified document type
     *
     * @param Request $request
     * @param AdditionalDocumentType $additionalDocumentType
     * @return JsonResponse
     */
    public function update(Request $request, AdditionalDocumentType $additionalDocumentType): JsonResponse
    {
        try {
            $validated = $this->validateDocumentTypeUpdate($request, $additionalDocumentType->id);
            
            $additionalDocumentType->update($validated);
            
            // Get only the changed attributes
            $changes = array_intersect_key(
                $additionalDocumentType->getChanges(),
                $validated
            );
            
            return $this->successResponse('Document type updated successfully', [
                'id' => $additionalDocumentType->id,
                'changes' => $changes,
                'document_type' => $additionalDocumentType
            ]);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return $this->errorResponse('Failed to update document type: ' . $e->getMessage());
        }
    }

    /**
     * Delete a document type
     *
     * @param AdditionalDocumentType $additionalDocumentType
     * @return JsonResponse
     */
    public function destroy(AdditionalDocumentType $additionalDocumentType): JsonResponse
    {
        try {
            // Check if document type is in use
            if ($additionalDocumentType->documents()->exists()) {
                return $this->errorResponse('Cannot delete document type that is in use', 422);
            }
            
            $additionalDocumentType->delete();
            
            return $this->successResponse('Document type deleted successfully');
        } catch (Exception $e) {
            return $this->errorResponse('Failed to delete document type: ' . $e->getMessage());
        }
    }

    /**
     * Apply filters to the document type query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applyFilters($query, Request $request)
    {
        $query->select('id', 'type_name');
        
        if ($request->has('type_name')) {
            $query->where('type_name', 'like', '%' . $request->type_name . '%');
        }

        return $query;
    }

    /**
     * Validate document type creation data
     *
     * @param Request $request
     * @return array
     */
    protected function validateDocumentType(Request $request): array
    {
        return $request->validate([
            'type_name' => 'required|string|max:255|unique:additional_document_types'
        ]);
    }

    /**
     * Validate document type update data
     *
     * @param Request $request
     * @param int $id
     * @return array
     */
    protected function validateDocumentTypeUpdate(Request $request, int $id): array
    {
        return $request->validate([
            'type_name' => 'required|string|max:255|unique:additional_document_types,type_name,' . $id
        ]);
    }
}
