@extends('layouts.guest')
@section('title', $cafe->name . ' — CafeRekomendasi')

@section('content')
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="mb-6 text-sm flex items-center text-coffee-400">
            <a href="{{ route('cafe.index') }}" class="hover:text-coffee-600 transition-colors">Daftar Cafe</a>
            <x-facility-icon name="chevron-right" class="w-4 h-4 mx-2" />
            <span class="text-coffee-700 font-medium">{{ $cafe->name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="h-64 md:h-80 rounded-2xl overflow-hidden relative mb-6 shadow-sm">
                    @include('components.cafe-image', ['cafe' => $cafe, 'height' => 'h-64 md:h-80', 'rounded' => 'rounded-2xl'])
                    <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-xl text-sm font-bold text-coffee-700 flex items-center gap-1.5 shadow-sm">
                        <x-facility-icon name="star" class="w-4 h-4 text-coffee-300" /> {{ number_format($cafe->rating, 1) }}
                    </div>
                </div>

                <h1 class="text-3xl font-bold text-coffee-800 mb-2">{{ $cafe->name }}</h1>
                <p class="text-coffee-500 mb-6 flex items-start gap-2">
                    <x-facility-icon name="map-pin" class="w-5 h-5 mt-0.5 shrink-0 text-coffee-400" />
                    <span>{{ $cafe->address }}</span>
                </p>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-coffee-100 mb-6">
                    <h2 class="text-lg font-bold text-coffee-800 mb-3 flex items-center gap-2">
                        Tentang Cafe
                    </h2>
                    <p class="text-coffee-500 leading-relaxed">{{ $cafe->description ?? 'Belum ada deskripsi.' }}</p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-coffee-100 mb-6">
                    <h2 class="text-lg font-bold text-coffee-800 mb-4 flex items-center gap-2">
                        Fasilitas
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($cafe->fasilitas as $f)
                        <div class="flex items-center gap-3 p-3 bg-coffee-50 rounded-xl hover:bg-coffee-100 transition-colors">
                            <span class="p-2 bg-white rounded-lg shadow-sm">
                                <x-facility-icon :name="$f->slug" class="w-5 h-5 text-coffee-600" />
                            </span>
                            <span class="text-sm font-medium text-coffee-700">{{ $f->name }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Galeri Foto Cafe --}}
                @if($cafe->fotos->count() > 0)
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-coffee-100 mb-6">
                    <h2 class="text-lg font-bold text-coffee-800 mb-4 flex items-center gap-2">
                        <x-facility-icon name="image" class="w-5 h-5 text-coffee-600" /> Galeri Foto Cafe
                    </h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach($cafe->fotos as $foto)
                        <div class="h-32 rounded-xl overflow-hidden cursor-pointer border border-coffee-50 hover:border-coffee-300 hover:shadow-md transition-all duration-200" onclick="openLightbox('{{ $foto->url }}')">
                            <img src="{{ $foto->url }}" alt="{{ $cafe->name }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($cafe->gmaps_url)
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-coffee-100">
                    <h2 class="text-lg font-bold text-coffee-800 mb-4">Lokasi</h2>
                    <a href="{{ $cafe->gmaps_url }}" target="_blank" class="flex items-center gap-3 p-4 bg-coffee-50 rounded-xl hover:bg-coffee-100 transition-colors text-coffee-700 text-sm font-medium group">
                        <div class="p-2 bg-white rounded-lg shadow-sm group-hover:scale-110 transition-transform">
                            <x-facility-icon name="map-pin" class="w-5 h-5 text-coffee-600" />
                        </div>
                        <span>Buka di Google Maps</span>
                        <x-facility-icon name="external-link" class="w-4 h-4 ml-auto text-coffee-400 group-hover:text-coffee-600 transition-colors" />
                    </a>
                </div>
                @endif
            </div>

            {{-- Lightbox Modal --}}
            <div id="lightbox" class="fixed inset-0 bg-black/90 z-50 hidden flex items-center justify-center p-4 transition-all duration-300">
                <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white hover:text-gray-300 text-4xl font-bold cursor-pointer focus:outline-none">&times;</button>
                <div class="max-w-4xl max-h-[85vh] overflow-hidden">
                    <img id="lightbox-img" src="" alt="Gallery Image" class="max-w-full max-h-[85vh] object-contain rounded-xl">
                </div>
            </div>

            @push('scripts')
            <script>
                function openLightbox(imgUrl) {
                    const lightbox = document.getElementById('lightbox');
                    const lightboxImg = document.getElementById('lightbox-img');
                    
                    lightboxImg.src = imgUrl;
                    lightbox.classList.remove('hidden');
                    document.body.style.overflow = 'hidden'; // Nonaktifkan scroll
                }
                
                function closeLightbox() {
                    const lightbox = document.getElementById('lightbox');
                    lightbox.classList.add('hidden');
                    document.body.style.overflow = ''; // Aktifkan scroll
                }
                
                // Tutup lightbox jika klik area luar gambar
                document.getElementById('lightbox').addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeLightbox();
                    }
                });

                // Tutup dengan ESC
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        closeLightbox();
                    }
                });
            </script>
            @endpush

            <div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-coffee-100 sticky top-24">
                    <h3 class="font-bold text-coffee-800 mb-4">Informasi</h3>
                    <div class="space-y-4">
                        @if($cafe->kemantren)
                        <div class="flex justify-between items-center py-2 border-b border-coffee-50">
                            <span class="text-sm text-coffee-500 flex items-center gap-2">
                                <x-facility-icon name="map-pin" class="w-4 h-4 text-coffee-400" /> Kemantren
                            </span>
                            <span class="text-sm font-semibold text-coffee-700">{{ $cafe->kemantren }}</span>
                        </div>
                        @endif
                        @if($cafe->konsep_utama)
                        <div class="flex justify-between items-center py-2 border-b border-coffee-50">
                            <span class="text-sm text-coffee-500 flex items-center gap-2">
                                <x-facility-icon name="star" class="w-4 h-4 text-coffee-400" /> Konsep Utama
                            </span>
                            <span class="text-sm font-semibold text-coffee-700">{{ $cafe->konsep_utama }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between items-center py-2 border-b border-coffee-50">
                            <span class="text-sm text-coffee-500 flex items-center gap-2">
                                <x-facility-icon name="clock" class="w-4 h-4 text-coffee-400" /> Jam Buka
                            </span>
                            <span class="text-sm font-semibold text-coffee-700">{{ $cafe->open_time }} - {{ $cafe->close_time }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-coffee-50">
                            <span class="text-sm text-coffee-500 flex items-center gap-2">
                                <x-facility-icon name="money" class="w-4 h-4 text-coffee-400" /> Harga
                            </span>
                            <span class="text-sm font-semibold text-coffee-700">{{ $cafe->formatted_price }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-coffee-50">
                            <span class="text-sm text-coffee-500 flex items-center gap-2">
                                <x-facility-icon name="star" class="w-4 h-4 text-coffee-400" /> Rating
                            </span>
                            <span class="text-sm font-semibold text-coffee-700">{{ number_format($cafe->rating, 1) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm text-coffee-500 flex items-center gap-2">
                                <x-facility-icon name="filter" class="w-4 h-4 text-coffee-400" /> Fasilitas
                            </span>
                            <span class="text-sm font-semibold text-coffee-700">{{ $cafe->fasilitas->count() }}</span>
                        </div>
                    </div>
                    <a href="{{ route('rekomendasi.form') }}" class="mt-6 w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-coffee-700 text-white font-semibold rounded-xl hover:bg-coffee-600 transition-colors text-sm shadow-sm">
                        <x-facility-icon name="search" class="w-4 h-4" /> Cari Cafe Serupa
                    </a>
                </div>
            </div>
        </div>

        @if($cafeSerupa->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-coffee-800 mb-6">Cafe Serupa</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($cafeSerupa as $s)
                <a href="{{ route('cafe.show', $s->slug) }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all hover:scale-[1.02] duration-300 border border-coffee-100 flex flex-col h-full">
                    <div class="h-40 overflow-hidden relative">
                        @include('components.cafe-image', ['cafe' => $s, 'height' => 'h-40'])
                        <div class="absolute top-2 right-2 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-lg text-xs font-bold text-coffee-700 shadow-sm flex items-center gap-1">
                            <x-facility-icon name="star" class="w-3 h-3 text-coffee-300" /> {{ number_format($s->rating, 1) }}
                        </div>
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-bold text-coffee-800 group-hover:text-coffee-600 transition-colors line-clamp-1 mb-2">{{ $s->name }}</h3>
                        <div class="mt-auto flex items-center justify-between">
                            <p class="text-xs font-medium text-coffee-500 flex items-center gap-1 bg-coffee-50 px-2 py-1 rounded-lg">
                                <x-facility-icon name="money" class="w-3 h-3" /> {{ $s->formatted_price }}
                            </p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
