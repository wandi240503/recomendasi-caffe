@extends('layouts.guest')
@section('title', 'Rekomendasi Cafe — CafeRekomendasi')

@section('content')
<section class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <span class="inline-block px-4 py-1.5 bg-coffee-100 text-coffee-600 rounded-full text-sm font-medium mb-4">Content-Based Filtering</span>
            <h1 class="text-3xl font-bold text-coffee-800 mb-2">Pilih Preferensi Anda</h1>
            <p class="text-coffee-400">Pilih fasilitas yang Anda inginkan, kami akan carikan cafe terbaik untuk Anda</p>
        </div>

        <form action="{{ route('rekomendasi.hasil') }}" method="POST" class="bg-white rounded-2xl p-8 shadow-sm border border-coffee-100" id="rekomendasi-form">
            @csrf
            <h2 class="font-bold text-coffee-800 mb-6 text-lg">Fasilitas yang diinginkan:</h2>

            @error('fasilitas')
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm mb-6">{{ $message }}</div>
            @enderror

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 mb-8">
                @foreach($fasilitas as $f)
                <label class="cursor-pointer block" id="fasilitas-{{ $f->id }}" onclick="toggleCard(this)">
                    <input type="checkbox" name="fasilitas[]" value="{{ $f->id }}" class="hidden fasilitas-checkbox" {{ in_array($f->id, old('fasilitas', [])) ? 'checked' : '' }}>
                    <div class="fasilitas-card flex items-center gap-3 p-4 rounded-xl border-2 border-coffee-100 hover:border-coffee-300 transition-all hover:shadow-md">
                        <span class="text-2xl">{{ $f->icon }}</span>
                        <div class="flex-1">
                            <p class="font-semibold text-coffee-800 text-sm">{{ $f->name }}</p>
                            <p class="fasilitas-hint text-xs text-coffee-400">Klik untuk memilih</p>
                        </div>
                        {{-- Unchecked circle --}}
                        <div class="fasilitas-unchecked w-6 h-6 rounded-full border-2 border-coffee-200 flex items-center justify-center transition-all">
                        </div>
                        {{-- Checked circle with checkmark --}}
                        <div class="fasilitas-checked w-6 h-6 rounded-full bg-green-500 border-2 border-green-500 items-center justify-center transition-all hidden">
                            <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </label>
                @endforeach
            </div>

        </form>
    </div>
</section>

{{-- Sticky Bottom Bar --}}
<div class="fixed bottom-0 left-0 right-0 z-50" id="sticky-btn-bar">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-4">
        <div class="bg-white/80 backdrop-blur-md border border-coffee-100 rounded-2xl shadow-2xl shadow-coffee-900/20 px-5 py-3 flex items-center gap-4">
            <p class="text-sm text-coffee-400 flex-1" id="selected-count">Belum ada fasilitas dipilih</p>
            <button
                type="submit"
                form="rekomendasi-form"
                id="submit-rekomendasi"
                class="py-3 px-8 bg-gradient-to-r from-coffee-700 to-coffee-600 text-white font-bold rounded-xl hover:from-coffee-600 hover:to-coffee-500 transition-all shadow-lg shadow-coffee-600/25 text-base whitespace-nowrap"
            >
                ✨ Dapatkan Rekomendasi
            </button>
        </div>
    </div>
</div>

{{-- Padding so last content isn't hidden behind sticky bar --}}
<div class="h-24"></div>
@endsection

@push('scripts')
<script>
function toggleCard(label) {
    // Delay to let the checkbox toggle first
    setTimeout(() => {
        const checkbox = label.querySelector('.fasilitas-checkbox');
        const card = label.querySelector('.fasilitas-card');
        const unchecked = label.querySelector('.fasilitas-unchecked');
        const checked = label.querySelector('.fasilitas-checked');
        const hint = label.querySelector('.fasilitas-hint');

        if (checkbox.checked) {
            card.classList.remove('border-coffee-100');
            card.classList.add('border-green-400', 'bg-green-50', 'shadow-md');
            unchecked.classList.add('hidden');
            checked.classList.remove('hidden');
            checked.classList.add('flex');
            hint.textContent = '✓ Dipilih';
            hint.classList.remove('text-coffee-400');
            hint.classList.add('text-green-600', 'font-medium');
        } else {
            card.classList.add('border-coffee-100');
            card.classList.remove('border-green-400', 'bg-green-50', 'shadow-md');
            unchecked.classList.remove('hidden');
            checked.classList.add('hidden');
            checked.classList.remove('flex');
            hint.textContent = 'Klik untuk memilih';
            hint.classList.add('text-coffee-400');
            hint.classList.remove('text-green-600', 'font-medium');
        }

        updateCount();
    }, 10);
}

function updateCount() {
    const checked = document.querySelectorAll('.fasilitas-checkbox:checked').length;
    const el = document.getElementById('selected-count');
    if (checked === 0) {
        el.textContent = 'Belum ada fasilitas dipilih';
    } else {
        el.textContent = checked + ' fasilitas dipilih';
        el.classList.add('text-green-600', 'font-medium');
    }
}

// Initialize on page load (for old() values)
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.fasilitas-checkbox:checked').forEach(cb => {
        toggleCard(cb.closest('label'));
    });
});
</script>
@endpush
