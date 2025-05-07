@foreach ($actions as $action)
    <button class="btn btn-{{ $action['color'] }}" wire:click="{{ $action['wire:click'] }}">
        @if (isset($action['icon']))
            <i class="fa-solid {{ $action['icon'] }}"></i>
        @endif
        {{ $action['title'] ?? '' }}
    </button>
@endforeach
