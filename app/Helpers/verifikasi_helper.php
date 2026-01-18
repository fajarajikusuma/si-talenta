<?php

use App\Models\RiwayatKerjaModel;

if (!function_exists('jumlah_penugasan_pending')) {
    function jumlah_penugasan_pending()
    {
        $model = new RiwayatKerjaModel();

        return $model
            ->join(
                'tb_data_pekerja',
                'tb_data_pekerja.id_pekerja = tb_riwayat_pekerjaan.id_pekerja'
            )
            ->where('tb_riwayat_pekerjaan.status', 'Menunggu')
            ->where('tb_data_pekerja.status_pekerja', 'Terverifikasi')
            ->countAllResults();
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
