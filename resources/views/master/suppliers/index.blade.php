@extends('layouts.main')

@section('title', 'Suppliers Management')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Suppliers Management</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#supplierModal">
                                <i class="fas fa-plus"></i> Add New Supplier
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="suppliers-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>SAP Code</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>City</th>
                                    <th>Payment Project</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Supplier Modal -->
    <div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="supplierModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="supplierModalLabel">Add New Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="supplierForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="supplier_id" name="id">
                        <div class="form-group">
                            <label for="sap_code">SAP Code</label>
                            <input type="text" class="form-control" id="sap_code" name="sap_code" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="vendor">Vendor</option>
                                <option value="customer">Customer</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city">
                        </div>
                        <div class="form-group">
                            <label for="payment_project">Payment Project</label>
                            <input type="text" class="form-control" id="payment_project" name="payment_project"
                                value="001H">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active"
                                    value="1" checked>
                                <label class="custom-control-label" for="is_active">Active</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="npwp">NPWP</label>
                            <input type="text" class="form-control" id="npwp" name="npwp">
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
            let table = $('#suppliers-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('master.suppliers.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'sap_code',
                        name: 'sap_code'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'city',
                        name: 'city'
                    },
                    {
                        data: 'payment_project',
                        name: 'payment_project'
                    },
                    {
                        data: 'status',
                        name: 'is_active'
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
            $('#supplierForm').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                let url = "{{ route('master.suppliers.store') }}";
                let method = 'POST';

                if ($('#supplier_id').val()) {
                    url = "{{ url('master/suppliers') }}/" + $('#supplier_id').val();
                    method = 'PUT';
                }

                // Ensure is_active is properly set
                if (!$('#is_active').prop('checked')) {
                    formData += '&is_active=0';
                }

                $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#supplierModal').modal('hide');
                        table.ajax.reload();
                        toastr.success(response.message || 'Operation successful');
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error('An error occurred while processing your request');
                        }
                    }
                });
            });

            // Handle edit button click
            $(document).on('click', '.edit-supplier', function() {
                let id = $(this).data('id');
                $.ajax({
                    url: "{{ url('master/suppliers') }}/" + id + "/edit",
                    method: 'GET',
                    success: function(response) {
                        console.log('Edit response:', response); // Debug log
                        $('#supplier_id').val(response.id);
                        $('#sap_code').val(response.sap_code);
                        $('#name').val(response.name);
                        $('#type').val(response.type);
                        $('#city').val(response.city);
                        $('#payment_project').val(response.payment_project);
                        $('#is_active').prop('checked', response.is_active === 1 || response
                            .is_active === true);
                        $('#address').val(response.address);
                        $('#npwp').val(response.npwp);
                        $('#supplierModalLabel').text('Edit Supplier');
                        $('#supplierModal').modal('show');
                    },
                    error: function(xhr) {
                        console.error('Error fetching supplier data:', xhr);
                        toastr.error('Error loading supplier data');
                    }
                });
            });

            // Handle delete button click
            $(document).on('click', '.delete-supplier', function() {
                let id = $(this).data('id');
                let form = $(this).closest('.delete-form');

                if (confirm('Are you sure you want to delete this supplier?')) {
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
                            toastr.error('Error deleting supplier');
                        }
                    });
                }
            });

            // Reset form when modal is closed
            $('#supplierModal').on('hidden.bs.modal', function() {
                $('#supplierForm')[0].reset();
                $('#supplier_id').val('');
                $('#payment_project').val('001H');
                $('#is_active').prop('checked', true);
                $('#supplierModalLabel').text('Add New Supplier');
            });
        });
    </script>
@endpush
