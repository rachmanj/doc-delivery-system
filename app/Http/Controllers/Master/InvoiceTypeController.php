<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\InvoiceType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InvoiceTypeController extends Controller
{
    public function index()
    {
        return view('master.invoice-types.index');
    }

    public function data()
    {
        try {
            $query = InvoiceType::query();
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('actions', function ($invoiceType) {
                    return view('master.invoice-types.actions', compact('invoiceType'))->render();
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
            'type_name' => 'required|string|max:255|unique:invoice_types,type_name'
        ]);

        InvoiceType::create($request->all());

        return response()->json(['message' => 'Invoice type created successfully']);
    }

    public function edit(InvoiceType $invoiceType)
    {
        return response()->json($invoiceType);
    }

    public function update(Request $request, InvoiceType $invoiceType)
    {
        $request->validate([
            'type_name' => 'required|string|max:255|unique:invoice_types,type_name,' . $invoiceType->id
        ]);

        $invoiceType->update($request->all());

        return response()->json(['message' => 'Invoice type updated successfully']);
    }

    public function destroy(InvoiceType $invoiceType)
    {
        $invoiceType->delete();
        return response()->json(['message' => 'Invoice type deleted successfully']);
    }
} 