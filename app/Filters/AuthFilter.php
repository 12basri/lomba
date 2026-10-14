<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Cek apakah pengguna sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userRole = session()->get('role');

        // 2. Cek hak akses berdasarkan role jika $arguments diisi pada routes
        if ($arguments && !in_array($userRole, $arguments)) {

            // Kelompokkan semua jenis juri agar di-redirect ke halaman juri jika ditolak
            $juriRoles = ['juri', 'juri_tetap', 'juri_sementara', 'juri_tamu'];

            if (in_array($userRole, $juriRoles)) {
                return redirect()->to('/juri/dashboard')->with('error', 'Akses ditolak.');
            }

            if ($userRole === 'sosmed') {
                return redirect()->to('/sosmed/penilaian')->with('error', 'Akses ditolak.');
            }

            return redirect()->to('/admin/dashboard')->with('error', 'Akses ditolak.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu diisi
    }
}
