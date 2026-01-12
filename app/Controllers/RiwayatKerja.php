<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\Style\Protection;


class RiwayatKerja extends BaseController
{
    public function __construct()
    {
        $this->dataPekerjaModel = new \App\Models\DataPekerjaModel();
        $this->riwayatKerjaModel = new \App\Models\RiwayatKerjaModel();
        $this->unitKerjaModel = new \App\Models\UnitKerjaModel();
        $this->listPekerjaanModel = new \App\Models\ListPekerjaanModel();
    }

    public function riwayat($id)
    {
        $encrypt = \Config\Services::encrypter();
        $id_decrypt = $encrypt->decrypt(hex2bin($id));

        $data = [
            'title' => 'Riwayat Pekerja',
            'subtitle' => 'Tenaga Kerja',
            'pekerja' => $this->dataPekerjaModel->getDataPekerjaById($id_decrypt),
            'riwayat' => $this->riwayatKerjaModel->getRiwayatKerjaById($id_decrypt),
            'id_pekerja_encrypted' => $id,
        ];
        return view('riwayat_kerja/riwayat_pekerja', $data);
    }

    public function add($id)
    {
        $encrypt = \Config\Services::encrypter();
        $id_pekerja = $encrypt->decrypt(hex2bin($id));
        $data = [
            'title' => 'Riwayat Pekerja',
            'subtitle' => 'Riwayat Kerja',
            'id_pekerja_encrypted' => $id,
            'pekerjaan' => $this->listPekerjaanModel->findAll(),
            'unit_kerja' => $this->unitKerjaModel->findAll(),
            'pekerja' => $this->dataPekerjaModel->getDataPekerjaById($id_pekerja),
        ];
        return view('riwayat_kerja/add_riwayat_kerja', $data);
    }

