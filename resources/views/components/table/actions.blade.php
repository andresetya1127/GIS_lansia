@foreach ($actions as $action)
    @if ($action['active'])
        <button class="btn btn-{{ $action['color'] }}" wire:click="{{ $action['wire:click'] }}">
            @if (isset($action['icon']))
                <i class="fa-solid {{ $action['icon'] }}"></i>
            @endif
            {{ $action['title'] ?? '' }}
        </button>
    @endif
@endforeach
