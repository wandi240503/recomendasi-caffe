@extends('layouts.admin')
@section('title', 'Kelola Fasilitas')
@section('page-title', 'Kelola Fasilitas')
@section('page-subtitle', 'Manage fasilitas cafe')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Form Tambah --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-6 h-fit">
        <h3 class="font-bold text-gray-900 mb-4">Tambah Fasilitas</h3>
        <form action="{{ route('admin.fasilitas.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama *</label>
                <input type="text" name="name" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-coffee-500 focus:ring-2 focus:ring-coffee-200 outline-none text-sm" placeholder="Nama fasilitas">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Icon (emoji)</label>
                <input type="text" name="icon" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-coffee-500 focus:ring-2 focus:ring-coffee-200 outline-none text-sm" placeholder="☕" maxlength="10">
            </div>
            <button type="submit" class="w-full py-3 bg-coffee-700 text-white font-semibold rounded-xl hover:bg-coffee-600 transition-colors text-sm">+ Tambah</button>
        </form>
    </div>

    {{-- List Fasilitas --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 p-6">
        <h3 class="font-bold text-gray-900 mb-4">Daftar Fasilitas ({{ $fasilitas->count() }})</h3>
        <div class="space-y-3">
            @foreach($fasilitas as $f)
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">{{ $f->icon }}</span>
                    <div>
                        <p class="font-medium text-gray-900">{{ $f->name }}</p>
                        <p class="text-xs text-gray-400">Digunakan oleh {{ $f->cafes_count }} cafe</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <form action="{{ route('admin.fasilitas.update', $f) }}" method="POST" class="flex items-center gap-2">
                        @csrf @method('PUT')
                        <input type="text" name="name" value="{{ $f->name }}" class="px-3 py-1.5 rounded-lg border border-gray-200 text-xs w-24 focus:border-coffee-500 outline-none">
                        <input type="text" name="icon" value="{{ $f->icon }}" class="px-3 py-1.5 rounded-lg border border-gray-200 text-xs w-12 focus:border-coffee-500 outline-none">
                        <button class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-medium hover:bg-blue-100">Save</button>
                    </form>
                    <form action="{{ route('admin.fasilitas.destroy', $f) }}" method="POST" onsubmit="return confirm('Hapus fasilitas ini?')">
                        @csrf @method('DELETE')
                        <button class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-xs font-medium hover:bg-red-100">Hapus</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