    public function store($id)
    {
        $validasi = \Config\Services::validation();
        $validasi->setRules([
            'tmt_kerja' => [
                'label' => 'TMT Kerja',
                'rules' => 'required|valid_date[Y-m-d]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'valid_date' => '{field} tidak valid',
                ],
            ],
            'pekerjaan' => [
                'label' => 'Pekerjaan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ],
            ],
            'unit_kerja' => [
                'label' => 'Unit Kerja',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ],
            ],
            'gaji' => [
                'label' => 'Gaji',
                'rules' => 'required|numeric',
                'errors' => [
                    'numeric' => '{field} harus berupa angka',
                    'required' => '{field} tidak boleh kosong',
                ],
            ],
            'uraian_pekerjaan' => [
                'label' => 'Uraian Pekerjaan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ],
            ],
        ]);
        if (!$this->validate($validasi->getRules())) {
            return redirect()->back()->withInput()->with('error', $validasi->listErrors());
        }

        $encrypt = \Config\Services::encrypter();
        $id_pekerja = $encrypt->decrypt(hex2bin($id));

        $tmtBaru = date('Y-m-d', strtotime($this->request->getVar('tmt_kerja')));
        $tahunBaru = date('Y', strtotime($tmtBaru));
        $pekerjaanBaru = $this->request->getVar('pekerjaan');
        $unitKerjaBaru = $this->request->getVar('unit_kerja');

        // Ambil semua riwayat kerja pada tahun yang sama
        $riwayatTahunSama = $this->riwayatKerjaModel
            ->where('id_pekerja', $id_pekerja)
            ->where('YEAR(tmt_kerja)', $tahunBaru)
            ->where('status', 'Terverifikasi')
            ->orderBy('tmt_kerja', 'DESC')
            ->first();

        // Cek apakah pekerjaan atau unit kerja berbeda dalam tahun yang sama
        if ($riwayatTahunSama) {
            if ($riwayatTahunSama['id_nama_pekerjaan'] != $pekerjaanBaru || $riwayatTahunSama['id_unit_kerja'] != $unitKerjaBaru) {
                // Update tst_kerja lama menjadi satu hari sebelum tmt baru
                $tstBaru = date('Y-m-d', strtotime($tmtBaru . ' -1 day'));
                $this->riwayatKerjaModel->update($riwayatTahunSama['id'], [
                    'tst_kerja' => $tstBaru,
                    'status' => 'Tidak Aktif',
                    'updated_at' => date('Y-m-d H:i:s'),
                    'penginput' => session()->get('nama_lengkap'),
                ]);
            } else {
                // Jika pekerjaan atau unit kerja sama, tidak perlu menambah riwayat baru
                session()->setFlashdata('error', 'Pekerjaan atau unit kerja sudah ada pada tahun ini.');
                return redirect()->to('/riwayat_kerja/riwayat/' . $id);
            }
        }

        // jika sudah ada riwayat kerja dengan status menunggu maka tidak bisa input lagi
        $riwayatMenunggu = $this->riwayatKerjaModel
            ->where('id_pekerja', $id_pekerja)
            ->where('status', 'Menunggu')
            ->orderBy('tmt_kerja', 'DESC')
            ->first();
        if ($riwayatMenunggu) {
            session()->setFlashdata('error', 'Pekerja sudah memiliki riwayat kerja yang menunggu verifikasi.');
            return redirect()->to('/riwayat_kerja/riwayat/' . $id);
        }

        // Cek jika user yang menginput dengan level user maka status menjadi menunggu verifikasi
        if (session()->get('level') == 'user') {
            $status = 'Menunggu';
        } else {
            $status = 'Terverifikasi';
        }

        // Simpan data baru
        $data = [
            'id_pekerja' => $id_pekerja,
            'id_nama_pekerjaan' => $pekerjaanBaru,
            'id_unit_kerja' => $unitKerjaBaru,
            'tmt_kerja' => $tmtBaru,
            'tst_kerja' => date('Y-m-d', strtotime($this->request->getVar('tst_kerja'))),
            'tahun' => $this->request->getVar('tahun'),
            'jenis_pegawai' => $this->request->getVar('jenis_pegawai'),
            'status' => ($this->request->getVar('tahun') < date('Y')) ? 'Tidak Aktif' : $status,
            'gaji' => $this->request->getVar('gaji'),
            'uraian_pekerjaan' => $this->request->getVar('uraian_pekerjaan'),
            'created_at' => date('Y-m-d H:i:s'),
            'penginput' => session()->get('nama_lengkap'),
        ];

        if ($this->riwayatKerjaModel->insert($data)) {
            session()->setFlashdata('success', 'Data riwayat kerja berhasil ditambahkan');
        } else {
            session()->setFlashdata('error', 'Data riwayat kerja gagal ditambahkan');
        }

        return redirect()->to('/riwayat_kerja/riwayat/' . $id);
    }

    public function hapus()
    {
        $encrypt = \Config\Services::encrypter();
        $id = $this->request->getPost('id');
        $target = $this->request->getPost('target');

        $model = new \App\Models\RiwayatKerjaModel();
        $data = $model->find($id);

        $id_pekerja_encrypted = bin2hex($encrypt->encrypt($data['id_pekerja']));

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        if ($target === 'spt' && $data['sk_spt']) {
            @unlink(FCPATH . 'uploads/spt/' . $data['sk_spt']);
            $model->update($id, ['sk_spt' => null]);
            return redirect()->back()->with('success', 'File SPT berhasil dihapus.');
        }

        if ($target === 'pks' && $data['sk_pks']) {
            @unlink(FCPATH . 'uploads/pks/' . $data['sk_pks']);
            $model->update($id, ['sk_pks' => null]);
            return redirect()->back()->with('success', 'File PKS berhasil dihapus.');
        }

        if ($target === 'all') {
            if ($data['sk_spt']) @unlink(FCPATH . 'uploads/spt/' . $data['sk_spt']);
            if ($data['sk_pks']) @unlink(FCPATH . 'uploads/pks/' . $data['sk_pks']);
            $model->delete($id);
            return redirect()->to('/riwayat_kerja/riwayat/' . $id_pekerja_encrypted)->with('success', 'Data riwayat pekerjaan berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Permintaan tidak valid.');
    }

    // download template for riwayat kerja
    public function download_template()
    {
        // ambil id dan nama pekerja dari database kemudian tampilkan semua di excel
        $pekerja = $this->dataPekerjaModel->joinDataPekerjaanAktif();
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'ID Pekerja');
        $sheet->setCellValue('C1', 'Nama Pekerja');
        $sheet->setCellValue('D1', 'Pekerjaan');
        $sheet->setCellValue('E1', 'Unit Kerja');
        $sheet->setCellValue('F1', 'TMT Kerja');
        $sheet->setCellValue('G1', 'TST Kerja');
        $sheet->setCellValue('H1', 'Jenis Pegawai');
        $sheet->setCellValue('I1', 'Tahun');
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:I1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A1:I1')->getFont()->setSize(12);
        $sheet->getStyle('A1:I1')->getFont()->setName('Arial');

        $sheet->getStyle('A1:I900')
            ->getProtection()
            ->setLocked(Protection::PROTECTION_UNPROTECTED);

        // protect first column
        $sheet->getStyle('A1:I1')->getProtection()->setLocked(Protection::PROTECTION_PROTECTED);

        $row = 2;
        foreach ($pekerja as $item) {
            $sheet->setCellValue('A' . $row, $row - 1);
            $sheet->setCellValue('B' . $row, $item['id_pekerja']);
            $sheet->setCellValue('C' . $row, $item['nama']);
            $sheet->setCellValue('D' . $row, $item['pekerjaan']);
            $sheet->setCellValue('E' . $row, $item['unit_kerja']);
            $sheet->setCellValue('F' . $row, ''); // TMT Kerja
            $sheet->setCellValue('G' . $row, ''); // TST Kerja
            $sheet->setCellValue('H' . $row, ''); // Jenis Pegawai
            $sheet->setCellValue('I' . $row, ''); // Tahun
            $sheet->getStyle('A' . $row . ':I' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A' . $row . ':I' . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('A' . $row . ':I' . $row)->getFont()->setSize(12);
            $sheet->getStyle('A' . $row . ':I' . $row)->getFont()->setName('Arial');
            $sheet->getRowDimension($row)->setRowHeight(20);
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(25);
            $sheet->getColumnDimension('D')->setWidth(20);
            $sheet->getColumnDimension('E')->setWidth(20);
            $sheet->getColumnDimension('F')->setWidth(15);
            $sheet->getColumnDimension('G')->setWidth(15);
            $sheet->getColumnDimension('H')->setWidth(15);
            $sheet->getColumnDimension('I')->setWidth(10);

            // LOCK hanya kolom tertentu
            $sheet->getStyle('B' . $row)->getProtection()->setLocked(Protection::PROTECTION_PROTECTED);
            $sheet->getStyle('C' . $row)->getProtection()->setLocked(Protection::PROTECTION_PROTECTED);
            $sheet->getStyle('I' . $row)->getProtection()->setLocked(Protection::PROTECTION_PROTECTED);

            // buat dropdown isian unit kerja dan pekerjaan pada kolom D dan E
            $pekerjaanList = $this->listPekerjaanModel->findAll();
            $pekerjaanOptions = [];
            foreach ($pekerjaanList as $pekerjaan) {
                $pekerjaanOptions[] = $pekerjaan['pekerjaan'];
            }
            $pekerjaanOptions = implode(',', $pekerjaanOptions);
            $sheet->getCell('D' . $row)->setDataValidation(
                (new \PhpOffice\PhpSpreadsheet\Cell\DataValidation())
                    ->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST)
                    ->setAllowBlank(true)
                    ->setFormula1('"' . $pekerjaanOptions . '"')
                    ->setShowDropDown(true)
            );
            $unitKerjaList = $this->unitKerjaModel->findAll();
            $unitKerjaOptions = [];
            foreach ($unitKerjaList as $unitKerja) {
                if ($unitKerja['unit_kerja'] == 'Dinas Lingkungan Hidup') {
                    continue; // Skip Dinas Lingkungan Hidup
                }
                $unitKerjaOptions[] = $unitKerja['unit_kerja'];
            }
            $unitKerjaOptions = implode(',', $unitKerjaOptions);
            $sheet->getCell('E' . $row)->setDataValidation(
                (new \PhpOffice\PhpSpreadsheet\Cell\DataValidation())
                    ->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST)
                    ->setAllowBlank(true)
                    ->setFormula1('"' . $unitKerjaOptions . '"')
                    ->setShowDropDown(true)
            );
            $sheet->getCell('F' . $row)->setDataValidation(
                (new \PhpOffice\PhpSpreadsheet\Cell\DataValidation())
                    ->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_DATE)
                    ->setAllowBlank(true)
                    ->setShowDropDown(true)
            );
            $sheet->getCell('G' . $row)->setDataValidation(
                (new \PhpOffice\PhpSpreadsheet\Cell\DataValidation())
                    ->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_DATE)
                    ->setAllowBlank(true)
                    ->setShowDropDown(true)
            );
            $sheet->getCell('H' . $row)->setDataValidation(
                (new \PhpOffice\PhpSpreadsheet\Cell\DataValidation())
                    ->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST)
                    ->setAllowBlank(true)
                    ->setFormula1('"Kontak Dinas,Kontak Walikota"')
                    ->setShowDropDown(true)
            );
            $sheet->setCellValue('I' . $row, '=YEAR(F' . $row . ')');

            $row++;
        }

        // 2. Setelah foreach selesai, barulah aktifkan proteksi sheet
        $sheet->getProtection()->setSheet(true);
        $sheet->getProtection()->setPassword('sayatahu');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'template_riwayat_kerja.xlsx';
        $filePath = 'template/' . $fileName;
        $writer->save($filePath);

        return $this->response->download($filePath, null)->setFileName($fileName);
    }

    public function import_excel()
    {
        $file = $this->request->getFile('file_excel_riwayat');
        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid atau tidak ditemukan.');
        }

        $sheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getTempName())->getActiveSheet();
        $data = [];

        foreach ($sheet->getRowIterator(2) as $row) {
            $rowData = [];
            foreach ($row->getCellIterator() as $cell) {
                $rowData[] = $cell->getFormattedValue();
            }
            // jika data tidak lengkap dan excel tidak sesuai template, abaikan baris ini
            if (empty($rowData[1]) || empty($rowData[3]) || empty($rowData[4]) || empty($rowData[5]) || empty($rowData[6]) || empty($rowData[7])) {
                continue;
            }

            // jika id pekerja tidak ditemukan, abaikan baris ini
            $idPekerja = $this->dataPekerjaModel->where('id_pekerja', $rowData[1])->first();
            if (!$idPekerja) {
                continue;
            }

            // jika data sudah ada, abaikan baris ini
            $existingData = $this->riwayatKerjaModel->where('id_pekerja', $rowData[1])
                ->where('id_nama_pekerjaan', $this->listPekerjaanModel->where('pekerjaan', $rowData[3])->first()['id_nama_pekerjaan'])
                ->where('id_unit_kerja', $this->unitKerjaModel->where('unit_kerja', $rowData[4])->first()['id_unit_kerja'])
                ->where('tahun', $rowData[8])
                ->where('jenis_pegawai', $rowData[7])
                ->first();

            if ($existingData) {
                continue;
            }
            $data[] = [
                'id_pekerja' => $rowData[1],
                'id_nama_pekerjaan' => $this->listPekerjaanModel->where('pekerjaan', $rowData[3])->first()['id_nama_pekerjaan'],
                'id_unit_kerja' => $this->unitKerjaModel->where('unit_kerja', $rowData[4])->first()['id_unit_kerja'],
                'tmt_kerja' => date('Y-m-d', strtotime($rowData[5])),
                'tst_kerja' => date('Y-m-d', strtotime($rowData[6])),
                'jenis_pegawai' => $rowData[7],
                'tahun' => $rowData[8],
                'status' => 'Tidak Aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'penginput' => session()->get('nama_lengkap'),
            ];
        }

        if (empty($data)) {
            return redirect()->back()->with('error', 'Tidak ada data yang valid untuk diimpor.');
        }
        $this->riwayatKerjaModel->insertBatch($data);
        session()->setFlashdata('success', 'Data riwayat kerja berhasil diimpor');
        return redirect()->to('/data_pekerja/aktif');
    }

    public function upload()
    {
        $id = $this->request->getPost('id_riwayat');
        $type = $this->request->getPost('type');
        $file = $this->request->getFile('fileUpload');

        // Validasi input
        if (!$file->isValid() || !$id || !$type || !in_array($type, ['spt', 'pks'])) {
            return redirect()->back()->with('error', 'Upload gagal! Data tidak valid.');
        }

        // Tentukan direktori dan nama kolom berdasarkan tipe
        $uploadPath = WRITEPATH . '../public/uploads/' . $type;
        $fieldName = ($type === 'spt') ? 'sk_spt' : 'sk_pks';

        // Generate nama file unik
        $newName = $file->getRandomName();

        // Pindahkan file
        if (!$file->move($uploadPath, $newName)) {
            return redirect()->back()->with('error', 'Upload gagal! Tidak bisa menyimpan file.');
        }

        // Update database
        $riwayatModel = new \App\Models\RiwayatKerjaModel();
        $riwayatModel->update($id, [
            $fieldName => $newName
        ]);

        return redirect()->back()->with('success', strtoupper($type) . ' berhasil diunggah.');
    }

    public function detail($id)
    {
        $encrypt = \Config\Services::encrypter();
        $id_riwayat = $encrypt->decrypt(hex2bin($id));
        $riwayat = $this->riwayatKerjaModel->find($id_riwayat);

        if (!$riwayat) {
            return redirect()->back()->with('error', 'Data riwayat kerja tidak ditemukan.');
        }

        $data = [
            'title' => 'Detail Riwayat Kerja',
            'subtitle' => 'Riwayat Kerja',
            'riwayat' => $riwayat,
            'pekerja' => $this->dataPekerjaModel->getDataPekerjaById($riwayat['id_pekerja']),
            'pekerjaan' => $this->listPekerjaanModel->find($riwayat['id_nama_pekerjaan']),
            'unit_kerja' => $this->unitKerjaModel->find($riwayat['id_unit_kerja']),
            'id_riwayat_encrypted' => $id,
        ];
        return view('riwayat_kerja/detail_riwayat', $data);
    }

    public function input_gaji_uraian()
    {
        $idRiwayat = $this->request->getPost('id_riwayat');
        $gaji = $this->request->getPost('gaji');
        $uraianPekerjaan = $this->request->getPost('uraian_pekerjaan');

        // Validasi sederhana
        if (!$idRiwayat || !$gaji || !$uraianPekerjaan) {
            return redirect()->back()->with('error', 'Semua data wajib diisi.');
        }

        // Update data gaji dan uraian pekerjaan ke tabel riwayat kerja
        $this->riwayatKerjaModel->update($idRiwayat, [
            'gaji' => $gaji,
            'uraian_pekerjaan' => $uraianPekerjaan
        ]);

        return redirect()->back()->with('success', 'Data gaji dan uraian kerja berhasil disimpan.');
    }

    public function getGajiUraian()
    {
        $idRiwayat = $this->request->getPost('id_riwayat');
        $riwayat = $this->riwayatKerjaModel->find($idRiwayat);

        if (!$riwayat) {
            return $this->response->setJSON(['error' => 'Data riwayat kerja tidak ditemukan.']);
        }

        return $this->response->setJSON([
            'gaji' => $riwayat['gaji'],
            'uraian_pekerjaan' => $riwayat['uraian_pekerjaan']
        ]);
    }
}
