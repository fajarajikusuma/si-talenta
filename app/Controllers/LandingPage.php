<?php

namespace App\Controllers;

class LandingPage extends BaseController
{
    public function __construct()
    {
        $this->dataPekerjaModel = new \App\Models\DataPekerjaModel();
        $this->unitKerjaModel = new \App\Models\UnitKerjaModel();
        $this->riwayatKerjaModel = new \App\Models\RiwayatKerjaModel();
        
        // Load helper statistik
        helper('statistik');
    }

    public function index()
    {
        $data = [
            'title' => 'SI-Talenta - Sistem Informasi Talenta',
            'statistik' => getStatistikGlobal(),
            'statistikUmur' => getStatistikUmur(),
            'statistikJenisKelamin' => getStatistikJenisKelamin(),
            'statistikPendidikan' => getStatistikPendidikan(),
            'statistikPerBidang' => getStatistikPerBidang(),
        ];

        return view('landing/index', $data);
    }
}
