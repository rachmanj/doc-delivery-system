<div class="btn-group">
    <button type="button" class="btn btn-info btn-xs edit-department" data-id="{{ $department->id }}"
        style="margin-right: 5px;">
        <i class="fas fa-edit"></i>
    </button>
    <form action="{{ route('master.departments.destroy', $department) }}" method="POST" class="d-inline delete-form">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-danger btn-xs delete-department" data-id="{{ $department->id }}">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>
