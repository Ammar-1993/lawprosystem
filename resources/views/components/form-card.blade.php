<div class="bg-white rounded-md shadow-card mb-lg overflow-hidden">
    @if(isset($title))
        <div class="px-lg py-md border-b border-gray-light bg-gray-50">
            <h3 class="text-xl font-bold text-dark m-0">{{ $title }}</h3>
        </div>
    @endif
    
    <div class="p-lg">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="px-lg py-md border-t border-gray-light bg-gray-50 flex items-center justify-end gap-md">
            {{ $footer }}
        </div>
    @endif
</div>
