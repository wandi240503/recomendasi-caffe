@extends('layouts.admin')
@section('title', 'Kelola Cafe')
@section('page-title', 'Kelola Cafe')
@section('page-subtitle', 'Manage semua data cafe')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-gray-500 text-sm">Total: {{ $cafes->total() }} cafe</p>
    <a href="{{ route('admin.cafe.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-coffee-700 text-white font-semibold rounded-xl hover:bg-coffee-800 transition-colors text-sm shadow-sm" id="btn-add-cafe">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Cafe
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="bg-gray-50 border-b border-gray-100">
                <th class="text-left py-4 px-5 text-gray-500 font-medium">Nama</th>
                <th class="text-left py-4 px-5 text-gray-500 font-medium">Alamat</th>
                <th class="text-left py-4 px-5 text-gray-500 font-medium">Rating</th>
                <th class="text-left py-4 px-5 text-gray-500 font-medium">Harga</th>
                <th class="text-left py-4 px-5 text-gray-500 font-medium">Status</th>
                <th class="text-left py-4 px-5 text-gray-500 font-medium">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($cafes as $cafe)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-4 px-5 font-medium text-gray-900">{{ $cafe->name }}</td>
                    <td class="py-4 px-5 text-gray-500">{{ Str::limit($cafe->address, 30) }}</td>
                    <td class="py-4 px-5 flex items-center gap-1.5 text-gray-600 mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        {{ number_format($cafe->rating, 1) }}
                    </td>
                    <td class="py-4 px-5 text-gray-600">{{ $cafe->formatted_price }}</td>
                    <td class="py-4 px-5">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $cafe->is_active ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
                            {{ $cafe->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="py-4 px-5">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.cafe.edit', $cafe) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-50 text-gray-700 rounded-lg text-xs font-medium border border-gray-200 hover:bg-gray-100 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                                Edit
                            </a>
                            <form action="{{ route('admin.cafe.destroy', $cafe) }}" method="POST" onsubmit="return confirm('Hapus cafe ini?')">
                                @csrf @method('DELETE')
                                <button class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-xs font-medium border border-red-100 hover:bg-red-100 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                    Hapus
                                </button>
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
