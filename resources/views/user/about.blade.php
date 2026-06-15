@extends('layouts.guest')
@section('title', 'Tentang — CafeRekomendasi')

@section('content')
<section class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-coffee-800 mb-2">Tentang CafeRekomendasi</h1>
            <p class="text-coffee-400">Sistem rekomendasi cafe berbasis Content-Based Filtering</p>
        </div>

        <div class="space-y-8">
            <div class="bg-white rounded-2xl p-8 border border-coffee-100">
                <h2 class="text-xl font-bold text-coffee-800 mb-4">📋 Apa itu CafeRekomendasi?</h2>
                <p class="text-coffee-500 leading-relaxed">CafeRekomendasi adalah sistem rekomendasi cafe yang membantu pengguna menemukan cafe terbaik berdasarkan preferensi fasilitas dan konsep ruangan. Sistem ini menggunakan metode <strong>Content-Based Filtering</strong> dengan algoritma <strong>Cosine Similarity</strong> untuk menghitung kesesuaian antara preferensi pengguna dengan fasilitas yang dimiliki setiap cafe.</p>
            </div>

            <div class="bg-white rounded-2xl p-8 border border-coffee-100">
                <h2 class="text-xl font-bold text-coffee-800 mb-4">🤖 Bagaimana Algoritma Bekerja?</h2>
                <div class="space-y-4 text-sm text-coffee-500">
                    <div class="flex gap-4 items-start p-4 bg-coffee-50 rounded-xl">
                        <span class="w-8 h-8 bg-coffee-600 text-white rounded-lg flex items-center justify-center font-bold flex-shrink-0">1</span>
                        <div><strong class="text-coffee-700">User memilih preferensi</strong><br>Pengguna memilih fasilitas yang diinginkan (WiFi, AC, Rooftop, dll)</div>
                    </div>
                    <div class="flex gap-4 items-start p-4 bg-coffee-50 rounded-xl">
                        <span class="w-8 h-8 bg-coffee-600 text-white rounded-lg flex items-center justify-center font-bold flex-shrink-0">2</span>
                        <div><strong class="text-coffee-700">Pembentukan vector</strong><br>Sistem membentuk binary vector untuk user dan setiap cafe. Contoh: [1,0,1,1,0,1,0,0,0]</div>
                    </div>
                    <div class="flex gap-4 items-start p-4 bg-coffee-50 rounded-xl">
                        <span class="w-8 h-8 bg-coffee-600 text-white rounded-lg flex items-center justify-center font-bold flex-shrink-0">3</span>
                        <div><strong class="text-coffee-700">Cosine Similarity</strong><br>Menghitung kemiripan: cos(θ) = (A·B) / (|A| × |B|)</div>
                    </div>
                    <div class="flex gap-4 items-start p-4 bg-coffee-50 rounded-xl">
                        <span class="w-8 h-8 bg-coffee-600 text-white rounded-lg flex items-center justify-center font-bold flex-shrink-0">4</span>
                        <div><strong class="text-coffee-700">Ranking</strong><br>Cafe diurutkan dari similarity score tertinggi ke terendah</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-8 border border-coffee-100">
                <h2 class="text-xl font-bold text-coffee-800 mb-4">🛠️ Teknologi</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-coffee-50 rounded-xl"><span class="text-2xl block mb-2">🐘</span><p class="text-sm font-medium text-coffee-700">Laravel</p></div>
                    <div class="text-center p-4 bg-coffee-50 rounded-xl"><span class="text-2xl block mb-2">🎨</span><p class="text-sm font-medium text-coffee-700">TailwindCSS</p></div>
                    <div class="text-center p-4 bg-coffee-50 rounded-xl"><span class="text-2xl block mb-2">🗄️</span><p class="text-sm font-medium text-coffee-700">SQLite</p></div>
                    <div class="text-center p-4 bg-coffee-50 rounded-xl"><span class="text-2xl block mb-2">📐</span><p class="text-sm font-medium text-coffee-700">Cosine Similarity</p></div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-8 border border-coffee-100">
                <h2 class="text-xl font-bold text-coffee-800 mb-4">👨‍💻 Tim Developer</h2>
                <div class="flex items-center gap-4 p-4 bg-coffee-50 rounded-xl">
                    <div class="w-16 h-16 rounded-full bg-coffee-200 flex items-center justify-center text-2xl">👤</div>
                    <div>
                        <p class="font-bold text-coffee-800">MUHAMMAD NISWANDI</p>
                        <p class="text-sm text-coffee-400">Fullstack Developer — Tugas Akhir</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
