<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Edit Product</h2>
            <p class="text-sm text-gray-500 mt-0.5">Update the details of your listing</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 sm:p-8">
                    @if($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-3.5 rounded-xl text-sm font-medium mb-6">
                            <p class="font-bold mb-1">Please fix the following errors:</p>
                            <ul class="list-disc list-inside text-xs space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Product Name -->
                        <div>
                            <label for="name" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Product Name</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $product->name) }}" required class="w-full border border-gray-200 rounded-xl text-sm px-4 py-3 focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition">
                        </div>

                        <!-- Category & Price -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="category_id" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Category</label>
                                <select id="category_id" name="category_id" class="w-full border border-gray-200 rounded-xl text-sm px-4 py-3 focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition bg-white">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="price" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Price ($)</label>
                                <input id="price" name="price" type="number" step="0.01" value="{{ old('price', $product->price) }}" required class="w-full border border-gray-200 rounded-xl text-sm px-4 py-3 focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition">
                            </div>
                        </div>

                        <!-- Stock & Image -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="stock" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Stock Quantity</label>
                                <input id="stock" name="stock" type="number" value="{{ old('stock', $product->stock) }}" required class="w-full border border-gray-200 rounded-xl text-sm px-4 py-3 focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition">
                            </div>
                            <div>
                                <label for="image" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Product Image</label>
                                @if($product->image)
                                    <div class="flex items-center gap-3 mb-2">
                                        <img src="{{ asset('storage/' . $product->image) }}" class="w-12 h-12 rounded-lg object-cover border border-gray-200" alt="Current image">
                                        <span class="text-xs text-gray-500">Current image</span>
                                    </div>
                                @endif
                                <label for="image" class="flex items-center gap-3 w-full border border-dashed border-gray-300 rounded-xl px-4 py-3 cursor-pointer hover:border-indigo-400 hover:bg-indigo-50/30 transition">
                                    <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span class="text-sm text-gray-500">Upload new image (optional)</span>
                                    <input id="image" name="image" type="file" accept="image/*" class="hidden">
                                </label>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Description</label>
                            <textarea id="description" name="description" rows="5" required class="w-full border border-gray-200 rounded-xl text-sm px-4 py-3 focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition resize-none">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('products.show', $product) }}" class="text-sm font-semibold text-gray-500 hover:text-gray-700 transition px-4 py-2.5">Cancel</a>
                            <button type="submit" class="px-8 py-3 text-sm font-bold text-white rounded-xl btn-primary">
                                Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
