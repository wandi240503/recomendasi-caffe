{{-- 
    Cafe Image Component
    Usage: @include('components.cafe-image', ['cafe' => $cafe, 'height' => 'h-48', 'rounded' => 'rounded-2xl'])
--}}
@php
    $photo = $cafe->fotos->where('is_primary', true)->first() ?? $cafe->fotos->first();
    $height = $height ?? 'h-48';
    $rounded = $rounded ?? '';
@endphp

@if($photo && file_exists(public_path(ltrim($photo->url, '/'))))
    <img src="{{ asset($photo->url) }}" 
         alt="{{ $cafe->name }}" 
         class="w-full {{ $height }} object-cover {{ $rounded }}">
@elseif($photo && str_starts_with($photo->url, '/storage/'))
    <img src="{{ asset($photo->url) }}" 
         alt="{{ $cafe->name }}" 
         class="w-full {{ $height }} object-cover {{ $rounded }}">
@else
    <div class="w-full {{ $height }} bg-gradient-to-br from-coffee-200 to-coffee-300 flex items-center justify-center {{ $rounded }}">
        <span class="text-6xl opacity-30">☕</span>
    </div>
@endif
