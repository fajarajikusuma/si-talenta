<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NoSkModel;

class NomorSk extends BaseController
{
    protected $noSkModel;

    public function __construct()
    {
        $this->noSkModel = new NoSkModel();
    }

    private function decryptId($encrypted)
    {
        try {
            $encryption = \Config\Services::encrypter();
            return $encryption->decrypt(hex2bin($encrypted));
        } catch (\Exception $e) {
            return null;
        }
    }


    // ===============================
    // LIST
    // ===============================
    public function index()
    {
        $encryption = \Config\Services::encrypter();
        $list = $this->noSkModel->orderBy('tahun', 'DESC')->findAll();
        foreach ($list as $key => $value) {
            $list[$key]['id_no_sk_encrypted'] = bin2hex($encryption->encrypt($value['id_no_sk']));
        }

        $data = [
            'title' => 'Nomor SK Tahunan',
            'list'  =>  $list
        ];

        return view('no_sk/no_sk', $data);
    }

    // ===============================
    // FORM TAMBAH
    // ===============================
    public function create()
    {
        return view('no_sk/add_no_sk', [
            'title' => 'Tambah Nomor SK'
        ]);
    }

    // ===============================
    // SIMPAN
    // ===============================
    public function store()
    {
        $tahun = $this->request->getPost('tahun');

        if ($this->noSkModel->where('tahun', $tahun)->first()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nomor SK untuk tahun ini sudah ada');
        }

        $this->noSkModel->insert([
            'tahun'       => $tahun,
            'kode_sk'     => $this->request->getPost('kode_sk'),
            'nomor_utama' => $this->request->getPost('nomor_utama'),
            'awalan_nomor' => $this->request->getPost('awalan_nomor')
        ]);

        return redirect()->to('no-sk')->with('success', 'Nomor SK berhasil disimpan');
    }

    // ===============================
    // FORM EDIT
    // ===============================
    public function edit($id_encrypted)
    {
        $id = $this->decryptId($id_encrypted);

        if (!$id) {
            return redirect()->to('no-sk')->with('error', 'ID tidak valid');
        }

        $data = $this->noSkModel->find($id);

        if (!$data) {
            return redirect()->to('no-sk')->with('error', 'Data tidak ditemukan');
        }

        return view('no_sk/edit_no_sk', [
            'title' => 'Edit Nomor SK',
            'data'  => $data,
            'id_encrypted' => $id_encrypted
        ]);
    }


    // ===============================
    // UPDATE
    // ===============================
    public function update($id_encrypted)
    {
        $id = $this->decryptId($id_encrypted);

        if (!$id) {
            return redirect()->to('no-sk')->with('error', 'ID tidak valid');
        }

        $this->noSkModel->update($id, [
            'tahun'       => $this->request->getPost('tahun'),
            'kode_sk'     => $this->request->getPost('kode_sk'),
            'nomor_utama' => $this->request->getPost('nomor_utama'),
            'awalan_nomor' => $this->request->getPost('awalan_nomor')
        ]);

        return redirect()->to('no-sk')->with('success', 'Nomor SK berhasil diperbarui');
    }


    // ===============================
    // DELETE (OPSIONAL)
    // ===============================
    public function delete($id_encrypted)
    {
        $id = $this->decryptId($id_encrypted);

        if (!$id) {
            return redirect()->to('no-sk')->with('error', 'ID tidak valid');
        }

        // cek apakah nomor SK digunakan di tabel SK
        $skModel = new \App\Models\SkModel();
        $count = $skModel->where('id_no_sk', $id)->countAllResults();
        if ($count > 0) {
            return redirect()->to('no-sk')
                ->with('error', 'Nomor SK tidak bisa dihapus karena sudah digunakan di data SK');
        }

        $this->noSkModel->delete($id);

        return redirect()->to('no-sk')
            ->with('success', 'Nomor SK berhasil dihapus');
    }

