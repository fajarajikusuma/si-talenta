<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Penugasan extends BaseController
{
    public function __construct()
    {
        $this->dataPekerjaModel = model('App\Models\DataPekerjaModel');
        $this->riwayatKerjaModel = model('App\Models\RiwayatKerjaModel');
        $this->unitKerjaModel = model('App\Models\UnitKerjaModel');
        $this->listPekerjaanModel = model('App\Models\ListPekerjaanModel');
        $this->daftarKepalaModel = model('App\Models\DaftarKepalaModel');
    }

    public function index()
    {
        // cek masing masing data riwayat kerja jika sebelumnya tidak ada riwayat kerja maka jangan tampilkan pekerja tersebut
        $dataPekerja = $this->dataPekerjaModel->dataPengajuanPekerjaan();
        foreach ($dataPekerja as $key => $pekerja) {
            // cek apakah pekerja memiliki riwayat kerja
            $riwayat = $this->riwayatKerjaModel->where('id_pekerja', $pekerja['id_pekerja'])->findAll();
            if (empty($riwayat)) {
                // jika tidak ada riwayat kerja, hapus pekerja dari daftar
                unset($dataPekerja[$key]);
            } else {
                // jika ada riwayat kerja, ambil status terakhir
                $lastRiwayat = end($riwayat);
                // jika status terakhir adalah 'Terverifikasi', hapus pekerja dari daftar
                if (strtolower($lastRiwayat['status']) === 'terverifikasi') {
                    unset($dataPekerja[$key]);
                }
            }
        }

        $data = [
            'title' => 'Penugasan',
            'dataPekerja' => $dataPekerja,
            'riwayatKerja' => $this->riwayatKerjaModel->findAll(),
            'unitKerja' => $this->unitKerjaModel->findAll(),
            'listPekerjaan' => $this->listPekerjaanModel->findAll(),
            'daftarKepala' => $this->daftarKepalaModel->findAll(),
        ];
        // dd($this->dataPekerjaModel->joinDataPekerjaanAktif());
        return view('penugasan/penugasan', $data);
    }

    public function ajukanSemua()
    {
        $selected = $this->request->getPost('selected');
        $pekerjaanSama = $this->request->getPost('pekerjaan_sama');
        $pekerjaanTidak = $this->request->getPost('pekerjaan_tidak');
        $pekerjaanPilih = $this->request->getPost('pekerjaan_pilih');

        $unitSama = $this->request->getPost('unit_sama');
        $unitTidak = $this->request->getPost('unit_tidak');
        $unitPilih = $this->request->getPost('unit_pilih');

        $aktif = $this->request->getPost('aktif');
        $tidak_aktif = $this->request->getPost('non_aktif');

        if (!$selected) {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
        }

        foreach ($selected as $idPekerja) {
            // Ambil riwayat terakhir berdasarkan TMT terbaru
            $riwayat = $this->riwayatKerjaModel
                ->where('id_pekerja', $idPekerja)
                ->orderBy('tmt_kerja', 'DESC')
                ->first();

            // Jika riwayat terakhir masih berstatus Menunggu, tolak pengajuan
            if ($riwayat && strtolower($riwayat['status']) === 'menunggu') {
                return redirect()->back()->with('error', 'Penugasan untuk pekerja masih dalam status Menunggu.');
            }

            // Ambil semua riwayat kerja pada tahun yang sama
            $riwayatTahun = $this->riwayatKerjaModel
                ->where('id_pekerja', $idPekerja)
                ->where('tahun', date('Y'))
                ->findAll();

            $idPekerjaan = null;
            $idUnitKerja = null;

            // Tentukan pekerjaan
            if (isset($pekerjaanSama[$idPekerja])) {
                $idPekerjaan = $riwayat['id_nama_pekerjaan'] ?? null;
            } elseif (isset($pekerjaanTidak[$idPekerja]) && !empty($pekerjaanPilih[$idPekerja])) {
                $idPekerjaan = $pekerjaanPilih[$idPekerja];
            }

            // Tentukan unit kerja
            if (isset($unitSama[$idPekerja])) {
                $idUnitKerja = $riwayat['id_unit_kerja'] ?? null;
            } elseif (isset($unitTidak[$idPekerja]) && !empty($unitPilih[$idPekerja])) {
                $idUnitKerja = $unitPilih[$idPekerja];
            }

            // Tentukan aktif atau tidak aktif
            if (isset($aktif[$idPekerja])) {
                $data = [
                    'status_pekerja' => 'Terverifikasi',
                ];
                $this->dataPekerjaModel->update($idPekerja, $data);
            } elseif (isset($tidak_aktif[$idPekerja])) {
                $data = [
                    'penginput' => session()->get('nama_lengkap'),
                    'tst_kerja' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                $this->dataPekerjaModel->update($idPekerja, ['status_pekerja' => 'Tidak Aktif']);
                $this->riwayatKerjaModel->update($riwayat['id'], $data);
            }

            if ($idPekerjaan && $idUnitKerja) {
                $tmtBaru = date('Y-m-d');
                $tahunBaru = date('Y');

                $riwayatTahunSama = array_filter($riwayatTahun, function ($item) use ($tahunBaru) {
                    return $item['tahun'] == $tahunBaru && $item['status'] == 'Terverifikasi';
                });

                if (!empty($riwayatTahunSama)) {
                    foreach ($riwayatTahunSama as $riwayatSama) {
                        $this->riwayatKerjaModel->update($riwayatSama['id'], [
                            'tst_kerja' => date('Y-m-d', strtotime($tmtBaru . ' -1 day')),
                        ]);
                    }
                }
                // Cek apakah pekerjaan, dan unit kerja sama dengan sebelumnya di tahun yang sama jika ya maka jangan input baru
                $riwayatSama = $this->riwayatKerjaModel
                    ->where('id_pekerja', $idPekerja)
                    ->where('id_nama_pekerjaan', $idPekerjaan)
                    ->where('id_unit_kerja', $idUnitKerja)
                    ->where('tahun', $tahunBaru)
                    ->where('status', 'Terverifikasi')
                    ->first();

                if ($riwayatSama) {
                    return redirect()->back()->with('error', 'Pekerja dengan ID ' . $idPekerja . ' sudah memiliki penugasan dengan pekerjaan dan unit kerja yang sama pada tahun ini.');
                    continue;
                }

                $this->riwayatKerjaModel->insert([
                    'id_pekerja' => $idPekerja,
                    'id_nama_pekerjaan' => $idPekerjaan,
                    'id_unit_kerja' => $idUnitKerja,
                    'jenis_pegawai' => $riwayat['jenis_pegawai'] ?? null,
                    'tmt_kerja' => date('Y') . '-01-01',
                    'tst_kerja' => date('Y') . '-12-31',
                    'tahun' => $tahunBaru,
                    'status' => 'Menunggu',
                    'penginput' => session()->get('nama_lengkap'),
                ]);
            }
        }

        return redirect()->to('/penugasan')->with('success', 'Proses Berhasil');
    }

    public function daftarPenugasan()
    {
        $idUnitKerja = $this->request->getPost('id_unit_kerja');
        if ($idUnitKerja) {
            $dataPekerja = $this->dataPekerjaModel->getDataPenugasanMenungguByUnit($idUnitKerja);
        } else {
            $dataPekerja = $this->dataPekerjaModel->getDataPenugasanMenunggu();
        }

        $data = [
            'dataPekerja' => $dataPekerja,
            'unitKerja' => $this->unitKerjaModel->findAll(),
            'title' => 'Daftar Penugasan Baru',
        ];

        return view('penugasan/daftar_penugasan', $data);
    }

    public function cetakPenugasan()
    {
        if (!$this->dataPekerjaModel->hasDataPenugasanMenunggu()) {
            return redirect()->back()->with('error', 'Tidak ada data penugasan yang menunggu untuk dicetak.');
        }
        $dataPekerja = $this->dataPekerjaModel->getDataPenugasanMenunggu();
        $getSessionUnitKerja = session()->get('id_unit_kerja');
        // jika unitkerja ditemukan maka tampilkan nama kepala unit kerja
        if ($getSessionUnitKerja) {
            $kepalaUnit = $this->daftarKepalaModel->where('id_unit_kerja', $getSessionUnitKerja)->first();
            if ($kepalaUnit) {
                $nama_kepala = $kepalaUnit['nama_kepala'];
                $jabatan = $kepalaUnit['jabatan'];
                $nip = $kepalaUnit['nip'];
            } else {
                $nama_kepala = 'Tidak Ditemukan';
                $jabatan = 'Tidak Ditemukan';
                $nip = 'Tidak Ditemukan';
            }
        } else {
            $dataPekerja['kepala_unit'] = 'Tidak Diketahui';
        }
        // dd($dataPekerja);
        $data = [
            'dataPekerja' => $dataPekerja,
            'title' => 'Cetak Penugasan',
            'nama_kepala' => $nama_kepala,
            'jabatan' => $jabatan,
            'nip' => $nip,
        ];

        return view('penugasan/cetak_penugasan', $data);
    }

    public function verifikasiPenugasan()
    {
        if ($this->request->getMethod() !== 'POST') {
            return redirect()->back()->with('error', 'Invalid request method.');
        }

        $verifikasiIds = $this->request->getPost('verifikasi_id');
        if (empty($verifikasiIds)) {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih untuk verifikasi.');
        }

        foreach ($verifikasiIds as $id) {
            $riwayat = $this->riwayatKerjaModel->find($id);
            if ($riwayat) {
                $this->riwayatKerjaModel->update($id, ['status' => 'Terverifikasi']);
            }

            // jika sudah diverifikasi, maka status sebelumnya harus diubah menjadi 'Tidak Aktif'
            $riwayatSebelumnya = $this->riwayatKerjaModel
                ->where('id_pekerja', $riwayat['id_pekerja'])
                ->where('status', 'Terverifikasi')
                ->where('id !=', $id)
                ->findAll();
            foreach ($riwayatSebelumnya as $item) {
                $this->riwayatKerjaModel->update($item['id'], ['status' => 'Tidak Aktif']);
            }
        }

        return redirect()->to('/cetak_usulan_tugas_baru')->with('success', 'Penugasan berhasil diverifikasi.');
    }
}
