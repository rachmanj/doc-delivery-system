<?php

namespace App\Http\Controllers\Master;

use App\Models\InvoiceType;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\ValidationException;
use Exception;

class InvoiceTypeController extends BaseMasterController
{
    /**
     * Search invoice types with pagination
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

            $query = $this->applyFilters(InvoiceType::query(), $request);
            $perPage = $request->input('per_page', 10);
            $invoiceTypes = $query->paginate($perPage);

            return $this->successResponse('Invoice types retrieved successfully', $invoiceTypes);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return $this->errorResponse('Failed to search invoice types: ' . $e->getMessage());
        }
    }

    /**
     * Get all invoice types without pagination
     *
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
        try {
            $invoiceTypes = InvoiceType::select('id', 'type_name')
                ->orderBy('type_name')
                ->get();

            return $this->successResponse('Invoice types retrieved successfully', $invoiceTypes);
        } catch (Exception $e) {
            return $this->errorResponse('Failed to fetch invoice types: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created invoice type
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $this->validateInvoiceType($request);
            
            $invoiceType = InvoiceType::create($validated);
            
            return $this->successResponse('Invoice type created successfully', $invoiceType, 201);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return $this->errorResponse('Failed to create invoice type: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified invoice type
     *
     * @param Request $request
     * @param InvoiceType $invoiceType
     * @return JsonResponse
     */
    public function update(Request $request, InvoiceType $invoiceType): JsonResponse
    {
        try {
            $validated = $this->validateInvoiceTypeUpdate($request, $invoiceType->id);
            
            $invoiceType->update($validated);
            
            // Get only the changed attributes
            $changes = array_intersect_key(
                $invoiceType->getChanges(),
                $validated
            );
            
            return $this->successResponse('Invoice type updated successfully', [
                'id' => $invoiceType->id,
                'changes' => $changes,
                'invoice_type' => $invoiceType
            ]);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return $this->errorResponse('Failed to update invoice type: ' . $e->getMessage());
        }
    }

    /**
     * Delete an invoice type
     *
     * @param InvoiceType $invoiceType
     * @return JsonResponse
     */
    public function destroy(InvoiceType $invoiceType): JsonResponse
    {
        try {
            // Check if invoice type is in use
            if ($invoiceType->invoices()->exists()) {
                return $this->errorResponse('Cannot delete invoice type that is in use', 422);
            }
            
            $invoiceType->delete();
            
            return $this->successResponse('Invoice type deleted successfully');
        } catch (Exception $e) {
            return $this->errorResponse('Failed to delete invoice type: ' . $e->getMessage());
        }
    }

    /**
     * Apply filters to the invoice type query
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
     * Validate invoice type creation data
     *
     * @param Request $request
     * @return array
     */
    protected function validateInvoiceType(Request $request): array
    {
        return $request->validate([
            'type_name' => 'required|string|max:100|unique:invoice_types'
        ]);
    }

    /**
     * Validate invoice type update data
     *
     * @param Request $request
     * @param int $id
     * @return array
     */
    protected function validateInvoiceTypeUpdate(Request $request, int $id): array
    {
        return $request->validate([
            'type_name' => 'required|string|max:100|unique:invoice_types,type_name,' . $id
        ]);
    }
}
