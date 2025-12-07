@props(['active' => false, 'size' => 'md'])

@php
    $baseClasses = 'inline-flex items-center font-medium transition-colors duration-200 focus:outline-none';
    
    $sizes = [
        'sm' => 'text-sm px-3 py-2',
        'md' => 'text-base px-4 py-3',
        'lg' => 'text-lg px-6 py-4',
    ];
    
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    
    $activeClasses = $active 
        ? 'text-primary-600 border-b-2 border-primary-500 font-semibold' 
        : 'text-gray-600 hover:text-primary-500';
    
    $classes = "$baseClasses $sizeClass $activeClasses";
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
