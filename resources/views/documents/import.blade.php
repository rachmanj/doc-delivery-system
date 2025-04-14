@extends('layouts.main')

@section('title', 'Import Additional Documents')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Import Additional Documents from Excel</h3>
                    </div>
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('documents.import.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="file">Excel File</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('file') is-invalid @enderror"
                                            id="file" name="file" accept=".xlsx,.xls" required>
                                        <label class="custom-file-label" for="file">Choose file</label>
                                    </div>
                                </div>
                                @error('file')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="check_duplicates"
                                        name="check_duplicates" value="1">
                                    <label class="custom-control-label" for="check_duplicates">Check for duplicates (skip
                                        existing document numbers)</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Import</button>
                                <a href="{{ route('documents.index') }}" class="btn btn-default">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
@endpush
