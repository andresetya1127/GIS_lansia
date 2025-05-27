@extends('layout.panel.app', ['title' => 'Detail Lansia'])
@section('content')
    <div class="row align-items-center">
        <div class="col-xl-6 col-sm-12">
            <h1 class="text-capitalize fs-3">{{ $data->nama }}</h1>
            <span class="text-muted">{{ $data->alamat }}</span>
        </div>
        <div class="col-xl-6 col-sm-12  ">
            <div class="d-flex float-end gap-2">
                <a href="{{ route('lansia.edit', $data->uuid) }}" class="btn btn-primary">
                    <i class="fa-solid fa-pen-to-square"></i> Edit
                </a>
                <button class="btn btn-danger text-white">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        </div>
    </div>


    <div class="mt-5 row">
        <div class="col-xl-4 col-md-4 col-sm-12 mb-3">
            <x-base.card>
              @if ($data->foto)
                    <div class="d-flex justify-content-center mb-4">
                    <img src="{{ asset($data->foto) }}" alt="profile" class="img-fluid rounded-circle" width="105">
                </div>
              @endif

                <div class="d-flex flex-column">

                    <!-- Tgl Lahir -->
                    <h5 class="fw-semibold">Tgl Lahir</h5>
                    <p>{{ $data->tgl_lahir }}</p>

                    <!-- Umur -->
                    <h5 class="fw-semibold">Umur</h5>
                    <p>{{ $data->umur }}</p>

                    <!-- Provinsi -->
                    <h5 class="fw-semibold">Provinsi</h5>
                    <p>{{ $data->provinsi }}</p>

                    <!-- Kota -->
                    <h5 class="fw-semibold">Kabupaten</h5>
                    <p>{{ $data->kabupaten }}</p>

                    <!-- Kecamatan -->
                    <h5 class="fw-semibold">Kecamatan</h5>
                    <p>{{ $data->kecamatan }}</p>

                    <!-- Kelurahan -->
                    <h5 class="fw-semibold">Desa/Kelurahan</h5>
                    <p>{{ $data->desa }}</p>

                    <!-- Tgl pengajuan -->
                    <h5 class="fw-semibold">Petugas</h5>
                    <p class="text-capitalize"><i class="fa-solid fa-user"></i> {{ $data->pendata->name }}</p>

                    <!-- Tgl pengajuan -->
                    <h5 class="fw-semibold">Tanggal Pendataan</h5>
                    <p><i class="fa-solid fa-calendar"></i> {{ $data->created_at->format('d M Y') }}</p>

                    <livewire:status-lansia :id="$data->uuid" />

                </div>
            </x-base.card>
        </div>
        <div class="col-xl-8 col-md-8 col-sm-12 mb-3">
            <x-base.card>
                <x-base.map height="100%" :lat="$data->lat" :lng="$data->lng"></x-base.map>
            </x-base.card>
        </div>
    </div>
@endsection
@section('scripts')
    @vite(['resources/js/map-detail.js'])
@endsection
