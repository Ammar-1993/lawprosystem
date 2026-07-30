<div class="mb-lg">
    <!-- Header -->
    <div class="flex items-center justify-between mb-md">
        <h3 class="text-2xl font-bold text-dark m-0">
            {{ $title ?? '' }}
        </h3>
        
        @if(isset($action))
            <div>
                {{ $action }}
            </div>
        @endif
    </div>

    <!-- Filters Slot -->
    @if(isset($filters))
        <div class="bg-white p-md rounded-md shadow-card mb-md">
            {{ $filters }}
        </div>
    @endif

    <!-- Table Container -->
    <div class="bg-white rounded-md shadow-card p-md overflow-x-auto">
        {{ $slot }}
    </div>
</div>
