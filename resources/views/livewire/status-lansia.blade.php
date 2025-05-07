<div class="">
    <!-- Tgl Lahir -->
    <h5 class="fw-semibold">Status</h5>
    <p>
        <span
            class="text-capitalize badge bg-{{ $data->status == 'success' ? 'success' : ($data->status == 'pending' ? 'info' : 'danger') }}">
            {{ $data->status == 'success' ? 'Dikonfirmasi' : ($data->status == 'pending' ? 'Proses' : 'Ditolak') }}
        </span>
    </p>


    @if ($data->status == 'pending' && auth()->user()->hasRole('admin'))
        <h5 class="fw-semibold">Ubah Status</h5>
        <x-forms.select name="status" placeholder="Pilih Status" wire:model="status" select-type="normal">
            <option value="" selected>Pilih Status</option>
            <option value="success">Konfirmasi</option>
            <option value="reject">Tolak</option>
        </x-forms.select>
        <button class="btn btn-primary float-end" wire:click="updateStatus">
            Simpan
        </button>
    @endif
</div>
