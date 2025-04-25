@extends('layouts.main')

@section('title', 'Additional Documents')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Documents</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Search Panel -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Search Documents</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="searchForm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="search_document_number">Document Number</label>
                                            <input type="text" class="form-control" id="search_document_number"
                                                name="document_number" placeholder="Enter document number">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="search_type">Document Type</label>
                                            <select class="form-control select2bs4" id="search_type" name="type_id">
                                                <option value="">All Types</option>
                                                @foreach ($types as $type)
                                                    <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="search_po_no">PO Number</label>
                                            <input type="text" class="form-control" id="search_po_no" name="po_no"
                                                placeholder="Enter PO number">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="search_invoice">Invoice Number</label>
                                            <select class="form-control select2bs4" id="search_invoice"
                                                name="invoice_number">
                                                <option value="">All Invoices</option>
                                                @foreach ($invoices as $invoice)
                                                    <option value="{{ $invoice->invoice_number }}">
                                                        {{ $invoice->invoice_number }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="search_cur_loc">Current Location</label>
                                            <select class="form-control select2bs4" id="search_cur_loc" name="cur_loc">
                                                <option value="">All Locations</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->location_code }}">{{ $department->name }}
                                                        ({{ $department->location_code }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group pt-4 mt-2">
                                            <button type="button" id="searchButton" class="btn btn-sm btn-primary">
                                                <i class="fas fa-search"></i> Search
                                            </button>
                                            <button type="button" id="resetButton" class="btn btn-sm btn-default">
                                                <i class="fas fa-undo"></i> Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results Table -->
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
                            <table id="documentsTable" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th width="3%">#</th>
                                        <th width="15%">Document Number</th>
                                        <th width="10%">Type</th>
                                        <th width="10%">Date</th>
                                        <th width="10%">PO No</th>
                                        <th width="10%">Invoice</th>
                                        <th width="10%">Receive Date</th>
                                        <th width="15%">Current Location</th>
                                        <th width="10%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@push('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <style>
        .btn-group .btn {
            margin-right: 5px;
        }

        .table-sm td,
        .table-sm th {
            padding: 0.3rem;
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
    <!-- Select2 -->
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(function() {
            // Initialize Select2
            $('.select2bs4').select2({
                theme: 'bootstrap4',
                width: '100%'
            });

            let table;

            // Initialize DataTable with processing indicator but no initial data
            initializeTable(false);

            // Search button click
            $('#searchButton').on('click', function() {
                if (table) {
                    table.destroy();
                }
                initializeTable(true);
            });

            // Reset button click
            $('#resetButton').on('click', function() {
                $('#searchForm')[0].reset();
                if (table) {
                    table.destroy();
                }
                initializeTable(false);
            });

            // Initialize the DataTable
            function initializeTable(loadData) {
                table = $('#documentsTable').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false, // Disable built-in search as we have custom search
                    ajax: {
                        url: "{{ route('documents.data') }}",
                        type: "GET",
                        data: function(d) {
                            if (loadData) {
                                d.document_number = $('#search_document_number').val();
                                d.type_id = $('#search_type').val();
                                d.po_no = $('#search_po_no').val();
                                d.invoice_number = $('#search_invoice').val();
                                d.cur_loc = $('#search_cur_loc').val();
                            } else {
                                // Send flag to return empty dataset on initial load
                                d.initial_load = true;
                            }
                        }
                    },
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
                            data: 'cur_loc',
                            name: 'cur_loc',
                            defaultContent: 'N/A'
                        },
                        {
                            data: 'actions',
                            name: 'actions',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    responsive: true,
                    pageLength: 25,
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, "All"]
                    ]
                });
            }

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
