<?php

namespace App\Http\Controllers\Master;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use App\Http\Resources\SupplierResource;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Exception;

class SupplierController extends BaseMasterController
{
    /**
     * Get suppliers with pagination
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $suppliers = Supplier::select('id', 'sap_code', 'name', 'type', 'created_by', 'is_active', 'payment_project')
                ->paginate(10);

            return $this->successResponse('Suppliers retrieved successfully', $suppliers);
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve suppliers: ' . $e->getMessage());
        }
    }

    /**
     * Get all suppliers without pagination
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function all(Request $request): JsonResponse
    {
        try {
            $query = Supplier::query();

            if ($request->has('type')) {
                $query->where('type', $request->type);
            }

            $suppliers = $query->orderBy('name', 'asc')->get();

            return $this->successResponse('Suppliers retrieved successfully', 
                SupplierResource::collection($suppliers));
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve suppliers: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created supplier
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $this->validateSupplier($request);
            $validated['created_by'] = Auth::id();
            
            $supplier = Supplier::create($validated);
            
            return $this->successResponse('Supplier created successfully', $supplier, 201);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return $this->errorResponse('Failed to create supplier: ' . $e->getMessage());
        }
    }

    /**
     * Get supplier by ID
     *
     * @param Supplier $supplier
     * @return JsonResponse
     */
    public function show(Supplier $supplier): JsonResponse
    {
        try {
            return $this->successResponse('Supplier retrieved successfully', $supplier);
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve supplier: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified supplier
     *
     * @param Request $request
     * @param Supplier $supplier
     * @return JsonResponse
     */
    public function update(Request $request, Supplier $supplier): JsonResponse
    {
        try {
            $validated = $this->validateSupplierUpdate($request);
            
            // Check for existing SAP code
            if (isset($validated['sap_code']) && $supplier->sap_code !== $validated['sap_code']) {
                $existingSapCode = Supplier::where('sap_code', $validated['sap_code'])->first();
                if ($existingSapCode) {
                    return $this->errorResponse('SAP Code already exists', 422);
                }
            }
            
            $supplier->update($validated);
            
            // Get only the changed attributes
            $changes = array_intersect_key(
                $supplier->getChanges(),
                $validated
            );
            
            return $this->successResponse('Supplier updated successfully', [
                'id' => $supplier->id,
                'changes' => $changes
            ]);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return $this->errorResponse('Failed to update supplier: ' . $e->getMessage());
        }
    }

    /**
     * Delete a supplier
     *
     * @param Supplier $supplier
     * @return JsonResponse
     */
    public function destroy(Supplier $supplier): JsonResponse
    {
        try {
            $supplier->delete();
            return $this->successResponse('Supplier deleted successfully');
        } catch (Exception $e) {
            return $this->errorResponse('Failed to delete supplier: ' . $e->getMessage());
        }
    }

    /**
     * Check target API availability
     *
     * @return JsonResponse
     */
    public function cek_target(): JsonResponse
    {
        try {
            $url = 'http://192.168.32.17/payreq-x-v3/api/customers';
            
            $client = new Client();
            $response = $client->get($url, [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'timeout' => 30,
                'verify' => false, // Skip SSL verification if needed
            ]);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

            if ($statusCode >= 400) {
                Log::error('Failed to fetch suppliers from external API', [
                    'status' => $statusCode,
                    'body' => $body,
                ]);
                return $this->errorResponse('Failed to fetch suppliers from external API', 500);
            }

            $data = json_decode($body, true);

            if (!isset($data['customers'])) {
                Log::error('External API response missing "customers" key', [
                    'response' => $data,
                ]);
                return $this->errorResponse('External API response missing "customers" key', 500);
            }

            return $this->successResponse('Suppliers fetched successfully from external API', $data);
        } catch (Exception $e) {
            Log::error('Failed to fetch suppliers from external API', ['exception' => $e]);
            return $this->errorResponse('Failed to fetch suppliers from external API: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Import suppliers from external API
     *
     * @return JsonResponse
     */
    public function import(): JsonResponse
    {
        try {
            $url = 'http://192.168.32.17/payreq-x-v3/api/customers';
            $client = new Client();
            $response = $client->get($url, [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'timeout' => 30,
                'verify' => false, // Skip SSL verification if needed
            ]);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

            if ($statusCode >= 400) {
                Log::error('Failed to fetch suppliers from external API', [
                    'status' => $statusCode,
                    'body' => $body,
                ]);
                return $this->errorResponse('Failed to fetch suppliers from external API', 500);
            }

            $suppliers = json_decode($body, true);
            $createdCount = 0;

            // Insert data to suppliers table
            foreach ($suppliers['customers'] as $supplier) {
                $existingSupplier = DB::table('suppliers')->where('sap_code', $supplier['code'])->first();
                if (!$existingSupplier) {
                    DB::table('suppliers')->insert([
                        'sap_code' => $supplier['code'],
                        'name' => $supplier['name'],
                        'type' => $supplier['type'],
                        'created_by' => Auth::id(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $createdCount++;
                }
            }

            return $this->successResponse("Data suppliers berhasil diimport. Total created: $createdCount");
        } catch (Exception $e) {
            Log::error('Failed to import suppliers', ['exception' => $e]);
            return $this->errorResponse('Failed to import suppliers: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Search suppliers with filters
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

            $query = $this->applyFilters(Supplier::query(), $request);
            $perPage = $request->input('per_page', 10);
            $suppliers = $query->paginate($perPage);

            return $this->successResponse('Suppliers retrieved successfully', $suppliers);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return $this->errorResponse('Failed to search suppliers: ' . $e->getMessage());
        }
    }

    /**
     * Get payment project options
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getPaymentProject(Request $request): JsonResponse
    {
        try {
            $paymentProjects = Supplier::select('payment_project')
                ->whereNotNull('payment_project')
                ->distinct()
                ->orderBy('payment_project')
                ->get()
                ->pluck('payment_project');

            return $this->successResponse('Payment projects retrieved successfully', $paymentProjects);
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve payment projects: ' . $e->getMessage());
        }
    }

    /**
     * Apply filters to the supplier query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applyFilters($query, Request $request)
    {
        if ($request->has('sap_code')) {
            $query->where('sap_code', 'like', '%' . $request->sap_code . '%');
        }

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('payment_project')) {
            $query->where('payment_project', $request->payment_project);
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        return $query;
    }

    /**
     * Validate supplier creation data
     *
     * @param Request $request
     * @return array
     */
    protected function validateSupplier(Request $request): array
    {
        return $request->validate([
            'sap_code' => 'required|string|unique:suppliers,sap_code',
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:customer,vendor',
            'payment_project' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);
    }

    /**
     * Validate supplier update data
     *
     * @param Request $request
     * @return array
     */
    protected function validateSupplierUpdate(Request $request): array
    {
        return $request->validate([
            'sap_code' => 'sometimes|string',
            'name' => 'sometimes|string|max:255',
            'type' => 'sometimes|string|in:customer,vendor',
            'payment_project' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);
    }
}
