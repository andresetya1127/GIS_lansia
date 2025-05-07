@props([
    'height' => '300px',
    'width' => '100%',
    'lat' => '',
    'lng' => '',
])
<div id="map" style="height: {{ $height }}; width: {{ $width }};" class="mb-3"
    data-lat="{{ $lat }}" data-lng="{{ $lng }}"></div>
