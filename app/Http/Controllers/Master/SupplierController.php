<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $suppliers = Supplier::query();
            return DataTables::of($suppliers)
                ->addColumn('actions', function ($supplier) {
                    return view('master.suppliers.actions', compact('supplier'))->render();
                })
                ->addColumn('status', function ($supplier) {
                    return $supplier->is_active ? 
                        '<span class="badge badge-success">Active</span>' : 
                        '<span class="badge badge-danger">Inactive</span>';
                })
                ->rawColumns(['actions', 'status'])
                ->make(true);
        }
        return view('master.suppliers.index');
    }

    public function create()
    {
        return view('master.suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sap_code' => 'nullable|string|max:50',
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:50|in:vendor,customer',
            'city' => 'nullable|string|max:255',
            'payment_project' => 'required|string|max:10',
            'is_active' => 'boolean',
            'address' => 'nullable|string',
            'npwp' => 'nullable|string|max:50',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['is_active'] = $request->has('is_active');

        Supplier::create($validated);

        return redirect()->route('master.suppliers.index')
            ->with('success', 'Supplier created successfully.');
    }

    public function edit(Supplier $supplier)
    {
        if (request()->ajax()) {
            return response()->json($supplier);
        }
        return view('master.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'sap_code' => 'nullable|string|max:50',
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:50|in:vendor,customer',
            'city' => 'nullable|string|max:255',
            'payment_project' => 'required|string|max:10',
            'is_active' => 'boolean',
            'address' => 'nullable|string',
            'npwp' => 'nullable|string|max:50',
        ]);

        // Handle is_active checkbox
        $validated['is_active'] = $request->input('is_active', false) ? true : false;

        $supplier->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Supplier updated successfully.'
            ]);
        }

        return redirect()->route('master.suppliers.index')
            ->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return response()->json(['success' => true]);
    }
} 