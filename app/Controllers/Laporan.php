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
        $this->skModel = model('App\Models\SkModel');
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

            // 🔧 VALIDASI: Cek status Terverifikasi DAN Menunggu
            $adaStatusMenunggu = false;
            $adaStatusTerverifikasi = false;

            foreach ($semuaRiwayat as $riwayat) {
                if (strtolower($riwayat['status']) === 'menunggu') {
                    $adaStatusMenunggu = true;
                }
                if (strtolower($riwayat['status']) === 'terverifikasi') {
                    $adaStatusTerverifikasi = true;
                }
            }

            // Jika TIDAK ADA status 'Terverifikasi', skip pegawai ini
            if (!$adaStatusTerverifikasi) {
                continue;
            }

            // Jika ada status 'Menunggu', skip pegawai ini
            if ($adaStatusMenunggu) {
                continue;
            }

            // Jika lolos semua validasi, masukkan ke daftar
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

        // 🔧 PERBAIKAN: Cek apakah ada SK yang sudah digenerate untuk tahun ini (tidak perlu ambil id_no_sk spesifik)
        $cekSKTahunIni = $this->skModel
            ->select('tb_sk.*')
            ->join('tb_no_sk', 'tb_no_sk.id_no_sk = tb_sk.id_no_sk', 'inner')
            ->where('tb_no_sk.tahun', date('Y'))
            ->countAllResults();

        if ($cekSKTahunIni === 0) {
            return redirect()->back()->with('error', 'Nomor SK untuk tahun ini belum digenerate.');
        }

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
            
            // Ambil riwayat aktif (Terverifikasi, tmt terbaru) pegawai ini
            $semuaRiwayat = $this->riwayatKerjaModel
                ->where('id_pekerja', $pekerja['id_pekerja'])
                ->orderBy('tmt_kerja', 'DESC')
                ->findAll();

            $riwayatAktif = null;
            foreach ($semuaRiwayat as $r) {
                if (strtolower($r['status']) === 'terverifikasi') {
                    $riwayatAktif = $r;
                    break;
                }
            }

            // Ambil SK yang terikat ke riwayat aktif, bukan semua SK pegawai di tahun ini
            $skData = null;
            if ($riwayatAktif) {
                $skData = $this->skModel
                    ->select('tb_sk.*, tb_no_sk.id_no_sk, tb_no_sk.tahun')
                    ->join('tb_no_sk', 'tb_no_sk.id_no_sk = tb_sk.id_no_sk', 'inner')
                    ->where('tb_sk.id_riwayat', $riwayatAktif['id'])
                    ->first();
            }

            if (!$skData) {
                // Skip pegawai yang riwayat aktifnya belum punya SK
                continue;
            }

            $pekerja['tanggal_penetapan_sk'] = $skData['tanggal_penetapan'];
            $pekerja['nomor_sk']             = $skData['nomor_sk'];
            $pekerja['kode_sk']              = $skData['kode_sk'] ?? '';

            // Hitung bulan kerja dari riwayat aktif
            if (!empty($riwayatAktif['tmt_kerja']) && !empty($riwayatAktif['tst_kerja'])) {
                $tmt = strtotime($riwayatAktif['tmt_kerja']);
                $tst = strtotime($riwayatAktif['tst_kerja']);
                $pekerja['bulan_kerja'] = floor(($tst - $tmt) / (30 * 24 * 60 * 60));
            } else {
                $pekerja['bulan_kerja'] = 0;
            }

            // 🔧 VALIDASI: Cek status Terverifikasi DAN Menunggu
            $adaStatusMenunggu  = false;
            $adaStatusTerverifikasi = false;

            foreach ($semuaRiwayat as $riwayat) {
                if (strtolower($riwayat['status']) === 'menunggu')      $adaStatusMenunggu = true;
                if (strtolower($riwayat['status']) === 'terverifikasi') $adaStatusTerverifikasi = true;
            }

            // Jika TIDAK ADA status 'Terverifikasi', skip pegawai ini
            if (!$adaStatusTerverifikasi) {
                continue;
            }

            // Jika ada status 'Menunggu', skip pegawai ini
            if ($adaStatusMenunggu) {
                continue;
            }

            // Jika lolos semua validasi, masukkan ke daftar
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
        // dd($data);
        return view('laporan/cetak_pks', $data);
    }

    public function cetak_spt_individu($id_pekerja_encrypted)
    {
        $encryption = \Config\Services::encrypter();
        $id_pekerja = $encryption->decrypt(hex2bin($id_pekerja_encrypted));

        // Ambil SEMUA pekerja aktif (array)
        $daftarPekerja = $this->dataPekerjaModel->joinDataPekerjaanAktif();

        // Cari pekerja berdasarkan ID
        $pekerja = null;
        foreach ($daftarPekerja as $row) {
            if ($row['id_pekerja'] == $id_pekerja) {
                $pekerja = $row;
                break;
            }
        }

        if (!$pekerja) {
            return redirect()->back()->with('error', 'Data pekerja tidak ditemukan atau tidak aktif.');
        }

        // Ambil riwayat kerja
        $riwayatKerja = $this->riwayatKerjaModel
            ->where('id_pekerja', $id_pekerja)
            ->orderBy('tmt_kerja', 'DESC')
            ->findAll();

        // 🔧 VALIDASI: Cek apakah ada status Terverifikasi yang aktif
        $adaTerverifikasi = false;
        $adaMenunggu = false;

        foreach ($riwayatKerja as $riwayat) {
            if (strtolower($riwayat['status']) === 'terverifikasi') {
                $adaTerverifikasi = true;
            }
            if (strtolower($riwayat['status']) === 'menunggu') {
                $adaMenunggu = true;
            }
        }

        // Jika tidak ada status Terverifikasi, tidak bisa cetak SPT
        if (!$adaTerverifikasi) {
            return redirect()->back()->with(
                'error',
                'SPT tidak dapat dicetak karena tidak ada riwayat kerja dengan status Terverifikasi.'
            );
        }

        // Jika masih ada status Menunggu
        if ($adaMenunggu) {
            return redirect()->back()->with(
                'error',
                'SPT tidak dapat dicetak karena masih ada riwayat kerja berstatus Menunggu.'
            );
        }

        $data = [
            'title' => 'Cetak SPT Individu',
            'pekerja' => $pekerja,
            'riwayatKerja' => $riwayatKerja,
            'unitKerja' => $this->unitKerjaModel->findAll(),
            'listPekerjaan' => $this->listPekerjaanModel->findAll(),
            'daftarKepala' => $this->daftarKepalaModel->getDaftarKepala(),
            'dasarHukum' => $this->dasarHukumModel
                ->whereIn('status', ['Aktif 1', 'Aktif 2'])
                ->orderBy("FIELD(status, 'Aktif 1', 'Aktif 2')", '', false)
                ->findAll()
        ];

        return view('laporan/cetak_spt_individu', $data);
    }

    public function cetak_pks_individu($id_pekerja_encrypted)
    {
        $encryption = \Config\Services::encrypter();
        $id_pekerja = $encryption->decrypt(hex2bin($id_pekerja_encrypted));
        // Ambil SEMUA pekerja aktif (array)
        $daftarPekerja = $this->dataPekerjaModel->joinDataPekerjaanAktif();

        // Cari pekerja berdasarkan ID
        $pekerja = null;
        foreach ($daftarPekerja as $row) {
            if ($row['id_pekerja'] == $id_pekerja) {
                $pekerja = $row;
                break;
            }
        }

        if (!$pekerja) {
            return redirect()->back()->with('error', 'Data pekerja tidak ditemukan atau tidak aktif.');
        }

        // Ambil semua riwayat kerja
        $riwayatKerja = $this->riwayatKerjaModel
            ->where('id_pekerja', $id_pekerja)
            ->orderBy('tmt_kerja', 'DESC')
            ->findAll();

        // 🔧 VALIDASI: Cek apakah ada status Terverifikasi yang aktif
        $adaTerverifikasi = false;
        $adaMenunggu = false;

        foreach ($riwayatKerja as $riwayat) {
            if (strtolower($riwayat['status']) === 'terverifikasi') {
                $adaTerverifikasi = true;
            }
            if (strtolower($riwayat['status']) === 'menunggu') {
                $adaMenunggu = true;
            }
        }

        // Jika tidak ada status Terverifikasi, tidak bisa cetak PKS
        if (!$adaTerverifikasi) {
            return redirect()->back()->with(
                'error',
                'PKS tidak dapat dicetak karena tidak ada riwayat kerja dengan status Terverifikasi.'
            );
        }

        // Jika masih ada status Menunggu
        if ($adaMenunggu) {
            return redirect()->back()->with(
                'error',
                'PKS tidak dapat dicetak karena masih ada riwayat kerja berstatus Menunggu.'
            );
        }

        // Ambil riwayat aktif (Terverifikasi, tmt terbaru)
        $riwayatAktif = null;
        foreach ($riwayatKerja as $r) {
            if (strtolower($r['status']) === 'terverifikasi') {
                $riwayatAktif = $r;
                break; // sudah diurutkan DESC, ambil yang pertama
            }
        }

        // Hitung bulan kerja dari riwayat aktif
        if ($riwayatAktif && !empty($riwayatAktif['tmt_kerja']) && !empty($riwayatAktif['tst_kerja'])) {
            $tmt = strtotime($riwayatAktif['tmt_kerja']);
            $tst = strtotime($riwayatAktif['tst_kerja']);
            $pekerja['bulan_kerja'] = floor(($tst - $tmt) / (30 * 24 * 60 * 60));
        } else {
            $pekerja['bulan_kerja'] = 0;
        }

        // Ambil SK yang terikat ke riwayat aktif ini (bukan semua SK pegawai)
        $skData = null;
        if ($riwayatAktif) {
            $skData = $this->skModel
                ->select('tb_sk.*, tb_no_sk.id_no_sk, tb_no_sk.tahun, tb_no_sk.kode_sk, tb_no_sk.nomor_utama')
                ->join('tb_no_sk', 'tb_no_sk.id_no_sk = tb_sk.id_no_sk', 'inner')
                ->where('tb_sk.id_riwayat', $riwayatAktif['id'])
                ->first();
        }

        if (!$skData) {
            return redirect()->back()->with('error', 'Nomor SK untuk kontrak aktif ini belum di-generate. Silakan generate nomor SK terlebih dahulu.');
        }

        $pekerja['tanggal_penetapan_sk'] = $skData['tanggal_penetapan'];
        $pekerja['nomor_sk']             = $skData['nomor_sk'];
        $pekerja['kode_sk']              = $skData['kode_sk'] ?? '';

        // Ambil kepala unit kerja
        $kepala = $this->daftarKepalaModel
            ->where('id_unit_kerja', $pekerja['id_unit_kerja'])
            ->first();

        $pekerja['jabatan_short'] = $kepala['jabatan_short'] ?? 'Tidak Diketahui';
        $pekerja['nama_kepala']   = $kepala['nama_kepala'] ?? 'Tidak Diketahui';

        $data = [
            'title' => 'Cetak PKS Individu',
            'pekerja' => $pekerja,
            'riwayatKerja' => $riwayatKerja,
            'unitKerja' => $this->unitKerjaModel->findAll(),
            'listPekerjaan' => $this->listPekerjaanModel->findAll(),
            'daftarKepala' => $this->daftarKepalaModel->getDaftarKepala()
        ];
        
        return view('laporan/cetak_pks_individu', $data);
    }
}
