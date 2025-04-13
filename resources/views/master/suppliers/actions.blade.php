<button type="button" class="btn btn-primary btn-xs edit-supplier" data-id="{{ $supplier->id }}"
    style="margin-right: 5px;">
    <i class="fas fa-edit"></i>
</button>
<form class="delete-form d-inline" action="{{ route('master.suppliers.destroy', $supplier->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-danger btn-xs delete-supplier" data-id="{{ $supplier->id }}">
        <i class="fas fa-trash"></i>
    </button>
</form>
