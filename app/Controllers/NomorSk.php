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
            $decrypted = $encryption->decrypt(hex2bin($encrypted));
            
            // Log untuk debugging
            log_message('debug', 'Decrypt ID - Input: ' . $encrypted);
            log_message('debug', 'Decrypt ID - Output: ' . $decrypted);
            
            return $decrypted;
        } catch (\Exception $e) {
            log_message('error', 'Decrypt ID Error: ' . $e->getMessage());
            log_message('error', 'Encrypted value: ' . $encrypted);
            return null;
        }
    }

    private function encryptId($id)
    {
        try {
            $encryption = \Config\Services::encrypter();
            return bin2hex($encryption->encrypt($id));
        } catch (\Exception $e) {
            log_message('error', 'Encrypt ID Error: ' . $e->getMessage());
            return null;
        }
    }


    // ===============================
    // LIST
    // ===============================
    public function index()
    {
        $list = $this->noSkModel->orderBy('tahun', 'DESC')->findAll();
        $skModel = new \App\Models\SkModel();
        
        foreach ($list as $key => $value) {
            // Gunakan fungsi encryptId yang konsisten
            $list[$key]['id_no_sk_encrypted'] = $this->encryptId($value['id_no_sk']);
            
            // 🔧 PERBAIKAN: Hitung jumlah SK yang sebenarnya berdasarkan tanggal penetapan
            $jumlahSk = $skModel
                ->where('id_no_sk', $value['id_no_sk'])
                ->where('tanggal_penetapan', $value['tanggal_penetapan'])
                ->countAllResults();
            
            $list[$key]['jumlah_sk'] = $jumlahSk;
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
        $nomorUtama = $this->request->getPost('nomor_utama');
        $tanggalPenetapan = $this->request->getPost('tanggal_penetapan');

        // 🔧 VALIDASI 1: Cek apakah nomor utama sudah ada untuk tanggal penetapan yang berbeda
        $cekNomorUtama = $this->noSkModel
            ->where('nomor_utama', $nomorUtama)
            ->where('tahun', $tahun)
            ->first();

        if ($cekNomorUtama && $cekNomorUtama['tanggal_penetapan'] != $tanggalPenetapan) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nomor utama ' . $nomorUtama . ' sudah digunakan untuk tanggal penetapan ' . 
                       date('d-m-Y', strtotime($cekNomorUtama['tanggal_penetapan'])) . 
                       '. Gunakan nomor utama yang berbeda!');
        }

        // 🔧 VALIDASI 2: Cek apakah sudah ada entry untuk tanggal penetapan ini
        $cekTanggal = $this->noSkModel
            ->where('tanggal_penetapan', $tanggalPenetapan)
            ->where('tahun', $tahun)
            ->first();

        if ($cekTanggal) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Sudah ada nomor SK untuk tanggal penetapan ' . 
                       date('d-m-Y', strtotime($tanggalPenetapan)) . 
                       ' dengan nomor utama ' . $cekTanggal['nomor_utama']);
        }

        // Insert data baru
        $this->noSkModel->insert([
            'tahun'            => $tahun,
            'kode_sk'          => $this->request->getPost('kode_sk'),
            'nomor_utama'      => $nomorUtama,
            'awalan_nomor'     => $this->request->getPost('awalan_nomor') ?? 0,
            'tanggal_penetapan' => $tanggalPenetapan
        ]);

        return redirect()->to('no-sk')->with('success', 'Nomor SK berhasil disimpan untuk tanggal ' . 
                                             date('d-m-Y', strtotime($tanggalPenetapan)));
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

        $nomorUtama = $this->request->getPost('nomor_utama');
        $tanggalPenetapan = $this->request->getPost('tanggal_penetapan');
        $tahun = $this->request->getPost('tahun');

        // 🔧 VALIDASI: Cek apakah nomor utama sudah digunakan untuk tanggal berbeda
        $cekNomorUtama = $this->noSkModel
            ->where('nomor_utama', $nomorUtama)
            ->where('tahun', $tahun)
            ->where('id_no_sk !=', $id)
            ->first();

        if ($cekNomorUtama && $cekNomorUtama['tanggal_penetapan'] != $tanggalPenetapan) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nomor utama ' . $nomorUtama . ' sudah digunakan untuk tanggal ' . 
                       date('d-m-Y', strtotime($cekNomorUtama['tanggal_penetapan'])) . 
                       '. Gunakan nomor utama yang berbeda!');
        }

        $this->noSkModel->update($id, [
            'tahun'            => $tahun,
            'kode_sk'          => $this->request->getPost('kode_sk'),
            'nomor_utama'      => $nomorUtama,
            'awalan_nomor'     => $this->request->getPost('awalan_nomor'),
            'tanggal_penetapan' => $tanggalPenetapan
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

        // 🔧 PERBAIKAN: Tambahkan tanggal_penetapan pada query
        $listSk = $skModel
            ->select('tb_sk.*, tb_data_pekerja.nama')
            ->join('tb_data_pekerja', 'tb_data_pekerja.id_pekerja = tb_sk.id_pekerja')
            ->where('tb_sk.id_no_sk', $id_no_sk)
            ->orderBy('tb_sk.tanggal_penetapan', 'DESC')
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
    
    /**
     * Tampilkan form untuk generate nomor SK
     * User dapat memilih mode Otomatis atau Selektif
     */
    public function formGenerate($encryptedId)
    {
        $id_no_sk = $this->decryptId($encryptedId);

        $noSk = $this->noSkModel->find($id_no_sk);
        if (!$noSk) {
            return redirect()->to('no-sk')->with('error', 'Nomor SK tidak ditemukan');
        }

        $skModel = new \App\Models\SkModel();
        $pegawaiModel = new \App\Models\DataPekerjaModel();

        // Ambil semua pegawai aktif
        $pegawaiAktif = $pegawaiModel->where('status_pekerja', 'Terverifikasi')->findAll();

        // 🔧 PERBAIKAN UTAMA: Filter berdasarkan tahun yang sama
        // Jika tahun SK sama, maka cek apakah pegawai sudah punya nomor SK di tahun itu
        // Jika sudah punya, maka jangan tampilkan lagi
        $tahunNoSk = $noSk['tahun'];
        $pegawaiBelumAdaSk = [];
        
        foreach ($pegawaiAktif as $p) {
            // Cek apakah pegawai sudah punya SK di tahun yang sama
            $cekSudahAdaDiTahunIni = $skModel
                ->select('tb_sk.*, tb_no_sk.tahun')
                ->join('tb_no_sk', 'tb_no_sk.id_no_sk = tb_sk.id_no_sk')
                ->where('tb_sk.id_pekerja', $p['id_pekerja'])
                ->where('tb_no_sk.tahun', $tahunNoSk)
                ->where('tb_sk.nomor_sk IS NOT NULL')
                ->where('tb_sk.nomor_sk !=', '')
                ->first();
            
            // Hanya tampilkan pegawai yang belum punya nomor SK di tahun ini
            if (!$cekSudahAdaDiTahunIni) {
                $p['sudah_ada_sk'] = false;
                $p['nomor_sk_sekarang'] = null;
                $pegawaiBelumAdaSk[] = $p;
            }
        }

        return view('no_sk/form_generate_sk', [
            'title'       => 'Generate Nomor SK',
            'noSk'        => $noSk,
            'pegawaiAktif' => $pegawaiBelumAdaSk, // Hanya tampilkan yang belum ada SK
            'id_enc'      => $encryptedId
        ]);
    }
    
    /**
     * Generate Nomor SK dengan mode Otomatis atau Selektif
     * 
     * Mode Otomatis: Hanya pegawai yang belum memiliki nomor SK yang akan digenerate
     * Mode Selektif: User dapat memilih pegawai tertentu untuk digenerate nomor SK-nya
     * 
     * IMMUTABILITY: Nomor SK yang sudah ada TIDAK AKAN BERUBAH/TERHAPUS
     * 
     * @param string $encryptedId ID terenkripsi dari tb_no_sk
     */
    public function generate($encryptedId)
    {
        $id_no_sk = $this->decryptId($encryptedId);

        $noSk = $this->noSkModel->find($id_no_sk);
        if (!$noSk) {
            return redirect()->back()->with('error', 'Nomor SK tidak ditemukan');
        }

        $skModel = new \App\Models\SkModel();
        $pegawaiModel = new \App\Models\DataPekerjaModel();

        // 🔧 PERBAIKAN 1: Ambil parameter mode dan pilihan pegawai (untuk mode selektif)
        $mode = $this->request->getPost('mode') ?? 'otomatis'; // otomatis atau selektif
        $selectedPegawai = $this->request->getPost('selected_pegawai') ?? []; // array id_pekerja
        $tanggalPenetapan = $this->request->getPost('tanggal_penetapan') ?? date('Y-m-d'); // tanggal penetapan SK

        // Validasi tanggal penetapan
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggalPenetapan)) {
            return redirect()->back()->with('error', 'Format tanggal penetapan tidak valid');
        }

        // 🔧 PERBAIKAN 2: Ambil semua pegawai aktif
        $pegawaiAktif = $pegawaiModel->where('status_pekerja', 'Terverifikasi')->findAll();

        if (empty($pegawaiAktif)) {
            return redirect()->back()->with('error', 'Tidak ada pegawai aktif yang dapat digenerate nomor SK');
        }

        // 🔧 PERBAIKAN 3: Filter pegawai berdasarkan mode
        $pegawaiYangAkanDigenerate = [];
        $tahunNoSk = $noSk['tahun'];

        if ($mode === 'selektif' && !empty($selectedPegawai)) {
            // Mode Selektif: Hanya pegawai yang dipilih
            foreach ($pegawaiAktif as $p) {
                if (in_array($p['id_pekerja'], $selectedPegawai)) {
                    // Cek apakah sudah ada nomor SK di tahun yang sama
                    $cekSudahAdaDiTahunIni = $skModel
                        ->select('tb_sk.*, tb_no_sk.tahun')
                        ->join('tb_no_sk', 'tb_no_sk.id_no_sk = tb_sk.id_no_sk')
                        ->where('tb_sk.id_pekerja', $p['id_pekerja'])
                        ->where('tb_no_sk.tahun', $tahunNoSk)
                        ->where('tb_sk.nomor_sk IS NOT NULL')
                        ->where('tb_sk.nomor_sk !=', '')
                        ->first();
                    
                    // Hanya tambahkan jika BELUM memiliki nomor SK di tahun yang sama
                    if (!$cekSudahAdaDiTahunIni) {
                        $pegawaiYangAkanDigenerate[] = $p;
                    }
                }
            }
        } else {
            // Mode Otomatis: Hanya pegawai yang BELUM memiliki nomor SK di tahun yang sama (IMMUTABLE)
            foreach ($pegawaiAktif as $p) {
                $cekSudahAdaDiTahunIni = $skModel
                    ->select('tb_sk.*, tb_no_sk.tahun')
                    ->join('tb_no_sk', 'tb_no_sk.id_no_sk = tb_sk.id_no_sk')
                    ->where('tb_sk.id_pekerja', $p['id_pekerja'])
                    ->where('tb_no_sk.tahun', $tahunNoSk)
                    ->where('tb_sk.nomor_sk IS NOT NULL')
                    ->where('tb_sk.nomor_sk !=', '')
                    ->first();
                
                // Hanya tambahkan jika BELUM memiliki nomor SK di tahun yang sama
                if (!$cekSudahAdaDiTahunIni) {
                    $pegawaiYangAkanDigenerate[] = $p;
                }
            }
        }

        if (empty($pegawaiYangAkanDigenerate)) {
            $message = $mode === 'selektif' 
                ? 'Tidak ada pegawai yang dipilih atau pegawai sudah memiliki nomor SK'
                : 'Semua pegawai aktif sudah memiliki nomor SK';
            return redirect()->back()->with('error', $message);
        }

        // 🔧 PERBAIKAN 4: Urutkan pegawai berdasarkan nama untuk konsistensi
        usort($pegawaiYangAkanDigenerate, function ($a, $b) {
            return strcmp($a['nama'], $b['nama']);
        });

        // 🔧 PERBAIKAN 5: Tentukan nomor urut berikutnya berdasarkan tanggal penetapan
        // Cari nomor terakhir untuk tanggal penetapan yang sama
        $nomorTerakhir = $skModel
            ->where('id_no_sk', $id_no_sk)
            ->where('tanggal_penetapan', $tanggalPenetapan)
            ->orderBy('id_sk', 'DESC')
            ->first();

        $awalan = (int) $noSk['awalan_nomor'];
        
        if ($nomorTerakhir && !empty($nomorTerakhir['nomor_sk'])) {
            // Extract nomor urut dari nomor SK terakhir
            $parts = explode('.', $nomorTerakhir['nomor_sk']);
            if (count($parts) > 1) {
                $no = (int) end($parts) + 1;
            } else {
                // Jika nomor SK tidak ada titik, mulai dari awalan
                $no = $awalan > 0 ? $awalan : 1;
            }
        } else {
            // Belum ada nomor untuk tanggal ini, mulai dari awalan
            $no = $awalan;
        }

        // 🔧 PERBAIKAN 6: Generate nomor SK dengan logika yang benar
        $jumlahBerhasil = 0;
        foreach ($pegawaiYangAkanDigenerate as $index => $p) {
            // Logika penomoran:
            // - Jika awalan = 0 dan ini pegawai pertama untuk tanggal penetapan ini → tanpa suffix
            // - Selain itu → pakai suffix .nomor
            if ($awalan === 0 && $no === 0) {
                $nomorSk = $noSk['nomor_utama'];
                $no++; // Increment untuk pegawai berikutnya
            } else {
                $nomorSk = $noSk['nomor_utama'] . '.' . $no;
                $no++;
            }

            // 🔧 PERBAIKAN 7: Tambahkan tanggal_penetapan ke data SK
            $dataInsert = [
                'id_no_sk'          => $id_no_sk,
                'id_pekerja'        => $p['id_pekerja'],
                'nomor_sk'          => $nomorSk,
                'tanggal_penetapan' => $tanggalPenetapan
            ];

            if ($skModel->insert($dataInsert)) {
                $jumlahBerhasil++;
            }
        }

        if ($jumlahBerhasil > 0) {
            $message = "Berhasil generate {$jumlahBerhasil} nomor SK untuk tanggal penetapan " . 
                       date('d-m-Y', strtotime($tanggalPenetapan));
            // 🔧 PERBAIKAN: Redirect ke halaman detail, bukan kembali ke form
            return redirect()->to('no-sk/detail/' . $encryptedId)->with('success', $message);
        } else {
            return redirect()->back()->with('error', 'Gagal generate nomor SK');
        }
    }

    /**
     * Hapus nomor SK berdasarkan tanggal penetapan atau semua
     * 
     * PERINGATAN: Fungsi ini menghapus data, gunakan dengan hati-hati!
     * Hanya hapus SK yang belum tercetak/digunakan untuk menjaga integritas data historis
     * 
     * @param string $encryptedId ID terenkripsi dari tb_no_sk
     */
    public function hapusSemua($encryptedId)
    {
        $id_no_sk = $this->decryptId($encryptedId);

        $skModel = new \App\Models\SkModel();

        // 🔧 PERBAIKAN: Tambahkan parameter tanggal_penetapan untuk hapus selektif
        $tanggalPenetapan = $this->request->getPost('tanggal_penetapan');

        if ($tanggalPenetapan) {
            // Hapus hanya untuk tanggal penetapan tertentu
            $cek = $skModel
                ->where('id_no_sk', $id_no_sk)
                ->where('tanggal_penetapan', $tanggalPenetapan)
                ->countAllResults();

            if ($cek == 0) {
                return redirect()->back()->with('error', 'Tidak ada nomor SK dengan tanggal penetapan tersebut');
            }

            $skModel
                ->where('id_no_sk', $id_no_sk)
                ->where('tanggal_penetapan', $tanggalPenetapan)
                ->delete();

            $message = 'Nomor SK untuk tanggal ' . date('d-m-Y', strtotime($tanggalPenetapan)) . ' berhasil dihapus';
        } else {
            // Hapus semua nomor SK
            $cek = $skModel->where('id_no_sk', $id_no_sk)->countAllResults();
            if ($cek == 0) {
                return redirect()->back()->with('error', 'Tidak ada nomor SK yang bisa dihapus');
            }

            $skModel->where('id_no_sk', $id_no_sk)->delete();
            $message = 'Semua nomor SK berhasil dihapus';
        }

        return redirect()->back()->with('success', $message);
    }
}
