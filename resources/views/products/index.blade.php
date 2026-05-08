<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-gray-900 tracking-tight">Marketplace</h2>
                <p class="text-sm text-gray-500 mt-0.5">Discover unique handmade goods from talented artisans</p>
            </div>
            @auth
                @if(Auth::user()->isSeller())
                    <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white rounded-xl btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        List New Product
                    </a>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search & Filter Bar -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-5 mb-8">
                <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center">
                    <form action="{{ route('products.index') }}" method="GET" class="flex gap-2 w-full lg:w-auto lg:flex-1">
                        <div class="relative flex-1">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input type="text" name="search" placeholder="Search handmade items..." value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition">
                        </div>
                        <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white rounded-xl btn-primary shrink-0">Search</button>
                    </form>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('products.index') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition {{ !request('category') ? 'bg-indigo-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">All</a>
                        @foreach(\App\Models\Category::all() as $cat)
                            <a href="{{ route('products.index', ['category' => $cat->slug]) }}"
                               class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition whitespace-nowrap {{ request('category') == $cat->slug ? 'bg-indigo-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            @if($products->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">No products found</h3>
                    <p class="text-sm text-gray-500 mb-6">Try adjusting your search or filters.</p>
                    <a href="{{ route('products.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">Clear all filters →</a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    @foreach($products as $product)
                        <a href="{{ route('products.show', $product) }}" class="group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden card-hover">
                            <div class="aspect-[4/3] relative bg-gray-100 overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt="{{ $product->name }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                                <div class="absolute top-3 left-3">
                                    <span class="bg-white/90 backdrop-blur-sm px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider text-indigo-600 shadow-sm">
                                        {{ $product->category->name }}
                                    </span>
                                </div>
                                @if($product->stock <= 0)
                                    <div class="absolute inset-0 bg-gray-900/40 flex items-center justify-center">
                                        <span class="bg-white text-gray-900 text-xs font-bold px-3 py-1 rounded-lg">Sold Out</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <div class="flex items-start justify-between gap-2 mb-1.5">
                                    <h3 class="text-sm font-bold text-gray-900 line-clamp-1 group-hover:text-indigo-600 transition">{{ $product->name }}</h3>
                                </div>
                                <p class="text-xs text-gray-500 line-clamp-2 mb-3 leading-relaxed">{{ $product->description }}</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-lg font-black bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">${{ number_format($product->price, 2) }}</span>
                                    <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">by {{ $product->seller->name }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
