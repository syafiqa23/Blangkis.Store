<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class KontakController extends BaseController
{
    public function kirim()
    {
        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'subject' => 'required|min_length[3]',
            'message' => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim.');
    }
}
