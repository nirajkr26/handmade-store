<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center gap-2 text-sm text-gray-500">
                    <li><a href="{{ route('products.index') }}" class="hover:text-indigo-600 transition">Marketplace</a></li>
                    <li><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                    <li class="font-medium text-gray-900">{{ $product->name }}</li>
                </ol>
            </nav>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="lg:flex">
                    <!-- Image Section -->
                    <div class="lg:w-1/2 p-5 lg:p-8">
                        <div class="aspect-square rounded-2xl overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-100">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-contain p-4" alt="{{ $product->name }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-20 h-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Details Section -->
                    <div class="lg:w-1/2 p-5 lg:p-8 flex flex-col">
                        <div class="mb-4">
                            <span class="inline-flex items-center text-[10px] font-bold uppercase tracking-widest text-indigo-600 bg-indigo-50 px-3 py-1 rounded-lg">
                                {{ $product->category->name }}
                            </span>
                        </div>

                        <h1 class="text-3xl lg:text-4xl font-black text-gray-900 leading-tight mb-2">{{ $product->name }}</h1>

                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr($product->seller->name, 0, 1)) }}
                            </div>
                            <p class="text-sm text-gray-500">By <span class="font-semibold text-gray-700">{{ $product->seller->name }}</span></p>
                        </div>

                        <div class="mb-6">
                            <span class="text-4xl font-black bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">${{ number_format($product->price, 2) }}</span>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Description</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $product->description }}</p>
                        </div>

                        <div class="mt-auto pt-6 border-t border-gray-100 space-y-4">
                            <!-- Availability badge -->
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Availability</span>
                                @if($product->stock > 0)
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-lg">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                        {{ $product->stock }} in stock
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-red-600 bg-red-50 px-3 py-1 rounded-lg">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                        Out of stock
                                    </span>
                                @endif
                            </div>

                            @auth
                                @if(Auth::id() !== $product->user_id)
                                    @if($product->stock > 0)
                                        <form action="{{ route('orders.store') }}" method="POST" class="space-y-3">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <div>
                                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Shipping Address</label>
                                                <textarea name="shipping_address" required rows="2" class="w-full border border-gray-200 rounded-xl text-sm px-4 py-2.5 focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition resize-none" placeholder="Enter your full delivery address..."></textarea>
                                            </div>
                                            <button type="submit" class="w-full py-3.5 text-sm font-bold text-white rounded-xl btn-primary active:scale-[0.98] transition">
                                                Buy Now — ${{ number_format($product->price, 2) }}
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('messages.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="receiver_id" value="{{ $product->user_id }}">
                                        <div class="flex gap-2">
                                            <input type="text" name="message" required class="flex-1 border border-gray-200 rounded-xl text-sm px-4 py-2.5 focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition" placeholder="Ask the seller a question...">
                                            <button type="submit" class="px-5 py-2.5 text-sm font-bold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition shrink-0">
                                                Send
                                            </button>
                                        </div>
                                    </form>
                                @else
                                    <div class="flex gap-3">
                                        <a href="{{ route('products.edit', $product) }}" class="flex-1 text-center py-3 text-sm font-bold text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-xl transition">Edit Product</a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full py-3 text-sm font-bold text-red-600 bg-red-50 hover:bg-red-100 rounded-xl transition" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                        </form>
                                    </div>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="block w-full text-center py-3.5 text-sm font-bold text-white rounded-xl btn-primary">
                                    Log in to Purchase
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
