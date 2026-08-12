@extends('layouts.guest')
@section('title', 'CafeRekomendasi — Temukan Cafe Terbaik Untuk Anda')

@section('content')
{{-- Hero Section --}}
<section class="relative overflow-hidden bg-gradient-to-br from-coffee-900 via-coffee-800 to-coffee-700">
    <div class="absolute inset-0 opacity-10 flex justify-between items-center px-10">
        <x-facility-icon name="coffee" class="w-[200px] h-[200px] text-white rotate-12 opacity-50" />
        <x-facility-icon name="sparkles" class="w-[150px] h-[150px] text-white -rotate-12 opacity-50" />
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32">
        <div class="text-center max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full text-sm text-coffee-100 mb-6 border border-white/20">
                <span class="w-2 h-2 bg-coffee-300 rounded-full animate-pulse"></span>
                Content-Based Filtering & Cosine Similarity
            </div>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white leading-tight mb-6">
                Temukan Cafe
                <span class="bg-gradient-to-r from-coffee-300 to-coffee-200 bg-clip-text text-transparent"> Terbaik</span>
                <br>Sesuai Preferensi Anda
            </h1>
            <p class="text-lg text-coffee-200 mb-8 max-w-xl mx-auto leading-relaxed">
                Pilih fasilitas yang Anda inginkan, dan sistem kami akan merekomendasikan cafe dengan kesesuaian tertinggi menggunakan algoritma Cosine Similarity.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('rekomendasi.form') }}" class="group px-8 py-4 bg-white text-coffee-900 font-bold rounded-2xl hover:bg-cream transition-all duration-300 shadow-xl hover:shadow-2xl hover:scale-[1.02] text-lg flex items-center justify-center gap-2" id="cta-rekomendasi">
                    <x-facility-icon name="sparkles" class="w-5 h-5 text-coffee-300 group-hover:text-coffee-600 transition-colors" /> 
                    Mulai Rekomendasi
                </a>
                <a href="{{ route('cafe.index') }}" class="group px-8 py-4 bg-white/10 backdrop-blur-sm text-white font-semibold rounded-2xl hover:bg-white/20 transition-all duration-300 border border-white/20 hover:scale-[1.02] flex items-center justify-center gap-2" id="cta-explore">
                    Jelajahi Cafe 
                    <x-facility-icon name="arrow-left" class="w-5 h-5 rotate-180 group-hover:translate-x-1 transition-transform" />
                </a>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-8 max-w-2xl mx-auto mt-16 bg-white/5 backdrop-blur-md rounded-3xl p-6 border border-white/10 shadow-2xl">
            <div class="text-center flex flex-col items-center gap-2">
                <div class="w-12 h-12 rounded-full bg-coffee-800/50 flex items-center justify-center border border-coffee-600">
                    <x-facility-icon name="coffee" class="w-6 h-6 text-coffee-300" />
                </div>
                <p class="text-3xl font-extrabold text-white mt-2">{{ $totalCafe }}</p>
                <p class="text-sm text-coffee-300 font-medium tracking-wide uppercase">Cafe</p>
            </div>
            <div class="text-center flex flex-col items-center gap-2 border-x border-white/10 px-4">
                <div class="w-12 h-12 rounded-full bg-coffee-800/50 flex items-center justify-center border border-coffee-600">
                    <x-facility-icon name="list" class="w-6 h-6 text-coffee-300" />
                </div>
                <p class="text-3xl font-extrabold text-white mt-2">{{ $totalFasilitas }}</p>
                <p class="text-sm text-coffee-300 font-medium tracking-wide uppercase">Fasilitas</p>
            </div>
            <div class="text-center flex flex-col items-center gap-2">
                <div class="w-12 h-12 rounded-full bg-coffee-800/50 flex items-center justify-center border border-coffee-600">
                    <x-facility-icon name="target" class="w-6 h-6 text-coffee-300" />
                </div>
                <p class="text-3xl font-extrabold text-white mt-2">{{ $totalRekomendasi }}</p>
                <p class="text-sm text-coffee-300 font-medium tracking-wide uppercase">Rekomendasi</p>
            </div>
        </div>
    </div>
</section>

