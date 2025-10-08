<?php

namespace App\Helpers;

class WhatsAppHelper
{
    public static function formatNumber($number)
    {
        // hapus semua karakter non-angka
        $number = preg_replace('/[^0-9]/', '', $number);

        // kalau mulai dari 0 → ubah ke 62
        if (substr($number, 0, 1) === '0') {
            $number = '62' . substr($number, 1);
        }

        // kalau belum ada awalan 62, tambahkan
        if (substr($number, 0, 2) !== '62') {
            $number = '62' . $number;
        }

        return $number;
    }
}
