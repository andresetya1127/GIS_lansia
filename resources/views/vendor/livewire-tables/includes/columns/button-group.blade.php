{{-- <div {!! count($attributes) ? $column->arrayToAttributes($attributes) : '' !!}>
    @foreach ($buttons as $button)
        {!! $button->getContents($row) !!}
    @endforeach
</div> --}}
<div class="btn-group" {!! count($attributes) ? $column->arrayToAttributes($attributes) : '' !!}>
    <button type="button" class="btn btn-outline-info btn-sm dropdown-toggle" data-coreui-toggle="dropdown"
        aria-expanded="false">
        <i class="fas fa-ellipsis-v"></i>
    </button>
    <ul class="dropdown-menu">
        @foreach ($buttons as $button)
            <li> {!! $button->getContents($row) !!}</li>
        @endforeach
    </ul>
</div>
