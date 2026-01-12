<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UnitKerja extends BaseController
{
    public function __construct()
    {
        $this->unitKerjaModel = new \App\Models\UnitKerjaModel();
    }

    public function index()
    {
        $encrypter = \Config\Services::encrypter();
        $unitKerja = $this->unitKerjaModel->findAll();
        // Enkripsi id_unit_kerja
        foreach ($unitKerja as &$row) {
            $row['id_unit_kerja_encrypted'] = bin2hex($encrypter->encrypt($row['id_unit_kerja']));
        }

        $data = [
            'title' => 'Unit Kerja',
            'subtitle' => 'Unit Kerja',
            'unit_kerja' => $unitKerja,
        ];

        return view('unit_kerja/unit_kerja', $data);
    }

    public function add()
    {
        $data = [
            'title' => 'Unit Kerja',
            'subtitle' => 'Tambah Unit Kerja',
        ];

        return view('unit_kerja/add_unit_kerja', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'unit_kerja' => 'required|min_length[3]|max_length[50]',
            'keterangan' => 'required|max_length[255]',
        ]);

        if (!$this->validate($validation->getRules())) {
            session()->setFlashdata('error', $validation->listErrors());
            return redirect()->to('/unit_kerja/add')->withInput();
        }

        $data = [
            'unit_kerja' => $this->request->getPost('unit_kerja'),
            'detail' => $this->request->getPost('keterangan'),
        ];

        $this->unitKerjaModel->insert($data);
        session()->setFlashdata('success', 'Data berhasil ditambahkan');
        return redirect()->to('/unit_kerja');
    }

    public function edit($id)
    {
        $encrypter = \Config\Services::encrypter();
        $id_decrypted = $encrypter->decrypt(hex2bin($id));
        $data = [
            'title' => 'Unit Kerja',
            'subtitle' => 'Edit Unit Kerja',
            'unit_kerja' => $this->unitKerjaModel->find($id_decrypted),
            'id_unit_kerja_encrypted' => $id,
        ];

        return view('unit_kerja/edit_unit_kerja', $data);
    }

    public function update($id)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'unit_kerja' => 'required|min_length[3]|max_length[50]',
            'keterangan' => 'required|max_length[255]',
        ]);

        if (!$this->validate($validation->getRules())) {
            session()->setFlashdata('error', $validation->listErrors());
            return redirect()->to('/unit_kerja/add')->withInput();
        }

        $encrypter = \Config\Services::encrypter();
        $id_decrypted = $encrypter->decrypt(hex2bin($id));

        $data = [
            'unit_kerja' => $this->request->getPost('unit_kerja'),
            'detail' => $this->request->getPost('keterangan'),
        ];

        $this->unitKerjaModel->update($id_decrypted, $data);
        session()->setFlashdata('success', 'Data berhasil diupdate');
        return redirect()->to('/unit_kerja');
    }

    public function delete($id)
    {
        $encrypter = \Config\Services::encrypter();
        $id_decrypted = $encrypter->decrypt(hex2bin($id));
        $this->unitKerjaModel->delete($id_decrypted);
        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to('/unit_kerja');
    }
}
