@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Additional Documents</h3>
                        <div class="card-tools">
                            <a href="{{ route('documents.create') }}" class="btn btn-success btn-sm">
                                <i class="fas fa-plus"></i> Add New Document
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="documentsTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Document Number</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>PO No</th>
                                    <th>Invoice</th>
                                    <th>Receive Date</th>
                                    <th>Remarks</th>
                                    <th width="15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Static data will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <style>
        .btn-group .btn {
            margin-right: 5px;
        }
    </style>
@endpush

@push('scripts')
    <!-- Moment.js -->
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <script>
        $(function() {
            $('#documentsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('documents.data') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'document_number',
                        name: 'document_number'
                    },
                    {
                        data: 'type.type_name',
                        name: 'type.type_name'
                    },
                    {
                        data: 'document_date',
                        name: 'document_date',
                        render: function(data) {
                            return moment(data).format('DD-MMM-YYYY');
                        }
                    },
                    {
                        data: 'po_no',
                        name: 'po_no'
                    },
                    {
                        data: 'invoice.invoice_number',
                        name: 'invoice.invoice_number',
                        defaultContent: 'N/A'
                    },
                    {
                        data: 'receive_date',
                        name: 'receive_date',
                        render: function(data) {
                            return data ? moment(data).format('DD-MMM-YYYY') : 'N/A';
                        },
                        defaultContent: 'N/A'
                    },
                    {
                        data: 'remarks',
                        name: 'remarks',
                        defaultContent: 'N/A'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ],
                responsive: true
            });

            // Handle document deletion with SweetAlert2
            $(document).on('click', '.delete-document', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
