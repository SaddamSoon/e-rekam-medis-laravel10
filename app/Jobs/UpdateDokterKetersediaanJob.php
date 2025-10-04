<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Dokter;
use App\Models\KetDok;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateDokterKetersediaanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $now = Carbon::now('Asia/Jakarta');
            KetDok::where('jam_selesai', '<=', $now->format('H:i:s'))->update([
                'status' => 'Tidak Tersedia'
            ]);
    }
}
