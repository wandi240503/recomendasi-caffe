@extends('layouts.admin')
@section('title', 'Kelola Cafe')
@section('page-title', 'Kelola Cafe')
@section('page-subtitle', 'Manage semua data cafe')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-gray-500 text-sm">Total: {{ $cafes->total() }} cafe</p>
    <a href="{{ route('admin.cafe.create') }}" class="px-5 py-2.5 bg-coffee-700 text-white font-semibold rounded-xl hover:bg-coffee-600 transition-colors text-sm" id="btn-add-cafe">+ Tambah Cafe</a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="bg-gray-50 border-b border-gray-100">
                <th class="text-left py-3 px-4 text-gray-500 font-medium">Nama</th>
                <th class="text-left py-3 px-4 text-gray-500 font-medium">Alamat</th>
                <th class="text-left py-3 px-4 text-gray-500 font-medium">Rating</th>
                <th class="text-left py-3 px-4 text-gray-500 font-medium">Harga</th>
                <th class="text-left py-3 px-4 text-gray-500 font-medium">Status</th>
                <th class="text-left py-3 px-4 text-gray-500 font-medium">Aksi</th>
            </tr></thead>
            <tbody>
                @foreach($cafes as $cafe)
                <tr class="border-b border-gray-50 hover:bg-gray-50">
                    <td class="py-3 px-4 font-medium text-gray-900">{{ $cafe->name }}</td>
                    <td class="py-3 px-4 text-gray-500">{{ Str::limit($cafe->address, 30) }}</td>
                    <td class="py-3 px-4">⭐ {{ number_format($cafe->rating, 1) }}</td>
                    <td class="py-3 px-4">{{ $cafe->formatted_price }}</td>
                    <td class="py-3 px-4">
                        <span class="px-2 py-1 rounded-lg text-xs font-medium {{ $cafe->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $cafe->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.cafe.edit', $cafe) }}" class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-medium hover:bg-blue-100">Edit</a>
                            <form action="{{ route('admin.cafe.destroy', $cafe) }}" method="POST" onsubmit="return confirm('Hapus cafe ini?')">
                                @csrf @method('DELETE')
                                <button class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-xs font-medium hover:bg-red-100">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6">{{ $cafes->links() }}</div>
@endsection
