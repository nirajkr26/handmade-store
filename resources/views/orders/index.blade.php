<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">My Orders</h2>
            <p class="text-sm text-gray-500 mt-0.5">Track your purchases and order history</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($orders->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">No orders yet</h3>
                    <p class="text-sm text-gray-500 mb-6">Start shopping to see your orders here.</p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white rounded-xl btn-primary">
                        Browse Marketplace
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            @else
                <div class="space-y-5">
                    @foreach($orders as $order)
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden card-hover">
                            <!-- Order Header -->
                            <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-400 flex items-center justify-center shadow-sm">
                                        <span class="text-xs font-bold text-white">#{{ $order->id }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">Order #{{ $order->id }}</p>
                                        <p class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-amber-50 text-amber-600 border-amber-200',
                                            'processing' => 'bg-blue-50 text-blue-600 border-blue-200',
                                            'shipped' => 'bg-indigo-50 text-indigo-600 border-indigo-200',
                                            'delivered' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                            'cancelled' => 'bg-red-50 text-red-600 border-red-200',
                                        ];
                                        $colorClass = $statusColors[$order->status] ?? 'bg-gray-50 text-gray-600 border-gray-200';
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider border {{ $colorClass }}">
                                        {{ $order->status }}
                                    </span>
                                    <p class="text-xl font-black text-gray-900">${{ number_format($order->total_amount, 2) }}</p>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="p-6">
                                @foreach($order->items as $item)
                                    <div class="flex items-center gap-4 {{ !$loop->last ? 'mb-4 pb-4 border-b border-gray-50' : '' }}">
                                        <div class="w-14 h-14 bg-gray-100 rounded-xl overflow-hidden shrink-0 border border-gray-100">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover" alt="">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-bold text-gray-900 truncate">{{ $item->product ? $item->product->name : 'Product removed' }}</p>
                                            <p class="text-xs text-gray-500">Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                                        </div>
                                        <p class="text-sm font-bold text-gray-900 shrink-0">${{ number_format($item->quantity * $item->price, 2) }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Shipping Info -->
                            <div class="px-6 py-3 bg-gray-50/50 border-t border-gray-100">
                                <p class="text-xs text-gray-500 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span class="truncate">{{ $order->shipping_address }}</span>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
