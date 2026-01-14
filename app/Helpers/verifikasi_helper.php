<?php

// use App\Models\RiwayatPekerjaanModel;

// if (!function_exists('badge_verifikasi')) {
//     function badge_verifikasi($status)
//     {
//         $model = new RiwayatPekerjaanModel();

//         $jumlah = $model
//             ->where('status', $status)
//             ->countAllResults();

//         if ($jumlah <= 0) {
//             return '';
//         }

//         // Warna otomatis
//         if ($jumlah <= 3) {
//             $warna = 'bg-warning text-dark';
//         } else {
//             $warna = 'bg-danger';
//         }

//         return '<span class="badge ' . $warna . ' ms-2">' . $jumlah . '</span>';
//     }
// }



use App\Models\RiwayatKerjaModel;

if (!function_exists('jumlah_penugasan_pending')) {
    function jumlah_penugasan_pending()
    {
        $model = new RiwayatKerjaModel();

        return $model->where('status', 'Menunggu')->countAllResults();
    }
}

if (!function_exists('badge_penugasan')) {
    function badge_penugasan()
    {
        $jumlah = jumlah_penugasan_pending();

        if ($jumlah <= 0) {
            return '';
        }

        $warna = ($jumlah <= 3)
            ? 'bg-warning text-dark'
            : 'bg-danger';

        return '<span class="badge rounded-circle ' . $warna . ' ms-2 d-inline-flex align-items-center justify-content-center"
        style="width:18px;height:18px;font-size:11px;line-height:1;">' . $jumlah . '</span>';
    }
}
