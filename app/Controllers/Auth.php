<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function __construct()
    {
        $this->authModel = new \App\Models\AuthModel();
        $this->unitKerjaModel = new \App\Models\UnitKerjaModel();
    }

    public function index()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('/'));
        }

        $data = [
            'title' => 'Login',
        ];

        return view('auth/login', $data);
    }

    public function login()
    {
        $encrypter = \Config\Services::encrypter();
        if ($this->request->getMethod() === 'POST') {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'username' => 'required',
                'password' => 'required',
            ]);

            if (!$this->validate($validation->getRules())) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }

            $model = new \App\Models\AuthModel();
            $user = $model->where('username', $this->request->getPost('username'))
                ->first();

            if ($user && password_verify($this->request->getPost('password'), $user['password'])) {
                if (strtolower($user['status']) === 'aktif') {
                    $setUser = $this->authModel->getUserById($user['id']);
                    session()->set([
                        'isLoggedIn' => true,
                        'userId'     => bin2hex($encrypter->encrypt($setUser['id'])),
                        'level'      => $setUser['level'],
                        'nama_lengkap' => $setUser['nama_lengkap'],
                        'unitKerja'  => $setUser['unit_kerja'],
                        'foto'       => $setUser['foto'],
                        'id_unit_kerja' => $setUser['id_unit_kerja'],
                    ]);
                    return redirect()->to(base_url('/'));
                } else {
                    return redirect()->back()->withInput()->with('error', 'User is not active');
                }
            } else {
                return redirect()->back()->withInput()->with('error', 'Invalid username or password');
            }
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'))->with('success', 'You have been logged out successfully.');
    }

    public function list_users()
    {
        session()->set('page', 'user_sistem');
        if (session()->get('level') !== 'admin') {
            return redirect()->to(base_url('/'))->with('error', 'Access denied');
        }

        $encrypter = \Config\Services::encrypter();
        $user = $this->authModel->getUser();
        // Encrypt id_user
        foreach ($user as &$row) {
            $row['id_user_encrypted'] = bin2hex($encrypter->encrypt($row['id']));
        }

        $data = [
            'title' => 'User List',
            'users' => $user,
        ];

        return view('user/user', $data);
    }

    public function add_user()
    {
        if (session()->get('level') !== 'admin') {
            return redirect()->to(base_url('/'))->with('error', 'Access denied');
        }

        $data = [
            'title' => 'Add User',
            'unitKerja' => $this->unitKerjaModel->findAll(),
            'validation' => \Config\Services::validation(),
        ];

        return view('user/user_add', $data);
    }

    public function register()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nama_lengkap'   => 'required',
            'email'          => 'required|valid_email',
            'no_hp'          => 'required',
            'alamat'         => 'required',
            'username'       => 'required|is_unique[tb_user.username]',
            'password'       => 'required|min_length[6]',
            'level'          => 'required',
            'status'         => 'required',
            'id_unit_kerja'  => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }

        $foto = $this->request->getFile('foto');
        $namaFoto = null;

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/user_pict', $namaFoto);
        }
        $this->authModel->insert([
            'nama_lengkap'   => $this->request->getPost('nama_lengkap'),
            'email'          => $this->request->getPost('email'),
            'no_hp'          => $this->request->getPost('no_hp'),
            'alamat'         => $this->request->getPost('alamat'),
            'username'       => $this->request->getPost('username'),
            'password'       => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'level'          => $this->request->getPost('level'),
            'status'         => $this->request->getPost('status'),
            'id_unit_kerja'  => $this->request->getPost('id_unit_kerja'),
            'foto'           => $namaFoto
        ]);

        return redirect()->to('/user_sistem')->with('success', 'Data user berhasil disimpan.');
    }

    public function edit_user($id)
    {

        $encrypter = \Config\Services::encrypter();
        $id_decrypted = $encrypter->decrypt(hex2bin($id));
        $user = $this->authModel->find($id_decrypted);
        if (!$user) {
            return redirect()->to('/user_sistem')->with('error', 'User not found');
        }

        $data = [
            'title' => 'Edit User',
            'user' => $user,
            'unitKerja' => $this->unitKerjaModel->findAll(),
            'id_user_encrypted' => $id,
        ];

        if (session()->get('page') == 'user_sistem') {
            return view('user/user_edit', $data);
        } else {
            return view('auth/edit_auth', $data);
        }
    }

    public function update_user($id)
    {

        $encrypter = \Config\Services::encrypter();
        $id_decrypted = $encrypter->decrypt(hex2bin($id));

        $user = $this->authModel->find($id_decrypted);
        if (!$user) {
            return redirect()->to('/user_sistem')->with('error', 'User not found');
        }

        $validation = \Config\Services::validation();
        $rules = [
            'nama_lengkap'   => 'required',
            'email'          => 'required|valid_email',
            'no_hp'          => 'required',
            'alamat'         => 'required',
            'username'       => "required|is_unique[tb_user.username,id,{$id_decrypted}]",
            'password'       => 'permit_empty|min_length[6]',
        ];

        // Tambahkan validasi 'level' dan 'status' jika bukan halaman profile
        if (session()->get('profile') != 'true') {
            $rules['level']  = 'required';
            $rules['status'] = 'required';
            $rules['id_unit_kerja'] = 'required';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }

        $foto = $this->request->getFile('foto');
        $namaFoto = $user['foto'];

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            if ($namaFoto) {
                unlink('uploads/user_pict/' . $namaFoto);
            }
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/user_pict', $namaFoto);
        }

        $this->authModel->update($id_decrypted, [
            'nama_lengkap'   => $this->request->getPost('nama_lengkap'),
            'email'          => $this->request->getPost('email'),
            'no_hp'          => $this->request->getPost('no_hp'),
            'alamat'         => $this->request->getPost('alamat'),
            'username'       => $this->request->getPost('username'),
            'level'          => $this->request->getPost('level') ?? $user['level'], // Tetap gunakan level lama jika tidak diubah
            'status'         => $this->request->getPost('status') ?? $user['status'], // Tetap gunakan status lama jika tidak diubah
            'id_unit_kerja'  => $this->request->getPost('id_unit_kerja') ?? $user['id_unit_kerja'], // Tetap gunakan id_unit_kerja lama jika tidak diubah
            'password'       => $this->request->getPost('password') ? password_hash($this->request->getPost('password'), PASSWORD_DEFAULT) : $user['password'],
            'foto'           => $namaFoto
        ]);
        session()->remove('profile');
        session()->remove('page');
        return redirect()->to('/user_sistem')->with('success', 'Data user berhasil diperbarui.');
    }

    public function delete_user($id)
    {
        if (session()->get('level') !== 'admin') {
            return redirect()->to(base_url('/'))->with('error', 'Access denied');
        }
        $encrypter = \Config\Services::encrypter();
        $id_decrypted = $encrypter->decrypt(hex2bin($id));

        $user = $this->authModel->find($id_decrypted);
        if (!$user) {
            return redirect()->to('/user_sistem')->with('error', 'User not found');
        }

        if ($user['foto']) {
            unlink('uploads/user_pict/' . $user['foto']);
        }

        $this->authModel->delete($id_decrypted);

        return redirect()->to('/user_sistem')->with('success', 'Data user berhasil dihapus.');
    }

    public function detail_user($id)
    {
        session()->remove('page');

        $encrypter = \Config\Services::encrypter();
        $id_decrypted = $encrypter->decrypt(hex2bin($id));

        $user = $this->authModel->getUserById($id_decrypted);
        if (!$user) {
            return redirect()->to('/user_sistem')->with('error', 'User not found');
        }

        $data = [
            'title' => 'Detail User',
            'user' => $user,
            'id_user_encrypted' => $id,
        ];

        return view('user/user_detail', $data);
    }
}
