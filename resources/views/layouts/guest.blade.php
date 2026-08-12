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
    <nav class="bg-white/90 backdrop-blur-md border-b border-coffee-100 sticky top-0 z-50 transition-all duration-300 shadow-sm" id="main-navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <svg class="w-8 h-8 text-coffee-700 group-hover:text-coffee-500 transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12h19.5" />
                    </svg>
                    <span class="text-xl font-bold bg-gradient-to-r from-coffee-800 to-coffee-500 bg-clip-text text-transparent group-hover:from-coffee-600 group-hover:to-coffee-400 transition-all duration-300">
                        CafeRekomendasi
                    </span>
                </a>

                {{-- Desktop Menu --}}
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium hover:bg-coffee-50 hover:text-coffee-700 transition-all duration-300 {{ request()->routeIs('home') ? 'bg-coffee-50 text-coffee-700' : 'text-coffee-500' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        Beranda
                    </a>
                    <a href="{{ route('cafe.index') }}" class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium hover:bg-coffee-50 hover:text-coffee-700 transition-all duration-300 {{ request()->routeIs('cafe.*') ? 'bg-coffee-50 text-coffee-700' : 'text-coffee-500' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        Daftar Cafe
                    </a>
                    <a href="{{ route('rekomendasi.form') }}" class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium hover:bg-coffee-50 hover:text-coffee-700 transition-all duration-300 {{ request()->routeIs('rekomendasi.*') ? 'bg-coffee-50 text-coffee-700' : 'text-coffee-500' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        Rekomendasi
                    </a>
                    <a href="{{ route('about') }}" class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium hover:bg-coffee-50 hover:text-coffee-700 transition-all duration-300 {{ request()->routeIs('about') ? 'bg-coffee-50 text-coffee-700' : 'text-coffee-500' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Tentang
                    </a>
                    <a href="{{ route('rekomendasi.form') }}" class="ml-2 flex items-center gap-1.5 px-5 py-2.5 bg-coffee-300 text-coffee-900 text-sm font-semibold rounded-xl hover:bg-coffee-200 transition-all duration-300 shadow-md shadow-coffee-200/50 hover:shadow-coffee-300/60 hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        Cari Cafe
                    </a>
                </div>

                {{-- Mobile Menu Button --}}
                <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="md:hidden p-2 rounded-lg hover:bg-coffee-50 text-coffee-600 transition-all duration-300" id="mobile-menu-btn">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

            {{-- Mobile Menu --}}
            <div class="hidden md:hidden pb-4 border-t border-coffee-100 mt-2 pt-3 transition-all duration-300" id="mobile-menu">
                <div class="flex flex-col gap-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-coffee-50 transition-all duration-300 {{ request()->routeIs('home') ? 'bg-coffee-50 text-coffee-700' : 'text-coffee-500' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        Beranda
                    </a>
                    <a href="{{ route('cafe.index') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-coffee-50 transition-all duration-300 {{ request()->routeIs('cafe.*') ? 'bg-coffee-50 text-coffee-700' : 'text-coffee-500' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        Daftar Cafe
                    </a>
                    <a href="{{ route('rekomendasi.form') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-coffee-50 transition-all duration-300 {{ request()->routeIs('rekomendasi.*') ? 'bg-coffee-50 text-coffee-700' : 'text-coffee-500' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        Rekomendasi
                    </a>
                    <a href="{{ route('about') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-coffee-50 transition-all duration-300 {{ request()->routeIs('about') ? 'bg-coffee-50 text-coffee-700' : 'text-coffee-500' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Tentang
                    </a>
                    <div class="border-t border-coffee-100 mt-2 pt-2">
                        <a href="{{ route('admin.login') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium text-coffee-400 hover:bg-coffee-50 hover:text-coffee-600 transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            Admin Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
            {{ session('success') }}
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            {{ session('error') }}
        </div>
    </div>
    @endif

    {{-- Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-coffee-800 text-coffee-200 mt-20 border-t border-coffee-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2 mb-4 group">
                        <svg class="w-8 h-8 text-coffee-300 group-hover:text-coffee-200 transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12h19.5" />
                        </svg>
                        <span class="text-xl font-bold text-white group-hover:text-coffee-100 transition-all duration-300">CafeRekomendasi</span>
                    </div>
                    <p class="text-coffee-300 text-sm leading-relaxed mb-6 max-w-sm">
                        Sistem rekomendasi cafe menggunakan Content-Based Filtering & Cosine Similarity untuk membantu Anda menemukan tempat ngopi dan bekerja terbaik dengan akurasi tinggi.
                    </p>
                    <div class="flex gap-4">
                        {{-- Social SVG placeholders --}}
                        <a href="#" class="text-coffee-400 hover:text-coffee-300 transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="text-coffee-400 hover:text-coffee-300 transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-5 text-sm uppercase tracking-wider">Tautan Menu</h4>
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('home') }}" class="text-sm text-coffee-300 hover:text-white transition-all duration-300 flex items-center gap-2">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                            Beranda
                        </a>
                        <a href="{{ route('cafe.index') }}" class="text-sm text-coffee-300 hover:text-white transition-all duration-300 flex items-center gap-2">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                            Daftar Cafe
                        </a>
                        <a href="{{ route('rekomendasi.form') }}" class="text-sm text-coffee-300 hover:text-white transition-all duration-300 flex items-center gap-2">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                            Rekomendasi
                        </a>
                        <a href="{{ route('about') }}" class="text-sm text-coffee-300 hover:text-white transition-all duration-300 flex items-center gap-2">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                            Tentang
                        </a>
                        <a href="{{ route('admin.login') }}" class="text-sm text-coffee-200 font-semibold hover:text-white transition-all duration-300 flex items-center gap-2 pt-2 border-t border-coffee-700/60">
                            <svg class="w-3.5 h-3.5 text-coffee-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            Login Admin
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-5 text-sm uppercase tracking-wider">Teknologi</h4>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-coffee-700/50 border border-coffee-700 rounded-lg text-xs text-coffee-200">Laravel</span>
                        <span class="px-3 py-1 bg-coffee-700/50 border border-coffee-700 rounded-lg text-xs text-coffee-200">TailwindCSS v4</span>
                        <span class="px-3 py-1 bg-coffee-700/50 border border-coffee-700 rounded-lg text-xs text-coffee-200">SQLite</span>
                        <span class="px-3 py-1 bg-coffee-700/50 border border-coffee-700 rounded-lg text-xs text-coffee-200">Cosine Similarity</span>
                    </div>
                </div>
            </div>
            <div class="border-t border-coffee-700 mt-10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-coffee-300">&copy; {{ date('Y') }} CafeRekomendasi — Sistem Rekomendasi</p>
                <a href="{{ route('admin.login') }}" class="text-xs font-semibold text-coffee-200 hover:text-white bg-coffee-700/60 hover:bg-coffee-600 px-3.5 py-1.5 rounded-lg border border-coffee-600 transition-all duration-300 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    Admin Area
                </a>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>

