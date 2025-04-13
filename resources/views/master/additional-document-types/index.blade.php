@extends('layouts.main')

@section('title', 'Additional Document Types Management')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <style>
        .btn-group .btn {
            margin-right: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Additional Document Types Management</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#documentTypeModal">
                                <i class="fas fa-plus"></i> Add New Document Type
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="document-types-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="5%">ID</th>
                                    <th>Type Name</th>
                                    <th width="15%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Document Type Modal -->
    <div class="modal fade" id="documentTypeModal" tabindex="-1" role="dialog" aria-labelledby="documentTypeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="documentTypeModalLabel">Add New Document Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="documentTypeForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="document_type_id" name="id">
                        <div class="form-group">
                            <label for="type_name">Type Name</label>
                            <input type="text" class="form-control" id="type_name" name="type_name">
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

@section('scripts')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script>
        $(function() {
            let table = $('#document-types-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('master.additional-document-types.data') }}",
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'type_name',
                        name: 'type_name'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [1, 'desc']
                ]
            });

            // Handle form submission
            $('#documentTypeForm').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                let url = "{{ route('master.additional-document-types.store') }}";
                let method = 'POST';

                if ($('#document_type_id').val()) {
                    url = "{{ url('master/additional-document-types') }}/" + $('#document_type_id').val();
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
                        $('#documentTypeModal').modal('hide');
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
            $(document).on('click', '.edit-document-type', function() {
                let id = $(this).data('id');
                $.get("{{ url('master/additional-document-types') }}/" + id + "/edit", function(data) {
                    $('#document_type_id').val(data.id);
                    $('#type_name').val(data.type_name || '');
                    $('#documentTypeModalLabel').text('Edit Document Type');
                    $('#documentTypeModal').modal('show');
                });
            });

            // Handle delete button click
            $(document).on('click', '.delete-document-type', function() {
                let id = $(this).data('id');
                let form = $(this).closest('.delete-form');

                if (confirm('Are you sure you want to delete this document type?')) {
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
                            toastr.error('Error deleting document type');
                        }
                    });
                }
            });

            // Reset form when modal is closed
            $('#documentTypeModal').on('hidden.bs.modal', function() {
                $('#documentTypeForm')[0].reset();
                $('#document_type_id').val('');
                $('#documentTypeModalLabel').text('Add New Document Type');
            });
        });
    </script>
@endsection
