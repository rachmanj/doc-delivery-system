<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Models\AdditionalDocument;
use App\Models\AdditionalDocumentType;
use App\Models\Invoice;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class AdditionalDocumentController extends Controller
{
    public function index()
    {
        return view('documents.index');
    }

    public function create()
    {
        $types = AdditionalDocumentType::all();
        $invoices = Invoice::all();
        $departments = Department::all();
        return view('documents.create', compact('types', 'invoices', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type_id' => 'required|exists:additional_document_types,id',
            'document_number' => 'required|string|max:255',
            'document_date' => 'required|date',
            'po_no' => 'nullable|string|max:50',
            'invoice_id' => 'nullable|exists:invoices,id',
            'project' => 'nullable|string|max:50',
            'receive_date' => 'nullable|date',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:2048',
            'remarks' => 'nullable|string',
            'flag' => 'nullable|string|max:30',
            'cur_loc' => 'nullable|string|max:30',
            'ito_creator' => 'nullable|string|max:50',
            'grpo_no' => 'nullable|string|max:20',
            'origin_wh' => 'nullable|string|max:20',
            'destination_wh' => 'nullable|string|max:20',
            'batch_no' => 'nullable|integer',
        ]);

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('documents', 'public');
            $validated['attachment'] = $path;
        }

        $validated['created_by'] = Auth::id();
        $validated['status'] = 'open';

        AdditionalDocument::create($validated);

        return redirect()->route('documents.index')
            ->with('success', 'Document created successfully.');
    }

    public function show(AdditionalDocument $document)
    {
        $document->load(['type', 'createdBy', 'invoice']);
        return view('documents.show', compact('document'));
    }

    public function edit(AdditionalDocument $document)
    {
        $types = AdditionalDocumentType::all();
        $invoices = Invoice::all();
        $departments = Department::all();
        return view('documents.edit', compact('document', 'types', 'invoices', 'departments'));
    }

    public function update(Request $request, AdditionalDocument $document)
    {
        $validated = $request->validate([
            'type_id' => 'required|exists:additional_document_types,id',
            'document_number' => 'required|string|max:255',
            'document_date' => 'required|date',
            'po_no' => 'nullable|string|max:50',
            'invoice_id' => 'nullable|exists:invoices,id',
            'project' => 'nullable|string|max:50',
            'receive_date' => 'nullable|date',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'remarks' => 'nullable|string',
            'flag' => 'nullable|string|max:30',
            'cur_loc' => 'nullable|string|max:30',
            'ito_creator' => 'nullable|string|max:50',
            'grpo_no' => 'nullable|string|max:20',
            'origin_wh' => 'nullable|string|max:20',
            'destination_wh' => 'nullable|string|max:20',
            'batch_no' => 'nullable|integer',
            'status' => 'nullable|string|max:20',
        ]);

        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($document->attachment) {
                Storage::disk('public')->delete($document->attachment);
            }
            
            $path = $request->file('attachment')->store('documents', 'public');
            $validated['attachment'] = $path;
        }

        $document->update($validated);

        return redirect()->route('documents.index')
            ->with('success', 'Document updated successfully.');
    }

    public function destroy(AdditionalDocument $document)
    {
        if ($document->attachment) {
            Storage::disk('public')->delete($document->attachment);
        }
        
        $document->delete();

        return redirect()->route('documents.index')
            ->with('success', 'Document deleted successfully.');
    }

    public function data()
    {
        try {
            $query = AdditionalDocument::with(['type', 'invoice'])
                ->select('additional_documents.*');

            \Log::info('DataTables Query:', ['query' => $query->toSql(), 'bindings' => $query->getBindings()]);

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('actions', function ($document) {
                    return view('documents.partials.actions', compact('document'))->render();
                })
                ->rawColumns(['actions'])
                ->make(true);
        } catch (\Exception $e) {
            \Log::error('DataTables Error:', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
} 