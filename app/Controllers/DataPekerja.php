<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;



class DataPekerja extends BaseController
{
    public function __construct()
    {
        $this->dataPekerjaModel = model('App\Models\DataPekerjaModel');
        $this->riwayatKerjaModel = model('App\Models\RiwayatKerjaModel');
        $this->unitKerjaModel = model('App\Models\UnitKerjaModel');
        $this->listPekerjaanModel = model('App\Models\ListPekerjaanModel');
        $this->daftarKepalaModel = model('App\Models\DaftarKepalaModel');
    }

    public function index(): string
    {
        session()->set('page', 'aktif');
        $modelDataPekerjaAktif = $this->dataPekerjaModel->joinDataPekerjaanAktif();
        $encrypt = \Config\Services::encrypter();
        foreach ($modelDataPekerjaAktif as &$row) {
            $row['id_pekerja_encrypted'] = bin2hex($encrypt->encrypt($row['id_pekerja']));
        }

        $data = [
            'title' => 'Data Pekerja',
            'subtitle' => 'Tenaga Kerja Aktif',
            'data_pekerja' => $modelDataPekerjaAktif,
        ];
        return view('data_pekerja/data_pekerja', $data);
    }

    public function new(): string
    {
        session()->set('page', 'new');
        $modelDataPekerjaBaru = $this->dataPekerjaModel->joinDataPekerjaanBaru();
        $encrypt = \Config\Services::encrypter();

        foreach ($modelDataPekerjaBaru as &$row) {
            $row['id_pekerja_encrypted'] = bin2hex($encrypt->encrypt($row['id_pekerja']));
        }

        $data = [
            'title' => 'Data Pekerja',
            'subtitle' => 'Tenaga Kerja Baru',
            'data_pekerja' => $modelDataPekerjaBaru,
        ];
        return view('data_pekerja/data_pekerja', $data);
    }

    public function nonaktif(): string
    {
        session()->set('page', 'out');
        $modelDataPekerjaTidakAktif = $this->dataPekerjaModel->joinDataPekerjaanTidakAktif();
        $encrypt = \Config\Services::encrypter();
        foreach ($modelDataPekerjaTidakAktif as &$row) {
            $row['id_pekerja_encrypted'] = bin2hex($encrypt->encrypt($row['id_pekerja']));
        }
        $data = [
            'title' => 'Data Pekerja',
            'subtitle' => 'Tenaga Kerja Tidak Aktif',
            'data_pekerja' => $modelDataPekerjaTidakAktif,
        ];
        return view('data_pekerja/data_pekerja', $data);
    }

    // public function pensiun()
    // {
    //     session()->set('page', 'pensiun');
    //     $this->dataPekerjaModel->updateStatusPensiunOtomatis();

    //     $modelDataPekerjaPensiun = $this->dataPekerjaModel->joinDataPekerjaanPensiun();

    //     $encrypt = \Config\Services::encrypter();
    //     foreach ($modelDataPekerjaPensiun as &$row) {
    //         $row['id_pekerja_encrypted'] = bin2hex($encrypt->encrypt($row['id_pekerja']));
    //     }

    //     $tahun_cari = $this->request->getVar('tahun_cari');
    //     $data_pensiun = $this->dataPekerjaModel->getDataPensiun($tahun_cari);
    //     // Proses perhitungan tanggal pensiun
    //     foreach ($data_pensiun as &$p) {
    //         $tanggal_lahir = $p['tanggal_lahir'];
    //         $ulang_tahun_ke_58 = date('Y-m-d', strtotime('+58 years', strtotime($tanggal_lahir)));
    //         $p['tanggal_pensiun'] = date('Y-m-01', strtotime('+1 month', strtotime($ulang_tahun_ke_58)));
    //     }
    //     // dd($data_pensiun);

    //     $nama_bulan = [
    //         '01' => 'Januari',
    //         '02' => 'Februari',
    //         '03' => 'Maret',
    //         '04' => 'April',
    //         '05' => 'Mei',
    //         '06' => 'Juni',
    //         '07' => 'Juli',
    //         '08' => 'Agustus',
    //         '09' => 'September',
    //         '10' => 'Oktober',
    //         '11' => 'November',
    //         '12' => 'Desember'
    //     ];

    //     $data_bulanan = [];
    //     // Inisialisasi 12 bulan dengan default total 0
    //     foreach ($nama_bulan as $key => $nama) {
    //         $data_bulanan[$key] = [
    //             'nama_bulan' => $nama,
    //             'total' => 0,
    //             'data' => [],
    //         ];
    //     }

    //     // Kelompokkan data pensiun ke dalam array per bulan per tahun berdasar pada tanggal pensiun
    //     foreach ($data_pensiun as $pensiun) {
    //         $bulan = date('m', strtotime($pensiun['tanggal_pensiun']));
    //         $data_bulanan[$bulan]['total']++;
    //         $data_bulanan[$bulan]['data'][] = $pensiun;
    //     }

