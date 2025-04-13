<div class="btn-group">
    <button type="button" class="btn btn-info btn-xs edit-project" data-id="{{ $project->id }}"
        style="margin-right: 5px;">
        <i class="fas fa-edit"></i>
    </button>
    <form action="{{ route('master.projects.destroy', $project) }}" method="POST" class="d-inline delete-form">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-danger btn-xs delete-project" data-id="{{ $project->id }}">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>
