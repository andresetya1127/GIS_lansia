<?php

namespace App\Livewire;

use Livewire\Component;

class Notifications extends Component
{
    public function render()
    {
        $notifications = auth()->user()->notifications()->get();
        $notifLimit = auth()->user()->notifications()->latest()->take(5)->get();

        return view('livewire.notifications', compact('notifications', 'notifLimit'));
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
            $this->redirect($notification->data['url']);
        }
    }
}