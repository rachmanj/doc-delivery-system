<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

abstract class BaseMasterController extends Controller
{
    /**
     * Return a standardized success response
     *
     * @param string $message
     * @param mixed $data
     * @param int $status
     * @return JsonResponse
     */
    protected function successResponse(string $message, $data = null, int $status = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $status);
    }

    /**
     * Return a standardized error response
     *
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    protected function errorResponse(string $message, int $status = 500): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $status);
    }

    /**
     * Return a standardized validation error response
     *
     * @param array $errors
     * @return JsonResponse
     */
    protected function validationErrorResponse(array $errors): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Validation error',
            'errors' => $errors,
        ], 422);
    }
} 