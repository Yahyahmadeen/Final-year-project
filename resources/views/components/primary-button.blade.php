@props([
    'type' => 'button',
    'as' => 'button',
    'color' => 'primary',
    'size' => 'md',
    'fullWidth' => false,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-200';
    
    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-base',
        'lg' => 'px-6 py-3 text-lg',
    ];
    
    $colors = [
        'primary' => 'bg-primary-600 text-white hover:bg-primary-700 focus:ring-primary-500',
        'secondary' => 'bg-secondary-600 text-white hover:bg-secondary-700 focus:ring-secondary-500',
        'accent' => 'bg-accent-500 text-white hover:bg-accent-600 focus:ring-accent-400',
        'white' => 'bg-white text-gray-700 hover:bg-gray-50 focus:ring-gray-200 border border-gray-300',
    ];
    
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $colorClass = $colors[$color] ?? $colors['primary'];
    $widthClass = $fullWidth ? 'w-full' : '';
    
    $classes = "$baseClasses $sizeClass $colorClass $widthClass";
    
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
