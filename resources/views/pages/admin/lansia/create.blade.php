@extends('layout.panel.app', ['title' => 'Data Lansia'])
@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('lansia.store') }}" method="POST" data-ajax="submit-location">
                @csrf
                <div class="d-flex justify-content-end mb-4">
                    <x-actions.button type="submit" :title="'Simpan'" :icon="'fa-save'" />
                </div>
                <x-base.card>
                    <div class="mb-3">
                        <input id="location-search" type="text" placeholder="Cari lokasi..." class="form-control">
                    </div>
                    <x-base.map />
                    
                </x-base.card>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-detail-location" data-coreui-backdrop="static" data-coreui-backdrop="static"
        data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Lokasi</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @vite(['resources/js/map-add.js', 'resources/js/form-location.js'])
@endsection
