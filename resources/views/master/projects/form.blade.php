@extends('layouts.main')

@section('title', isset($project) ? 'Edit Project' : 'Create Project')

@section('content')
    <form action="{{ isset($project) ? route('master.projects.update', $project->id) : route('master.projects.store') }}"
        method="POST">
        @csrf
        @if (isset($project))
            @method('PUT')
        @endif

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="code">Code <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"
                        name="code" value="{{ old('code', $project->code ?? '') }}" required>
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="owner">Owner</label>
                    <input type="text" class="form-control @error('owner') is-invalid @enderror" id="owner"
                        name="owner" value="{{ old('owner', $project->owner ?? '') }}">
                    @error('owner')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control @error('location') is-invalid @enderror" id="location"
                name="location" value="{{ old('location', $project->location ?? '') }}">
            @error('location')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date"
                            name="start_date"
                            value="{{ old('start_date', $project->start_date ? $project->start_date->format('Y-m-d') : '') }}">
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date"
                            name="end_date"
                            value="{{ old('end_date', $project->end_date ? $project->end_date->format('Y-m-d') : '') }}">
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                    rows="3">{{ old('description', $project->description ?? '') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status <span class="text-danger">*</span></label>
                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="1" {{ old('status', $project->status ?? '') == 1 ? 'selected' : '' }}>Active
                    </option>
                    <option value="0" {{ old('status', $project->status ?? '') == 0 ? 'selected' : '' }}>Inactive
                    </option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('master.projects.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
    </form>
@endsection
