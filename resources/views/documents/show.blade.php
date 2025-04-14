@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Document Details</h5>
                        <div class="btn-group" role="group">
                            <a href="{{ route('documents.edit', $document) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <div style="margin-left: 5px;"></div> <!-- Added gap -->
                            <form action="{{ route('documents.destroy', $document) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this document?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted">Basic Information</h6>
                                <dl class="row">
                                    <dt class="col-sm-4">Document Number</dt>
                                    <dd class="col-sm-8">{{ $document->document_number }}</dd>

                                    <dt class="col-sm-4">Document Type</dt>
                                    <dd class="col-sm-8">{{ $document->type->name }}</dd>

                                    <dt class="col-sm-4">Document Date</dt>
                                    <dd class="col-sm-8">
                                        {{ \Carbon\Carbon::parse($document->document_date)->format('Y-m-d') }}</dd>

                                    <dt class="col-sm-4">Status</dt>
                                    <dd class="col-sm-8">
                                        <span class="badge bg-{{ $document->status === 'open' ? 'success' : 'warning' }}">
                                            {{ ucfirst($document->status) }}
                                        </span>
                                    </dd>
                                </dl>
                            </div>

                            <div class="col-md-6">
                                <h6 class="text-muted">Reference Information</h6>
                                <dl class="row">
                                    <dt class="col-sm-4">PO Number</dt>
                                    <dd class="col-sm-8">{{ $document->po_no ?? 'N/A' }}</dd>

                                    <dt class="col-sm-4">Invoice</dt>
                                    <dd class="col-sm-8">
                                        {{ $document->invoice ? $document->invoice->invoice_number : 'N/A' }}</dd>

                                    <dt class="col-sm-4">Project</dt>
                                    <dd class="col-sm-8">{{ $document->project ?? 'N/A' }}</dd>

                                    <dt class="col-sm-4">GRPO Number</dt>
                                    <dd class="col-sm-8">{{ $document->grpo_no ?? 'N/A' }}</dd>
                                </dl>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h6 class="text-muted">Location Information</h6>
                                <dl class="row">
                                    <dt class="col-sm-4">Current Location</dt>
                                    <dd class="col-sm-8">{{ $document->cur_loc ?? 'N/A' }}</dd>

                                    <dt class="col-sm-4">Origin Warehouse</dt>
                                    <dd class="col-sm-8">{{ $document->origin_wh ?? 'N/A' }}</dd>

                                    <dt class="col-sm-4">Destination Warehouse</dt>
                                    <dd class="col-sm-8">{{ $document->destination_wh ?? 'N/A' }}</dd>
                                </dl>
                            </div>

                            <div class="col-md-6">
                                <h6 class="text-muted">Additional Information</h6>
                                <dl class="row">
                                    <dt class="col-sm-4">Flag</dt>
                                    <dd class="col-sm-8">{{ $document->flag ?? 'N/A' }}</dd>

                                    <dt class="col-sm-4">ITO Creator</dt>
                                    <dd class="col-sm-8">{{ $document->ito_creator ?? 'N/A' }}</dd>

                                    <dt class="col-sm-4">Batch Number</dt>
                                    <dd class="col-sm-8">{{ $document->batch_no ?? 'N/A' }}</dd>

                                    <dt class="col-sm-4">Receive Date</dt>
                                    <dd class="col-sm-8">
                                        {{ $document->receive_date ? \Carbon\Carbon::parse($document->receive_date)->format('Y-m-d') : 'N/A' }}
                                    </dd>
                                </dl>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="text-muted">Attachment</h6>
                                @if ($document->attachment)
                                    <a href="{{ Storage::url($document->attachment) }}" target="_blank"
                                        class="btn btn-info">
                                        <i class="fas fa-download"></i> Download Attachment
                                    </a>
                                @else
                                    <p class="text-muted">No attachment available</p>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="text-muted">Remarks</h6>
                                <p>{{ $document->remarks ?? 'No remarks' }}</p>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="text-muted">Document History</h6>
                                <dl class="row">
                                    <dt class="col-sm-4">Created By</dt>
                                    <dd class="col-sm-8">{{ $document->createdBy->name }}</dd>

                                    <dt class="col-sm-4">Created At</dt>
                                    <dd class="col-sm-8">
                                        {{ \Carbon\Carbon::parse($document->created_at)->format('Y-m-d H:i:s') }}</dd>

                                    <dt class="col-sm-4">Last Updated</dt>
                                    <dd class="col-sm-8">
                                        {{ \Carbon\Carbon::parse($document->updated_at)->format('Y-m-d H:i:s') }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
