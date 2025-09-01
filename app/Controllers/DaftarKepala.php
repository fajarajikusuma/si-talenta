<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DaftarKepala extends BaseController
{
    public function __construct()
    {
        $this->daftarKepalaModel = new \App\Models\DaftarKepalaModel();
        $this->unitKerjaModel = new \App\Models\UnitKerjaModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $encrypter = \Config\Services::encrypter();
        $kepala = $this->daftarKepalaModel->getDaftarKepala();

        // Enkripsi id_kepala
        foreach ($kepala as &$row) {
            $row['id_kepala_encrypted'] = bin2hex($encrypter->encrypt($row['id_kepala']));
        }

        $data = [
            'title' => 'Daftar Kepala',
            'subtitle' => 'Daftar Kepala',
            'daftar_kepala' => $kepala,
        ];

        return view('daftar_kepala/daftar_kepala', $data);
    }


    public function add()
    {
        $data = [
            'title' => 'Tambah Daftar Kepala',
            'subtitle' => 'Tambah Daftar Kepala',
            'unit_kerja' => $this->unitKerjaModel->findAll(),
        ];

        return view('daftar_kepala/add_daftar_kepala', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nip' => 'required|min_length[18]|max_length[18]|is_unique[tb_kepala.nip]',
            'nama_kepala' => 'required',
            'unit_kerja' => 'required',
            'jabatan' => 'required',
            'jabatan_short' => 'required',
            'keterangan' => 'required',
            'status' => 'required',
        ]);

        if (!$this->validate($validation->getRules())) {
            session()->setFlashdata('error', $validation->listErrors());
            return redirect()->to('/daftar_kepala/add')->withInput();
        }

        $data = [
            'nip' => $this->request->getPost('nip'),
            'nama_kepala' => $this->request->getPost('nama_kepala'),
            'id_unit_kerja' => $this->request->getPost('unit_kerja'),
            'jabatan' => $this->request->getPost('jabatan'),
            'jabatan_short' => $this->request->getPost('jabatan_short'),
            'keterangan' => $this->request->getPost('keterangan'),
            'status' => $this->request->getPost('status'),
        ];

        if ($this->daftarKepalaModel->insert($data)) {
            session()->setFlashdata('success', 'Data berhasil ditambahkan');
            return redirect()->to('/daftar_kepala');
        } else {
            session()->setFlashdata('error', 'Data gagal ditambahkan');
            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        $encrypter = \Config\Services::encrypter();
        // Encript the ID
        $id_decrypted = $encrypter->decrypt(hex2bin($id));
        $data = [
            'title' => 'Edit Daftar Kepala',
            'subtitle' => 'Edit Daftar Kepala',
            'daftar_kepala' => $this->daftarKepalaModel->find($id_decrypted),
            'id_kepala_encrypted' => $id,
            'unit_kerja' => $this->unitKerjaModel->findAll(),
        ];

        return view('daftar_kepala/edit_daftar_kepala', $data);
    }

    public function update($id)
    {
        $encrypter = \Config\Services::encrypter();
        // Decrypt the ID
        $id_decrypted = $encrypter->decrypt(hex2bin($id));
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nip' => 'required|min_length[18]|max_length[18]|is_unique[tb_kepala.nip,id_kepala,' . $id_decrypted . ']',
            'nama_kepala' => 'required',
            'unit_kerja' => 'required',
            'jabatan' => 'required',
            'jabatan_short' => 'required',
            'keterangan' => 'required',
            'status' => 'required',
        ]);

        if (!$this->validate($validation->getRules())) {
            session()->setFlashdata('error', $validation->listErrors());
            return redirect()->to('/daftar_kepala/edit/' . $id)->withInput();
        }

        $data = [
            'nip' => $this->request->getPost('nip'),
            'nama_kepala' => $this->request->getPost('nama_kepala'),
            'id_unit_kerja' => $this->request->getPost('unit_kerja'),
            'jabatan' => $this->request->getPost('jabatan'),
            'jabatan_short' => $this->request->getPost('jabatan_short'),
            'keterangan' => $this->request->getPost('keterangan'),
            'status' => $this->request->getPost('status'),
        ];

        // Gunakan id_decrypted untuk update, bukan id terenkripsi
        if ($this->daftarKepalaModel->update($id_decrypted, $data)) {
            session()->setFlashdata('success', 'Data berhasil diupdate');
            return redirect()->to('/daftar_kepala');
        } else {
            session()->setFlashdata('error', 'Data gagal diupdate');
            return redirect()->back()->withInput();
        }
    }

    public function delete($id)
    {
        $encrypter = \Config\Services::encrypter();
        // Decrypt the ID
        $id_decrypted = $encrypter->decrypt(hex2bin($id));
        // Check if the ID exists
        if (!$this->daftarKepalaModel->find($id_decrypted)) {
            session()->setFlashdata('error', 'Data tidak ditemukan');
            return redirect()->to('/daftar_kepala');
        }
        // Delete the record

        if ($this->daftarKepalaModel->delete($id_decrypted)) {
            session()->setFlashdata('success', 'Data berhasil dihapus');
            return redirect()->to('/daftar_kepala');
        } else {
            session()->setFlashdata('error', 'Data gagal dihapus');
            return redirect()->back();
        }
    }

    public function change_status()
    {
        $encrypter = \Config\Services::encrypter();
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        // Decrypt the ID
        $id_decrypted = $encrypter->decrypt(hex2bin($id));

        $model = new \App\Models\DaftarKepalaModel();
        $updated = $model->update($id_decrypted, ['status' => $status]);
        return $this->response->setJSON(['success' => $updated]);
    }

    public function detail($encryptedId)
    {
        $encrypter = \Config\Services::encrypter();
        $id_kepala = $encrypter->decrypt(hex2bin($encryptedId));

        $data = [
            'title' => 'Detail Daftar Kepala',
            'subtitle' => 'Detail Daftar Kepala',
            'kepala' => $this->daftarKepalaModel->find($id_kepala),
            'nama_unit_kerja' => $this->unitKerjaModel->find($this->daftarKepalaModel->find($id_kepala)['id_unit_kerja']),
        ];
        return view('daftar_kepala/detail_daftar_kepala', $data);
    }
}
