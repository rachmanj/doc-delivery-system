@extends('layouts.main')

@section('title', 'Notification Examples')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Notification Examples</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Notification Examples</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Toastr Notifications</h3>
                        </div>
                        <div class="card-body">
                            <p>Click the buttons below to show Toastr notifications:</p>

                            <div class="btn-group mb-3">
                                <button type="button" class="btn btn-success"
                                    onclick="toastr.success('This is a success message')">
                                    Success
                                </button>
                                <button type="button" class="btn btn-danger"
                                    onclick="toastr.error('This is an error message')">
                                    Error
                                </button>
                                <button type="button" class="btn btn-info"
                                    onclick="toastr.info('This is an info message')">
                                    Info
                                </button>
                                <button type="button" class="btn btn-warning"
                                    onclick="toastr.warning('This is a warning message')">
                                    Warning
                                </button>
                            </div>

                            <p>In your controller, you can use:</p>
                            <pre><code>use App\Facades\Notify;

// In your method
Notify::success('Your message here');
Notify::error('Your error message');
Notify::info('Your info message');
Notify::warning('Your warning message');</code></pre>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">SweetAlert2 Examples</h3>
                        </div>
                        <div class="card-body">
                            <p>Click the buttons below to show SweetAlert2 dialogs:</p>

                            <div class="mb-3">
                                <button type="button" class="btn btn-danger"
                                    onclick="confirmDelete('#', 'Delete Demo', 'This is just a demonstration')">
                                    <i class="fas fa-trash"></i> Delete Confirmation
                                </button>
                            </div>

                            <div class="mb-3">
                                <form id="demo-form">
                                    <button type="button" class="btn btn-primary"
                                        onclick="confirmSubmit('demo-form', 'Submit Form?', 'This is just a demonstration')">
                                        <i class="fas fa-save"></i> Form Submit Confirmation
                                    </button>
                                </form>
                            </div>

                            <p>In your controller, you can use:</p>
                            <pre><code>use App\Facades\Notify;

// In your method
Notify::alert('Your message here', 'Optional Title');</code></pre>

                            <p>For delete buttons, you can use the component:</p>
                            <pre><code>&lt;x-delete-button url="{{ route('home') }}" /&gt;</code></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
