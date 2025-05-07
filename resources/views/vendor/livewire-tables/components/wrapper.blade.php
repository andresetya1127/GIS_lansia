@props(['component', 'tableName', 'primaryKey', 'isTailwind', 'isBootstrap', 'isBootstrap4', 'isBootstrap5'])
<div wire:key="{{ $tableName }}-wrapper">
    <div {{ $attributes->merge($this->getComponentWrapperAttributes()) }}
        @if ($this->hasRefresh()) wire:poll{{ $this->getRefreshOptions() }} @endif
        @if ($this->isFilterLayoutSlideDown()) wire:ignore.self @endif>

        <div>
            @if (method_exists($this, 'topFilterIsEnabled'))
                <div class="row g-4 align-items-center justify-content-center">
                    <div class="col-sm-12 col-xl-4 mb-4 bg-white px-2 py-2 rounded shadow-lg w-auto">
                        <x-actions.button-group>
                            @foreach ($this->topFilterIsEnabled()[0]->getOptions() as $key => $value)
                                <input type="radio" class="btn-check" id="{{ $value }}" autocomplete="off"
                                    name="{{ $value }}" value="{{ $value }}" {!! $this->topFilterIsEnabled()[0]->getWireMethod(
                                        'filterComponents.' . $this->topFilterIsEnabled()[0]->getKey(),
                                    ) !!}>
                                <label class="btn btn-outline-info" for="{{ $value }}">{{ $value }}</label>
                            @endforeach
                        </x-actions.button-group>
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    @if ($this->debugIsEnabled())
                        @include('livewire-tables::includes.debug')
                    @endif
                    @if ($this->offlineIndicatorIsEnabled())
                        @include('livewire-tables::includes.offline')
                    @endif
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>
