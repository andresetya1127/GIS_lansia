<div class="">
    <!-- Tgl Lahir -->
    <h5 class="fw-semibold">Status</h5>
    <p>
        <span
            class="text-capitalize badge bg-{{ $data->status == 'success' ? 'success' : ($data->status == 'pending' ? 'info' : ($data->status == 'die' ? 'warning' : 'danger')) }}">
            {{ $data->status == 'success' ? 'Dikonfirmasi' : ($data->status == 'pending' ? 'Proses' : ($data->status == 'die' ? 'Meninggal' : 'Ditolak')) }}
        </span>
    </p>

    @if ($data->status == 'reject')
        <h5 class="fw-semibold">Catatan</h5>
        <p>{{ $data->note }}</p>
    @endif

    <hr>

    <h5 class="fw-semibold m-0">Ubah Status</h5>
    <x-forms.select name="status" placeholder="Pilih Status" wire:model="status" select-type="normal">
        <option value="" selected>Pilih Status</option>
        <option value="success">Konfirmasi</option>
        <option value="reject">Tolak</option>
        <option value="die">Meninggal</option>
    </x-forms.select>

    <button class="btn btn-primary float-end" wire:click="updateStatus">
        Simpan
    </button>
</div>
