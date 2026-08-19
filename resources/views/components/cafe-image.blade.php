{{-- 
    Cafe Image Component
    Usage: @include('components.cafe-image', ['cafe' => $cafe, 'height' => 'h-48', 'rounded' => 'rounded-2xl'])
--}}
@php
    $photo = $cafe->fotos->where('is_primary', true)->first() ?? $cafe->fotos->first();
    $height = $height ?? 'h-48';
    $rounded = $rounded ?? '';
    
    $url = null;
    if ($photo && !empty($photo->url)) {
        if (str_starts_with($photo->url, 'http://') || str_starts_with($photo->url, 'https://')) {
            $url = $photo->url;
        } else {
            $url = asset(ltrim($photo->url, '/'));
        }
    }
@endphp

@if($url)
    <img src="{{ $url }}" 
         alt="{{ $cafe->name }}" 
         class="w-full {{ $height }} object-cover {{ $rounded }}"
         onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full {{ $height }} bg-gradient-to-br from-coffee-800 to-coffee-600 flex items-center justify-center {{ $rounded }} border border-coffee-700/50 shadow-inner\'><svg class=\'w-16 h-16 text-coffee-400 opacity-60\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'currentColor\' stroke-width=\'1.5\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25\' /></svg></div>';">
@else
    <div class="w-full {{ $height }} bg-gradient-to-br from-coffee-800 to-coffee-600 flex items-center justify-center {{ $rounded }} border border-coffee-700/50 shadow-inner">
        <svg class="w-16 h-16 text-coffee-400 opacity-60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
        </svg>
    </div>
@endif
