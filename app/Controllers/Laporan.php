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

        $noSk = model('App\Models\NoSkModel')
            ->where('tahun', date('Y'))
            ->first();

        if (!$noSk) {
            return redirect()->back()->with('error', 'Nomor SK tahun ini belum dibuat. Hubungi admin.');
        }

        $cekSK = $this->skModel
            ->where('id_no_sk', $noSk['id_no_sk'])
            ->countAllResults();

        if ($cekSK === 0) {
            return redirect()->back()->with('error', 'Nomor SK belum digenerate.');
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
            
            // 🔧 PERBAIKAN: Ambil tanggal penetapan SK dari tb_sk dengan JOIN ke tb_no_sk
            // untuk memastikan nomor SK masih valid (tidak terhapus)
            $skData = $this->skModel
                ->select('tb_sk.*, tb_no_sk.id_no_sk')
                ->join('tb_no_sk', 'tb_no_sk.id_no_sk = tb_sk.id_no_sk', 'inner')
                ->where('tb_sk.id_pekerja', $pekerja['id_pekerja'])
                ->where('tb_sk.id_no_sk', $noSk['id_no_sk'])
                ->where('tb_no_sk.tahun', date('Y'))
                ->first();
            
            if ($skData && isset($skData['tanggal_penetapan'])) {
                $pekerja['tanggal_penetapan_sk'] = $skData['tanggal_penetapan'];
            } else {
                // Jika tidak ada data SK yang valid, skip pegawai ini
                $pekerja['skip'] = true;
                continue;
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

        // Cek status MENUNGGU
        foreach ($riwayatKerja as $riwayat) {
            if (strtolower($riwayat['status']) === 'menunggu') {
                return redirect()->back()->with(
                    'error',
                    'SPT tidak dapat dicetak karena masih ada riwayat kerja berstatus Menunggu.'
                );
            }
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
        // Cek apakah nomor SK sudah digenerate untuk tahun berjalan
        $noSk = model('App\Models\NoSkModel')
            ->where('tahun', date('Y'))
            ->first();

        if (!$noSk) {
            return redirect()->back()->with('error', 'Nomor SK tahun ini belum dibuat. Hubungi admin.');
        }

        $cekSK = $this->skModel
            ->where('id_no_sk', $noSk['id_no_sk'])
            ->countAllResults();

        if ($cekSK === 0) {
            return redirect()->back()->with('error', 'Nomor SK belum digenerate.');
        }


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

        // Cek status MENUNGGU
        foreach ($riwayatKerja as $riwayat) {
            if (strtolower($riwayat['status']) === 'menunggu') {
                return redirect()->back()->with(
                    'error',
                    'PKS tidak dapat dicetak karena masih ada riwayat kerja berstatus Menunggu.'
                );
            }
        }

        // Hitung bulan kerja
        if (!empty($pekerja['tmt_kerja']) && !empty($pekerja['tst_kerja'])) {
            $tmt = strtotime($pekerja['tmt_kerja']);
            $tst = strtotime($pekerja['tst_kerja']);
            $pekerja['bulan_kerja'] = floor(($tst - $tmt) / (30 * 24 * 60 * 60));
        } else {
            $pekerja['bulan_kerja'] = 0;
        }

        // 🔧 PERBAIKAN: Ambil tanggal penetapan SK dari tb_sk dengan JOIN ke tb_no_sk
        // untuk memastikan nomor SK masih valid (tidak terhapus)
        $skData = $this->skModel
            ->select('tb_sk.*, tb_no_sk.id_no_sk')
            ->join('tb_no_sk', 'tb_no_sk.id_no_sk = tb_sk.id_no_sk', 'inner')
            ->where('tb_sk.id_pekerja', $id_pekerja)
            ->where('tb_sk.id_no_sk', $noSk['id_no_sk'])
            ->where('tb_no_sk.tahun', date('Y'))
            ->first();
        
        if ($skData && isset($skData['tanggal_penetapan'])) {
            $pekerja['tanggal_penetapan_sk'] = $skData['tanggal_penetapan'];
        } else {
            // Jika tidak ada data SK yang valid, kembalikan error
            return redirect()->back()->with('error', 'Data nomor SK tidak valid atau sudah dihapus. Silakan generate ulang nomor SK.');
        }

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
