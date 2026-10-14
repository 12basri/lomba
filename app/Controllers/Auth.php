<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        // Jika sudah login, langsung lempar ke dashboard masing-masing
        if (session()->get('isLoggedIn')) {
            return $this->redirectByRole(session()->get('role'));
        }

        return view('auth/login');
    }

    public function loginProcess()
    {
        $session   = session();
        $userModel = new UserModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $userModel->where('username', $username)->first();

        if ($user) {
            // Validasi Status Aktif / Tidak Aktif
            if (isset($user['status']) && $user['status'] !== 'aktif') {
                return redirect()->back()->with('error', 'Akun Anda dinonaktifkan. Silakan hubungi Administrator.');
            }

            // Verifikasi Password
            if (password_verify($password, $user['password']) || $password === $user['password']) {
                $sessionData = [
                    'id'           => $user['id'],
                    'user_id'      => $user['id'],
                    'username'     => $user['username'],
                    'nama_lengkap' => $user['nama_lengkap'],
                    'role'         => $user['role'],
                    'status'       => $user['status'] ?? 'aktif',
                    'isLoggedIn'   => true
                ];
                $session->set($sessionData);

                return $this->redirectByRole($user['role']);
            } else {
                return redirect()->back()->with('error', 'Password salah.');
            }
        } else {
            return redirect()->back()->with('error', 'Username tidak ditemukan.');
        }
    }

    private function redirectByRole($role)
    {
        switch ($role) {
            case 'admin':
                return redirect()->to(base_url('admin/dashboard'));
            case 'sosmed':
                return redirect()->to(base_url('sosmed/penilaian'));
            case 'juri':
            case 'juri_tetap':
            case 'juri_sementara':
            case 'juri_tamu':
                return redirect()->to(base_url('juri/dashboard'));
            default:
                session()->destroy();
                return redirect()->to(base_url('auth'))->with('error', 'Role tidak valid.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('auth'));
    }
}
