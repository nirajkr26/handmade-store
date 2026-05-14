<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Messages</h2>
            <p class="text-sm text-gray-500 mt-0.5">Your conversations with sellers and buyers</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex h-[600px]">
                
                <!-- Sidebar: Conversations List -->
                <div class="w-1/3 border-r border-gray-100 overflow-y-auto">
                    <div class="p-4 border-b border-gray-50">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Conversations</h3>
                    </div>
                    @forelse($conversations as $convUser)
                        <a href="{{ route('messages.index', ['user' => $convUser->id]) }}" 
                           class="flex items-center gap-3 p-4 hover:bg-gray-50 transition border-b border-gray-50 {{ $activeUser && $activeUser->id == $convUser->id ? 'bg-indigo-50/50 border-r-2 border-r-indigo-500' : '' }}">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-sm font-bold shrink-0">
                                {{ strtoupper(substr($convUser->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-gray-900 truncate">{{ $convUser->name }}</p>
                                <p class="text-xs text-gray-500">{{ $convUser->role }}</p>
                            </div>
                        </a>
                    @empty
                        <div class="p-8 text-center">
                            <p class="text-xs text-gray-400">No conversations yet</p>
                        </div>
                    @endforelse
                </div>

                <!-- Main Content: Chat View -->
                <div class="flex-1 flex flex-col bg-gray-50/30">
                    @if($activeUser)
                        <!-- Chat Header -->
                        <div class="p-4 bg-white border-b border-gray-100 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr($activeUser->name, 0, 1)) }}
                                </div>
                                <h4 class="text-sm font-bold text-gray-900">{{ $activeUser->name }}</h4>
                            </div>
                        </div>

                        <!-- Messages Content -->
                        <div class="flex-1 overflow-y-auto p-4 space-y-4">
                            @foreach($activeMessages as $msg)
                                @php $isMine = $msg->sender_id === Auth::id(); @endphp
                                <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                                    <div class="flex items-end gap-2 max-w-[85%] {{ $isMine ? 'flex-row-reverse' : '' }}">
                                        <div class="{{ $isMine ? 'bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-2xl rounded-br-md' : 'bg-white text-gray-900 rounded-2xl rounded-bl-md shadow-sm border border-gray-100' }} px-4 py-3">
                                            <p class="text-sm leading-relaxed">{{ $msg->message }}</p>
                                            <p class="text-[10px] mt-1.5 {{ $isMine ? 'text-indigo-200' : 'text-gray-400' }}">{{ $msg->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Reply Form -->
                        <div class="p-4 bg-white border-t border-gray-100">
                            <form action="{{ route('messages.store') }}" method="POST" class="flex gap-2">
                                @csrf
                                <input type="hidden" name="receiver_id" value="{{ $activeUser->id }}">
                                <input type="text" name="message" required 
                                       class="flex-1 border border-gray-200 rounded-xl text-sm px-4 py-2.5 focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition" 
                                       placeholder="Type your message here...">
                                <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white rounded-xl btn-primary">
                                    Reply
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex-1 flex flex-col items-center justify-center text-center p-8">
                            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Select a conversation</h3>
                            <p class="text-sm text-gray-500 max-w-xs">Choose a chat from the sidebar to view messages and reply to your customers or sellers.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
