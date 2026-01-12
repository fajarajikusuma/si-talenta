<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\DasarHukumModel;

class DasarHukum extends BaseController
{
    public function __construct()
    {
        // Load any necessary models or libraries here
        $this->model = new DasarHukumModel();
    }

    public function index()
    {
        $encrypter = \Config\Services::encrypter();
        $dasarHukum = $this->model->findAll();

        // Encrypt the ID for each dasar hukum
        foreach ($dasarHukum as &$row) {
            $row['id_dasar_hukum_encrypted'] = bin2hex($encrypter->encrypt($row['id']));
        }

        $data = [
            'title' => 'Dasar Hukum',
            'subtitle' => 'Daftar Dasar Hukum',
            'dasar_hukum' => $dasarHukum,
        ];

        return view('dasar_hukum/dasar_hukum', $data);
    }

    public function add()
    {
        $data = [
            'title' => 'Dasar Hukum',
            'subtitle' => 'Tambah Dasar Hukum',
        ];

        return view('dasar_hukum/add_dasar_hukum', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();

        // Validate input data
        if (!$this->validate([
            'nama_dasar_hukum' => 'required|min_length[2]|max_length[20]',
            'nomor' => 'required',
            'tahun' => 'required|numeric',
            'tentang' => 'required',
            'upload_dokumen' => 'uploaded[upload_dokumen]|max_size[upload_dokumen,2048]|ext_in[upload_dokumen,pdf]',
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        // handle file upload
        if ($this->request->getFile('upload_dokumen')) {
            $file = $this->request->getFile('upload_dokumen');
            if ($file->isValid() && !$file->hasMoved()) {
                $fileName = $file->getRandomName();
                $file->move('uploads/dasar_hukum/', $fileName);
                $data['upload_dokumen'] = $fileName; // Save the file name
            } else {
                session()->setFlashdata('error', 'Gagal mengupload file.');
                return redirect()->back()->withInput();
            }
        } else {
            session()->setFlashdata('error', 'File tidak ditemukan.');
            return redirect()->back()->withInput();
        }

        // dd($data); // Debugging line, remove in production

        if ($this->model->insert($data)) {
            session()->setFlashdata('success', 'Dasar Hukum berhasil ditambahkan.');
            return redirect()->to(site_url('dasar_hukum'));
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan Dasar Hukum.');
            return redirect()->back()->withInput();
        }
    }

    public function change_status()
    {
        $encrypter = \Config\Services::encrypter();
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        // Decrypt the ID
        $id_decrypted = $encrypter->decrypt(hex2bin($id));

        $model = new \App\Models\DasarHukumModel();
        $updated = $model->update($id_decrypted, ['status' => $status]);
        return $this->response->setJSON(['success' => $updated]);
    }

    public function edit($id)
    {
        $encrypter = \Config\Services::encrypter();
        $id_decrypted = $encrypter->decrypt(hex2bin($id));

        $dasarHukum = $this->model->find($id_decrypted);
        if (!$dasarHukum) {
            session()->setFlashdata('error', 'Dasar Hukum tidak ditemukan.');
            return redirect()->to(site_url('dasar_hukum'));
        }
        $data = [
            'title' => 'Dasar Hukum',
            'subtitle' => 'Edit Dasar Hukum',
            'dasar_hukum' => $dasarHukum,
            'id_encrypted' => $id,
        ];

        return view('dasar_hukum/edit_dasar_hukum', $data);
    }

    public function update($id)
    {
        $encrypter = \Config\Services::encrypter();
        $id_decrypted = $encrypter->decrypt(hex2bin($id));

        // Validate input data
        $rules = [
            'nama_dasar_hukum' => 'required|min_length[2]|max_length[20]',
            'nomor' => 'required',
            'tahun' => 'required|numeric',
            'tentang' => 'required',
            'upload_dokumen' => 'permit_empty|uploaded[upload_dokumen]|max_size[upload_dokumen,2048]|ext_in[upload_dokumen,pdf]',
        ];
        if (!$this->validate($rules)) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $data = $this->request->getPost();

        // handle file upload jika ada upload dokumen baru jika tidak ada, tetap gunakan dokumen lama
        if ($this->request->getFile('upload_dokumen') && $this->request->getFile('upload_dokumen')->isValid()) {
            $file = $this->request->getFile('upload_dokumen');
            if ($file->isValid() && !$file->hasMoved()) {
                $fileName = $file->getRandomName();
                $file->move('uploads/dasar_hukum/', $fileName);
                $data['upload_dokumen'] = $fileName; // Save the new file
            } else {
                session()->setFlashdata('error', 'Gagal mengupload file.');
                return redirect()->back()->withInput();
            }
        } else {
            // Jika tidak ada file baru, ambil dokumen lama dari database
            $existingDasarHukum = $this->model->find($id_decrypted);
            if ($existingDasarHukum) {
                $data['upload_dokumen'] = $existingDasarHukum['upload_dokumen'];
            } else {
                session()->setFlashdata('error', 'Dasar Hukum tidak ditemukan.');
                return redirect()->back()->withInput();
            }
        }

        if ($this->model->update($id_decrypted, $data)) {
            session()->setFlashdata('success', 'Dasar Hukum berhasil diupdate.');
            return redirect()->to(site_url('dasar_hukum'));
        } else {
            session()->setFlashdata('error', 'Gagal mengupdate Dasar Hukum.');
            return redirect()->back()->withInput();
        }
    }

    public function delete($id)
    {
        $encrypter = \Config\Services::encrypter();
        $id_decrypted = $encrypter->decrypt(hex2bin($id));

        if ($this->model->delete($id_decrypted)) {
            session()->setFlashdata('success', 'Dasar Hukum berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus Dasar Hukum.');
        }

        return redirect()->to(site_url('dasar_hukum'));
    }
}
