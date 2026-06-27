@extends('layouts.admin')
@section('title', 'Edit Cafe')
@section('page-title', 'Edit Cafe')
@section('page-subtitle', $cafe->name)

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('admin.cafe.update', $cafe) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl border border-gray-100 p-6 space-y-6">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Cafe *</label>
                <input type="text" name="name" value="{{ old('name', $cafe->name) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-coffee-500 focus:ring-2 focus:ring-coffee-200 outline-none text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat *</label>
                <input type="text" name="address" value="{{ old('address', $cafe->address) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-coffee-500 focus:ring-2 focus:ring-coffee-200 outline-none text-sm">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kemantren</label>
                <input type="text" name="kemantren" value="{{ old('kemantren', $cafe->kemantren) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-coffee-500 focus:ring-2 focus:ring-coffee-200 outline-none text-sm" placeholder="Contoh: Jetis, Kraton">
                @error('kemantren')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Konsep Utama</label>
                <input type="text" name="konsep_utama" value="{{ old('konsep_utama', $cafe->konsep_utama) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-coffee-500 focus:ring-2 focus:ring-coffee-200 outline-none text-sm" placeholder="Contoh: Dominan Indoor, Semi-Outdoor">
                @error('konsep_utama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
            <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-coffee-500 focus:ring-2 focus:ring-coffee-200 outline-none text-sm">{{ old('description', $cafe->description) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Google Maps URL</label>
            <input type="url" name="gmaps_url" value="{{ old('gmaps_url', $cafe->gmaps_url) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-coffee-500 focus:ring-2 focus:ring-coffee-200 outline-none text-sm">
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div><label class="block text-sm font-medium text-gray-700 mb-2">Jam Buka</label><input type="text" name="open_time" value="{{ old('open_time', $cafe->open_time) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-coffee-500 focus:ring-2 focus:ring-coffee-200 outline-none text-sm"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-2">Jam Tutup</label><input type="text" name="close_time" value="{{ old('close_time', $cafe->close_time) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-coffee-500 focus:ring-2 focus:ring-coffee-200 outline-none text-sm"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-2">Harga Rata²</label><input type="number" name="avg_price" value="{{ old('avg_price', $cafe->avg_price) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-coffee-500 focus:ring-2 focus:ring-coffee-200 outline-none text-sm"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-2">Rating</label><input type="number" name="rating" value="{{ old('rating', $cafe->rating) }}" step="0.1" min="0" max="5" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-coffee-500 focus:ring-2 focus:ring-coffee-200 outline-none text-sm"></div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Fasilitas</label>
            <div class="flex flex-wrap gap-2">
                @foreach($fasilitas as $f)
                <label class="cursor-pointer"><input type="checkbox" name="fasilitas[]" value="{{ $f->id }}" class="hidden peer" {{ $cafe->fasilitas->contains($f->id) ? 'checked' : '' }}>
                    <span class="inline-flex items-center gap-1 px-3 py-2 rounded-xl border border-gray-200 text-sm peer-checked:bg-coffee-700 peer-checked:text-white peer-checked:border-coffee-700 hover:border-coffee-400 transition-all">{{ $f->icon }} {{ $f->name }}</span>
                </label>
                @endforeach
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Cafe</label>
            @php $currentPhoto = $cafe->fotos->where('is_primary', true)->first() ?? $cafe->fotos->first(); @endphp
            @if($currentPhoto)
            <div class="mb-3 relative inline-block">
                <img src="{{ asset($currentPhoto->url) }}" alt="{{ $cafe->name }}" class="w-48 h-32 object-cover rounded-xl border border-gray-200" onerror="this.style.display='none'">
                <p class="text-xs text-gray-400 mt-1">Foto saat ini</p>
            </div>
            @endif
            <input type="file" name="foto" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-coffee-100 file:text-coffee-700 file:font-medium">
            <p class="text-xs text-gray-400 mt-1">Upload foto baru untuk mengganti foto lama</p>
        </div>
        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" id="is_active" {{ $cafe->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-coffee-600">
            <label for="is_active" class="text-sm text-gray-700">Cafe Aktif</label>
        </div>
        <div class="flex gap-4">
            <button type="submit" class="px-6 py-3 bg-coffee-700 text-white font-semibold rounded-xl hover:bg-coffee-600 transition-colors text-sm">💾 Update Cafe</button>
            <a href="{{ route('admin.cafe.index') }}" class="px-6 py-3 bg-gray-100 text-gray-600 font-semibold rounded-xl hover:bg-gray-200 transition-colors text-sm">Batal</a>
        </div>
    </form>

    {{-- Galeri Foto Tambahan --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-6 space-y-6 mt-8">
        <div>
            <h3 class="text-lg font-bold text-coffee-800">📸 Galeri Foto Tambahan</h3>
            <p class="text-xs text-gray-400 mt-1">Tambahkan foto-foto suasana, interior, eksterior, atau menu cafe.</p>
        </div>

        <form action="{{ route('admin.cafe.gallery.store', $cafe) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                <div class="flex-1 w-full">
                    <input type="file" name="gallery_fotos[]" multiple accept="image/*" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-coffee-100 file:text-coffee-700 file:font-medium hover:file:bg-coffee-200">
                </div>
                <button type="submit" class="px-5 py-2.5 bg-coffee-700 text-white font-semibold rounded-xl hover:bg-coffee-600 transition-colors text-sm whitespace-nowrap">📤 Unggah Foto</button>
            </div>
        </form>

        <div class="border-t border-gray-100 pt-6">
            <h4 class="text-sm font-semibold text-coffee-800 mb-4">Foto Saat Ini ({{ $cafe->fotos->count() }})</h4>
            
            @if($cafe->fotos->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach($cafe->fotos as $foto)
                <div class="relative group rounded-xl overflow-hidden border border-gray-200 h-32">
                    <img src="{{ $foto->url }}" alt="Foto Cafe" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                        @if($foto->is_primary)
                        <span class="absolute top-2 left-2 bg-emerald-500 text-white text-[10px] px-2 py-0.5 rounded-md font-medium">Utama</span>
                        @endif
                        <form action="{{ route('admin.cafe.foto.destroy', $foto) }}" method="POST" onsubmit="return confirm('Hapus foto ini dari galeri?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-semibold transition-colors">
                                🗑️ Hapus
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-sm text-gray-400">Belum ada foto galeri.</p>
            @endif
        </div>
    </div>
</div>
@endsection
