@extends('layout.panel.app', ['title' => 'Data Lansia'])
@section('content')
<x-base.card>
    <div id="map" style="height: 400px;"></div>
</x-base.card>
<x-base.card>
    <form action="{{ route('lansia.store', $data->uuid) }}" method="POST" id="form-lansia">
        @csrf
        <div class="row row-cols-sm-1 row-cols-lg-2">
            <x-forms.input name="nama" label="Nama" :value="$data->nama" />
            <x-forms.input name="nik" label="NIK" :value="$data->nik" />
            <x-forms.input name="tgl_lahir" label="Tanggal Lahir" type="date" :value="$data->tgl_lahir" />
            <x-forms.input name="umur" label="Umur" :value="$data->umur" />
            <x-forms.input id="lat" name="lat" readonly label="Latitude" :value="$data->lat" />
            <x-forms.input id="lng" name="lng" readonly label="Longitude" :value="$data->lng" />
            <x-forms.input name="provinsi" readonly label="Provinsi" :value="$data->provinsi" />
            <x-forms.input name="kabupaten" readonly label="Kota/Kabupaten" :value="$data->kabupaten" />
            <x-forms.input name="kecamatan" label="Kecamatan" :value="$data->kecamatan" />
            <x-forms.input name="desa" label="Desa/Kelurahan" :value="$data->desa" />
            <x-forms.input name="rt" label="RT" type="number" :value="$data->rt" highlight="Jika tidak ada silahkan isi 00" />
            <x-forms.input name="rw" label="RW" type="number" :value="$data->rw" highlight="Jika tidak ada silahkan isi 00" />
        </div>

        <x-forms.textarea name="alamat" label="Alamat" :value="$data->alamat" />
        <div class="d-flex justify-content-end gap-3 mb-4">
            <x-actions.button color="success" id="check-location"  :title="'Cek Lokasi'" :icon="'fa-location'" />
            <x-actions.button type="submit" :title="'Simpan'" :icon="'fa-paper-plane'" />
        </div>
    </form>
</x-base.card>

@endsection
@section('scripts')
    @vite(['resources/js/map-add.js', 'resources/js/form-location.js'])
@endsection
