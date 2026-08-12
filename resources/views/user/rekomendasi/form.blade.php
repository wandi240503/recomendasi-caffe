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
            
            @error('fasilitas')
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm mb-6">{{ $message }}</div>
            @enderror

            @php
            $groupDefs = [
              'Indoor' => ['AC', 'WiFi', 'Colokan/Charger', 'Meja Kerja', 'Meeting Room', 'Sofa', 'Buka 24 Jam'],
              'Outdoor' => ['Semi-Outdoor', 'Garden/Taman', 'Spot Foto', 'Pet-Friendly', 'Live Music'],
            ];
            $standaloneDefs = ['Smoking Area', 'Rooftop'];
            
            $parentObjs = [];
            $groups = ['Indoor' => [], 'Outdoor' => []];
            $standalone = [];
            $general = [];
            
            foreach($fasilitas as $f) {
                if ($f->name === 'Indoor' || $f->name === 'Outdoor') {
                    $parentObjs[$f->name] = $f;
                }
                
                if (in_array($f->name, $groupDefs['Indoor'])) $groups['Indoor'][] = $f;
                elseif (in_array($f->name, $groupDefs['Outdoor'])) $groups['Outdoor'][] = $f;
                elseif (in_array($f->name, $standaloneDefs)) $standalone[] = $f;
                elseif ($f->name !== 'Indoor' && $f->name !== 'Outdoor') $general[] = $f;
            }
            @endphp

            <div class="space-y-6">
                {{-- Group 1 & 2: Accordions (Indoor & Outdoor) --}}
                @foreach(['Indoor', 'Outdoor'] as $groupName)
                @php $parentF = $parentObjs[$groupName] ?? null; @endphp
                <div class="accordion-group border border-coffee-200 rounded-2xl overflow-hidden">
                    <div class="bg-coffee-50 p-4 flex items-center justify-between cursor-pointer accordion-header transition-colors hover:bg-coffee-100" onclick="toggleAccordion(this)">
                        <div class="flex items-center gap-3">
                            @if($parentF)
                            <input type="checkbox" name="fasilitas[]" value="{{ $parentF->id }}" class="parent-checkbox facility-checkbox w-5 h-5 text-green-600 rounded border-coffee-300 focus:ring-green-500 cursor-pointer" onclick="event.stopPropagation(); toggleParent(this, '{{ $groupName }}')" {{ in_array($parentF->id, old('fasilitas', [])) ? 'checked' : '' }}>
                            @else
                            <input type="checkbox" class="parent-checkbox w-5 h-5 text-green-600 rounded border-coffee-300 focus:ring-green-500 cursor-pointer" onclick="event.stopPropagation(); toggleParent(this, '{{ $groupName }}')">
                            @endif
                            <div class="flex items-center gap-2">
                                @if($parentF)
                                <x-facility-icon :name="$parentF->slug" class="w-5 h-5 text-coffee-700" />
                                @endif
                                <span class="font-bold text-coffee-800 text-base">{{ $groupName }}</span>
                            </div>
                        </div>
                        <div class="text-coffee-400 transition-transform duration-300 transform accordion-icon flex items-center gap-2">
                            <span class="text-xs text-coffee-400 font-normal">Klik untuk lihat detail</span>
                            <x-facility-icon name="chevron-down" class="w-5 h-5" />
                        </div>
                    </div>
                    <div class="accordion-content hidden bg-white p-4 border-t border-coffee-100">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3" data-group="{{ $groupName }}">
                            @foreach($groups[$groupName] as $f)
                            <label class="cursor-pointer block">
                                <input type="checkbox" name="fasilitas[]" value="{{ $f->id }}" class="hidden child-checkbox facility-checkbox" onchange="updateParent('{{ $groupName }}'); updateCount(); toggleCardStyle(this)" {{ in_array($f->id, old('fasilitas', [])) ? 'checked' : '' }}>
                                <div class="facility-card flex items-center gap-3 p-3 rounded-xl border border-coffee-100 hover:border-coffee-300 transition-all hover:shadow-sm">
                                    <div class="text-coffee-600">
                                        <x-facility-icon :name="$f->slug" class="w-6 h-6" />
                                    </div>
                                    <span class="font-medium text-coffee-800 text-sm flex-1">{{ $f->name }}</span>
                                    <div class="checkbox-indicator w-5 h-5 rounded border border-coffee-300 flex items-center justify-center transition-all">
                                        <x-facility-icon name="check" class="w-3.5 h-3.5 text-white hidden check-icon" />
                                    </div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach

                {{-- Group 3 & 4: Standalone --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($standalone as $f)
                    <label class="cursor-pointer block">
                        <input type="checkbox" name="fasilitas[]" value="{{ $f->id }}" class="hidden facility-checkbox" onchange="updateCount(); toggleCardStyle(this)" {{ in_array($f->id, old('fasilitas', [])) ? 'checked' : '' }}>
                        <div class="facility-card flex items-center gap-3 p-3 rounded-xl border border-coffee-100 hover:border-coffee-300 transition-all hover:shadow-sm">
                            <div class="text-coffee-600">
                                <x-facility-icon :name="$f->slug" class="w-6 h-6" />
                            </div>
                            <span class="font-medium text-coffee-800 text-sm flex-1">{{ $f->name }}</span>
                            <div class="checkbox-indicator w-5 h-5 rounded border border-coffee-300 flex items-center justify-center transition-all">
                                <x-facility-icon name="check" class="w-3.5 h-3.5 text-white hidden check-icon" />
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>

                {{-- Group 5: General Attributes --}}
                <div>
                    <h3 class="font-bold text-coffee-800 mb-3 mt-6">Atribut Umum</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($general as $f)
                        <label class="cursor-pointer block">
                            <input type="checkbox" name="fasilitas[]" value="{{ $f->id }}" class="hidden facility-checkbox" onchange="updateCount(); toggleCardStyle(this)" {{ in_array($f->id, old('fasilitas', [])) ? 'checked' : '' }}>
                            <div class="facility-card flex items-center gap-3 p-3 rounded-xl border border-coffee-100 hover:border-coffee-300 transition-all hover:shadow-sm">
                                <div class="text-coffee-600">
                                    <x-facility-icon :name="$f->slug" class="w-6 h-6" />
                                </div>
                                <span class="font-medium text-coffee-800 text-sm flex-1">{{ $f->name }}</span>
                                <div class="checkbox-indicator w-5 h-5 rounded border border-coffee-300 flex items-center justify-center transition-all">
                                    <x-facility-icon name="check" class="w-3.5 h-3.5 text-white hidden check-icon" />
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

{{-- Sticky Bottom Bar --}}
<div class="fixed bottom-0 left-0 right-0 z-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-4">
        <div class="bg-white/80 backdrop-blur-md border border-coffee-100 rounded-2xl shadow-2xl shadow-coffee-900/20 px-5 py-3 flex items-center gap-4">
            <p class="text-sm text-coffee-400 flex-1 font-medium" id="selected-count">0 fasilitas dipilih</p>
            <button
                type="submit"
                form="rekomendasi-form"
                class="py-3 px-8 bg-gradient-to-r from-coffee-700 to-coffee-600 text-white font-bold rounded-xl hover:from-coffee-600 hover:to-coffee-500 transition-all shadow-lg shadow-coffee-600/25 text-base whitespace-nowrap flex items-center gap-2"
            >
                <x-facility-icon name="sparkles" class="w-5 h-5" />
                Dapatkan Rekomendasi
            </button>
        </div>
    </div>
</div>

<div class="h-24"></div>
@endsection

@push('scripts')
<script>
function toggleAccordion(header) {
    const content = header.nextElementSibling;
    const icon = header.querySelector('.accordion-icon');
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        content.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}

function toggleParent(checkbox, groupName) {
    const isChecked = checkbox.checked;
    const container = document.querySelector(`[data-group="${groupName}"]`);
    if (container) {
        const children = container.querySelectorAll('.child-checkbox');
        children.forEach(child => {
            if (child.checked !== isChecked) {
                child.checked = isChecked;
                toggleCardStyle(child);
            }
        });
        updateCount();
    }
}

function updateParent(groupName) {
    const container = document.querySelector(`[data-group="${groupName}"]`);
    if (container) {
        const parentCheckbox = container.closest('.accordion-group').querySelector('.parent-checkbox');
        const children = container.querySelectorAll('.child-checkbox');
        const checkedCount = container.querySelectorAll('.child-checkbox:checked').length;
        
        if (checkedCount === 0) {
            parentCheckbox.checked = false;
            parentCheckbox.indeterminate = false;
        } else if (checkedCount === children.length) {
            parentCheckbox.checked = true;
            parentCheckbox.indeterminate = false;
        } else {
            parentCheckbox.checked = false;
            parentCheckbox.indeterminate = true;
        }
    }
}

function toggleCardStyle(checkbox) {
    const card = checkbox.closest('label').querySelector('.facility-card');
    const indicator = checkbox.closest('label').querySelector('.checkbox-indicator');
    const checkIcon = checkbox.closest('label').querySelector('.check-icon');
    const iconContainer = checkbox.closest('label').querySelector('.text-coffee-600, .text-green-600');
    
    if (checkbox.checked) {
        card.classList.remove('border-coffee-100');
        card.classList.add('border-green-400', 'bg-green-50', 'shadow-md');
        
        indicator.classList.remove('border-coffee-300');
        indicator.classList.add('bg-green-500', 'border-green-500');
        
        checkIcon.classList.remove('hidden');
        
        if (iconContainer) {
            iconContainer.classList.remove('text-coffee-600');
            iconContainer.classList.add('text-green-600');
        }
    } else {
        card.classList.add('border-coffee-100');
        card.classList.remove('border-green-400', 'bg-green-50', 'shadow-md');
        
        indicator.classList.add('border-coffee-300');
        indicator.classList.remove('bg-green-500', 'border-green-500');
        
        checkIcon.classList.add('hidden');
        
        if (iconContainer) {
            iconContainer.classList.add('text-coffee-600');
            iconContainer.classList.remove('text-green-600');
        }
    }
}

function updateCount() {
    const count = document.querySelectorAll('.facility-checkbox:checked').length;
    const el = document.getElementById('selected-count');
    if (count === 0) {
        el.textContent = 'Belum ada fasilitas dipilih';
        el.className = 'text-sm text-coffee-400 flex-1 font-medium';
    } else {
        el.textContent = `${count} fasilitas dipilih`;
        el.className = 'text-sm text-green-600 flex-1 font-bold';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.facility-checkbox').forEach(cb => {
        if (cb.checked) {
            toggleCardStyle(cb);
        }
    });
    
    ['Indoor', 'Outdoor'].forEach(group => {
        updateParent(group);
    });
    
    updateCount();
});
</script>
@endpush
