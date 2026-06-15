<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="CafeRekomendasi - Sistem rekomendasi cafe terbaik menggunakan Content-Based Filtering & Cosine Similarity">
    <title>@yield('title', 'CafeRekomendasi')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-cream font-sans text-coffee-800 antialiased">

    {{-- Navbar --}}
    <nav class="bg-white/80 backdrop-blur-md border-b border-coffee-100 sticky top-0 z-50" id="main-navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <span class="text-2xl">☕</span>
                    <span class="text-xl font-bold bg-gradient-to-r from-coffee-800 to-coffee-500 bg-clip-text text-transparent group-hover:from-coffee-600 group-hover:to-coffee-400 transition-all">
                        CafeRekomendasi
                    </span>
                </a>

                {{-- Desktop Menu --}}
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-xl text-sm font-medium hover:bg-coffee-50 hover:text-coffee-700 transition-all {{ request()->routeIs('home') ? 'bg-coffee-50 text-coffee-700' : 'text-coffee-500' }}">
                        Beranda
                    </a>
                    <a href="{{ route('cafe.index') }}" class="px-4 py-2 rounded-xl text-sm font-medium hover:bg-coffee-50 hover:text-coffee-700 transition-all {{ request()->routeIs('cafe.*') ? 'bg-coffee-50 text-coffee-700' : 'text-coffee-500' }}">
                        Daftar Cafe
                    </a>
                    <a href="{{ route('rekomendasi.form') }}" class="px-4 py-2 rounded-xl text-sm font-medium hover:bg-coffee-50 hover:text-coffee-700 transition-all {{ request()->routeIs('rekomendasi.*') ? 'bg-coffee-50 text-coffee-700' : 'text-coffee-500' }}">
                        Rekomendasi
                    </a>
                    <a href="{{ route('about') }}" class="px-4 py-2 rounded-xl text-sm font-medium hover:bg-coffee-50 hover:text-coffee-700 transition-all {{ request()->routeIs('about') ? 'bg-coffee-50 text-coffee-700' : 'text-coffee-500' }}">
                        Tentang
                    </a>
                    <a href="{{ route('rekomendasi.form') }}" class="ml-2 px-5 py-2.5 bg-gradient-to-r from-coffee-700 to-coffee-600 text-white text-sm font-semibold rounded-xl hover:from-coffee-600 hover:to-coffee-500 transition-all shadow-lg shadow-coffee-600/25 hover:shadow-coffee-500/30 hover:-translate-y-0.5">
                        ✨ Cari Cafe
                    </a>
                </div>

                {{-- Mobile Menu Button --}}
                <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="md:hidden p-2 rounded-lg hover:bg-coffee-50 transition-colors" id="mobile-menu-btn">
                    <svg class="w-6 h-6 text-coffee-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

            {{-- Mobile Menu --}}
            <div class="hidden md:hidden pb-4 border-t border-coffee-100 mt-2 pt-3" id="mobile-menu">
                <div class="flex flex-col gap-1">
                    <a href="{{ route('home') }}" class="px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-coffee-50 {{ request()->routeIs('home') ? 'bg-coffee-50 text-coffee-700' : 'text-coffee-500' }}">🏠 Beranda</a>
                    <a href="{{ route('cafe.index') }}" class="px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-coffee-50 {{ request()->routeIs('cafe.*') ? 'bg-coffee-50 text-coffee-700' : 'text-coffee-500' }}">☕ Daftar Cafe</a>
                    <a href="{{ route('rekomendasi.form') }}" class="px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-coffee-50 {{ request()->routeIs('rekomendasi.*') ? 'bg-coffee-50 text-coffee-700' : 'text-coffee-500' }}">✨ Rekomendasi</a>
                    <a href="{{ route('about') }}" class="px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-coffee-50 {{ request()->routeIs('about') ? 'bg-coffee-50 text-coffee-700' : 'text-coffee-500' }}">ℹ️ Tentang</a>
                    <div class="border-t border-coffee-100 mt-2 pt-2">
                        <a href="{{ route('admin.login') }}" class="px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-coffee-50 text-coffee-400">🔐 Admin Login</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm">
            ✅ {{ session('success') }}
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm">
            ❌ {{ session('error') }}
        </div>
    </div>
    @endif

    {{-- Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-coffee-800 text-coffee-200 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-2xl">☕</span>
                        <span class="text-xl font-bold text-white">CafeRekomendasi</span>
                    </div>
                    <p class="text-coffee-300 text-sm leading-relaxed">
                        Sistem rekomendasi cafe menggunakan Content-Based Filtering & Cosine Similarity untuk membantu Anda menemukan cafe terbaik.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-4">Menu</h4>
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('home') }}" class="text-sm text-coffee-300 hover:text-white transition-colors">Beranda</a>
                        <a href="{{ route('cafe.index') }}" class="text-sm text-coffee-300 hover:text-white transition-colors">Daftar Cafe</a>
                        <a href="{{ route('rekomendasi.form') }}" class="text-sm text-coffee-300 hover:text-white transition-colors">Rekomendasi</a>
                        <a href="{{ route('about') }}" class="text-sm text-coffee-300 hover:text-white transition-colors">Tentang</a>
                        <a href="{{ route('admin.login') }}" class="text-sm text-coffee-400 hover:text-white transition-colors mt-2 pt-2 border-t border-coffee-700">🔐 Admin Login</a>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-4">Teknologi</h4>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-coffee-700 rounded-lg text-xs text-coffee-200">Laravel</span>
                        <span class="px-3 py-1 bg-coffee-700 rounded-lg text-xs text-coffee-200">TailwindCSS</span>
                        <span class="px-3 py-1 bg-coffee-700 rounded-lg text-xs text-coffee-200">SQLite</span>
                        <span class="px-3 py-1 bg-coffee-700 rounded-lg text-xs text-coffee-200">Cosine Similarity</span>
                    </div>
                </div>
            </div>
            <div class="border-t border-coffee-700 mt-8 pt-8 text-center">
                <p class="text-sm text-coffee-400">&copy; {{ date('Y') }} CafeRekomendasi — Tugas Akhir</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