    // ===============================
    // DETAIL (OPSIONAL)
    // ===============================
    public function detail($encryptedId)
    {
        $id_no_sk = $this->decryptId($encryptedId);

        $noSk = $this->noSkModel->find($id_no_sk);
        if (!$noSk) {
            return redirect()->to('no-sk')->with('error', 'Data tidak ditemukan');
        }

        $skModel = new \App\Models\SkModel();

        $listSk = $skModel
            ->select('tb_sk.*, tb_data_pekerja.nama')
            ->join('tb_data_pekerja', 'tb_data_pekerja.id_pekerja = tb_sk.id_pekerja')
            ->where('tb_sk.id_no_sk', $id_no_sk)
            ->orderBy('tb_data_pekerja.nama', 'ASC')
            ->findAll();

        // dd($listSk);
        return view('no_sk/detail_no_sk', [
            'title'   => 'Detail Nomor SK',
            'noSk'    => $noSk,
            'listSk'  => $listSk,
            'id_enc'  => $encryptedId
        ]);
    }

    // =============================
    // GENERATE NOMOR SK UNTUK PEKERJA
    // =============================

    public function generate($encryptedId)
    {
        $id_no_sk = $this->decryptId($encryptedId);

        $noSk = $this->noSkModel->find($id_no_sk);
        if (!$noSk) {
            return redirect()->back()->with('error', 'Nomor SK tidak ditemukan');
        }

        $skModel = new \App\Models\SkModel();
        // cek apakah sudah ada nomor SK untuk tahun ini
        $cek = $skModel->where('id_no_sk', $id_no_sk)->countAllResults();
        if ($cek > 0) {
            return redirect()->back()->with('error', 'Nomor SK untuk tahun ini sudah digenerate. Hapus dulu jika ingin generate ulang.');
        }

        // ambil pegawai aktif (sesuaikan field kamu)
        $pegawaiModel = new \App\Models\DataPekerjaModel();
        $pegawaiAktif = $pegawaiModel->where('status_pekerja', 'Terverifikasi')->findAll();

        // hapus dulu agar bisa regenerate
        $skModel->where('id_no_sk', $id_no_sk)->delete();

        // 1️⃣ KUNCI URUTAN PEGAWAI (WAJIB)
        usort($pegawaiAktif, function ($a, $b) {
            return strcmp($a['nama'], $b['nama']); // atau id_pekerja
        });

        // 2️⃣ GENERATE NOMOR SK
        $awalan = (int) $noSk['awalan_nomor'];
        $no = $awalan;

        foreach ($pegawaiAktif as $index => $p) {

            // jika awalan 0 dan index pertama → tanpa revisi
            if ($awalan === 0 && $index === 0) {
                $nomorSk = $noSk['nomor_utama'];
            } else {
                // selain itu selalu pakai .nomor
                $nomorSk = $noSk['nomor_utama'] . '.' . $no;
            }

            $skModel->insert([
                'id_no_sk'   => $id_no_sk,
                'id_pekerja' => $p['id_pekerja'],
                'tahun'      => $noSk['tahun'],
                'nomor_sk'   => $nomorSk
            ]);

            $no++;
        }

        return redirect()->back()->with('success', 'Nomor SK berhasil digenerate');
    }

    public function hapusSemua($encryptedId)
    {
        $id_no_sk = $this->decryptId($encryptedId);

        $skModel = new \App\Models\SkModel();

        // cek apakah ada data
        $cek = $skModel->where('id_no_sk', $id_no_sk)->countAllResults();
        if ($cek == 0) {
            return redirect()->back()->with('error', 'Tidak ada nomor SK yang bisa dihapus');
        }

        // hapus semua nomor SK terkait
        $skModel->where('id_no_sk', $id_no_sk)->delete();

        return redirect()->back()->with('success', 'Semua nomor SK berhasil dihapus');
    }
}
