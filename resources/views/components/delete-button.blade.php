<button type="button" class="btn {{ $class ?? 'btn-danger btn-sm' }}"
    onclick="confirmDelete('{{ $url }}', '{{ $title ?? 'Are you sure?' }}', '{{ $text ?? 'You will not be able to recover this item!' }}')">
    <i class="fas fa-trash"></i> {{ $slot ?? 'Delete' }}
</button>
