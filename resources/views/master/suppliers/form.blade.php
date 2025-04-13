@extends('layouts.main')

@section('title', isset($supplier) ? 'Edit Supplier' : 'Create Supplier')

@section('content')
    <form action="{{ isset($supplier) ? route('master.suppliers.update', $supplier->id) : route('master.suppliers.store') }}"
        method="POST">
        @csrf
        @if (isset($supplier))
            @method('PUT')
        @endif

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="sap_code">SAP Code</label>
                    <input type="text" class="form-control @error('sap_code') is-invalid @enderror" id="sap_code"
                        name="sap_code" value="{{ old('sap_code', $supplier->sap_code ?? '') }}">
                    @error('sap_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name', $supplier->name ?? '') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="type">Type <span class="text-danger">*</span></label>
                    <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                        <option value="vendor" {{ old('type', $supplier->type ?? '') == 'vendor' ? 'selected' : '' }}>Vendor
                        </option>
                        <option value="customer" {{ old('type', $supplier->type ?? '') == 'customer' ? 'selected' : '' }}>
                            Customer</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" id="city"
                        name="city" value="{{ old('city', $supplier->city ?? '') }}">
                    @error('city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="payment_project">Payment Project <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('payment_project') is-invalid @enderror"
                        id="payment_project" name="payment_project"
                        value="{{ old('payment_project', $supplier->payment_project ?? '001H') }}" required>
                    @error('payment_project')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="npwp">NPWP</label>
                    <input type="text" class="form-control @error('npwp') is-invalid @enderror" id="npwp"
                        name="npwp" value="{{ old('npwp', $supplier->npwp ?? '') }}">
                    @error('npwp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $supplier->address ?? '') }}</textarea>
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="is_active">Status <span class="text-danger">*</span></label>
            <select class="form-control @error('is_active') is-invalid @enderror" id="is_active" name="is_active" required>
                <option value="1" {{ old('is_active', $supplier->is_active ?? '') == 1 ? 'selected' : '' }}>Active
                </option>
                <option value="0" {{ old('is_active', $supplier->is_active ?? '') == 0 ? 'selected' : '' }}>Inactive
                </option>
            </select>
            @error('is_active')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('master.suppliers.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