{{-- Cara Kerja Section --}}
<section class="py-24 bg-cream">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-coffee-100/50 text-coffee-700 rounded-full text-sm font-semibold mb-4 border border-coffee-200">
                <x-facility-icon name="info" class="w-4 h-4" />
                Bagaimana Cara Kerjanya?
            </span>
            <h2 class="text-3xl md:text-5xl font-extrabold text-coffee-900 tracking-tight">3 Langkah Mudah</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-8 rounded-3xl bg-white shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-coffee-50 group">
                <div class="w-16 h-16 bg-gradient-to-br from-coffee-800 to-coffee-600 rounded-2xl flex items-center justify-center text-white mx-auto mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg shadow-coffee-900/20">
                    <x-facility-icon name="filter" class="w-8 h-8" />
                </div>
                <h3 class="text-xl font-bold text-coffee-900 mb-3">1. Pilih Preferensi</h3>
                <p class="text-coffee-500 leading-relaxed">Pilih fasilitas yang Anda inginkan seperti WiFi, AC, Rooftop, Live Music, dan lainnya.</p>
            </div>
            <div class="text-center p-8 rounded-3xl bg-white shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-coffee-50 group">
                <div class="w-16 h-16 bg-gradient-to-br from-coffee-800 to-coffee-600 rounded-2xl flex items-center justify-center text-white mx-auto mb-6 group-hover:scale-110 group-hover:-rotate-3 transition-all duration-300 shadow-lg shadow-coffee-900/20">
                    <x-facility-icon name="target" class="w-8 h-8" />
                </div>
                <h3 class="text-xl font-bold text-coffee-900 mb-3">2. Proses Algoritma</h3>
                <p class="text-coffee-500 leading-relaxed">Sistem menghitung Cosine Similarity antara preferensi Anda dengan data fasilitas setiap cafe.</p>
            </div>
            <div class="text-center p-8 rounded-3xl bg-white shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-coffee-50 group">
                <div class="w-16 h-16 bg-gradient-to-br from-coffee-800 to-coffee-600 rounded-2xl flex items-center justify-center text-white mx-auto mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg shadow-coffee-900/20">
                    <x-facility-icon name="star" class="w-8 h-8" />
                </div>
                <h3 class="text-xl font-bold text-coffee-900 mb-3">3. Lihat Rekomendasi</h3>
                <p class="text-coffee-500 leading-relaxed">Dapatkan ranking cafe terbaik berdasarkan similarity score tertinggi beserta detail fasilitas.</p>
            </div>
        </div>
    </div>
</section>

