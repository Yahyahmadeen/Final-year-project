@extends('layouts.vendor')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-secondary-800">Add New Product</h1>
                <p class="text-gray-600 mt-1">Create a new product for your store</p>
            </div>
            <a href="{{ route('vendor.products.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                ← Back to Products
            </a>
        </div>

        @if($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-lg p-4">
            <div class="flex">
                <svg class="h-5 w-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <h3 class="font-semibold mb-2">Please fix the following errors:</h3>
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('vendor.products.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf
            
            <!-- Left Column: Product Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Product Information -->
                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                    <h3 class="text-xl font-semibold text-secondary-800 mb-6 flex items-center">
                        <svg class="h-6 w-6 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Product Information
                    </h3>
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Product Name *</label>
                            <input type="text" name="name" id="name" 
                                   class="block w-full px-4 py-3 text-base border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors" 
                                   value="{{ old('name') }}" 
                                   placeholder="Enter product name"
                                   required>
                            @error('name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description *</label>
                            <textarea name="description" id="description" rows="6" 
                                      class="block w-full px-4 py-3 text-base border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors" 
                                      placeholder="Describe your product in detail..."
                                      required>{{ old('description') }}</textarea>
                            @error('description')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Pricing & Inventory -->
                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                    <h3 class="text-xl font-semibold text-secondary-800 mb-6 flex items-center">
                        <svg class="h-6 w-6 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Pricing & Inventory
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Price (₦) *</label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 pl-4 flex items-center">
                                    <span class="text-gray-500 text-base font-medium">₦</span>
                                </div>
                                <input type="number" step="0.01" name="price" id="price" 
                                       class="block w-full pl-10 pr-4 py-3 text-base border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors" 
                                       value="{{ old('price') }}" 
                                       placeholder="0.00"
                                       required>
                            </div>
                            @error('price')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="stock_quantity" class="block text-sm font-semibold text-gray-700 mb-2">Stock Quantity *</label>
                            <input type="number" name="stock_quantity" id="stock_quantity" 
                                   class="block w-full px-4 py-3 text-base border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors" 
                                   value="{{ old('stock_quantity', 0) }}" 
                                   placeholder="0"
                                   required>
                            @error('stock_quantity')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Category & Images -->
            <div class="space-y-6">
                <!-- Category -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-secondary-800 mb-4 flex items-center">
                        <svg class="h-5 w-5 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        Category
                    </h3>
                    <div>
                        <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">Select Category *</label>
                        <select name="category_id" id="category_id" 
                                class="block w-full px-4 py-3 text-base border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors" 
                                required>
                            <option value="">Choose a category...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Product Images -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-secondary-800 mb-4 flex items-center">
                        <svg class="h-5 w-5 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Product Images
                    </h3>
                    <div id="image-upload-zone" class="mt-2 flex justify-center px-6 py-10 border-2 border-gray-300 border-dashed rounded-xl hover:border-primary-400 transition-colors cursor-pointer bg-gray-50">
                        <div class="space-y-2 text-center">
                            <svg class="mx-auto h-16 w-16 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-base text-gray-600 justify-center">
                                <label for="images" class="relative cursor-pointer bg-white rounded-lg px-3 py-1 font-semibold text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                    <span>Upload files</span>
                                    <input id="images" name="images[]" type="file" class="sr-only" multiple accept="image/*">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-sm text-gray-500">PNG, JPG, GIF, WEBP up to 10MB each</p>
                            <p class="text-xs text-gray-400">You can upload multiple images</p>
                        </div>
                    </div>
                    
                    <!-- Image Preview Section -->
                    <div id="preview-section" class="mt-6 hidden">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-sm font-semibold text-gray-700 flex items-center">
                                <svg class="h-4 w-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Selected Images (<span id="image-count">0</span>)
                            </h4>
                            <button type="button" id="clear-all" class="text-xs text-red-600 hover:text-red-800 font-medium">Clear All</button>
                        </div>
                        <div id="image-preview-container" class="grid grid-cols-2 gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200"></div>
                    </div>
                    
                    @error('images.*')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    @error('images')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="lg:col-span-3 bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex justify-between items-center">
                    <p class="text-sm text-gray-600">
                        <span class="text-red-500">*</span> Required fields
                    </p>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('vendor.products.index') }}" 
                           class="px-8 py-3 border-2 border-gray-300 rounded-xl text-base font-semibold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 transition-all">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-8 py-3 border-2 border-transparent rounded-xl shadow-md text-base font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all transform hover:scale-105">
                            <span class="flex items-center">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Save Product
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const imageUploadZone = document.getElementById('image-upload-zone');
    const imageInput = document.getElementById('images');
    const previewContainer = document.getElementById('image-preview-container');
    const previewSection = document.getElementById('preview-section');
    const imageCount = document.getElementById('image-count');
    const clearAllBtn = document.getElementById('clear-all');
    let files = [];

    const updateInputFiles = () => {
        const dataTransfer = new DataTransfer();
        files.forEach(file => dataTransfer.items.add(file));
        imageInput.files = dataTransfer.files;
    };

    const updateUI = () => {
        // Show/hide preview section
        if (files.length > 0) {
            previewSection.classList.remove('hidden');
            imageCount.textContent = files.length;
        } else {
            previewSection.classList.add('hidden');
        }
    };

    const createPreview = (file, index) => {
        const reader = new FileReader();
        reader.onload = (e) => {
            const previewElement = document.createElement('div');
            previewElement.classList.add('relative', 'group', 'overflow-hidden', 'rounded-xl', 'border-2', 'border-gray-200', 'hover:border-primary-400', 'transition-all', 'shadow-sm');
            previewElement.innerHTML = `
                <img src="${e.target.result}" class="h-40 w-full object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all flex items-center justify-center">
                    <button type="button" data-index="${index}" class="remove-image bg-red-500 text-white rounded-full p-2 opacity-0 group-hover:opacity-100 transition-all transform scale-90 group-hover:scale-100 hover:bg-red-600 shadow-lg">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
                ${index === 0 ? '<span class="absolute top-2 left-2 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-lg shadow-md flex items-center"><svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>Primary</span>' : ''}
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-2">
                    <p class="text-white text-xs truncate">${file.name}</p>
                </div>
            `;
            previewContainer.appendChild(previewElement);
        };
        reader.readAsDataURL(file);
    };

    const handleFiles = (newFiles) => {
        Array.from(newFiles).forEach(file => {
            if (file.type.startsWith('image/')) {
                if (!files.some(f => f.name === file.name)) {
                    files.push(file);
                }
            }
        });
        previewContainer.innerHTML = '';
        files.forEach((file, index) => createPreview(file, index));
        updateInputFiles();
        updateUI();
    };

    // Drag and drop
    imageUploadZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        imageUploadZone.classList.add('border-primary-500', 'bg-primary-50');
    });
    
    imageUploadZone.addEventListener('dragleave', (e) => {
        e.preventDefault();
        imageUploadZone.classList.remove('border-primary-500', 'bg-primary-50');
    });
    
    imageUploadZone.addEventListener('drop', (e) => {
        e.preventDefault();
        imageUploadZone.classList.remove('border-primary-500', 'bg-primary-50');
        handleFiles(e.dataTransfer.files);
    });

    // File input change
    imageInput.addEventListener('change', () => handleFiles(imageInput.files));

    // Remove individual image
    previewContainer.addEventListener('click', (e) => {
        if (e.target.closest('.remove-image')) {
            const index = parseInt(e.target.closest('.remove-image').dataset.index);
            files.splice(index, 1);
            previewContainer.innerHTML = '';
            files.forEach((file, i) => createPreview(file, i));
            updateInputFiles();
            updateUI();
        }
    });

    // Clear all images
    clearAllBtn.addEventListener('click', () => {
        files = [];
        previewContainer.innerHTML = '';
        imageInput.value = '';
        updateUI();
    });
</script>
@endpush
@endsection
