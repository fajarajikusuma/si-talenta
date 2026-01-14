<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function __construct()
    {
        $this->riwayatKerjaModel = new \App\Models\RiwayatKerjaModel();
    }

    public function index(): string
    {
        // Update Status Riwayat Kerja Otomatis
        $tanggalSimulasi = date('Y-m-d');
        // 🔧 SATU SUMBER TANGGAL
        $today = $tanggalSimulasi ?: date('Y-m-d');
        $lastRun = session()->get('update_riwayat_run');

        if ($lastRun !== $today) {

            $this->riwayatKerjaModel
                ->updateStatusTidakAktifJikaKontrakHabis($today);

            session()->set('update_riwayat_run', $today);
        }
        // End Update Status Riwayat Kerja Otomatis
        $data = [
            'title' => 'Dashboard',
        ];
        return view('admin/home', $data);
    }
}
