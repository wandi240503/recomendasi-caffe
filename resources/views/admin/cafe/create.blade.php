@extends('layouts.admin')
@section('title', 'Tambah Cafe')
@section('page-title', 'Tambah Cafe')

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.cafe.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 space-y-8">
        @csrf
        
        <div>
            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Informasi Dasar</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Cafe <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-coffee-500 focus:ring-2 focus:ring-coffee-200 outline-none text-sm transition-all" placeholder="Contoh: Kopi Kenangan">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat <span class="text-red-500">*</span></label>
                    <input type="text" name="address" value="{{ old('address') }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-coffee-500 focus:ring-2 focus:ring-coffee-200 outline-none text-sm transition-all" placeholder="Alamat lengkap cafe">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kemantren</label>
                    <input type="text" name="kemantren" value="{{ old('kemantren') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-coffee-500 focus:ring-2 focus:ring-coffee-200 outline-none text-sm transition-all" placeholder="Contoh: Jetis, Kraton">
                    @error('kemantren')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konsep Utama</label>
                    <input type="text" name="konsep_utama" value="{{ old('konsep_utama') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-coffee-500 focus:ring-2 focus:ring-coffee-200 outline-none text-sm transition-all" placeholder="Contoh: Dominan Indoor, Semi-Outdoor">
                    @error('konsep_utama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-coffee-500 focus:ring-2 focus:ring-coffee-200 outline-none text-sm transition-all resize-none" placeholder="Ceritakan tentang cafe ini...">{{ old('description') }}</textarea>
            </div>
            
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Google Maps URL</label>
                <input type="url" name="gmaps_url" value="{{ old('gmaps_url') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-coffee-500 focus:ring-2 focus:ring-coffee-200 outline-none text-sm transition-all" placeholder="https://maps.google.com/...">
            </div>
        </div>

        <div>
            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Operasional & Detail</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jam Buka <span class="text-red-500">*</span></label>
                    <input type="time" name="open_time" value="{{ old('open_time', '08:00') }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-coffee-500 focus:ring-2 focus:ring-coffee-200 outline-none text-sm transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jam Tutup <span class="text-red-500">*</span></label>
                    <input type="time" name="close_time" value="{{ old('close_time', '22:00') }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-coffee-500 focus:ring-2 focus:ring-coffee-200 outline-none text-sm transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga Rata² <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                        <input type="number" name="avg_price" value="{{ old('avg_price', 30000) }}" required class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-coffee-500 focus:ring-2 focus:ring-coffee-200 outline-none text-sm transition-all">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-yellow-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </span>
                        <input type="number" name="rating" value="{{ old('rating', 4.0) }}" step="0.1" min="0" max="5" required class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-coffee-500 focus:ring-2 focus:ring-coffee-200 outline-none text-sm transition-all">
                    </div>
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Fasilitas & Foto</h3>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">Pilih Fasilitas</label>
                <div class="flex flex-wrap gap-3">
                    @foreach($fasilitas as $f)
                    <label class="cursor-pointer">
                        <input type="checkbox" name="fasilitas[]" value="{{ $f->id }}" class="hidden peer" {{ in_array($f->id, old('fasilitas', [])) ? 'checked' : '' }}>
                        <span class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-medium text-gray-600 peer-checked:bg-coffee-50 peer-checked:text-coffee-800 peer-checked:border-coffee-300 hover:bg-gray-50 transition-all">
                            <span class="w-4 h-4 text-gray-500 peer-checked:text-coffee-600 flex items-center justify-center">
                                <x-facility-icon :name="$f->slug ?? strtolower($f->name)" />
                            </span>
                            {{ $f->name }}
                        </span>
                    </label>
                    @endforeach
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Utama Cafe</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-2xl hover:border-coffee-500 transition-colors bg-gray-50 relative group">
                    <div class="space-y-2 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-coffee-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="foto" class="relative cursor-pointer rounded-md font-medium text-coffee-600 hover:text-coffee-500 focus-within:outline-none">
                                <span>Upload foto</span>
                                <input id="foto" name="foto" type="file" accept="image/*" class="sr-only">
                            </label>
                            <p class="pl-1">atau drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" id="is_active" checked class="w-5 h-5 rounded border-gray-300 text-coffee-600 focus:ring-coffee-500 cursor-pointer">
                <label for="is_active" class="text-sm font-medium text-gray-700 cursor-pointer select-none">Tampilkan di Publik (Cafe Aktif)</label>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('admin.cafe.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors text-sm border border-gray-200">Batal</a>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-coffee-700 text-white font-semibold rounded-xl hover:bg-coffee-800 transition-colors text-sm shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Cafe
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