    //     $data = [
    //         'title' => 'Data Pekerja',
    //         'subtitle' => 'Tenaga Kerja Pensiun',
    //         'data_pekerja' => $modelDataPekerjaPensiun,
    //         'data_bulanan' => $data_bulanan,
    //         'tahun_cari' => $tahun_cari,
    //     ];
    //     return view('data_pekerja/data_pekerja', $data);
    // }

    public function pensiun()
    {
        session()->set('page', 'pensiun');
        $this->dataPekerjaModel->updateStatusPensiunOtomatis(); // Jika Anda punya logika update status
        $modelDataPekerjaPensiun = $this->dataPekerjaModel->joinDataPekerjaanPensiun();

        $encrypt = \Config\Services::encrypter();
        $tahun_cari = $this->request->getVar('tahun_cari');

        $data_pensiun = $this->dataPekerjaModel->getDataPensiun($tahun_cari);

        foreach ($data_pensiun as &$p) {
            $p['id_pekerja_encrypted'] = bin2hex($encrypt->encrypt($p['id_pekerja']));
        }

        $nama_bulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        $data_bulanan = [];
        foreach ($nama_bulan as $key => $nama) {
            $data_bulanan[$key] = [
                'nama_bulan' => $nama,
                'total' => 0,
                'data' => [],
            ];
        }

        foreach ($data_pensiun as $p) {
            $bulan = date('m', strtotime($p['tanggal_pensiun']));
            $data_bulanan[$bulan]['total']++;
            $data_bulanan[$bulan]['data'][] = $p;
        }

        $data = [
            'title' => 'Data Pekerja',
            'subtitle' => 'Tenaga Kerja Pensiun',
            'data_bulanan' => $data_bulanan,
            'tahun_cari' => $tahun_cari,
            'data_pekerja' => $modelDataPekerjaPensiun,
        ];

        return view('data_pekerja/data_pekerja', $data);
    }


    public function add(): string
    {
        $data = [
            'title' => 'Tambah Data Pekerja',
            'subtitle' => 'Tenaga Kerja',
            'unit_kerja' => $this->unitKerjaModel->findAll(),
            'pekerjaan' => $this->listPekerjaanModel->findAll(),
        ];
        return view('data_pekerja/add_pekerja', $data);
    }

