<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ListPekerjaan extends BaseController
{
    public function __construct()
    {
        $this->listPekerjaanModel = new \App\Models\ListPekerjaanModel();
    }

    public function index()
    {
        $encrypted = \Config\Services::encrypter();
        $list_pekerjaan = $this->listPekerjaanModel->findAll();
        // Enkripsi id_list_pekerjaan
        foreach ($list_pekerjaan as &$row) {
            $row['id_list_pekerjaan_encrypted'] = bin2hex($encrypted->encrypt($row['id_nama_pekerjaan']));
        }

        $data = [
            'title' => 'List Pekerjaan',
            'subtitle' => 'List Pekerjaan',
            'list_pekerjaan' => $list_pekerjaan,
        ];

        return view('list_pekerjaan/list_pekerjaan', $data);
    }

    public function add()
    {
        $data = [
            'title' => 'List Pekerjaan',
            'subtitle' => 'Tambah List Pekerjaan',
        ];

        return view('list_pekerjaan/add_list_pekerjaan', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        if (!$this->validate([
            'pekerjaan' => [
                'label' => 'Pekerjaan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                ],
            ],
            'uraian_kerja' => [
                'label' => 'Uraian Kerja',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                ],
            ],
        ])) {
            return redirect()->to('/list_pekerjaan/add')->withInput()->with('error', $validation->listErrors());
        }

        $data = [
            'pekerjaan' => $this->request->getPost('pekerjaan'),
            'uraian_kerja' => $this->request->getPost('uraian_kerja'),
        ];

        $this->listPekerjaanModel->insert($data);

        session()->setFlashdata('success', 'Data berhasil ditambahkan.');

        return redirect()->to('/list_pekerjaan');
    }

    public function edit($id)
    {
        $encryption = \Config\Services::encrypter();
        $id_decrypted = $encryption->decrypt(hex2bin($id));
        $data = [
            'title' => 'List Pekerjaan',
            'subtitle' => 'Edit List Pekerjaan',
            'pekerjaan' => $this->listPekerjaanModel->find($id_decrypted),
            'id_list_pekerjaan_encrypted' => $id,
        ];

        return view('list_pekerjaan/edit_list_pekerjaan', $data);
    }

    public function update($id)
    {
        $validation = \Config\Services::validation();

        if (!$this->validate([
            'pekerjaan' => [
                'label' => 'Pekerjaan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                ],
            ],
            'uraian_kerja' => [
                'label' => 'Uraian Kerja',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                ],
            ],
        ])) {
            return redirect()->to('/list_pekerjaan/edit/' . $id)->withInput()->with('error', $validation->listErrors());
        }

        $encryption = \Config\Services::encrypter();
        $id_decrypted = $encryption->decrypt(hex2bin($id));
        $data = [
            'pekerjaan' => $this->request->getPost('pekerjaan'),
            'uraian_kerja' => $this->request->getPost('uraian_kerja'),
        ];

        $this->listPekerjaanModel->update($id_decrypted, $data);

        session()->setFlashdata('success', 'Data berhasil diubah.');

        return redirect()->to('/list_pekerjaan');
    }

    public function delete($id)
    {
        $encryption = \Config\Services::encrypter();
        $id_decrypted = $encryption->decrypt(hex2bin($id));
        $this->listPekerjaanModel->delete($id_decrypted);

        session()->setFlashdata('success', 'Data berhasil dihapus.');

        return redirect()->to('/list_pekerjaan');
    }

    public function import_excel()
    {
        $validation = \Config\Services::validation();
        if (!$this->validate([
            'file_excel' => [
                'label' => 'File Excel',
                'rules' => 'uploaded[file_excel]|ext_in[file_excel,xls,xlsx]',
                'errors' => [
                    'uploaded' => '{field} tidak boleh kosong.',
                    'ext_in' => '{field} harus berformat .xls atau .xlsx.',
                ],
            ],
        ])) {
            return redirect()->to('/list_pekerjaan')->withInput()->with('error', $validation->listErrors());
        }

        $file = $this->request->getFile('file_excel');
        if ($file->isValid() && !$file->hasMoved()) {

            $newName = $file->getRandomName();
            $path = 'uploads/excel/list_pekerjaan/' . $newName;
            $file->move('uploads/excel/list_pekerjaan/', $newName);
            $spreadsheet = IOFactory::load($path);
            $data = $spreadsheet->getActiveSheet()->toArray();

            foreach ($data as $row => $value) {
                // jika baris pertama bukan no, pekerjaan, dan uraian kerja maka skip
                if ($row === 0 && (trim($value[0]) !== 'No' || trim($value[1]) !== 'Pekerjaan' || trim($value[2]) !== 'Uraian Pekerjaan')) {
                    session()->setFlashdata('error', 'File tidak valid.');
                    return redirect()->to('/list_pekerjaan');
                }
                // Skip the first row (header)
                if ($row === 0) {
                    continue;
                }
                // Skip empty row (misal pekerjaan dan uraian kerja kosong)
                if (empty($value[1]) && empty($value[2])) {
                    continue;
                }

                $pekerjaan = trim($value[1]);
                $uraian = trim($value[2]);

                // Skip if pekerjaan already exists
                $existing = $this->listPekerjaanModel->where('pekerjaan', $pekerjaan)->first();
                if ($existing) {
                    continue; // atau tampilkan pesan lain
                }

                $this->listPekerjaanModel->insert([
                    'pekerjaan' => $pekerjaan,
                    'uraian_kerja' => $uraian,
                ]);
            }

            session()->setFlashdata('success', 'Data berhasil diimport.');
            return redirect()->to('/list_pekerjaan');
        } else {
            session()->setFlashdata('error', 'File tidak valid.');
        }
    }

    public function download_template()
    {
        $file = 'template/template_list_pekerjaan.xlsx';
        return $this->response->download($file, null)->setFileName('Template List Pekerjaan.xlsx');
    }
}
