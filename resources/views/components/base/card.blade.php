@props(['title' => null])

<div class="card card-margin h-100">
    @if ($title)
        <div class="card-header no-border">
            <h5 class="card-title text-capitalize">{{ $title }}</h5>
        </div>
    @endif
    <div {{ $attributes->merge(['class' => 'card-body']) }}>
        {{ $slot }}
    </div>
</div>
