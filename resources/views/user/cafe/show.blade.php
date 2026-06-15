@extends('layouts.guest')
@section('title', $cafe->name . ' — CafeRekomendasi')

@section('content')
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="mb-6 text-sm">
            <a href="{{ route('cafe.index') }}" class="text-coffee-400 hover:text-coffee-600">Daftar Cafe</a>
            <span class="text-coffee-300 mx-2">→</span>
            <span class="text-coffee-700 font-medium">{{ $cafe->name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="h-64 md:h-80 rounded-2xl overflow-hidden relative mb-6">
                    @include('components.cafe-image', ['cafe' => $cafe, 'height' => 'h-64 md:h-80', 'rounded' => 'rounded-2xl'])
                    <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-xl text-sm font-bold text-coffee-700">⭐ {{ number_format($cafe->rating, 1) }}</div>
                </div>

                <h1 class="text-3xl font-bold text-coffee-800 mb-2">{{ $cafe->name }}</h1>
                <p class="text-coffee-400 mb-6">📍 {{ $cafe->address }}</p>

                <div class="bg-white rounded-2xl p-6 border border-coffee-100 mb-6">
                    <h2 class="font-bold text-coffee-800 mb-3">Tentang Cafe</h2>
                    <p class="text-coffee-500 leading-relaxed">{{ $cafe->description ?? 'Belum ada deskripsi.' }}</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-coffee-100 mb-6">
                    <h2 class="font-bold text-coffee-800 mb-4">Fasilitas</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($cafe->fasilitas as $f)
                        <div class="flex items-center gap-3 p-3 bg-coffee-50 rounded-xl">
                            <span class="text-xl">{{ $f->icon }}</span>
                            <span class="text-sm font-medium text-coffee-700">{{ $f->name }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                @if($cafe->gmaps_url)
                <div class="bg-white rounded-2xl p-6 border border-coffee-100">
                    <h2 class="font-bold text-coffee-800 mb-4">Lokasi</h2>
                    <a href="{{ $cafe->gmaps_url }}" target="_blank" class="flex items-center gap-3 p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors text-blue-700 text-sm font-medium">🗺️ Buka di Google Maps →</a>
                </div>
                @endif
            </div>

            <div>
                <div class="bg-white rounded-2xl p-6 border border-coffee-100 sticky top-24">
                    <h3 class="font-bold text-coffee-800 mb-4">Informasi</h3>
                    <div class="space-y-4">
                        @if($cafe->kemantren)
                        <div class="flex justify-between py-2 border-b border-coffee-50"><span class="text-sm text-coffee-400">📍 Kemantren</span><span class="text-sm font-semibold text-coffee-700">{{ $cafe->kemantren }}</span></div>
                        @endif
                        @if($cafe->konsep_utama)
                        <div class="flex justify-between py-2 border-b border-coffee-50"><span class="text-sm text-coffee-400">🎨 Konsep Utama</span><span class="text-sm font-semibold text-coffee-700">{{ $cafe->konsep_utama }}</span></div>
                        @endif
                        <div class="flex justify-between py-2 border-b border-coffee-50"><span class="text-sm text-coffee-400">🕐 Jam Buka</span><span class="text-sm font-semibold text-coffee-700">{{ $cafe->open_time }} - {{ $cafe->close_time }}</span></div>
                        <div class="flex justify-between py-2 border-b border-coffee-50"><span class="text-sm text-coffee-400">💰 Harga</span><span class="text-sm font-semibold text-coffee-700">{{ $cafe->formatted_price }}</span></div>
                        <div class="flex justify-between py-2 border-b border-coffee-50"><span class="text-sm text-coffee-400">⭐ Rating</span><span class="text-sm font-semibold text-coffee-700">{{ number_format($cafe->rating, 1) }}</span></div>
                        <div class="flex justify-between py-2"><span class="text-sm text-coffee-400">🛠️ Fasilitas</span><span class="text-sm font-semibold text-coffee-700">{{ $cafe->fasilitas->count() }}</span></div>
                    </div>
                    <a href="{{ route('rekomendasi.form') }}" class="mt-6 w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-coffee-700 text-white font-semibold rounded-xl hover:bg-coffee-600 transition-colors text-sm">✨ Cari Cafe Serupa</a>
                </div>
            </div>
        </div>

        @if($cafeSerupa->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-coffee-800 mb-6">Cafe Serupa</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($cafeSerupa as $s)
                <a href="{{ route('cafe.show', $s->slug) }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all hover:-translate-y-1 border border-coffee-100">
                    <div class="h-40 overflow-hidden">@include('components.cafe-image', ['cafe' => $s, 'height' => 'h-40'])</div>
                    <div class="p-4"><h3 class="font-bold text-coffee-800 group-hover:text-coffee-600">{{ $s->name }}</h3><p class="text-xs text-coffee-400 mt-1">⭐ {{ number_format($s->rating, 1) }} • {{ $s->formatted_price }}</p></div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
