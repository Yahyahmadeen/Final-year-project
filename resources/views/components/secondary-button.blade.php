@props([
    'type' => 'button',
    'as' => 'button',
    'size' => 'md',
    'fullWidth' => false,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200';
    
    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-base',
        'lg' => 'px-6 py-3 text-lg',
    ];
    
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $widthClass = $fullWidth ? 'w-full' : '';
    
    $classes = "$baseClasses $sizeClass $widthClass";
    
    if ($attributes->get('disabled')) {
        $classes .= ' opacity-50 cursor-not-allowed';
    }
@endphp

@if($as === 'button')
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@elseif($as === 'a')
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@endif
