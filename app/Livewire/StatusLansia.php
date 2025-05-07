<?php

namespace App\Livewire;

use App\Models\Lansia;
use App\Notifications\LansiaNotif;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\On;
use Livewire\Component;

class StatusLansia extends Component
{
    public $id;
    public $status;


    public function mount($id)
    {
        $this->id = $id;
    }
    public function render()
    {
        $data = Lansia::find($this->id);
        return view('livewire.status-lansia', compact('data'));
    }

    public function updateStatus()
    {
        if ($this->status == 'success') {
            $data = Lansia::with('pendata')->find($this->id);
            $data->status = $this->status;
            $data->save();
            $notif = [
                'title' => 'Lansia berhasil dikonfirmasi',
                'name' => auth()->user()->name,
                'icon' => 'fa-solid fa-check',
                'message' => 'Data lansia berhasil dikonfirmasi oleh ' . auth()->user()->name,
                'url' => route('lansia.detail', $data->uuid),
            ];
            Notification::sendNow($data->pendata, new LansiaNotif($notif));
            $this->dispatch('miniNotif', ['message' => 'Status berhasil diubah!']);
        }

        if ($this->status == 'reject') {
            $this->dispatch('statusReject', ['message' => 'Masukkan alasan penolakan!']);
        }
    }

    #[On('rejectData')]
    public function rejectData($message)
    {
        $data = Lansia::find($this->id);
        $data->status = 'reject';
        $data->save();
        $notif = [
            'title' => 'Lansia gagal dikonfirmasi',
            'name' => auth()->user()->name,
            'icon' => 'fa-solid fa-check',
            'message' => $message,
            'url' => route('lansia.detail', $data->uuid),
        ];
        Notification::sendNow($data->pendata, new LansiaNotif($notif));
        $this->dispatch('miniNotif', ['message' => 'Pesan notifikasi berhasil dikirim!']);
    }
}