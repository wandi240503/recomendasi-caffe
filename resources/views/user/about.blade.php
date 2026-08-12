@extends('layouts.guest')
@section('title', 'Tentang — CafeRekomendasi')

@section('content')
<section class="py-20 bg-cream min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-coffee-100/50 text-coffee-700 rounded-full text-sm font-semibold mb-4 border border-coffee-200">
                <x-facility-icon name="info" class="w-4 h-4" />
                Informasi Sistem
            </span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-coffee-900 mb-4 tracking-tight">Tentang CafeRekomendasi</h1>
            <p class="text-lg text-coffee-500 font-medium max-w-2xl mx-auto">
                Sistem rekomendasi cafe cerdas berbasis Content-Based Filtering
            </p>
        </div>

        <div class="space-y-8">
            <div class="bg-white rounded-3xl p-8 md:p-10 border border-coffee-100 shadow-sm hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-coffee-50 rounded-2xl flex items-center justify-center border border-coffee-100">
                        <x-facility-icon name="coffee" class="w-6 h-6 text-coffee-700" />
                    </div>
                    <h2 class="text-2xl font-bold text-coffee-900">Apa itu CafeRekomendasi?</h2>
                </div>
                <p class="text-coffee-600 leading-relaxed text-lg">
                    CafeRekomendasi adalah platform inovatif yang membantu Anda menemukan cafe ideal berdasarkan preferensi fasilitas dan konsep ruangan. Sistem kami menggunakan pendekatan <strong>Content-Based Filtering</strong> dengan algoritma <strong>Cosine Similarity</strong> canggih untuk menganalisis dan mencocokkan keinginan Anda dengan fasilitas yang tersedia di setiap cafe secara presisi.
                </p>
            </div>

            <div class="bg-white rounded-3xl p-8 md:p-10 border border-coffee-100 shadow-sm hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-12 h-12 bg-coffee-50 rounded-2xl flex items-center justify-center border border-coffee-100">
                        <x-facility-icon name="target" class="w-6 h-6 text-coffee-700" />
                    </div>
                    <h2 class="text-2xl font-bold text-coffee-900">Bagaimana Algoritma Bekerja?</h2>
                </div>
                <div class="space-y-6">
                    <div class="flex gap-6 items-start p-6 bg-cream rounded-2xl border border-coffee-50 hover:border-coffee-200 transition-colors">
                        <span class="w-12 h-12 bg-coffee-800 text-white rounded-xl flex items-center justify-center font-bold text-xl flex-shrink-0 shadow-md">1</span>
                        <div>
                            <strong class="text-coffee-900 text-lg block mb-1">User Memilih Preferensi</strong>
                            <p class="text-coffee-600 leading-relaxed">Pengguna memilih fasilitas yang diinginkan dengan bebas (misal: WiFi, AC, Rooftop, Live Music).</p>
                        </div>
                    </div>
                    <div class="flex gap-6 items-start p-6 bg-cream rounded-2xl border border-coffee-50 hover:border-coffee-200 transition-colors">
                        <span class="w-12 h-12 bg-coffee-800 text-white rounded-xl flex items-center justify-center font-bold text-xl flex-shrink-0 shadow-md">2</span>
                        <div>
                            <strong class="text-coffee-900 text-lg block mb-1">Pembentukan Vector</strong>
                            <p class="text-coffee-600 leading-relaxed">Sistem membentuk binary vector representatif untuk user dan setiap cafe yang terdaftar. <br/><span class="inline-block mt-2 font-mono text-sm bg-white px-3 py-1 rounded-md text-coffee-500 border border-coffee-100">Contoh: [1, 0, 1, 1, 0, 1, 0]</span></p>
                        </div>
                    </div>
                    <div class="flex gap-6 items-start p-6 bg-cream rounded-2xl border border-coffee-50 hover:border-coffee-200 transition-colors">
                        <span class="w-12 h-12 bg-coffee-800 text-white rounded-xl flex items-center justify-center font-bold text-xl flex-shrink-0 shadow-md">3</span>
                        <div>
                            <strong class="text-coffee-900 text-lg block mb-1">Perhitungan Cosine Similarity</strong>
                            <p class="text-coffee-600 leading-relaxed">Sistem memproses perhitungan matematis untuk mengukur tingkat kemiripan: <br/><span class="inline-block mt-2 font-mono text-sm font-semibold bg-white px-3 py-1 rounded-md text-coffee-700 border border-coffee-100">cos(θ) = (A · B) / (||A|| × ||B||)</span></p>
                        </div>
                    </div>
                    <div class="flex gap-6 items-start p-6 bg-cream rounded-2xl border border-coffee-50 hover:border-coffee-200 transition-colors">
                        <span class="w-12 h-12 bg-coffee-800 text-white rounded-xl flex items-center justify-center font-bold text-xl flex-shrink-0 shadow-md">4</span>
                        <div>
                            <strong class="text-coffee-900 text-lg block mb-1">Pemeringkatan (Ranking)</strong>
                            <p class="text-coffee-600 leading-relaxed">Cafe diurutkan secara cerdas dari similarity score tertinggi hingga terendah untuk ditampilkan kepada Anda.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-8 md:p-10 border border-coffee-100 shadow-sm hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-12 h-12 bg-coffee-50 rounded-2xl flex items-center justify-center border border-coffee-100">
                        <x-facility-icon name="sparkles" class="w-6 h-6 text-coffee-700" />
                    </div>
                    <h2 class="text-2xl font-bold text-coffee-900">Teknologi Modern</h2>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="text-center p-6 bg-cream rounded-2xl border border-coffee-50 hover:border-coffee-200 transition-colors hover:-translate-y-1">
                        <svg class="w-10 h-10 mx-auto mb-4 text-[#FF2D20]" viewBox="0 0 24 24" fill="currentColor"><path d="M22.046 7.426c-.11-.082-.249-.126-.394-.126H13.62L12.35 1.5a.64.64 0 0 0-.6-.445.64.64 0 0 0-.6.445L9.88 7.3H1.848c-.145 0-.284.044-.394.126a.666.666 0 0 0-.226.353.642.642 0 0 0 .092.428l4.896 6.84-2.585 8.16a.65.65 0 0 0 .237.666.632.632 0 0 0 .76 0l7.122-5.184 7.12 5.184a.633.633 0 0 0 .76 0 .65.65 0 0 0 .238-.666l-2.586-8.16 4.896-6.84a.642.642 0 0 0 .092-.428.666.666 0 0 0-.226-.353z"/></svg>
                        <p class="text-sm font-bold text-coffee-900">Laravel v11</p>
                    </div>
                    <div class="text-center p-6 bg-cream rounded-2xl border border-coffee-50 hover:border-coffee-200 transition-colors hover:-translate-y-1">
                        <svg class="w-10 h-10 mx-auto mb-4 text-[#06B6D4]" viewBox="0 0 24 24" fill="currentColor"><path d="M12.001,4.8c-3.2,0-5.2,1.6-6,4.8c1.2-1.6,2.6-2.2,4.2-1.8c0.913,0.228,1.565,0.89,2.288,1.624 C13.666,10.618,15.027,12,18.001,12c3.2,0,5.2-1.6,6-4.8c-1.2,1.6-2.6,2.2-4.2,1.8c-0.913-0.228-1.565-0.89-2.288-1.624 C16.337,6.182,14.976,4.8,12.001,4.8z M6.001,12c-3.2,0-5.2,1.6-6,4.8c1.2-1.6,2.6-2.2,4.2-1.8c0.913,0.228,1.565,0.89,2.288,1.624 c1.177,1.194,2.538,2.576,5.512,2.576c3.2,0,5.2-1.6,6-4.8c-1.2,1.6-2.6,2.2-4.2,1.8c-0.913-0.228-1.565-0.89-2.288-1.624 C10.337,13.382,8.976,12,6.001,12z"/></svg>
                        <p class="text-sm font-bold text-coffee-900">TailwindCSS v4</p>
                    </div>
                    <div class="text-center p-6 bg-cream rounded-2xl border border-coffee-50 hover:border-coffee-200 transition-colors hover:-translate-y-1">
                        <x-facility-icon name="list" class="w-10 h-10 mx-auto mb-4 text-blue-500" />
                        <p class="text-sm font-bold text-coffee-900">SQLite</p>
                    </div>
                    <div class="text-center p-6 bg-cream rounded-2xl border border-coffee-50 hover:border-coffee-200 transition-colors hover:-translate-y-1">
                        <x-facility-icon name="target" class="w-10 h-10 mx-auto mb-4 text-emerald-500" />
                        <p class="text-sm font-bold text-coffee-900">Cosine Alg.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-8 md:p-10 border border-coffee-100 shadow-sm hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-12 h-12 bg-coffee-50 rounded-2xl flex items-center justify-center border border-coffee-100">
                        <svg class="w-6 h-6 text-coffee-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-coffee-900">Pengembang</h2>
                </div>
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 p-6 bg-cream rounded-2xl border border-coffee-50">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-coffee-700 to-coffee-900 flex items-center justify-center shadow-lg flex-shrink-0">
                        <svg class="w-10 h-10 text-coffee-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="text-center sm:text-left mt-2">
                        <p class="font-extrabold text-2xl text-coffee-900 mb-1">MUHAMMAD NISWANDI</p>
                        <p class="text-coffee-600 font-medium">Fullstack Developer &mdash; Tugas Akhir</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
