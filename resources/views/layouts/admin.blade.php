<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — CafeRekomendasi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased">

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 bg-coffee-800 text-white flex-shrink-0 hidden lg:flex flex-col" id="admin-sidebar">
            {{-- Logo --}}
            <div class="px-6 py-5 border-b border-coffee-700">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                    <span class="text-2xl">☕</span>
                    <span class="text-lg font-bold">CafeRekomendasi</span>
                </a>
                <p class="text-coffee-400 text-xs mt-1">Admin Panel</p>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-4 py-6 space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-coffee-700 text-white' : 'text-coffee-300 hover:bg-coffee-700/50 hover:text-white' }}">
                    <span>📊</span> Dashboard
                </a>
                <a href="{{ route('admin.cafe.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.cafe.*') ? 'bg-coffee-700 text-white' : 'text-coffee-300 hover:bg-coffee-700/50 hover:text-white' }}">
                    <span>☕</span> Kelola Cafe
                </a>
                <a href="{{ route('admin.fasilitas.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.fasilitas.*') ? 'bg-coffee-700 text-white' : 'text-coffee-300 hover:bg-coffee-700/50 hover:text-white' }}">
                    <span>🛠️</span> Kelola Fasilitas
                </a>

                <div class="pt-4 mt-4 border-t border-coffee-700">
                    <a href="{{ route('home') }}" target="_blank"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-coffee-300 hover:bg-coffee-700/50 hover:text-white transition-all">
                        <span>🌐</span> Lihat Website
                    </a>
                </div>
            </nav>

            {{-- User Info --}}
            <div class="px-4 py-4 border-t border-coffee-700">
                <div class="flex items-center gap-3 px-4 py-2">
                    <div class="w-8 h-8 rounded-full bg-coffee-600 flex items-center justify-center text-sm font-bold">
                        {{ substr(Auth::guard('admin')->user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">{{ Auth::guard('admin')->user()->name }}</p>
                        <p class="text-xs text-coffee-400 truncate">{{ Auth::guard('admin')->user()->email }}</p>
                    </div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-red-300 hover:bg-red-500/10 hover:text-red-200 transition-all">
                        <span>🚪</span> Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- Top Bar --}}
            <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                {{-- Mobile menu toggle --}}
                <button onclick="document.getElementById('admin-sidebar').classList.toggle('hidden'); document.getElementById('admin-sidebar').classList.toggle('lg:flex')" class="lg:hidden p-2 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <div>
                    <h1 class="text-lg font-bold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-sm text-gray-500">@yield('page-subtitle', '')</p>
                </div>

                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500">{{ now()->format('d M Y') }}</span>
                </div>
            </header>

            {{-- Flash Messages --}}
            @if(session('success'))
            <div class="mx-6 mt-4">
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                    <span>✅</span> {{ session('success') }}
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="mx-6 mt-4">
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                    <span>❌</span> {{ session('error') }}
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
