@extends('layouts.guest')
@section('title', 'Hasil Rekomendasi — CafeRekomendasi')

@section('content')
<section class="py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <span class="inline-block px-4 py-1.5 bg-coffee-100 text-coffee-600 rounded-full text-sm font-medium mb-4">Cosine Similarity</span>
            <h1 class="text-3xl font-bold text-coffee-800 mb-2">Hasil Rekomendasi</h1>
            <p class="text-coffee-400">Berdasarkan preferensi: <span class="font-medium text-coffee-600">{{ implode(', ', $selectedNames) }}</span></p>
        </div>

        {{-- Results --}}
        <div class="space-y-4">
            @foreach($results as $item)
            @if($item['similarity'] > 0)
            <div class="bg-white rounded-2xl p-6 border border-coffee-100 hover:shadow-lg transition-all {{ $item['rank'] <= 3 ? 'ring-2 ring-coffee-200' : '' }}">
                <div class="flex flex-col md:flex-row gap-6">
                    {{-- Rank Badge --}}
                    <div class="flex-shrink-0 flex items-start">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-xl font-extrabold
                            {{ $item['rank'] == 1 ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $item['rank'] == 2 ? 'bg-gray-100 text-gray-600' : '' }}
                            {{ $item['rank'] == 3 ? 'bg-orange-100 text-orange-600' : '' }}
                            {{ $item['rank'] > 3 ? 'bg-coffee-50 text-coffee-500' : '' }}">
                            #{{ $item['rank'] }}
                        </div>
                    </div>

                    {{-- Cafe Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between mb-2">
                            <div>
                                <a href="{{ route('cafe.show', $item['cafe']->slug) }}" class="text-xl font-bold text-coffee-800 hover:text-coffee-600 transition-colors">{{ $item['cafe']->name }}</a>
                                <p class="text-sm text-coffee-400 mt-1">📍 {{ $item['cafe']->address }}</p>
                            </div>
                            <div class="text-right flex-shrink-0 ml-4">
                                <div class="text-2xl font-extrabold text-coffee-700">{{ $item['percentage'] }}%</div>
                                <p class="text-xs text-coffee-400">match</p>
                            </div>
                        </div>

                        {{-- Similarity Bar --}}
                        <div class="w-full bg-coffee-100 rounded-full h-2.5 mb-4">
                            <div class="h-2.5 rounded-full transition-all {{ $item['percentage'] >= 80 ? 'bg-green-500' : ($item['percentage'] >= 50 ? 'bg-yellow-500' : 'bg-orange-500') }}"
                                 style="width: {{ $item['percentage'] }}%"></div>
                        </div>

                        {{-- Matched Fasilitas --}}
                        <div class="flex flex-wrap gap-1.5 mb-3">
                            @foreach($item['cafe']->fasilitas as $f)
                            <span class="px-2.5 py-1 rounded-lg text-xs font-medium {{ in_array($f->id, $selectedIds) ? 'bg-green-100 text-green-700 ring-1 ring-green-200' : 'bg-coffee-50 text-coffee-400' }}">
                                {{ $f->icon }} {{ $f->name }} {{ in_array($f->id, $selectedIds) ? '✓' : '' }}
                            </span>
                            @endforeach
                        </div>

                        <div class="flex items-center gap-4 text-sm text-coffee-400">
                            <span>⭐ {{ number_format($item['cafe']->rating, 1) }}</span>
                            <span>💰 {{ $item['cafe']->formatted_price }}</span>
                            <span>🕐 {{ $item['cafe']->open_time }}-{{ $item['cafe']->close_time }}</span>
                            <span>🎯 {{ $item['matched_count'] }}/{{ $item['total_selected'] }} fasilitas cocok</span>
                        </div>
                    </div>
                </div>

                {{-- Vector Detail (collapsible) --}}
                <details class="mt-4 pt-4 border-t border-coffee-50">
                    <summary class="text-xs text-coffee-400 cursor-pointer hover:text-coffee-600">Lihat detail vektor & perhitungan</summary>
                    <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                        <div class="bg-coffee-50 p-3 rounded-xl">
                            <p class="font-semibold text-coffee-600 mb-1">User Vector:</p>
                            <code class="text-coffee-500">[{{ implode(', ', $item['user_vector']) }}]</code>
                        </div>
                        <div class="bg-coffee-50 p-3 rounded-xl">
                            <p class="font-semibold text-coffee-600 mb-1">Cafe Vector:</p>
                            <code class="text-coffee-500">[{{ implode(', ', $item['cafe_vector']) }}]</code>
                        </div>
                    </div>
                    <p class="text-xs text-coffee-400 mt-2">Cosine Similarity = {{ $item['similarity'] }}</p>
                </details>
            </div>
            @endif
            @endforeach
        </div>

        {{-- Back --}}
        <div class="text-center mt-10">
            <a href="{{ route('rekomendasi.form') }}" class="px-8 py-3 bg-coffee-700 text-white font-semibold rounded-xl hover:bg-coffee-600 transition-colors">← Cari Lagi</a>
        </div>
    </div>
</section>
@endsection
