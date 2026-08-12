@extends('layouts.admin')
@section('title', 'Kelola Fasilitas')
@section('page-title', 'Kelola Fasilitas')
@section('page-subtitle', 'Manage fasilitas cafe')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Form Tambah --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 h-fit">
        <h3 class="font-bold text-gray-900 mb-5 border-b border-gray-100 pb-3">Tambah Fasilitas</h3>
        <form action="{{ route('admin.fasilitas.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Fasilitas <span class="text-red-500">*</span></label>
                <input type="text" name="name" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-coffee-500 focus:ring-2 focus:ring-coffee-200 outline-none text-sm transition-all" placeholder="Contoh: WiFi, Parkir Luas">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Slug Icon <span class="text-gray-400 font-normal">(opsional)</span></label>
                <input type="text" name="slug" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-coffee-500 focus:ring-2 focus:ring-coffee-200 outline-none text-sm transition-all" placeholder="Contoh: wifi, parking">
                <p class="text-xs text-gray-500 mt-2">Sistem akan otomatis menggunakan nama fasilitas jika slug dikosongkan.</p>
            </div>
            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 py-3 bg-coffee-700 text-white font-semibold rounded-xl hover:bg-coffee-800 transition-colors text-sm shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Fasilitas
            </button>
        </form>
    </div>

    {{-- List Fasilitas --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-bold text-gray-900 mb-5 border-b border-gray-100 pb-3">Daftar Fasilitas ({{ $fasilitas->count() }})</h3>
        
        @if($fasilitas->count() > 0)
        <div class="space-y-3">
            @foreach($fasilitas as $f)
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 bg-gray-50 border border-gray-100 rounded-xl hover:bg-white transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-gray-600 shadow-sm">
                        <x-facility-icon :name="$f->slug ?? strtolower($f->name)" class="w-5 h-5"/>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ $f->name }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">Digunakan oleh <span class="font-medium text-gray-700">{{ $f->cafes_count ?? 0 }}</span> cafe</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 sm:self-auto self-end">
                    <form action="{{ route('admin.fasilitas.update', $f) }}" method="POST" class="flex items-center gap-2">
                        @csrf @method('PUT')
                        <input type="text" name="name" value="{{ $f->name }}" required placeholder="Nama" class="px-3 py-2 rounded-lg border border-gray-200 text-sm w-28 md:w-36 focus:border-coffee-500 focus:ring-1 focus:ring-coffee-500 outline-none transition-all">
                        <input type="text" name="slug" value="{{ $f->slug ?? '' }}" placeholder="Slug" class="px-3 py-2 rounded-lg border border-gray-200 text-sm w-24 md:w-28 focus:border-coffee-500 focus:ring-1 focus:ring-coffee-500 outline-none transition-all hidden sm:block">
                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors shadow-sm" title="Simpan Perubahan">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><polyline points="20 6 9 17 4 12"/></svg>
                        </button>
                    </form>
                    <form action="{{ route('admin.fasilitas.destroy', $f) }}" method="POST" onsubmit="return confirm('Hapus fasilitas ini secara permanen?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 bg-white border border-red-100 text-red-600 rounded-lg text-sm font-medium hover:bg-red-50 transition-colors shadow-sm" title="Hapus Fasilitas">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="9" y1="3" x2="9" y2="21"/></svg>
            <p class="text-gray-500 text-sm">Belum ada data fasilitas.</p>
        </div>
        @endif
    </div>
</div>
@endsection
