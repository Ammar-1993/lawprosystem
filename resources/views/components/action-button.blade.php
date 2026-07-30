@props([
    'variant' => 'primary',
    'href' => null,
    'type' => 'button',
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-semibold rounded-md transition-colors px-4 py-2 text-sm shadow-sm cursor-pointer';
    
    $variants = [
        'primary' => 'bg-primary text-white hover:bg-primary-dark',
        'secondary' => 'bg-gray text-white hover:bg-gray-dark',
        'danger' => 'bg-danger text-white hover:opacity-90',
        'success' => 'bg-success text-white hover:opacity-90',
        'warning' => 'bg-warning text-white hover:opacity-90',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
