@extends('layouts.vendor')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-secondary-800">Add New Product</h1>
            <a href="{{ route('vendor.products.index') }}" class="text-gray-600 hover:text-primary-500 transition-colors">Back to Products</a>
        </div>

        <form action="{{ route('vendor.products.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf
            
            <!-- Left Column: Product Details -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-secondary-800 mb-4">Product Information</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" value="{{ old('name') }}" required>
                            @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="5" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>{{ old('description') }}</textarea>
                            @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-secondary-800 mb-4">Pricing & Inventory</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                            <div class="mt-1 relative rounded-lg shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" step="0.01" name="price" id="price" class="block w-full rounded-lg border-gray-300 pl-7 pr-12 focus:border-primary-500 focus:ring-primary-500" value="{{ old('price') }}" required>
                            </div>
                            @error('price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="stock_quantity" class="block text-sm font-medium text-gray-700">Stock Quantity</label>
                            <input type="number" name="stock_quantity" id="stock_quantity" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" value="{{ old('stock_quantity', 0) }}" required>
                            @error('stock_quantity')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Category & Images -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-secondary-800 mb-4">Category</h3>
                    <select name="category_id" id="category_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-secondary-800 mb-4">Product Images</h3>
                    <div id="image-upload-zone" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                    <span>Upload files</span>
                                    <input id="images" name="images[]" type="file" class="sr-only" multiple>
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                        </div>
                    </div>
                    <div id="image-preview-container" class="mt-4 grid grid-cols-3 gap-4"></div>
                    @error('images.*')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    @error('images')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="lg:col-span-3 flex justify-end items-center space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('vendor.products.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">Cancel</a>
                <button type="submit" class="px-6 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">Save Product</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const imageUploadZone = document.getElementById('image-upload-zone');
    const imageInput = document.getElementById('images');
    const previewContainer = document.getElementById('image-preview-container');
    let files = [];

    const updateInputFiles = () => {
        const dataTransfer = new DataTransfer();
        files.forEach(file => dataTransfer.items.add(file));
        imageInput.files = dataTransfer.files;
    };

    const createPreview = (file, index) => {
        const reader = new FileReader();
        reader.onload = (e) => {
            const previewElement = document.createElement('div');
            previewElement.classList.add('relative', 'group');
            previewElement.innerHTML = `
                <img src="${e.target.result}" class="h-24 w-full object-cover rounded-lg">
                <button type="button" data-index="${index}" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            `;
            previewContainer.appendChild(previewElement);
        };
        reader.readAsDataURL(file);
    };

    const handleFiles = (newFiles) => {
        Array.from(newFiles).forEach(file => {
            if (!files.some(f => f.name === file.name)) {
                files.push(file);
            }
        });
        previewContainer.innerHTML = '';
        files.forEach((file, index) => createPreview(file, index));
        updateInputFiles();
    };

    imageUploadZone.addEventListener('dragover', (e) => e.preventDefault());
    imageUploadZone.addEventListener('drop', (e) => {
        e.preventDefault();
        handleFiles(e.dataTransfer.files);
    });
    imageInput.addEventListener('change', () => handleFiles(imageInput.files));

    previewContainer.addEventListener('click', (e) => {
        if (e.target.closest('button')) {
            const index = e.target.closest('button').dataset.index;
            files.splice(index, 1);
            previewContainer.innerHTML = '';
            files.forEach((file, i) => createPreview(file, i));
            updateInputFiles();
        }
    });
</script>
@endpush
@endsection
