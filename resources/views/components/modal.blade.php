@props(['id', 'targetId' => 'show_modal'])

<div x-data="{ open: false }" 
     @keydown.escape.window="open = false" 
     id="{{ $id }}"
     {{-- We still output the class .modal for jQuery to find, but it's a conflict! --}}
     class="modal fixed inset-0 z-50 flex items-center justify-center" 
     style="display: none;" 
     x-show="open" 
     x-cloak>
     
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-dark bg-opacity-50 transition-opacity" 
         @click="open = false" 
         x-show="open" 
         x-transition.opacity></div>

    <!-- Modal Panel -->
    <div class="bg-white rounded-lg shadow-card w-full max-w-lg mx-4 z-10 overflow-hidden" 
         x-show="open" 
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
         
        <!-- Header -->
        <div class="px-lg py-md border-b border-gray-light bg-gray-50 flex items-center justify-between">
            <h3 class="text-xl font-bold text-dark m-0 modal-title">
                {{ $title ?? '' }}
            </h3>
            <button type="button" @click="open = false" class="text-gray hover:text-danger">
                <i class="fa fa-times text-lg"></i>
            </button>
        </div>

        <!-- Content Body (This is the target for jQuery .html() injection) -->
        <div class="p-lg modal-content" id="{{ $targetId }}">
            {{ $slot }}
        </div>
    </div>
</div>
