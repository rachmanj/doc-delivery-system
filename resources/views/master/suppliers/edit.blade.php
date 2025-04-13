@extends('layouts.main')

@section('title', 'Edit Supplier')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Supplier</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('master.suppliers.update', $supplier) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="sap_code">SAP Code</label>
                                <input type="text" class="form-control @error('sap_code') is-invalid @enderror"
                                    id="sap_code" name="sap_code" value="{{ old('sap_code', $supplier->sap_code) }}">
                                @error('sap_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $supplier->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="type">Type</label>
                                <select class="form-control @error('type') is-invalid @enderror" id="type"
                                    name="type" required>
                                    <option value="vendor" {{ old('type', $supplier->type) == 'vendor' ? 'selected' : '' }}>
                                        Vendor</option>
                                    <option value="customer"
                                        {{ old('type', $supplier->type) == 'customer' ? 'selected' : '' }}>Customer</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror"
                                    id="city" name="city" value="{{ old('city', $supplier->city) }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="payment_project">Payment Project</label>
                                <input type="text" class="form-control @error('payment_project') is-invalid @enderror"
                                    id="payment_project" name="payment_project"
                                    value="{{ old('payment_project', $supplier->payment_project) }}" required>
                                @error('payment_project')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active"
                                        {{ old('is_active', $supplier->is_active) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">Active</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $supplier->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="npwp">NPWP</label>
                                <input type="text" class="form-control @error('npwp') is-invalid @enderror"
                                    id="npwp" name="npwp" value="{{ old('npwp', $supplier->npwp) }}">
                                @error('npwp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Update Supplier</button>
                            <a href="{{ route('master.suppliers.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
