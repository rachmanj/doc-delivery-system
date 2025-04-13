@extends('layouts.main')

@section('title', isset($department) ? 'Edit Department' : 'Create Department')

@section('content')
    <form
        action="{{ isset($department) ? route('master.departments.update', $department->id) : route('master.departments.store') }}"
        method="POST">
        @csrf
        @if (isset($department))
            @method('PUT')
        @endif

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                        value="{{ old('name', $department->name ?? '') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="project">Project</label>
                    <input type="text" class="form-control @error('project') is-invalid @enderror" id="project"
                        name="project" value="{{ old('project', $department->project ?? '') }}">
                    @error('project')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="location_code">Location Code</label>
                    <input type="text" class="form-control @error('location_code') is-invalid @enderror"
                        id="location_code" name="location_code"
                        value="{{ old('location_code', $department->location_code ?? '') }}">
                    @error('location_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="transit_code">Transit Code</label>
                    <input type="text" class="form-control @error('transit_code') is-invalid @enderror" id="transit_code"
                        name="transit_code" value="{{ old('transit_code', $department->transit_code ?? '') }}">
                    @error('transit_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="akronim">Akronim</label>
                    <input type="text" class="form-control @error('akronim') is-invalid @enderror" id="akronim"
                        name="akronim" value="{{ old('akronim', $department->akronim ?? '') }}">
                    @error('akronim')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="sap_code">SAP Code</label>
                    <input type="text" class="form-control @error('sap_code') is-invalid @enderror" id="sap_code"
                        name="sap_code" value="{{ old('sap_code', $department->sap_code ?? '') }}">
                    @error('sap_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('master.departments.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
