<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — CafeRekomendasi</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=10">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}?v=10">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=10">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}?v=10">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream font-sans text-coffee-800 antialiased">

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 bg-coffee-800 text-white flex-shrink-0 hidden lg:flex flex-col border-r border-coffee-900 shadow-xl" id="admin-sidebar">
            {{-- Logo --}}
            <div class="px-6 py-6 border-b border-coffee-700/50 bg-coffee-900/20">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo.png') }}" alt="CafeRekomendasi Logo" class="w-9 h-9 object-contain bg-white/10 rounded-xl p-1 group-hover:scale-105 transition-transform duration-300">
                    <div>
                        <span class="text-lg font-bold block text-white group-hover:text-coffee-100 transition-all duration-300">CafeRekomendasi</span>
                        <p class="text-coffee-300 text-xs mt-0.5">Admin Panel</p>
                    </div>
                </a>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'bg-coffee-700/80 text-white shadow-inner border border-coffee-600/50' : 'text-coffee-300 hover:bg-coffee-700/40 hover:text-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-coffee-200' : 'text-coffee-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.cafe.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('admin.cafe.*') ? 'bg-coffee-700/80 text-white shadow-inner border border-coffee-600/50' : 'text-coffee-300 hover:bg-coffee-700/40 hover:text-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.cafe.*') ? 'text-coffee-200' : 'text-coffee-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    Kelola Cafe
                </a>
                <a href="{{ route('admin.fasilitas.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('admin.fasilitas.*') ? 'bg-coffee-700/80 text-white shadow-inner border border-coffee-600/50' : 'text-coffee-300 hover:bg-coffee-700/40 hover:text-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.fasilitas.*') ? 'text-coffee-200' : 'text-coffee-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    Kelola Fasilitas
                </a>

                <div class="pt-4 mt-4 border-t border-coffee-700/50">
                    <a href="{{ route('home') }}" target="_blank"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-coffee-300 hover:bg-coffee-700/40 hover:text-white transition-all duration-300">
                        <svg class="w-5 h-5 text-coffee-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
                        Lihat Website
                    </a>
                </div>
            </nav>

            {{-- User Info --}}
            <div class="px-4 py-4 border-t border-coffee-700/50 bg-coffee-900/20">
                <div class="flex items-center gap-3 px-3 py-2">
                    <div class="w-9 h-9 rounded-xl bg-coffee-300 text-coffee-900 flex items-center justify-center text-sm font-bold shadow-inner">
                        {{ substr(Auth::guard('admin')->user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold truncate text-white">{{ Auth::guard('admin')->user()->name }}</p>
                        <p class="text-xs text-coffee-400 truncate">{{ Auth::guard('admin')->user()->email }}</p>
                    </div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium text-red-200 bg-red-900/30 hover:bg-red-800/60 hover:text-white transition-all duration-300 border border-red-900/50 hover:border-red-700">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-w-0 bg-cream">
            {{-- Top Bar --}}
            <header class="bg-white/80 backdrop-blur-md border-b border-coffee-100 px-6 py-4 flex items-center justify-between sticky top-0 z-40 transition-all duration-300">
                {{-- Mobile menu toggle --}}
                <div class="flex items-center gap-4">
                    <button onclick="document.getElementById('admin-sidebar').classList.toggle('hidden'); document.getElementById('admin-sidebar').classList.toggle('lg:flex')" class="lg:hidden p-2 rounded-lg text-coffee-600 hover:bg-coffee-50 transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <div>
                        <h1 class="text-xl font-bold text-coffee-900">@yield('page-title', 'Dashboard')</h1>
                        <p class="text-sm text-coffee-500 font-medium mt-0.5">@yield('page-subtitle', '')</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-coffee-50 rounded-lg text-coffee-600 border border-coffee-100">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        <span class="text-sm font-medium">{{ now()->format('d M Y') }}</span>
                    </div>
                </div>
            </header>

            {{-- Flash Messages --}}
            @if(session('success'))
            <div class="mx-6 mt-6">
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="mx-6 mt-6">
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            </div>
            @endif

            {{-- Page Content --}}
            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
