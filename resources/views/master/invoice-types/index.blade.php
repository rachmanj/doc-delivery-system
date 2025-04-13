@extends('layouts.main')

@section('title', 'Invoice Types Management')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <style>
        .btn-group .btn {
            margin-right: 5px;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Invoice Types Management</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#invoiceTypeModal">
                                <i class="fas fa-plus"></i> Add New Invoice Type
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="invoice-types-table" class="table table-bordered table-striped">
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

    <!-- Invoice Type Modal -->
    <div class="modal fade" id="invoiceTypeModal" tabindex="-1" role="dialog" aria-labelledby="invoiceTypeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="invoiceTypeModalLabel">Add New Invoice Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="invoiceTypeForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="invoice_type_id" name="id">
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

@push('scripts')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script>
        $(function() {
            let table = $('#invoice-types-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('master.invoice-types.data') }}",
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
            $('#invoiceTypeForm').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                let url = "{{ route('master.invoice-types.store') }}";
                let method = 'POST';

                if ($('#invoice_type_id').val()) {
                    url = "{{ url('master/invoice-types') }}/" + $('#invoice_type_id').val();
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
                        $('#invoiceTypeModal').modal('hide');
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
            $(document).on('click', '.edit-invoice-type', function() {
                let id = $(this).data('id');
                $.get("{{ url('master/invoice-types') }}/" + id + "/edit", function(data) {
                    $('#invoice_type_id').val(data.id);
                    $('#type_name').val(data.type_name || '');
                    $('#invoiceTypeModalLabel').text('Edit Invoice Type');
                    $('#invoiceTypeModal').modal('show');
                });
            });

            // Handle delete button click
            $(document).on('click', '.delete-invoice-type', function() {
                let id = $(this).data('id');
                let form = $(this).closest('.delete-form');

                if (confirm('Are you sure you want to delete this invoice type?')) {
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
                            toastr.error('Error deleting invoice type');
                        }
                    });
                }
            });

            // Reset form when modal is closed
            $('#invoiceTypeModal').on('hidden.bs.modal', function() {
                $('#invoiceTypeForm')[0].reset();
                $('#invoice_type_id').val('');
                $('#invoiceTypeModalLabel').text('Add New Invoice Type');
            });
        });
    </script>
@endpush
