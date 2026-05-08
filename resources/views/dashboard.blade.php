<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-gray-900 tracking-tight">Welcome back, {{ Auth::user()->name }}!</h2>
                <p class="text-sm text-gray-500 mt-0.5">Here's what's happening with your shop today.</p>
            </div>
            @if(Auth::user()->isSeller())
                <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white rounded-xl btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Add New Product
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Row -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                @if(Auth::user()->isSeller())
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm card-hover">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-500 flex items-center justify-center shadow-lg shadow-emerald-100">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Sales</p>
                                <p class="text-2xl font-black text-gray-900">${{ number_format($stats['total_sales'], 2) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm card-hover">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-400 to-indigo-500 flex items-center justify-center shadow-lg shadow-indigo-100">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">My Products</p>
                                <p class="text-2xl font-black text-gray-900">{{ $stats['total_products'] }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm card-hover">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-400 to-orange-400 flex items-center justify-center shadow-lg shadow-amber-100">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Recent Orders</p>
                            <p class="text-2xl font-black text-gray-900">{{ $stats['recent_orders']->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm card-hover">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center shadow-lg shadow-purple-100">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Messages</p>
                            <p class="text-2xl font-black text-gray-900">{{ $stats['unread_messages']->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Recent Orders -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Recent Orders</h3>
                        <a href="{{ route('orders.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition">View All →</a>
                    </div>
                    <div class="p-4">
                        @if($stats['recent_orders']->isEmpty())
                            <div class="text-center py-10">
                                <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                </div>
                                <p class="text-sm text-gray-500">No orders yet</p>
                                <a href="{{ route('products.index') }}" class="text-xs text-indigo-600 font-semibold mt-1 inline-block">Browse marketplace →</a>
                            </div>
                        @else
                            <div class="space-y-2">
                                @foreach($stats['recent_orders'] as $order)
                                    <div class="flex items-center justify-between p-3.5 bg-gray-50/80 rounded-xl hover:bg-gray-100/80 transition">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-lg bg-amber-100 flex items-center justify-center">
                                                <span class="text-xs font-bold text-amber-600">#{{ $order->id }}</span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">Order #{{ $order->id }}</p>
                                                <p class="text-xs text-gray-400">{{ $order->created_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-bold text-gray-900">${{ number_format($order->total_amount, 2) }}</p>
                                            <span class="text-[10px] font-bold uppercase tracking-wider {{ $order->status === 'delivered' ? 'text-emerald-500' : 'text-amber-500' }}">{{ $order->status }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Messages -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Recent Messages</h3>
                        <a href="{{ route('messages.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition">Open Inbox →</a>
                    </div>
                    <div class="p-4">
                        @if($stats['unread_messages']->isEmpty())
                            <div class="text-center py-10">
                                <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                                </div>
                                <p class="text-sm text-gray-500">No messages yet</p>
                            </div>
                        @else
                            <div class="space-y-2">
                                @foreach($stats['unread_messages'] as $msg)
                                    <div class="flex items-start gap-3 p-3.5 bg-gray-50/80 rounded-xl hover:bg-gray-100/80 transition">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-xs font-bold shrink-0 mt-0.5">
                                            {{ strtoupper(substr($msg->sender->name, 0, 1)) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900">{{ $msg->sender->name }}</p>
                                            <p class="text-xs text-gray-500 truncate">{{ $msg->message }}</p>
                                        </div>
                                        <span class="text-[10px] text-gray-400 shrink-0">{{ $msg->created_at->diffForHumans() }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Seller: My Listings -->
            @if(Auth::user()->isSeller() && isset($stats['my_products']) && $stats['my_products']->count() > 0)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Your Listings</h3>
                        <a href="{{ route('products.create') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-white px-4 py-2 rounded-lg btn-primary">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            Add New
                        </a>
                    </div>
                    <div class="p-5">
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                            @foreach($stats['my_products'] as $product)
                                <a href="{{ route('products.show', $product) }}" class="group">
                                    <div class="aspect-square bg-gray-100 rounded-xl overflow-hidden mb-2.5 border border-gray-100">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" alt="{{ $product->name }}">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $product->name }}</p>
                                    <p class="text-xs text-gray-500 font-medium">${{ number_format($product->price, 2) }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Buyer Quick Actions -->
            @if(Auth::user()->isBuyer())
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-8 text-center text-white mt-4">
                    <h3 class="text-xl font-bold mb-2">Ready to explore?</h3>
                    <p class="text-indigo-100 text-sm mb-6 max-w-md mx-auto">Discover one-of-a-kind handmade creations from talented artisans.</p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-white text-indigo-700 font-bold px-6 py-3 rounded-xl hover:bg-indigo-50 transition text-sm">
                        Browse Marketplace
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
