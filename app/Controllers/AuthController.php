<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\Google;
use CodeIgniter\I18n\Time;

class AuthController extends BaseController
{
    protected $user;
    protected $google;

    function __construct()
    {
        helper('form');
        $this->user = new UserModel();

        $this->google = new Google([
            'clientId'     => env('GOOGLE_CLIENT_ID'),
            'clientSecret' => env('GOOGLE_CLIENT_SECRET'),
            'redirectUri'  => env('GOOGLE_REDIRECT_URI', base_url('auth/google/callback')),
        ]);
    }

    public function googleLogin()
    {
        if (!$this->isGoogleConfigured()) {
            return redirect()->to(base_url('login'))->with('failed', 'Konfigurasi Google Login belum lengkap.');
        }

        $authUrl = $this->google->getAuthorizationUrl([
            'scope' => ['openid', 'email', 'profile'],
            'prompt' => 'select_account',
        ]);

        session()->set('oauth2state', $this->google->getState());
        return redirect()->to($authUrl);
    }

    public function googleCallback()
    {
        $code = $this->request->getGet('code');
        $state = $this->request->getGet('state');

        if (empty($code) || ($state !== session()->get('oauth2state'))) {
            session()->remove('oauth2state');
            return redirect()->to(base_url('login'))->with('failed', 'Login Google gagal. Silakan coba lagi.');
        }

        try {
            $token = $this->google->getAccessToken('authorization_code', ['code' => $code]);
            $googleUser = $this->google->getResourceOwner($token);
        } catch (IdentityProviderException $e) {
            log_message('error', 'Google OAuth provider error: ' . $e->getMessage());
            return redirect()->to(base_url('login'))->with('failed', 'Login Google gagal: pastikan Redirect URI di Google Cloud sudah sesuai.');
        } catch (\Throwable $e) {
            log_message('error', 'Google OAuth error: ' . $e->getMessage());
            return redirect()->to(base_url('login'))->with('failed', 'Login Google gagal. Silakan coba lagi.');
        }

        $userData = $googleUser->toArray();
        $email = $userData['email'] ?? null;

        if (!$email) {
            return redirect()->to(base_url('login'))->with('failed', 'Email Google tidak ditemukan.');
        }

        $user = $this->user->where('email', $email)->first();

        if (!$user) {
            $username = strstr($email, '@', true) ?: 'google_user';
            $baseUsername = preg_replace('/[^a-zA-Z0-9_]/', '', $username) ?: 'google_user';
            $username = $baseUsername;
            $counter = 1;

            while ($this->user->where('username', $username)->first()) {
                $username = $baseUsername . $counter++;
            }

            $this->user->insert([
                'name' => $userData['name'] ?? $username,
                'username' => $username,
                'email' => $email,
                'password' => password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT),
                'role' => 'guest',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            $user = $this->user->find($this->user->getInsertID());
        }

        // Lakukan pengecekan user di DB, simpan session login
       session()->set([
    'id'       => $user['id'],
    'username' => $user['username'],
    'email'    => $user['email'],
    'role'     => $user['role'] ?? 'guest',
    'avatar'   => $user['avatar'] ?? null,
    'isLoggedIn' => true
]);

        return redirect()->to('/');
    }

    private function isGoogleConfigured(): bool
    {
        return (bool) env('GOOGLE_CLIENT_ID')
            && (bool) env('GOOGLE_CLIENT_SECRET')
            && (bool) env('GOOGLE_REDIRECT_URI', base_url('auth/google/callback'));
    }

    public function login()
    {
        if ($this->request->getPost()) {
            $rules = [
                'username' => 'required|min_length[3]',
                'password' => 'required|min_length[6]',
            ];

            if ($this->validate($rules)) {
                $username = $this->request->getVar('username');
                $password = $this->request->getVar('password');

                $dataUser = $this->user->where(['username' => $username])->first(); //pasw 1234567

                if ($dataUser) {
                    if (password_verify($password, $dataUser['password'])) {
                       session()->set([
    'id'        => $dataUser['id'],         // tambahkan ID user
    'username'  => $dataUser['username'],
    'email'     => $dataUser['email'],      // tambahkan email user
    'role'      => $dataUser['role'],
      'avatar' => $dataUser['avatar'] ?? null,
    'isLoggedIn'=> true
]);

                        return redirect()->to(base_url('home'));
                    } else {
                        session()->setFlashdata('failed', 'Kombinasi Username & Password Salah');
                        return redirect()->back();
                    }
                } else {
                    session()->setFlashdata('failed', 'Username Tidak Ditemukan');
                    return redirect()->back();
                }
            } else {
                session()->setFlashdata('failed', $this->validator->listErrors());
                return redirect()->back();
            }
        }

        return view('v_login');
    }public function registerForm()
{
    return view('register');
}


public function register()
{
    $validation = \Config\Services::validation();

    $rules = [
        'name'         => 'required',
        'email'        => 'required|valid_email|is_unique[user.email]',
        'username'     => 'required|min_length[3]|is_unique[user.username]',
        'password'     => 'required|min_length[6]',
        'confpassword' => 'required|matches[password]'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('error', implode("<br>", $validation->getErrors()));
    }

    $data = [
        'name'       => $this->request->getPost('name'),
        'username'   => $this->request->getPost('username'),
        'email'      => $this->request->getPost('email'),
        'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        'role'       => 'guest', // default role
        'created_at' => Time::now(),
        'updated_at' => Time::now()
    ];

    $userModel = new \App\Models\UserModel();
    $userModel->insert($data);

    return redirect()->to(base_url('login'))->with('success', 'Akun berhasil dibuat!');
}



    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
    
}
