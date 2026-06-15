@extends('layouts.guest')
@section('title', 'CafeRekomendasi — Temukan Cafe Terbaik Untuk Anda')

@section('content')
{{-- Hero Section --}}
<section class="relative overflow-hidden bg-gradient-to-br from-coffee-800 via-coffee-700 to-coffee-600">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 left-10 text-[200px] leading-none">☕</div>
        <div class="absolute bottom-10 right-10 text-[150px] leading-none">🫘</div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32">
        <div class="text-center max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full text-sm text-coffee-100 mb-6">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
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
                <a href="{{ route('rekomendasi.form') }}" class="px-8 py-4 bg-white text-coffee-800 font-bold rounded-2xl hover:bg-coffee-50 transition-all shadow-2xl shadow-black/20 hover:-translate-y-1 text-lg" id="cta-rekomendasi">
                    ✨ Mulai Rekomendasi
                </a>
                <a href="{{ route('cafe.index') }}" class="px-8 py-4 bg-white/10 backdrop-blur-sm text-white font-semibold rounded-2xl hover:bg-white/20 transition-all border border-white/20" id="cta-explore">
                    Jelajahi Cafe →
                </a>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-4 max-w-lg mx-auto mt-16">
            <div class="text-center">
                <p class="text-3xl font-extrabold text-white">{{ $totalCafe }}</p>
                <p class="text-sm text-coffee-300">Cafe</p>
            </div>
            <div class="text-center border-x border-coffee-600">
                <p class="text-3xl font-extrabold text-white">{{ $totalFasilitas }}</p>
                <p class="text-sm text-coffee-300">Fasilitas</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-extrabold text-white">{{ $totalRekomendasi }}</p>
                <p class="text-sm text-coffee-300">Rekomendasi</p>
            </div>
        </div>
    </div>
</section>

{{-- Cara Kerja Section --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1.5 bg-coffee-100 text-coffee-600 rounded-full text-sm font-medium mb-4">Bagaimana Cara Kerjanya?</span>
            <h2 class="text-3xl md:text-4xl font-bold text-coffee-800">3 Langkah Mudah</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-8 rounded-2xl bg-cream hover:shadow-xl transition-all hover:-translate-y-1 group">
                <div class="w-16 h-16 bg-gradient-to-br from-coffee-500 to-coffee-600 rounded-2xl flex items-center justify-center text-2xl text-white mx-auto mb-6 group-hover:scale-110 transition-transform">1</div>
                <h3 class="text-lg font-bold text-coffee-800 mb-3">Pilih Preferensi</h3>
                <p class="text-sm text-coffee-500 leading-relaxed">Pilih fasilitas yang Anda inginkan seperti WiFi, AC, Rooftop, Live Music, dan lainnya.</p>
            </div>
            <div class="text-center p-8 rounded-2xl bg-cream hover:shadow-xl transition-all hover:-translate-y-1 group">
                <div class="w-16 h-16 bg-gradient-to-br from-coffee-500 to-coffee-600 rounded-2xl flex items-center justify-center text-2xl text-white mx-auto mb-6 group-hover:scale-110 transition-transform">2</div>
                <h3 class="text-lg font-bold text-coffee-800 mb-3">Proses Algoritma</h3>
                <p class="text-sm text-coffee-500 leading-relaxed">Sistem menghitung Cosine Similarity antara preferensi Anda dengan data fasilitas setiap cafe.</p>
            </div>
            <div class="text-center p-8 rounded-2xl bg-cream hover:shadow-xl transition-all hover:-translate-y-1 group">
                <div class="w-16 h-16 bg-gradient-to-br from-coffee-500 to-coffee-600 rounded-2xl flex items-center justify-center text-2xl text-white mx-auto mb-6 group-hover:scale-110 transition-transform">3</div>
                <h3 class="text-lg font-bold text-coffee-800 mb-3">Lihat Rekomendasi</h3>
                <p class="text-sm text-coffee-500 leading-relaxed">Dapatkan ranking cafe terbaik berdasarkan similarity score tertinggi beserta detail fasilitas.</p>
            </div>
        </div>
    </div>
</section>

{{-- Cafe Populer Section --}}
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-12">
            <div>
                <span class="inline-block px-4 py-1.5 bg-coffee-100 text-coffee-600 rounded-full text-sm font-medium mb-4">Paling Diminati</span>
                <h2 class="text-3xl md:text-4xl font-bold text-coffee-800">Cafe Populer</h2>
            </div>
            <a href="{{ route('cafe.index') }}" class="hidden md:inline-flex items-center gap-1 text-coffee-600 hover:text-coffee-800 font-medium text-sm transition-colors">
                Lihat Semua <span>→</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($cafePopuler as $cafe)
            <a href="{{ route('cafe.show', $cafe->slug) }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all hover:-translate-y-1 border border-coffee-100">
                {{-- Cafe Image --}}
                <div class="h-48 relative overflow-hidden">
                    @include('components.cafe-image', ['cafe' => $cafe, 'height' => 'h-48'])
                    <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-2.5 py-1 rounded-lg text-sm font-bold text-coffee-700">
                        ⭐ {{ number_format($cafe->rating, 1) }}
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-coffee-800 text-lg mb-1 group-hover:text-coffee-600 transition-colors">{{ $cafe->name }}</h3>
                    <div class="flex flex-wrap gap-1 mb-2 text-xs">
                        @if($cafe->kemantren)
                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded-md font-medium">📍 {{ $cafe->kemantren }}</span>
                        @endif
                        @if($cafe->konsep_utama)
                        <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 rounded-md font-medium">✨ {{ $cafe->konsep_utama }}</span>
                        @endif
                    </div>
                    <p class="text-sm text-coffee-400 mb-3 flex items-center gap-1">
                        <span>🏠</span> {{ Str::limit($cafe->address, 40) }}
                    </p>
                    <div class="flex flex-wrap gap-1.5 mb-3">
                        @foreach($cafe->fasilitas->take(4) as $f)
                        <span class="px-2 py-0.5 bg-coffee-50 text-coffee-600 rounded-md text-xs font-medium">{{ $f->icon }} {{ $f->name }}</span>
                        @endforeach
                        @if($cafe->fasilitas->count() > 4)
                        <span class="px-2 py-0.5 bg-coffee-50 text-coffee-500 rounded-md text-xs">+{{ $cafe->fasilitas->count() - 4 }}</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between pt-3 border-t border-coffee-50">
                        <span class="text-sm font-semibold text-coffee-700">{{ $cafe->formatted_price }}</span>
                        <span class="text-xs text-coffee-400">{{ $cafe->open_time }} - {{ $cafe->close_time }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="text-center mt-8 md:hidden">
            <a href="{{ route('cafe.index') }}" class="inline-flex items-center gap-1 text-coffee-600 font-medium text-sm">Lihat Semua Cafe →</a>
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="py-20 bg-gradient-to-br from-coffee-700 to-coffee-800 relative overflow-hidden">
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-[400px]">☕</div>
    </div>
    <div class="relative max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Siap Menemukan Cafe Impian Anda?</h2>
        <p class="text-coffee-200 mb-8 text-lg">Cukup pilih preferensi Anda, biarkan algoritma kami bekerja.</p>
        <a href="{{ route('rekomendasi.form') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-coffee-800 font-bold rounded-2xl hover:bg-coffee-50 transition-all shadow-2xl hover:-translate-y-1 text-lg">
            ✨ Cari Rekomendasi Sekarang
        </a>
    </div>
</section>
@endsection