    public function store()
    {
        session();
        $validation = \Config\Services::validation();
        if (!$this->validate(
            [
                'nik' => [
                    'rules' => 'required|is_unique[tb_data_pekerja.nik]',
                    'errors' => [
                        'required' => '{field} Harus Diisi',
                        'is_unique' => '{field} Sudah Terdaftar',
                    ],
                ],
                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus Diisi',
                    ],
                ],
                'tempat_lahir' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus Diisi',
                    ],
                ],
                'tanggal_lahir' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus Diisi',
                    ],
                ],
                'jenis_kelamin' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus Diisi',
                    ],
                ],
                'alamat' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus Diisi',
                    ],
                ],
                'rt_rw' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus Diisi',
                    ],
                ],
                'desa_kelurahan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus Diisi',
                    ],
                ],
                'kecamatan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus Diisi',
                    ],
                ],
                'kota' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus Diisi',
                    ],
                ],
                'provinsi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus Diisi',
                    ],
                ],
                'kode_pos' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus Diisi',
                    ],
                ],
                'pendidikan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus Diisi',
                    ],
                ],
                'jurusan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus Diisi',
                    ],
                ],
                'gelar_depan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus Diisi',
                    ],
                ],
                'gelar_belakang' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus Diisi',
                    ],
                ],
                'pekerjaan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus Diisi',
                    ],
                ],
                'jenis_pegawai' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus Diisi',
                    ],
                ],
                'unit_kerja' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus Diisi',
                    ],
                ],
                'tahun' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus Diisi',
                    ],
                ],
                'tmt_kerja' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus Diisi',
                    ],
                ],
                'tst_kerja' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus Diisi',
                    ],
                ],
                'ktp' => [
                    'rules' => 'uploaded[ktp]|max_size[ktp,2048]|ext_in[ktp,jpg,jpeg,png,pdf]',
                    'errors' => [
                        'uploaded' => '{field} Harus Diisi',
                        'max_size' => '{field} Maksimal 2MB',
                        'ext_in' => '{field} Harus JPG, JPEG, PNG, atau PDF',
                    ],
                ],
                'ijasah' => [
                    'rules' => 'uploaded[ijasah]|max_size[ijasah,2048]|ext_in[ijasah,jpg,jpeg,png,pdf]',
                    'errors' => [
                        'uploaded' => '{field} Harus Diisi',
                        'max_size' => '{field} Maksimal 2MB',
                        'ext_in' => '{field} Harus JPG, JPEG, PNG, atau PDF',
                    ],
                ],
            ]
        )) {
            session()->setFlashdata('error', $validation->listErrors());
            return redirect()->to('/data_pekerja/add')->withInput();
        }

        $autoID = "";
        $dateNow = date('ymd');
        $random_num = intval(mt_rand(0, 999999));
        $random_num_str = str_pad(strval($random_num), 6, '0', STR_PAD_LEFT);
        $autoID = 'PG' . $dateNow . $random_num_str;

        // Upload Handler
        $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        $maxSize = 2 * 1024 * 1024; // 2MB dalam bytes

        // === Upload KTP ===
        $ktp = $this->request->getFile('ktp');
        if ($ktp && $ktp->isValid() && !$ktp->hasMoved()) {
            if (in_array($ktp->getMimeType(), $allowedTypes) && $ktp->getSize() <= $maxSize) {

                $ktpFileName = 'KTP' . $autoID . $ktp->getRandomName();
                $ktp->move('assets/ktp', $ktpFileName);
                $dataTenagaKerja['ktp'] = $ktpFileName;
            } else {
                return redirect()->back()->withInput()->with('error', 'KTP harus berupa JPG, PNG, atau PDF dan maksimal 2MB.');
            }
        } else {
            $dataTenagaKerja['ktp'] = 'default.jpg';
        }

        // === Upload Ijazah ===
        $ijazah = $this->request->getFile('ijasah');
        if ($ijazah && $ijazah->isValid() && !$ijazah->hasMoved()) {
            if (in_array($ijazah->getMimeType(), $allowedTypes) && $ijazah->getSize() <= $maxSize) {

                $ijazahFileName = 'IJAZAH' . $autoID . $ijazah->getRandomName();
                $ijazah->move('assets/ijasah', $ijazahFileName);
                $dataTenagaKerja['ijasah'] = $ijazahFileName;
            } else {
                return redirect()->back()->withInput()->with('error', 'Ijazah harus berupa JPG, PNG, atau PDF dan maksimal 2MB.');
            }
        } else {
            $dataTenagaKerja['ijasah'] = 'default.jpg';
        }
        // End Upload Handler

        $dataTenagaKerja = [
            'id_pekerja' => $autoID,
            'nik' => $this->request->getPost('nik'),
            'nama' => $this->request->getPost('nama'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'alamat' => $this->request->getPost('alamat'),
            'rt/rw' => $this->request->getPost('rt_rw'),
            'desa/kelurahan' => $this->request->getPost('desa_kelurahan'),
            'kecamatan' => $this->request->getPost('kecamatan'),
            'kota_tinggal' => $this->request->getPost('kota'),
            'provinsi' => $this->request->getPost('provinsi'),
            'kode_pos' => $this->request->getPost('kode_pos'),
            'ktp' => $dataTenagaKerja['ktp'],
            'pendidikan' => $this->request->getPost('pendidikan'),
            'jurusan' => $this->request->getPost('jurusan'),
            'gelar_depan' => $this->request->getPost('gelar_depan'),
            'gelar_belakang' => $this->request->getPost('gelar_belakang'),
            'ijasah' => $dataTenagaKerja['ijasah'],
            'status_pekerja' => 'Menunggu',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $dataRiwayatKerja = [
            'id_pekerja' => $autoID,
            'id_nama_pekerjaan' => $this->request->getPost('pekerjaan'),
            'jenis_pegawai' => $this->request->getPost('jenis_pegawai'),
            'id_unit_kerja' => $this->request->getPost('unit_kerja'),
            'tahun' => $this->request->getPost('tahun'),
            'tmt_kerja' => $this->request->getPost('tmt_kerja'),
            'tst_kerja' => $this->request->getPost('tst_kerja'),
            'status' => 'Menunggu',
            'penginput' => session()->get('nama_lengkap'),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $insertDataPekerja = $this->dataPekerjaModel->insert($dataTenagaKerja);
        $insertRiwayatKerja = $this->riwayatKerjaModel->insert($dataRiwayatKerja);

        if (!$insertDataPekerja || !$insertRiwayatKerja) {
            session()->setFlashdata('error', 'Gagal Menyimpan Data');
            return redirect()->to('/data_pekerja/add')->withInput();
        } else {
            session()->setFlashdata('success', 'Data Berhasil Disimpan');
            return redirect()->to('/data_pekerja/new');
        }
    }

    public function edit($id)
    {
        $encrypt = \Config\Services::encrypter();
        $id_decrypt = $encrypt->decrypt(hex2bin($id));
        // dd($this->dataPekerjaModel->find($id_decrypt));
        $data = [
            'title' => 'Edit Data Pekerja',
            'subtitle' => 'Tenaga Kerja',
            'unit_kerja' => $this->unitKerjaModel->findAll(),
            'pekerjaan' => $this->listPekerjaanModel->findAll(),
            'pekerja' => $this->dataPekerjaModel->editDataPekerja($id_decrypt),
            'id_pekerja_decrypt' => $id,
        ];
        return view('data_pekerja/edit_pekerja', $data);
    }

    public function update($id)
    {
        $encrypt = \Config\Services::encrypter();
        $id_decrypt = $encrypt->decrypt(hex2bin($id));

        $validation = \Config\Services::validation();

        $rules = [
            'nik' => [
                'rules' => 'required',
                'errors' => ['required' => '{field} Harus Diisi'],
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => ['required' => '{field} Harus Diisi'],
            ],
            'tempat_lahir' => [
                'rules' => 'required',
                'errors' => ['required' => '{field} Harus Diisi'],
            ],
            'tanggal_lahir' => [
                'rules' => 'required',
                'errors' => ['required' => '{field} Harus Diisi'],
            ],
            'jenis_kelamin' => [
                'rules' => 'required',
                'errors' => ['required' => '{field} Harus Diisi'],
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => ['required' => '{field} Harus Diisi'],
            ],
            'rt_rw' => [
                'rules' => 'required',
                'errors' => ['required' => '{field} Harus Diisi'],
            ],
            'desa_kelurahan' => [
                'rules' => 'required',
                'errors' => ['required' => '{field} Harus Diisi'],
            ],
            'kecamatan' => [
                'rules' => 'required',
                'errors' => ['required' => '{field} Harus Diisi'],
            ],
            'kota' => [
                'rules' => 'required',
                'errors' => ['required' => '{field} Harus Diisi'],
            ],
            'provinsi' => [
                'rules' => 'required',
                'errors' => ['required' => '{field} Harus Diisi'],
            ],
            'kode_pos' => [
                'rules' => 'required',
                'errors' => ['required' => '{field} Harus Diisi'],
            ],
            'pendidikan' => [
                'rules' => 'required',
                'errors' => ['required' => '{field} Harus Diisi'],
            ],
            'jurusan' => [
                'rules' => 'required',
                'errors' => ['required' => '{field} Harus Diisi'],
            ],
            'gelar_depan' => [
                'rules' => 'required',
                'errors' => ['required' => '{field} Harus Diisi'],
            ],
            'gelar_belakang' => [
                'rules' => 'required',
                'errors' => ['required' => '{field} Harus Diisi'],
            ],
            'ktp' => [
                'rules' => 'max_size[ktp,2048]|ext_in[ktp,jpg,jpeg,png,pdf]',
                'errors' => [
                    'max_size' => '{field} Maksimal 2MB',
                    'ext_in' => '{field} Harus JPG, JPEG, PNG, atau PDF',
                ],
            ],
            'ijasah' => [
                'rules' => 'max_size[ijasah,2048]|ext_in[ijasah,jpg,jpeg,png,pdf]',
                'errors' => [
                    'max_size' => '{field} Maksimal 2MB',
                    'ext_in' => '{field} Harus JPG, JPEG, PNG, atau PDF',
                ],
            ],
        ];

        // Tambahkan rules tambahan jika halaman aktif
        if (session()->get('page') == 'new') {
            $rules = array_merge($rules, [
                'pekerjaan' => [
                    'rules' => 'required',
                    'errors' => ['required' => '{field} Harus Diisi'],
                ],
                'jenis_pegawai' => [
                    'rules' => 'required',
                    'errors' => ['required' => '{field} Harus Diisi'],
                ],
                'unit_kerja' => [
                    'rules' => 'required',
                    'errors' => ['required' => '{field} Harus Diisi'],
                ],
                'tahun' => [
                    'rules' => 'required',
                    'errors' => ['required' => '{field} Harus Diisi'],
                ],
                'tmt_kerja' => [
                    'rules' => 'required',
                    'errors' => ['required' => '{field} Harus Diisi'],
                ],
                'tst_kerja' => [
                    'rules' => 'required',
                    'errors' => ['required' => '{field} Harus Diisi'],
                ],
            ]);
        }

        // Proses validasi
        if (!$this->validate($rules)) {
            session()->setFlashdata('error', $validation->listErrors());
            return redirect()->to('/data_pekerja/edit/' . $id)->withInput();
        }


        // Upload Handler
        $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        $maxSize = 2 * 1024 * 1024; // 2MB dalam bytes

        // === Upload KTP ===
        $ktp = $this->request->getFile('ktp');
        if ($ktp && $ktp->isValid() && !$ktp->hasMoved()) {
            if (in_array($ktp->getMimeType(), $allowedTypes) && $ktp->getSize() <= $maxSize) {
                $ktpFileName = 'KTP' . $id_decrypt . $ktp->getRandomName();
                $ktp->move('assets/ktp', $ktpFileName);
                $dataTenagaKerja['ktp'] = $ktpFileName;
            } else {
                return redirect()->back()->withInput()->with('error', 'KTP harus berupa JPG, PNG, atau PDF dan maksimal 2MB.');
            }
        } else {
            // input file lama
            $dataTenagaKerja['ktp'] = $this->request->getPost('ktp_lama');
        }

        // === Upload Ijazah ===
        $ijazah = $this->request->getFile('ijasah');
        if ($ijazah && $ijazah->isValid() && !$ijazah->hasMoved()) {
            if (
                in_array($ijazah->getMimeType(), $allowedTypes) &&
                $ijazah->getSize() <= $maxSize
            ) {
                $ijazahFileName = 'IJAZAH' . $id_decrypt . $ijazah->getRandomName();
                $ijazah->move('assets/ijasah', $ijazahFileName);
                $dataTenagaKerja['ijasah'] = $ijazahFileName;
            } else {
                return redirect()->back()->withInput()->with('error', 'Ijazah harus berupa JPG, PNG, atau PDF dan maksimal 2MB.');
            }
        } else {
            // input file lama
            $dataTenagaKerja['ijasah'] = $this->request->getPost('ijasah_lama');
        }
        // End Upload Handler
        $existing = $this->dataPekerjaModel->find($id_decrypt);
        $nikBaru = $this->request->getPost('nik');

        // Cek jika NIK diubah, baru validasi unik
        if ($nikBaru != $existing['nik']) {
            $rules['nik'] = 'required|is_unique[pekerja.nik]';
        } else {
            $rules['nik'] = 'required';
        }
        // dd($dataTenagaKerja);
        $dataTenagaKerja = [
            'nik' => $nikBaru,
            'nama' => $this->request->getPost('nama'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'alamat' => $this->request->getPost('alamat'),
            'rt/rw' => $this->request->getPost('rt_rw'),
            'desa/kelurahan' => $this->request->getPost('desa_kelurahan'),
            'kecamatan' => $this->request->getPost('kecamatan'),
            'kota_tinggal' => $this->request->getPost('kota'),
            'provinsi' => $this->request->getPost('provinsi'),
            'kode_pos' => $this->request->getPost('kode_pos'),
            'pendidikan' => $this->request->getPost('pendidikan'),
            'jurusan' => $this->request->getPost('jurusan'),
            'gelar_depan' => $this->request->getPost('gelar_depan'),
            'gelar_belakang' => $this->request->getPost('gelar_belakang'),
            'updated_at' => date('Y-m-d H:i:s'),
            'ktp' => $dataTenagaKerja['ktp'],
            'ijasah' => $dataTenagaKerja['ijasah']
        ];

        $dataRiwayatKerja = [
            'id_nama_pekerjaan' => $this->request->getPost('pekerjaan'),
            'jenis_pegawai' => $this->request->getPost('jenis_pegawai'),
            'id_unit_kerja' => $this->request->getPost('unit_kerja'),
            'tahun' => $this->request->getPost('tahun'),
            'tmt_kerja' => $this->request->getPost('tmt_kerja'),
            'tst_kerja' => $this->request->getPost('tst_kerja'),
            'penginput' => session()->get('nama_lengkap'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $riwayat = $this->riwayatKerjaModel->where('id_pekerja', $id_decrypt)->first();

        if (session()->get('page') == 'new') {
            $update1 = $this->dataPekerjaModel->update($id_decrypt, $dataTenagaKerja);
            $update2 = $this->riwayatKerjaModel->update($riwayat['id'], $dataRiwayatKerja);
        } else {
            $update1 = $this->dataPekerjaModel->update($id_decrypt, $dataTenagaKerja);
            $update2 = true; // Tidak ada update riwayat kerja untuk halaman aktif
        }

        if (!$update1 || !$update2) {
            session()->setFlashdata('error', 'Data gagal diupdate');
            return redirect()->to('/data_pekerja/edit/' . $id)->withInput();
        } else {
            session()->setFlashdata('success', 'Data Tenaga Kerja Berhasil Diupdate');
            return redirect()->to(site_url('data_pekerja') . '/' . session()->get('page'));
        }
    }

    public function delete($id)
    {
        $encrypt = \Config\Services::encrypter();
        $id_decrypt = $encrypt->decrypt(hex2bin($id));

        $this->riwayatKerjaModel->where('id_pekerja', $id_decrypt)->delete();
        $this->dataPekerjaModel->delete($id_decrypt);

        session()->setFlashdata('success', 'Data Tenaga Kerja Berhasil Dihapus');
        return redirect()->to(site_url('data_pekerja') . '/' . session()->get('page'));
    }

    // detail
    public function detail($id)
    {
        $encrypt = \Config\Services::encrypter();
        $id_decrypt = $encrypt->decrypt(hex2bin($id));
        $data = [
            'title' => 'Detail Data Pekerja',
            'subtitle' => 'Tenaga Kerja',
            'pekerja' => $this->dataPekerjaModel->getDataPekerjaById($id_decrypt),
            'history' => $this->dataPekerjaModel->find($id_decrypt),
            'id_pekerja_encrypted' => $id,
        ];
        return view('data_pekerja/detail_pekerja', $data);
    }

    public function simpan_verifikasi($id)
    {
        $encrypt = \Config\Services::encrypter();
        $id_decrypt = $encrypt->decrypt(hex2bin($id));

        $status     = $this->request->getPost('status');
        $keterangan = $this->request->getPost('keterangan');

        $data = [
            'status_pekerja' => $status,
            'keterangan'     => $status == 'Terverifikasi' ? '' : $keterangan,
            'updated_at'     => date('Y-m-d H:i:s'),
        ];

        // Ambil riwayat kerja terakhir berdasarkan ID terbesar
        $riwayatKerja = $this->riwayatKerjaModel
            ->where('id_pekerja', $id_decrypt)
            ->where('deleted_at', null)
            ->orderBy('id', 'DESC')
            ->first();

        if ($status == 'Tidak Aktif') {
            //     if ($riwayatKerja) {
            //         $dataRiwayat = [
            //             'id_pekerja'        => $id_decrypt,
            //             'id_nama_pekerjaan' => $riwayatKerja['id_nama_pekerjaan'],
            //             'jenis_pegawai'     => $riwayatKerja['jenis_pegawai'],
            //             'id_unit_kerja'     => $riwayatKerja['id_unit_kerja'],
            //             'tahun'             => $riwayatKerja['tahun'],
            //             'tmt_kerja'         => date('Y-m-d'),
            //             'tst_kerja'         => date('Y') . '-12-31',
            //             'status'            => 'Terverifikasi',
            //             'penginput'         => 'Admin',
            //             'created_at'        => date('Y-m-d H:i:s'),
            //         ];
            //         $this->riwayatKerjaModel->insert($dataRiwayat);
            //     }
            // } else {
            if ($riwayatKerja) {
                $this->riwayatKerjaModel->update($riwayatKerja['id'], [
                    'tst_kerja' => date('Y-m-d'),
                ]);
            }
        }

        $update = $this->dataPekerjaModel->update($id_decrypt, $data);

        if ($update) {
            session()->setFlashdata('success', 'Data Tenaga Kerja Berhasil Diverifikasi');
            return redirect()->to(site_url('data_pekerja') . '/' . session()->get('page'));
        } else {
            session()->setFlashdata('error', 'Data gagal diupdate');
            return redirect()->to('/data_pekerja/detail/' . $id)->withInput();
        }
    }


    public function cetak_usulan($id_encrypted)
    {
        $encrypt = \Config\Services::encrypter();
        $id_decrypt = $encrypt->decrypt(hex2bin($id_encrypted));

        $riwayatKerja = $this->riwayatKerjaModel->where('id_pekerja', $id_decrypt)->first();
        // jika id_unit_kerja ditemukan maka ambil jabatan, nama_unit_kerja, dan nama_kepala
        if ($riwayatKerja) {
            $id_unit_kerja = $riwayatKerja['id_unit_kerja'];
            $unitKerja = $this->unitKerjaModel->where('id_unit_kerja', $id_unit_kerja)->first();
            if ($unitKerja) {
                // $jabatan = $unitKerja['jabatan'];
                $nama_unit_kerja = $unitKerja['unit_kerja'];
                $kepalaUnit = $this->daftarKepalaModel->where('id_unit_kerja', $id_unit_kerja)->first();
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
                $jabatan = 'Tidak Ditemukan';
                $nama_unit_kerja = 'Tidak Ditemukan';
                $nama_kepala = 'Tidak Ditemukan';
            }
        } else {
            session()->setFlashdata('error', 'Data Riwayat Kerja tidak ditemukan');
            return redirect()->to('/data_pekerja/detail/' . $id_encrypted)->withInput();
        }

        $data = [
            'title' => 'Usulan Pekerja',
            'subtitle' => 'Tenaga Kerja',
            'pekerja' => $this->dataPekerjaModel->getDataPekerjaById($id_decrypt),
            'riwayat' => $this->riwayatKerjaModel->getRiwayatKerjaById($id_decrypt),
            'id_pekerja_encrypted' => $id_encrypted,
            'jabatan' => $jabatan,
            'nama_unit_kerja' => $nama_unit_kerja,
            'nama_kepala' => $nama_kepala,
            'nip' => $nip,
        ];
        return view('data_pekerja/cetak_usulan_pekerja_baru', $data);
    }

    // import excel simpan method data pekerja dan riwayat kerja 
    public function import_excel_pekerja()
    {
        $autoID = "";
        $dateNow = date('ymd');
        $random_num = intval(mt_rand(0, 999999));
        $random_num_str = str_pad(strval($random_num), 6, '0', STR_PAD_LEFT);
        $autoID = 'PG' . $dateNow . $random_num_str;

        $file = $this->request->getFile('file_excel');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $path = 'uploads/excel/data_pekerja/' . $newName;
            $file->move('uploads/excel/data_pekerja/', $newName);
            $spreadsheet = IOFactory::load($path);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            foreach ($sheetData as $data => $row) {
                // Skip header row
                if ($data == 0) {
                    continue;
                }
                // skip nik yang sudah ada
                $nik = $row[1];
                $existing = $this->dataPekerjaModel->where('nik', $nik)->first();
                if ($existing) {
                    continue;
                }
                // Check if the row is empty
                if (empty($row[1] && $row[2] && $row[3] && $row[4] && $row[5] && $row[6] && $row[7] && $row[8] && $row[9] && $row[10] && $row[11] && $row[12] && $row[13])) {
                    continue;
                }

                // handle tanggal lahir menjadi format Y-m-d dengan trim
                $tanggalLahir = trim($row[4]);
                $tanggalLahirOk = strtotime($tanggalLahir);
                if ($tanggalLahirOk) {
                    $tanggalLahir = date('Y-m-d', $tanggalLahirOk);
                } else {
                    $tanggalLahir = null;
                }

                // Prepare data for insertion
                $dataTenagaKerja = [
                    'id_pekerja' => $autoID,
                    'nik' => $row[1],
                    'nama' => $row[2],
                    'tempat_lahir' => $row[3],
                    'tanggal_lahir' => $tanggalLahir,
                    'jenis_kelamin' => $row[5],
                    'alamat' => $row[6],
                    'pendidikan' => $row[7],
                    'jurusan' => $row[8],
                    'gelar_depan' => $row[9],
                    'gelar_belakang' => $row[10],
                    'status_pekerja' => 'Terverifikasi',
                    'created_at' => date('Y-m-d H:i:s'),
                ];

                // cocokan isi dari row[11] dengan id_nama_pekerjaan 
                $pekerjaan = $this->listPekerjaanModel->where('pekerjaan', $row[11])->first();
                if ($pekerjaan) {
                    $dataTenagaKerja['id_nama_pekerjaan'] = $pekerjaan['id_nama_pekerjaan'];
                } else {
                    $dataTenagaKerja['id_nama_pekerjaan'] = null;
                }

                // cocokan isi dari row[13] dengan id_unit_kerja
                $unitKerja = $this->unitKerjaModel->where('unit_kerja', $row[13])->first();
                if ($unitKerja) {
                    $dataTenagaKerja['id_unit_kerja'] = $unitKerja['id_unit_kerja'];
                } else {
                    $dataTenagaKerja['id_unit_kerja'] = null;
                }

                $dataRiwayatKerja = [
                    'id_pekerja' => $autoID,
                    'id_nama_pekerjaan' => $dataTenagaKerja['id_nama_pekerjaan'],
                    'jenis_pegawai' => $row[12],
                    'id_unit_kerja' => $dataTenagaKerja['id_unit_kerja'],
                    'tahun' => date('Y'),
                    'tmt_kerja' => date('Y') . '-01-01',
                    'tst_kerja' => date('Y') . '-12-31',
                    'status' => 'Terverifikasi',
                    'penginput' => session()->get('nama_lengkap'),
                    'created_at' => date('Y-m-d H:i:s'),
                ];

                // dd($dataTenagaKerja, $dataRiwayatKerja);
                // Insert data into the database
                $this->dataPekerjaModel->insert($dataTenagaKerja);
                $this->riwayatKerjaModel->insert($dataRiwayatKerja);

                // Update autoID for the next row
                $autoID = 'PG' . date('ymd') . str_pad(strval(intval(substr($autoID, -6)) + 1), 6, '0', STR_PAD_LEFT);
            }

            session()->setFlashdata('success', 'Data Pekerja Berhasil Diimpor');
            return redirect()->to('/data_pekerja/aktif');
        } else {
            session()->setFlashdata('error', 'File tidak valid atau sudah dipindahkan');
            return redirect()->to('/data_pekerja/import')->withInput();
        }
    }

    // download template excel
    public function download_template()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template');

        // Set header
        $headers = [
            'NO',
            'NIK',
            'NAMA',
            'TEMPAT LAHIR',
            'TANGGAL LAHIR',
            'JENIS KELAMIN',
            'ALAMAT',
            'PENDIDIKAN',
            'JURUSAN',
            'GELAR DEPAN',
            'GELAR BELAKANG',
            'PEKERJAAN',
            'JENIS PEGAWAI',
            'UNIT KERJA'
        ];
        $columnIndex = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($columnIndex . '1', $header);
            $columnIndex++;
        }

        // Style header
        $sheet->getStyle('A1:N1')->getFont()->setBold(true)->setSize(12)->setName('Arial');
        $sheet->getStyle('A1:N1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:N1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Ambil data dropdown
        $pekerjaanList = array_column($this->listPekerjaanModel->findAll(), 'pekerjaan');
        $unitKerjaList = array_filter(
            array_column($this->unitKerjaModel->findAll(), 'unit_kerja'),
            fn($u) => $u != 'Dinas Lingkungan Hidup'
        );
        $pendidikanOptions = ['SD', 'SMP', 'SMA', 'SMK', 'D3', 'S1', 'S2', 'S3'];
        $jenisKelaminOptions = ['L', 'P'];
        $jenisPegawaiOptions = ['Kontrak Dinas', 'Kontrak Walikota'];

        // Tambah sheet untuk dropdown
        $dropdownSheet = $spreadsheet->createSheet();
        $dropdownSheet->setTitle('Dropdowns');

        // Helper untuk menulis ke dropdown sheet
        $writeListToSheet = function ($sheet, $col, $rowStart, $label, $data) {
            $sheet->setCellValue($col . '1', $label);
            foreach ($data as $i => $value) {
                $sheet->setCellValue($col . ($rowStart + $i), $value);
            }
        };

        $writeListToSheet($dropdownSheet, 'A', 2, 'Jenis Kelamin', $jenisKelaminOptions);
        $writeListToSheet($dropdownSheet, 'B', 2, 'Pendidikan', $pendidikanOptions);
        $writeListToSheet($dropdownSheet, 'C', 2, 'Pekerjaan', $pekerjaanList);
        $writeListToSheet($dropdownSheet, 'D', 2, 'Jenis Pegawai', $jenisPegawaiOptions);
        $writeListToSheet($dropdownSheet, 'E', 2, 'Unit Kerja', $unitKerjaList);

        // Sembunyikan sheet dropdown
        $dropdownSheet->setSheetState(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::SHEETSTATE_HIDDEN);

        // Range validasi
        $startRow = 2;
        $endRow = 900;

        for ($row = $startRow; $row <= $endRow; $row++) {
            // Lebar kolom
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(25);
            $sheet->getColumnDimension('C')->setWidth(20);
            $sheet->getColumnDimension('D')->setWidth(20);
            $sheet->getColumnDimension('E')->setWidth(20);
            $sheet->getColumnDimension('F')->setWidth(20);
            $sheet->getColumnDimension('G')->setWidth(30);
            $sheet->getColumnDimension('H')->setWidth(15);
            $sheet->getColumnDimension('I')->setWidth(20);
            $sheet->getColumnDimension('J')->setWidth(20);
            $sheet->getColumnDimension('K')->setWidth(25);
            $sheet->getColumnDimension('L')->setWidth(20);
            $sheet->getColumnDimension('M')->setWidth(20);
            $sheet->getColumnDimension('N')->setWidth(20);

            // TANGGAL LAHIR - E
            $sheet->getCell('E' . $row)->getDataValidation()
                ->setType(DataValidation::TYPE_DATE)
                ->setAllowBlank(true)
                ->setShowErrorMessage(true);

            // JENIS KELAMIN - F
            $sheet->getCell('F' . $row)->getDataValidation()
                ->setType(DataValidation::TYPE_LIST)
                ->setFormula1('=Dropdowns!$A$2:$A$' . (count($jenisKelaminOptions) + 1))
                ->setShowDropDown(true)
                ->setAllowBlank(true);

            // PENDIDIKAN - H
            $sheet->getCell('H' . $row)->getDataValidation()
                ->setType(DataValidation::TYPE_LIST)
                ->setFormula1('=Dropdowns!$B$2:$B$' . (count($pendidikanOptions) + 1))
                ->setShowDropDown(true)
                ->setAllowBlank(true);

            // PEKERJAAN - L
            $sheet->getCell('L' . $row)->getDataValidation()
                ->setType(DataValidation::TYPE_LIST)
                ->setFormula1('=Dropdowns!$C$2:$C$' . (count($pekerjaanList) + 1))
                ->setShowDropDown(true)
                ->setAllowBlank(true);

            // JENIS PEGAWAI - M
            $sheet->getCell('M' . $row)->getDataValidation()
                ->setType(DataValidation::TYPE_LIST)
                ->setFormula1('=Dropdowns!$D$2:$D$' . (count($jenisPegawaiOptions) + 1))
                ->setShowDropDown(true)
                ->setAllowBlank(true);

            // UNIT KERJA - N
            $sheet->getCell('N' . $row)->getDataValidation()
                ->setType(DataValidation::TYPE_LIST)
                ->setFormula1('=Dropdowns!$E$2:$E$' . (count($unitKerjaList) + 1))
                ->setShowDropDown(true)
                ->setAllowBlank(true);
        }

        // Proteksi (opsional)
        $sheet->getStyle('A2:N900')->getProtection()->setLocked(Protection::PROTECTION_UNPROTECTED);
        $sheet->getStyle('A1:N1')->getProtection()->setLocked(Protection::PROTECTION_PROTECTED);
        $sheet->getProtection()->setSheet(true);

        // Unduh
        $filename = 'Template_Input_Tenaga_Kerja.xlsx';
        $writer = new Xlsx($spreadsheet);
        $response = response();
        $response->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->setHeader('Content-Disposition', 'attachment;filename="' . $filename . '"');
        $response->setHeader('Cache-Control', 'max-age=0');

        $temp_file = tempnam(sys_get_temp_dir(), $filename);
        $writer->save($temp_file);
        return $response->download($temp_file, null)->setFileName($filename);
    }

    public function ajaxDetailPensiun()
    {
        // $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        // Ambil semua data pekerja yang akan pensiun di tahun ini
        $data_pensiun = $this->dataPekerjaModel->getDataPensiun($tahun);

        // $filtered = [];

        // foreach ($data_pensiun as $p) {
        //     $tanggal_lahir = $p['tanggal_lahir'];

        //     $tahun_lahir = date('Y', strtotime($tanggal_lahir));
        //     $bulan_lahir = date('m', strtotime($tanggal_lahir));

        //     $tahun_pensiun = $tahun_lahir + 58;
        //     $bulan_pensiun = (int)$bulan_lahir + 1;
        //     if ($bulan_pensiun > 12) {
        //         $bulan_pensiun = 1;
        //         $tahun_pensiun += 1;
        //     }

        //     $tanggal_pensiun = date('Y-m-d', strtotime("{$tahun_pensiun}-{$bulan_pensiun}-01"));
        //     $p['tanggal_pensiun'] = $tanggal_pensiun;

        //     // if ($bulan_lahir == $bulan && $tahun_pensiun == $tahun) {
        //     $filtered[] = $p;
        //     // }
        // }


        // dd($filtered);
        // Urutkan berdasarkan tanggal pensiun
        usort($data_pensiun, function ($a, $b) {
            return strtotime($a['tanggal_pensiun']) - strtotime($b['tanggal_pensiun']);
        });
        return view('data_pekerja/ajax_detail_pensiun', ['data' => $data_pensiun]);
    }
}
