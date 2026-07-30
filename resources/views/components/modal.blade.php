@props(['id', 'targetId' => 'show_modal'])

<!-- Legacy Bootstrap wrapper to ensure $.fn.modal('show') continues working seamlessly -->
<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!-- Tailwind styled container, acts as the target for legacy AJAX HTML injection -->
        <div class="modal-content bg-white rounded-lg shadow-card border-0 overflow-hidden" id="{{ $targetId }}">
            {{ $slot }}
        </div>
    </div>
</div>
