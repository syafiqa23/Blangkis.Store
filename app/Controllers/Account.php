<?php

namespace App\Controllers;

use App\Models\UserModel;

class Account extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        helper(['form']);
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userId = session()->get('id');

        if (!$userId) {
            return redirect()->to('/login');
        }

        $user = $this->userModel->find($userId);

        if (!$user) {
            session()->setFlashdata('error', 'Data pengguna tidak ditemukan.');
            return redirect()->to('/login');
        }

        return view('account', ['user' => $user]);
    }
public function updateAvatar()
{
    $file = $this->request->getFile('avatar');

    if (!$this->validate([
        'avatar' => 'uploaded[avatar]|max_size[avatar,2048]|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png,image/webp]',
    ])) {
        return redirect()->to('account')->with('error', $this->validator->listErrors());
    }

    if ($file && $file->isValid() && !$file->hasMoved()) {
        $newName = $file->getRandomName();
        $file->move(FCPATH . 'uploads/avatar', $newName);

        $this->userModel->update(session()->get('id'), [
            'avatar' => $newName
        ]);

        session()->set('avatar', $newName);
        session()->setFlashdata('success', 'Avatar berhasil diperbarui!');
    } else {
        session()->setFlashdata('error', 'Gagal upload avatar.');
    }

    return redirect()->to('account');
}

    public function updateUsername()
    {
        $userId = session()->get('id');
        $username = $this->request->getPost('username');

        if (!$this->validate([
            'username' => "required|min_length[3]|is_unique[user.username,id,{$userId}]",
        ])) {
            return redirect()->to('/account')->with('error', $this->validator->listErrors());
        }

        $this->userModel->update($userId, [
            'username' => $username,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        session()->set('username', $username); // update session juga
        session()->setFlashdata('success', 'Username berhasil diperbarui.');
        return redirect()->to('/account');
    }

    public function updatePassword()
    {
        $userId = session()->get('id');
        $passwordLama = $this->request->getPost('password_lama');
        $passwordBaru = $this->request->getPost('password_baru');

        $user = $this->userModel->find($userId);

        if (!$this->validate([
            'password_lama' => 'required|min_length[6]',
            'password_baru' => 'required|min_length[6]',
        ])) {
            return redirect()->to('/account')->with('error', $this->validator->listErrors());
        }

        if (!password_verify($passwordLama, $user['password'])) {
            session()->setFlashdata('error', 'Password lama salah.');
            return redirect()->to('/account');
        }

        $this->userModel->update($userId, [
            'password' => password_hash($passwordBaru, PASSWORD_DEFAULT),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        session()->setFlashdata('success', 'Password berhasil diperbarui.');
        return redirect()->to('/account');
    }
}