{{-- Cafe Populer Section --}}
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-coffee-100/50 text-coffee-700 rounded-full text-sm font-semibold mb-4 border border-coffee-200">
                    <x-facility-icon name="star" class="w-4 h-4 text-coffee-500" />
                    Paling Diminati
                </span>
                <h2 class="text-3xl md:text-5xl font-extrabold text-coffee-900 tracking-tight">Cafe Populer</h2>
            </div>
            <a href="{{ route('cafe.index') }}" class="group hidden md:inline-flex items-center gap-2 text-coffee-700 hover:text-coffee-900 font-bold transition-colors">
                Lihat Semua Cafe
                <x-facility-icon name="arrow-left" class="w-5 h-5 rotate-180 group-hover:translate-x-1 transition-transform" />
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($cafePopuler as $cafe)
            <a href="{{ route('cafe.show', $cafe->slug) }}" class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-300 hover:scale-[1.02] border border-coffee-100 flex flex-col">
                {{-- Cafe Image --}}
                <div class="h-56 relative overflow-hidden">
                    @include('components.cafe-image', ['cafe' => $cafe, 'height' => 'h-56', 'class' => 'group-hover:scale-105 transition-transform duration-500'])
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-60 group-hover:opacity-80 transition-opacity"></div>
                    <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-xl text-sm font-bold text-coffee-900 flex items-center gap-1.5 shadow-lg">
                        <x-facility-icon name="star" class="w-4 h-4 text-coffee-400" />
                        {{ number_format($cafe->rating, 1) }}
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="font-bold text-coffee-900 text-xl mb-2 group-hover:text-coffee-700 transition-colors">{{ $cafe->name }}</h3>
                    <div class="flex flex-wrap gap-2 mb-4 text-xs font-semibold">
                        @if($cafe->kemantren)
                        <span class="px-2.5 py-1 bg-coffee-50 text-coffee-700 rounded-lg flex items-center gap-1 border border-coffee-100">
                            <x-facility-icon name="map-pin" class="w-3 h-3" />
                            {{ $cafe->kemantren }}
                        </span>
                        @endif
                        @if($cafe->konsep_utama)
                        <span class="px-2.5 py-1 bg-coffee-100 text-coffee-800 rounded-lg flex items-center gap-1 border border-coffee-200">
                            <x-facility-icon name="sparkles" class="w-3 h-3" />
                            {{ $cafe->konsep_utama }}
                        </span>
                        @endif
                    </div>
                    <p class="text-sm text-coffee-500 mb-5 flex items-start gap-2 leading-relaxed flex-1">
                        <x-facility-icon name="home" class="w-4 h-4 mt-0.5 shrink-0 text-coffee-400" />
                        {{ Str::limit($cafe->address, 50) }}
                    </p>
                    <div class="flex flex-wrap gap-2 mb-5">
                        @foreach($cafe->fasilitas->take(4) as $f)
                        <span class="px-2 py-1 bg-cream-dark text-coffee-700 rounded-lg text-xs font-medium flex items-center gap-1.5 border border-coffee-100" title="{{ $f->name }}">
                            <x-facility-icon :name="$f->slug" class="w-3.5 h-3.5 text-coffee-600" />
                            <span class="hidden sm:inline">{{ Str::limit($f->name, 12) }}</span>
                        </span>
                        @endforeach
                        @if($cafe->fasilitas->count() > 4)
                        <span class="px-2 py-1 bg-cream text-coffee-500 rounded-lg text-xs font-medium flex items-center border border-coffee-100">
                            +{{ $cafe->fasilitas->count() - 4 }}
                        </span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-coffee-100 mt-auto">
                        <span class="text-sm font-bold text-coffee-900 flex items-center gap-1.5">
                            <x-facility-icon name="money" class="w-4 h-4 text-coffee-400" />
                            {{ $cafe->formatted_price }}
                        </span>
                        <span class="text-sm font-medium text-coffee-500 flex items-center gap-1.5">
                            <x-facility-icon name="clock" class="w-4 h-4 text-coffee-400" />
                            {{ $cafe->open_time }} - {{ $cafe->close_time }}
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="text-center mt-10 md:hidden">
            <a href="{{ route('cafe.index') }}" class="inline-flex items-center gap-2 text-coffee-700 font-bold bg-coffee-50 px-6 py-3 rounded-xl border border-coffee-100">
                Lihat Semua Cafe 
                <x-facility-icon name="arrow-left" class="w-4 h-4 rotate-180" />
            </a>
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="py-24 bg-gradient-to-br from-coffee-900 via-coffee-800 to-coffee-700 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <x-facility-icon name="sparkles" class="absolute top-0 right-10 w-64 h-64 text-white opacity-50" />
        <x-facility-icon name="coffee" class="absolute -bottom-10 -left-10 w-80 h-80 text-white opacity-50 -rotate-12" />
    </div>
    <div class="relative max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-6 tracking-tight">Siap Menemukan Cafe Impian Anda?</h2>
        <p class="text-coffee-200 mb-10 text-lg md:text-xl font-medium max-w-2xl mx-auto">
            Cukup pilih preferensi Anda, biarkan algoritma cerdas kami mencari yang paling cocok.
        </p>
        <a href="{{ route('rekomendasi.form') }}" class="group inline-flex items-center gap-3 px-10 py-5 bg-white text-coffee-900 font-bold rounded-full hover:bg-cream transition-all duration-300 shadow-2xl hover:scale-[1.02] hover:shadow-coffee-900/50 text-lg">
            <x-facility-icon name="search" class="w-6 h-6 text-coffee-400 group-hover:text-coffee-600 transition-colors" />
            Cari Rekomendasi Sekarang
        </a>
    </div>
</section>
@endsection
