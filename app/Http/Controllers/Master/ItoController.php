<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Imports\ItoImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Exception;

class ItoController extends BaseMasterController
{
    /**
     * Import ITO data from Excel file
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function import(Request $request): JsonResponse
    {
        try {
            $validated = $this->validateImportFile($request);
            
            $import = new ItoImport(false);
            Excel::import($import, $request->file('file'));

            return $this->successResponse('Data imported successfully', [
                'imported' => $import->getSuccessCount(),
                'skipped' => $import->getSkippedCount()
            ]);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return $this->errorResponse('Error importing data: ' . $e->getMessage());
        }
    }

    /**
     * Check import data without actually importing
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function checkImport(Request $request): JsonResponse
    {
        try {
            $validated = $this->validateImportFile($request);
            
            $import = new ItoImport(true);
            Excel::import($import, $request->file('file'));

            return $this->successResponse('Import check completed', [
                'importable' => $import->getSuccessCount(),
                'duplicates' => $import->getSkippedCount()
            ]);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e->errors());
        } catch (Exception $e) {
            return $this->errorResponse('Error checking import: ' . $e->getMessage());
        }
    }

    /**
     * Validate import file
     *
     * @param Request $request
     * @return array
     * @throws ValidationException
     */
    protected function validateImportFile(Request $request): array
    {
        return $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
    }
}
