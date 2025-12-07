@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl">Shop by Category</h1>
            <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                Browse our wide selection of products by category
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($categories as $category)
                <div class="group relative bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-t-lg bg-gray-200">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" 
                                 alt="{{ $category->name }}" 
                                 class="h-48 w-full object-cover object-center group-hover:opacity-75">
                        @else
                            <div class="h-48 w-full flex items-center justify-center bg-gray-100">
                                <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">
                            <a href="{{ route('categories.show', $category->slug) }}">
                                {{ $category->name }}
                                <span class="absolute inset-0"></span>
                            </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ $category->products_count }} products
                        </p>
                        
                        @if($category->children->count() > 0)
                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-500">Subcategories:</h4>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @foreach($category->children as $subcategory)
                                        <a href="{{ route('categories.show', $subcategory->slug) }}" 
                                           class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 hover:bg-gray-200">
                                            {{ $subcategory->name }}
                                            <span class="ml-1 text-gray-500">({{ $subcategory->products_count }})</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
