<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\AdditionalDocumentType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdditionalDocumentTypeController extends Controller
{
    public function index()
    {
        return view('master.additional-document-types.index');
    }

    public function data()
    {
        try {
            $query = AdditionalDocumentType::query();
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('actions', function ($documentType) {
                    return view('master.additional-document-types.actions', compact('documentType'))->render();
                })
                ->rawColumns(['actions'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_name' => 'required|string|max:255|unique:additional_document_types,type_name'
        ]);

        AdditionalDocumentType::create($request->all());

        return response()->json(['message' => 'Document type created successfully']);
    }

    public function edit(AdditionalDocumentType $additionalDocumentType)
    {
        return response()->json($additionalDocumentType);
    }

    public function update(Request $request, AdditionalDocumentType $additionalDocumentType)
    {
        $request->validate([
            'type_name' => 'required|string|max:255|unique:additional_document_types,type_name,' . $additionalDocumentType->id
        ]);

        $additionalDocumentType->update($request->all());

        return response()->json(['message' => 'Document type updated successfully']);
    }

    public function destroy(AdditionalDocumentType $additionalDocumentType)
    {
        $additionalDocumentType->delete();
        return response()->json(['message' => 'Document type deleted successfully']);
    }
} 