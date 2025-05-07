<div class="">
    <form action="{{ route('lansia.store') }}" method="POST" data-ajax="submit-location">
        @csrf
        <input type="hidden" name="target" value="save">

        <div class="row row-cols-sm-1 row-cols-lg-2">
            <x-forms.input name="nama" label="Nama" />
            <x-forms.input name="nik" label="NIK" />
            <x-forms.input name="tgl_lahir" label="Tanggal Lahir" type="date" />
            <x-forms.input name="umur" label="Umur" />
            <x-forms.input name="lat" readonly label="Latitude" :value="$location['lat'] ?? ''" />
            <x-forms.input name="lng" readonly label="Longitude" :value="$location['lon'] ?? ''" />
            <x-forms.input name="provinsi" readonly label="Provinsi" :value="$location['address']['state'] ?? ''" />
            <x-forms.input name="kabupaten" readonly label="Kota/Kabupaten" :value="$location['address']['county'] ?? ''" />
            <x-forms.input name="kecamatan" label="Kecamatan" :value="$location['address']['municipality'] ?? ($location['address']['town'] ?? '')" />
            <x-forms.input name="desa" label="Desa/Kelurahan" :value="$location['address']['village'] ?? ''" />
            <x-forms.input name="rt" label="RT" type="number" highlight="Jika tidak ada silahkan isi 00" />
            <x-forms.input name="rw" label="RW" type="number" highlight="Jika tidak ada silahkan isi 00" />
        </div>
        <x-forms.textarea name="alamat" label="Alamat" :value="$location['display_name'] ?? ''" />
        <div class="d-flex justify-content-end mb-4">
            <x-actions.button type="submit" :title="'Simpan'" :icon="'fa-paper-plane'" />
        </div>
    </form>
</div>
