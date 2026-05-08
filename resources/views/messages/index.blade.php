<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Messages</h2>
            <p class="text-sm text-gray-500 mt-0.5">Your conversations with sellers and buyers</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col" style="min-height: 500px;">
                <!-- Messages List -->
                <div class="flex-1 overflow-y-auto p-5 sm:p-6 space-y-4">
                    @if($messages->isEmpty())
                        <div class="text-center py-16">
                            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">No messages yet</h3>
                            <p class="text-sm text-gray-500 max-w-sm mx-auto">Browse the marketplace and send a message to a seller to start a conversation.</p>
                            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white rounded-xl btn-primary mt-5">
                                Browse Marketplace
                            </a>
                        </div>
                    @else
                        @foreach($messages as $msg)
                            @php $isMine = $msg->sender_id === Auth::id(); @endphp
                            <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                                <div class="flex items-end gap-2 max-w-[85%] sm:max-w-[75%] {{ $isMine ? 'flex-row-reverse' : '' }}">
                                    <!-- Avatar -->
                                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-[10px] font-bold shrink-0 {{ $isMine ? 'bg-gradient-to-br from-indigo-400 to-purple-500 text-white' : 'bg-gray-200 text-gray-600' }}">
                                        {{ strtoupper(substr($msg->sender->name, 0, 1)) }}
                                    </div>
                                    <!-- Bubble -->
                                    <div class="{{ $isMine ? 'bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-2xl rounded-br-md' : 'bg-gray-100 text-gray-900 rounded-2xl rounded-bl-md' }} px-4 py-3">
                                        <p class="text-xs font-bold mb-0.5 {{ $isMine ? 'text-indigo-100' : 'text-gray-500' }}">{{ $msg->sender->name }}</p>
                                        <p class="text-sm leading-relaxed">{{ $msg->message }}</p>
                                        <p class="text-[10px] mt-1.5 {{ $isMine ? 'text-indigo-200' : 'text-gray-400' }}">{{ $msg->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Footer Hint -->
                <div class="px-5 py-3.5 bg-gray-50/80 border-t border-gray-100 text-center">
                    <p class="text-xs text-gray-400 font-medium">Visit a product page to send a message to its seller</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
