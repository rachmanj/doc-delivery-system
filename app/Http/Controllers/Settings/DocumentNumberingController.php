<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\DocumentNumberingSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DocumentNumberingController extends Controller
{
    // Generate number without saving to database
    public function generateNumber(Request $request)
    {
        try {
            $request->validate([
                'doc_type' => 'required|in:LPD,SPI',
                'dept_code' => 'required|string'
            ]);

            $year = Carbon::now()->format('y');
            $departmentCode = strtoupper($request->dept_code);
            $documentType = $request->doc_type;

            // Get the next sequence number without saving
            $nextSequence = $this->getNextSequenceNumber($documentType, $departmentCode, $year);

            // Generate document number
            return $this->formatDocumentNumber($year, $departmentCode, $documentType, $nextSequence);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Generate number and save/update in database
    public function generateNumberStore(Request $request)
    {
        $request->validate([
            'doc_type' => 'required|in:LPD,SPI',
            'dept_code' => 'required|string'
        ]);

        $year = Carbon::now()->format('y');
        $departmentCode = strtoupper($request->dept_code);
        $documentType = $request->doc_type;

        // Get or create sequence with department_code
        $sequence = DocumentNumberingSequence::firstOrCreate(
            [
                'document_type' => $documentType,
                'department_code' => $departmentCode,
                'year' => $year
            ],
            ['sequence' => 0]
        );

        // Increment and save sequence
        $sequence->increment('sequence');
        $sequenceNumber = str_pad($sequence->sequence, 5, '0', STR_PAD_LEFT);

        // Generate and return document number
        return $this->formatDocumentNumber($year, $departmentCode, $documentType, $sequenceNumber);
    }

    // Helper method to get next sequence number without saving
    private function getNextSequenceNumber($documentType, $departmentCode, $year)
    {
        $sequence = DocumentNumberingSequence::where([
            'document_type' => $documentType,
            'department_code' => $departmentCode,
            'year' => $year
        ])->first();

        return $sequence ? $sequence->sequence + 1 : 1;
    }

    // Helper method to format document number
    private function formatDocumentNumber($year, $departmentCode, $documentType, $sequenceNumber)
    {
        $documentNumber = sprintf(
            '%s%s-%s%s',
            $year,
            $departmentCode,
            $documentType,
            str_pad($sequenceNumber, 5, '0', STR_PAD_LEFT)
        );

        return response()->json([
            'document_number' => $documentNumber
        ]);
    }
}
