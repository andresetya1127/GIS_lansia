@extends('layout.panel.app')
@section('content')
    {{-- <div class="mb-3">
        <select name="location" class="form-control" placeholder="Pilih data.." id="markerSearch" autocomplete="off">
        </select>
    </div> --}}
    <div class="row mb-4">
        @foreach ($stats as $s)
            <div class="col-12 col-sm-6 col-xl-4 col-xxl-4">
                <div class="card">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="{{ $s['color'] }} text-white p-3 me-3">
                            <svg class="icon icon-xl">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-laptop"></use>
                            </svg>
                        </div>
                        <div>
                            <div class="text-body-secondary text-uppercase fw-semibold small">{{ $s['count'] }}</div>
                            <div class="fs-6 fw-semibold text-info">{{ $s['title'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <x-base.card>
        <x-base.map />
    </x-base.card>
@endsection
@section('scripts')
    @vite(['resources/js/dashboard.js'])
@endsection
