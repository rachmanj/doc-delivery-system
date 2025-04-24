@extends('layouts.main')

@section('title', 'Departments Management')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Departments Management</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item active">Departments</li>
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Departments Management</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#departmentModal">
                                    <i class="fas fa-plus"></i> Add New Department
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="departments-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Project</th>
                                        <th>Location Code</th>
                                        <th>Transit Code</th>
                                        <th>Akronim</th>
                                        <th>SAP Code</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

    <!-- Department Modal -->
    <div class="modal fade" id="departmentModal" tabindex="-1" role="dialog" aria-labelledby="departmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="departmentModalLabel">Add New Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="departmentForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="department_id" name="id">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="project">Project</label>
                            <input type="text" class="form-control" id="project" name="project">
                        </div>
                        <div class="form-group">
                            <label for="location_code">Location Code</label>
                            <input type="text" class="form-control" id="location_code" name="location_code">
                        </div>
                        <div class="form-group">
                            <label for="transit_code">Transit Code</label>
                            <input type="text" class="form-control" id="transit_code" name="transit_code">
                        </div>
                        <div class="form-group">
                            <label for="akronim">Akronim</label>
                            <input type="text" class="form-control" id="akronim" name="akronim">
                        </div>
                        <div class="form-group">
                            <label for="sap_code">SAP Code</label>
                            <input type="text" class="form-control" id="sap_code" name="sap_code">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script>
        $(function() {
            let table = $('#departments-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('master.departments.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'project',
                        name: 'project'
                    },
                    {
                        data: 'location_code',
                        name: 'location_code'
                    },
                    {
                        data: 'transit_code',
                        name: 'transit_code'
                    },
                    {
                        data: 'akronim',
                        name: 'akronim'
                    },
                    {
                        data: 'sap_code',
                        name: 'sap_code'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Handle form submission
            $('#departmentForm').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                let url = "{{ route('master.departments.store') }}";
                let method = 'POST';

                if ($('#department_id').val()) {
                    url = "{{ url('master/departments') }}/" + $('#department_id').val();
                    method = 'PUT';
                }

                $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#departmentModal').modal('hide');
                        table.ajax.reload();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            toastr.error(value[0]);
                        });
                    }
                });
            });

            // Handle edit button click
            $(document).on('click', '.edit-department', function() {
                let id = $(this).data('id');
                $.get("{{ url('master/departments') }}/" + id + "/edit", function(data) {
                    $('#department_id').val(data.id);
                    $('#name').val(data.name || '');
                    $('#project').val(data.project || '');
                    $('#location_code').val(data.location_code || '');
                    $('#transit_code').val(data.transit_code || '');
                    $('#akronim').val(data.akronim || '');
                    $('#sap_code').val(data.sap_code || '');
                    $('#departmentModalLabel').text('Edit Department');
                    $('#departmentModal').modal('show');
                });
            });

            // Handle delete button click
            $(document).on('click', '.delete-department', function() {
                let id = $(this).data('id');
                let form = $(this).closest('.delete-form');

                if (confirm('Are you sure you want to delete this department?')) {
                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: form.find('input[name="_token"]').val()
                        },
                        success: function(response) {
                            table.ajax.reload();
                            toastr.success(response.message);
                        },
                        error: function(xhr) {
                            toastr.error('Error deleting department');
                        }
                    });
                }
            });

            // Reset form when modal is closed
            $('#departmentModal').on('hidden.bs.modal', function() {
                $('#departmentForm')[0].reset();
                $('#department_id').val('');
                $('#departmentModalLabel').text('Add New Department');
            });
        });
    </script>
@endpush
