@extends('layouts.guest')
@section('title', 'Daftar Cafe — CafeRekomendasi')

@section('content')
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-coffee-800 mb-2">Daftar Cafe</h1>
            <p class="text-coffee-500">Jelajahi {{ $cafes->total() }} cafe yang tersedia</p>
        </div>

        {{-- Search & Filter --}}
        <form action="{{ route('cafe.index') }}" method="GET" class="bg-white rounded-2xl p-6 shadow-sm border border-coffee-100 mb-8" id="filter-form">
            <div class="flex flex-col md:flex-row gap-4 mb-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="🔍 Cari nama cafe..."
                           class="w-full px-4 py-3 rounded-xl border border-coffee-200 focus:border-coffee-400 focus:ring-2 focus:ring-coffee-200 outline-none transition-all text-sm" id="search-input">
                </div>
                <button type="submit" class="px-6 py-3 bg-coffee-700 text-white font-semibold rounded-xl hover:bg-coffee-600 transition-colors text-sm" id="search-btn">
                    Cari
                </button>
            </div>

            {{-- Filter Fasilitas --}}
            <div>
                <p class="text-sm font-medium text-coffee-600 mb-3">Filter Fasilitas:</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($allFasilitas as $f)
                    <label class="cursor-pointer">
                        <input type="checkbox" name="fasilitas[]" value="{{ $f->id }}"
                               class="hidden peer"
                               {{ in_array($f->id, request('fasilitas', [])) ? 'checked' : '' }}>
                        <span class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-coffee-200 text-sm text-coffee-500 peer-checked:bg-coffee-700 peer-checked:text-white peer-checked:border-coffee-700 hover:border-coffee-400 transition-all">
                            {{ $f->icon }} {{ $f->name }}
                        </span>
                    </label>
                    @endforeach
                </div>
            </div>
        </form>

        {{-- Cafe Grid --}}
        @if($cafes->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($cafes as $cafe)
            <a href="{{ route('cafe.show', $cafe->slug) }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all hover:-translate-y-1 border border-coffee-100">
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

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $cafes->withQueryString()->links() }}
        </div>
        @else
        <div class="text-center py-20">
            <span class="text-6xl mb-4 block">🔍</span>
            <h3 class="text-xl font-bold text-coffee-700 mb-2">Cafe tidak ditemukan</h3>
            <p class="text-coffee-400 mb-6">Coba ubah kata kunci atau filter pencarian</p>
            <a href="{{ route('cafe.index') }}" class="px-6 py-3 bg-coffee-700 text-white font-semibold rounded-xl hover:bg-coffee-600 transition-colors text-sm">Reset Filter</a>
        </div>
        @endif
    </div>
</section>
@endsection
