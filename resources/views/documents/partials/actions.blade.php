<div class="btn-group" role="group">
    <a href="{{ route('documents.show', $document) }}" class="btn btn-xs btn-info mr-1">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{ route('documents.edit', $document) }}" class="btn btn-xs btn-primary mr-1">
        <i class="fas fa-edit"></i>
    </a>
    <form action="{{ route('documents.destroy', $document) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-xs btn-danger delete-document" id="delete-document-{{ $document->id }}"
            name="delete-document">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>
