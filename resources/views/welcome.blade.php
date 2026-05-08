<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Handmade Marketplace — Unique Goods Made by Hand</title>
    <meta name="description" content="Connect directly with artists and makers. Find one-of-a-kind jewelry, home decor, clothing, and more on the Handmade Marketplace.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-text { background: linear-gradient(135deg, #6366f1 0%, #a855f7 50%, #ec4899 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .hero-gradient { background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 50%, #faf5ff 100%); }
        .card-float { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-float:hover { transform: translateY(-6px); box-shadow: 0 25px 50px rgba(0,0,0,0.08); }
        .btn-gradient { background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); transition: all 0.3s ease; }
        .btn-gradient:hover { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(99,102,241,0.4); }
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
        .animate-slide-up { animation: slideUp 0.6s ease-out; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .animate-slide-up-delay { animation: slideUp 0.6s ease-out 0.2s both; }
        .animate-slide-up-delay-2 { animation: slideUp 0.6s ease-out 0.4s both; }
    </style>
</head>
<body class="antialiased text-gray-800">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white/80 backdrop-blur-xl border-b border-gray-100/50 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="/" class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-200">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </div>
                    <span class="text-xl font-extrabold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">HANDMADE</span>
                </a>
                <div class="flex items-center gap-3">
                    <a href="{{ route('products.index') }}" class="hidden sm:inline-flex text-sm font-semibold text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-lg hover:bg-indigo-50 transition">Marketplace</a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-white px-5 py-2.5 rounded-xl btn-gradient">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-lg hover:bg-gray-50 transition">Log in</a>
                            <a href="{{ route('register') }}" class="text-sm font-semibold text-white px-5 py-2.5 rounded-xl btn-gradient">Start Selling</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:flex lg:items-center lg:gap-16">
                <div class="lg:w-1/2 mb-12 lg:mb-0">
                    <div class="animate-slide-up">
                        <span class="inline-flex items-center gap-2 bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider px-4 py-1.5 rounded-full mb-6">
                            <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></span>
                            Discover Unique Creations
                        </span>
                    </div>
                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black leading-[0.9] tracking-tight mb-6 animate-slide-up">
                        Unique goods<br>
                        <span class="gradient-text">Made by hand.</span>
                    </h1>
                    <p class="text-lg text-gray-500 max-w-lg mb-10 leading-relaxed animate-slide-up-delay">
                        Connect directly with artists and makers. Find one-of-a-kind jewelry, pottery, home decor, clothing, and more.
                    </p>
                    <div class="flex flex-wrap gap-4 animate-slide-up-delay-2">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-8 py-4 text-white font-bold rounded-2xl btn-gradient text-base">
                            Explore Items
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-4 text-indigo-700 font-bold rounded-2xl bg-white border-2 border-indigo-100 hover:border-indigo-200 hover:bg-indigo-50 transition text-base">
                            Become a Seller
                        </a>
                    </div>
                </div>
                <div class="lg:w-1/2 relative">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl shadow-indigo-100 animate-float">
                        <img class="w-full h-80 lg:h-[480px] object-cover" src="https://images.unsplash.com/photo-1452860606245-08b57e3fc25a?auto=format&fit=crop&q=80&w=800" alt="Handmade crafts collection">
                        <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/30 to-transparent"></div>
                    </div>
                    <!-- Floating stat card -->
                    <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl shadow-xl p-5 border border-gray-100 hidden lg:block">
                        <p class="text-2xl font-black text-gray-900">1,200+</p>
                        <p class="text-xs text-gray-500 font-medium">Active Artisans</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-20 lg:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <h2 class="text-3xl sm:text-4xl font-black text-gray-900 mb-3">Shop by Category</h2>
                <p class="text-gray-500 max-w-md mx-auto">Browse handmade collections curated just for you</p>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 lg:gap-5">
                @foreach(\App\Models\Category::all() as $category)
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="group card-float bg-gradient-to-br from-slate-50 to-indigo-50/50 p-6 rounded-2xl border border-gray-100 text-center">
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm group-hover:shadow-md group-hover:scale-110 transition-all duration-300">
                            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                        </div>
                        <span class="text-sm font-bold text-gray-700 group-hover:text-indigo-600 transition">{{ $category->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-purple-600 to-indigo-700"></div>
        <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,<svg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"><g fill=\"none\" fill-rule=\"evenodd\"><g fill=\"%23fff\" fill-opacity=\"0.4\"><path d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/></g></g></svg>');"></div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 text-center">
            <h2 class="text-3xl sm:text-4xl font-black text-white mb-4">Are You a Maker?</h2>
            <p class="text-lg text-indigo-100 mb-10 max-w-2xl mx-auto leading-relaxed">
                Turn your passion into profit. List your handmade products and reach thousands of buyers who appreciate authentic craftsmanship.
            </p>
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-white text-indigo-700 font-bold px-10 py-4 rounded-2xl hover:bg-indigo-50 transition shadow-xl shadow-indigo-900/20 text-base">
                Create Your Shop
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </div>
                    <span class="text-lg font-extrabold text-white">HANDMADE</span>
                </div>
                <div class="flex items-center gap-8 text-sm">
                    <a href="{{ route('products.index') }}" class="hover:text-white transition">Marketplace</a>
                    <a href="{{ route('register') }}" class="hover:text-white transition">Sell on Handmade</a>
                    <a href="{{ route('login') }}" class="hover:text-white transition">Sign In</a>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-10 pt-8 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Handmade Marketplace. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>
