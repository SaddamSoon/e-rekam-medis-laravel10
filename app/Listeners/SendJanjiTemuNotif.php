<?php

namespace App\Listeners;

use App\Events\JanjiTemuCreated;
use App\Models\JanjiTemu;
use App\Models\User;
use App\Notifications\JanjiTemuBaru;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendJanjiTemuNotif
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    
    public function handle(JanjiTemuCreated $event): void
    {
        $admin = User::where('roles', 'Admin')->first();
        $dokterTujuan = User::where('id_dokter', $event->janjiTemu->id_dokter)->first();
        $this->updateOrCreateJanjiTemuNotif($admin);
        $this->updateOrCreateJanjiTemuNotif($dokterTujuan);
        
    }

    public function updateOrCreateJanjiTemuNotif($user) {
        if (! $user) return;

        $notif = $user->notifications()
            ->where('type', JanjiTemuBaru::class)
            ->latest()
            ->first();

        if ($notif) {
            $count = $notif->data['count'] + 1;
            $notif->update([
                'data' => [
                    'count' => $count,
                    'message' => "Ada {$count} janji temu baru yang belum dilihat."
                ]
            ]);
        } else {
            $user->notify(new JanjiTemuBaru(1));
        }
    }

    
}
