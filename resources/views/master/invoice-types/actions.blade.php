<div class="btn-group" style="gap: 5px;">
    <button type="button" class="btn btn-sm btn-primary btn-xs edit-invoice-type" data-id="{{ $invoiceType->id }}">
        <i class="fas fa-edit"></i>
    </button>
    <form class="delete-form" action="{{ route('master.invoice-types.destroy', $invoiceType->id) }}" method="POST"
        style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-sm btn-danger btn-xs delete-invoice-type"
            data-id="{{ $invoiceType->id }}">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>
