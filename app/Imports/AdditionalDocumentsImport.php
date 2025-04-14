<?php

namespace App\Imports;

use App\Models\AdditionalDocument;
use App\Models\AdditionalDocumentType;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdditionalDocumentsImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $checkDuplicates;
    protected $successCount = 0;
    protected $skippedCount = 0;
    protected $ito_type_id;

    public function __construct($checkDuplicates = false)
    {
        $this->checkDuplicates = $checkDuplicates;
        $this->ito_type_id = $this->getItoTypeId();
    }

    public function model(array $row)
    {
        try {
            if ($this->checkDuplicates) {
                // Check for existing document with same document_number
                $exists = AdditionalDocument::where('document_number', (string)$row['ito_no'])
                    ->exists();

                if ($exists) {
                    $this->skippedCount++;
                    return null; // Skip this record
                }
            }

            $this->successCount++;
            return new AdditionalDocument([
                'type_id' => $this->ito_type_id,
                'document_number' => (string)$row['ito_no'],
                'document_date' => $this->convert_date($row['ito_date']),
                'po_no' => isset($row['po_no']) ? (string)$row['po_no'] : null,
                'invoice_id' => isset($row['invoice_id']) ? (string)$row['invoice_id'] : null,
                'receive_date' => isset($row['receive_date']) ? $this->convert_date($row['receive_date']) : null,
                'remarks' => isset($row['ito_remarks']) ? (string)$row['ito_remarks'] : null,
                'cur_loc' => '000H-LOG',
                'ito_creator' => isset($row['ito_created_by']) ? (string)$row['ito_created_by'] : null,
                'grpo_no' => isset($row['grpo_no']) ? (string)$row['grpo_no'] : null,
                'origin_wh' => isset($row['origin_wh']) ? (string)$row['origin_wh'] : null,
                'destination_wh' => isset($row['destination_wh']) ? (string)$row['destination_wh'] : null,
                'batch_no' => $this->getBatchNo(),
                'created_by' => Auth::id(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Import Error:', [
                'row' => $row,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    private function convert_date($date)
    {
        try {
            if ($date) {
                // If it's already a Carbon instance or DateTime, format it
                if ($date instanceof \Carbon\Carbon || $date instanceof \DateTime) {
                    return $date->format('Y-m-d');
                }

                // If it's a numeric value (Excel date), convert it
                if (is_numeric($date)) {
                    return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date))->format('Y-m-d');
                }

                // If it's a string date, try to parse it
                $year = substr($date, 6, 4);
                $month = substr($date, 3, 2);
                $day = substr($date, 0, 2);
                $new_date = $year . '-' . $month . '-' . $day;
                return $new_date;
            }
            return null;
        } catch (\Exception $e) {
            \Log::error('Date Conversion Error:', [
                'date' => $date,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    private function getItoTypeId()
    {
        $ito_type = AdditionalDocumentType::firstOrCreate(
            ['type_name' => 'ITO']
        );

        if (!$ito_type) {
            throw new \Exception('Failed to get or create ITO document type');
        }

        return $ito_type->id;
    }

    private function getBatchNo()
    {
        $batch_no = AdditionalDocument::max('batch_no');
        return $batch_no + 1;
    }

    public function getSuccessCount()
    {
        return $this->successCount;
    }

    public function getSkippedCount()
    {
        return $this->skippedCount;
    }

    public function rules(): array
    {
        return [
            'ito_no' => 'required',
            'ito_date' => 'required',
            'po_no' => 'nullable',
            'invoice_id' => 'nullable',
            'receive_date' => 'nullable',
            'ito_remarks' => 'nullable',
            'ito_created_by' => 'nullable',
            'grpo_no' => 'nullable',
            'origin_wh' => 'nullable',
            'destination_wh' => 'nullable',
        ];
    }
} 