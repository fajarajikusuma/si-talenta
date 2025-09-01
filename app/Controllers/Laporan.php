<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Laporan extends BaseController
{
    public function __construct()
    {
        // Load models if needed
        $this->dataPekerjaModel = model('App\Models\DataPekerjaModel');
        $this->riwayatKerjaModel = model('App\Models\RiwayatKerjaModel');
        $this->unitKerjaModel = model('App\Models\UnitKerjaModel');
        $this->listPekerjaanModel = model('App\Models\ListPekerjaanModel');
        $this->daftarKepalaModel = model('App\Models\DaftarKepalaModel');
        $this->dasarHukumModel = model('App\Models\DasarHukumModel');
    }

    public function index()
    {
        $data = ['title' => 'Laporan'];
        return view('laporan/laporan', $data);
    }

    public function cetak_spt()
    {
        $jumlahPekerjaAktif = $this->dataPekerjaModel->joinDataPekerjaanAktif();

        if (count($jumlahPekerjaAktif) == 0) {
            return redirect()->back()->with('error', 'Tidak ada data pekerja dengan status Aktif. Tidak dapat mencetak SPT.');
        }

        $daftarPekerja = $this->dataPekerjaModel->joinDataPekerjaanAktif();
        $daftarPekerjaBersih = [];

        foreach ($daftarPekerja as $pekerja) {
            // Ambil semua riwayat kerja untuk satu pegawai
            $semuaRiwayat = $this->riwayatKerjaModel
                ->where('id_pekerja', $pekerja['id_pekerja'])
                ->orderBy('tmt_kerja', 'DESC') // Urutkan berdasarkan TMT terbaru
                ->findAll();

            $adaStatusMenunggu = false;

            foreach ($semuaRiwayat as $riwayat) {
                if (strtolower($riwayat['status']) === 'menunggu') {
                    $adaStatusMenunggu = true;
                    break;
                }
            }

            // Jika ada status 'Menunggu', skip pegawai ini
            if ($adaStatusMenunggu) {
                continue;
            }

            // Jika tidak ada 'Menunggu', masukkan ke daftar
            $daftarPekerjaBersih[] = $pekerja;
        }

        // dd($daftarPekerjaBersih);
        $data = [
            'title' => 'Cetak SPT Kolektif',
            'daftarPekerja' => $daftarPekerjaBersih,
            'riwayatKerja' => $this->riwayatKerjaModel->findAll(),
            'unitKerja' => $this->unitKerjaModel->findAll(),
            'listPekerjaan' => $this->listPekerjaanModel->findAll(),
            'daftarKepala' => $this->daftarKepalaModel->getDaftarKepala(),
            'dasarHukum' => $this->dasarHukumModel
                ->whereIn('status', ['Aktif 1', 'Aktif 2'])
                ->orderBy("FIELD(status, 'Aktif 1', 'Aktif 2')", '', false)
                ->findAll()
        ];
        return view('laporan/cetak_spt', $data);
    }

    public function cetak_pks()
    {
        $jumlahPekerjaAktif = $this->dataPekerjaModel->joinDataPekerjaanAktif();

        if (count($jumlahPekerjaAktif) == 0) {
            return redirect()->back()->with('error', 'Tidak ada data pekerja dengan status Aktif. Tidak dapat mencetak PKS.');
        }

        $daftarPekerja = $this->dataPekerjaModel->joinDataPekerjaanAktif();
        $daftarKepala = $this->daftarKepalaModel->getDaftarKepala();
        $daftarKepalaByUnit = [];
        $daftarPekerjaBersih = [];

        // Buat daftar kepala berdasarkan unit kerja
        foreach ($daftarKepala as $kepala) {
            $daftarKepalaByUnit[$kepala['id_unit_kerja']] = $kepala;
        }

        foreach ($daftarPekerja as &$pekerja) {
            $unitKerjaId = $pekerja['id_unit_kerja'];
            if (isset($daftarKepalaByUnit[$unitKerjaId])) {
                $pekerja['jabatan_short'] = $daftarKepalaByUnit[$unitKerjaId]['jabatan_short'];
                $pekerja['nama_kepala'] = $daftarKepalaByUnit[$unitKerjaId]['nama_kepala'];
            } else {
                $pekerja['jabatan_short'] = 'Tidak Diketahui';
                $pekerja['nama_kepala'] = 'Tidak Diketahui';
            }
            // Ambil semua riwayat kerja untuk satu pegawai
            $semuaRiwayat = $this->riwayatKerjaModel
                ->where('id_pekerja', $pekerja['id_pekerja'])
                ->orderBy('tmt_kerja', 'DESC') // Urutkan berdasarkan TMT terbaru
                ->findAll();

            $adaStatusMenunggu = false;

            foreach ($semuaRiwayat as $riwayat) {
                if (strtolower($riwayat['status']) === 'menunggu') {
                    $adaStatusMenunggu = true;
                    break;
                }
            }

            // hitung berapa bulan tmt kerja hingga tst kerja masing-masing pegawai
            if (isset($pekerja['tmt_kerja']) && isset($pekerja['tst_kerja'])) {
                $tmt = strtotime($pekerja['tmt_kerja']);
                $tst = strtotime($pekerja['tst_kerja']);
                $bulanKerja = floor(($tst - $tmt) / (30 * 24 * 60 * 60)); // Hitung selisih dalam bulan
                $pekerja['bulan_kerja'] = $bulanKerja;
            } else {
                $pekerja['bulan_kerja'] = 0; // Atur ke 0 jika tidak ada data TMT atau TST
            }

            // Jika ada status 'Menunggu', skip pegawai ini
            if ($adaStatusMenunggu) {
                continue;
            }

            // Jika tidak ada 'Menunggu', masukkan ke daftar
            $daftarPekerjaBersih[] = $pekerja;
        }

        $data = [
            'title' => 'Cetak PKS',
            'daftarPekerja' => $daftarPekerjaBersih,
            'riwayatKerja' => $this->riwayatKerjaModel->findAll(),
            'unitKerja' => $this->unitKerjaModel->findAll(),
            'listPekerjaan' => $this->listPekerjaanModel->findAll(),
            'daftarKepala' => $this->daftarKepalaModel->getDaftarKepala()
        ];
        return view('laporan/cetak_pks', $data);
    }
}
