@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan data CafeRekomendasi')

@section('content')
{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 border border-gray-100 hover:shadow-md transition-all">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-coffee-100 rounded-xl flex items-center justify-center text-xl">☕</div>
            <div><p class="text-2xl font-bold text-gray-900">{{ $totalCafe }}</p><p class="text-sm text-gray-500">Total Cafe</p></div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-6 border border-gray-100 hover:shadow-md transition-all">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-xl">✅</div>
            <div><p class="text-2xl font-bold text-gray-900">{{ $cafeAktif }}</p><p class="text-sm text-gray-500">Cafe Aktif</p></div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-6 border border-gray-100 hover:shadow-md transition-all">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-xl">🛠️</div>
            <div><p class="text-2xl font-bold text-gray-900">{{ $totalFasilitas }}</p><p class="text-sm text-gray-500">Fasilitas</p></div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-6 border border-gray-100 hover:shadow-md transition-all">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-xl">✨</div>
            <div><p class="text-2xl font-bold text-gray-900">{{ $totalRekomendasi }}</p><p class="text-sm text-gray-500">Rekomendasi</p></div>
        </div>
    </div>
</div>

{{-- Cafe Terbaru --}}
<div class="bg-white rounded-2xl border border-gray-100 p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="font-bold text-gray-900">Cafe Terbaru</h2>
        <a href="{{ route('admin.cafe.index') }}" class="text-sm text-coffee-600 hover:text-coffee-800">Lihat Semua →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="border-b border-gray-100">
                <th class="text-left py-3 px-2 text-gray-500 font-medium">Nama</th>
                <th class="text-left py-3 px-2 text-gray-500 font-medium">Rating</th>
                <th class="text-left py-3 px-2 text-gray-500 font-medium">Harga</th>
                <th class="text-left py-3 px-2 text-gray-500 font-medium">Fasilitas</th>
            </tr></thead>
            <tbody>
                @foreach($cafeTerbaru as $cafe)
                <tr class="border-b border-gray-50 hover:bg-gray-50">
                    <td class="py-3 px-2 font-medium text-gray-900">{{ $cafe->name }}</td>
                    <td class="py-3 px-2">⭐ {{ number_format($cafe->rating, 1) }}</td>
                    <td class="py-3 px-2">{{ $cafe->formatted_price }}</td>
                    <td class="py-3 px-2">{{ $cafe->fasilitas->count() }} fasilitas</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Rekomendasi Terbaru --}}
<div class="bg-white rounded-2xl border border-gray-100 p-6">
    <h2 class="font-bold text-gray-900 mb-4">Log Rekomendasi Terbaru</h2>
    @if($rekomendasiTerbaru->count() > 0)
    <div class="space-y-3">
        @foreach($rekomendasiTerbaru as $r)
        <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl text-sm">
            <span class="text-lg">✨</span>
            <div class="flex-1">
                <p class="text-gray-700">Preferensi: <span class="font-medium">{{ implode(', ', $r->preferensi_json['fasilitas_names'] ?? []) }}</span></p>
                <p class="text-xs text-gray-400">{{ $r->created_at->diffForHumans() }}</p>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p class="text-gray-400 text-sm text-center py-8">Belum ada data rekomendasi</p>
    @endif
</div>
@endsection
