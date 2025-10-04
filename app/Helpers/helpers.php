<?php

use Carbon\Carbon;

if (!function_exists('disabled')) {
    function disabled($ketdok)
    {
        $now = Carbon::now('Asia/Jakarta');

        $jamMulai = Carbon::createFromTimeString($ketdok->jam_mulai)->copy()->subHour(); 
        $jamSelesai = Carbon::createFromTimeString($ketdok->jam_selesai)->copy()->subHours(2);

        $disabled1 = !$now->between(
            Carbon::createFromTimeString('07:30:00'),
            Carbon::createFromTimeString('17:00:00')
        );

        // $disabled2 = $now->between($jamMulai, $jamSelesai);

        // return $disabled1 || $disabled2;
        // return $disabled1;
        return;
    }
}


