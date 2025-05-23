<div class="page-header">
    <a href="{{ $link ?? 'javascript:void(0)' }}">
        <div class="page-header-title">
            <i class="{{ $icon ?? 'ik ik-menu bg-blue' }}"></i>
            <div class="d-inline">
                <h5>{{ $slot }}</h5>
                <span>{{ $tag }}</span>
            </div>
        </div>
    </a>
</div>