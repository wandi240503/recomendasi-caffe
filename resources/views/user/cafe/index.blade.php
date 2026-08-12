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
        <form action="{{ route('cafe.index') }}" method="GET" class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow border border-coffee-100 mb-8" id="filter-form">
            <div class="flex flex-col md:flex-row gap-4 mb-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <x-facility-icon name="search" class="w-5 h-5 text-coffee-400" />
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari nama cafe..."
                           class="w-full pl-11 pr-4 py-3 rounded-xl border border-coffee-200 focus:border-coffee-400 focus:ring-2 focus:ring-coffee-200 outline-none transition-all text-sm text-coffee-800" id="search-input">
                </div>
                <button type="submit" class="px-6 py-3 bg-coffee-700 text-white font-semibold rounded-xl hover:bg-coffee-600 transition-colors text-sm flex items-center justify-center gap-2" id="search-btn">
                    <x-facility-icon name="search" class="w-4 h-4" /> Cari
                </button>
            </div>

            {{-- Filter Fasilitas --}}
            <div x-data="{ expanded: false }" class="mt-4 border-t border-coffee-50 pt-4">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm font-medium text-coffee-600 flex items-center gap-2">
                        <x-facility-icon name="filter" class="w-4 h-4" /> Filter Fasilitas
                    </p>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach($allFasilitas as $f)
                    <label class="cursor-pointer">
                        <input type="checkbox" name="fasilitas[]" value="{{ $f->id }}"
                               class="hidden peer"
                               {{ in_array($f->id, request('fasilitas', [])) ? 'checked' : '' }}>
                        <span class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-coffee-200 text-sm text-coffee-500 peer-checked:bg-coffee-700 peer-checked:text-white peer-checked:border-coffee-700 hover:border-coffee-400 hover:bg-coffee-50 transition-all">
                            <x-facility-icon :name="$f->slug" class="w-4 h-4" /> {{ $f->name }}
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
            <a href="{{ route('cafe.show', $cafe->slug) }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all hover:scale-[1.02] duration-300 border border-coffee-100 flex flex-col h-full">
                <div class="h-48 relative overflow-hidden shrink-0">
                    @include('components.cafe-image', ['cafe' => $cafe, 'height' => 'h-48'])
                    <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-2.5 py-1.5 rounded-lg text-sm font-bold text-coffee-700 shadow-sm flex items-center gap-1">
                        <x-facility-icon name="star" class="w-4 h-4 text-coffee-300" /> {{ number_format($cafe->rating, 1) }}
                    </div>
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <h3 class="font-bold text-coffee-800 text-lg mb-1 group-hover:text-coffee-600 transition-colors line-clamp-1">{{ $cafe->name }}</h3>
                    <div class="flex flex-wrap gap-1.5 mb-2 text-xs">
                        @if($cafe->kemantren)
                        <span class="px-2 py-1 bg-coffee-50 text-coffee-700 rounded-lg font-medium flex items-center gap-1">
                            <x-facility-icon name="map-pin" class="w-3 h-3" /> {{ $cafe->kemantren }}
                        </span>
                        @endif
                        @if($cafe->konsep_utama)
                        <span class="px-2 py-1 bg-coffee-100 text-coffee-800 rounded-lg font-medium flex items-center gap-1">
                            <x-facility-icon name="star" class="w-3 h-3" /> {{ $cafe->konsep_utama }}
                        </span>
                        @endif
                    </div>
                    <p class="text-sm text-coffee-500 mb-4 flex items-start gap-1.5 line-clamp-2">
                        <x-facility-icon name="map-pin" class="w-4 h-4 shrink-0 mt-0.5 text-coffee-400" /> {{ $cafe->address }}
                    </p>
                    
                    <div class="mt-auto">
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            @foreach($cafe->fasilitas->take(4) as $f)
                            <span class="px-2 py-1 bg-white border border-coffee-100 text-coffee-600 rounded-lg text-xs font-medium flex items-center gap-1 shadow-sm">
                                <x-facility-icon :name="$f->slug" class="w-3 h-3" /> {{ $f->name }}
                            </span>
                            @endforeach
                            @if($cafe->fasilitas->count() > 4)
                            <span class="px-2 py-1 bg-coffee-50 border border-transparent text-coffee-500 rounded-lg text-xs font-medium">
                                +{{ $cafe->fasilitas->count() - 4 }}
                            </span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-coffee-50">
                            <span class="text-sm font-semibold text-coffee-700 flex items-center gap-1">
                                <x-facility-icon name="money" class="w-4 h-4 text-coffee-400" /> {{ $cafe->formatted_price }}
                            </span>
                            <span class="text-xs font-medium text-coffee-500 flex items-center gap-1 bg-coffee-50 px-2 py-1 rounded-lg">
                                <x-facility-icon name="clock" class="w-3 h-3" /> {{ $cafe->open_time }} - {{ $cafe->close_time }}
                            </span>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $cafes->withQueryString()->links() }}
        </div>
        @else
        <div class="text-center py-24 bg-white rounded-2xl border border-coffee-100 shadow-sm">
            <div class="flex justify-center mb-4">
                <div class="p-4 bg-coffee-50 rounded-full">
                    <x-facility-icon name="search" class="w-12 h-12 text-coffee-300" />
                </div>
            </div>
            <h3 class="text-xl font-bold text-coffee-800 mb-2">Cafe tidak ditemukan</h3>
            <p class="text-coffee-500 mb-6 max-w-md mx-auto">Kami tidak dapat menemukan cafe yang sesuai dengan pencarian atau filter Anda. Coba ubah kriteria pencarian.</p>
            <a href="{{ route('cafe.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-coffee-700 text-white font-semibold rounded-xl hover:bg-coffee-600 transition-colors text-sm shadow-sm">
                <x-facility-icon name="filter" class="w-4 h-4" /> Reset Filter
            </a>
        </div>
        @endif
    </div>
</section>
@endsection
