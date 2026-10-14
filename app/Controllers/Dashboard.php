<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'title'      => 'Dashboard Admin - Penilaian Dangdut',
            'page_title' => 'Dashboard Utama'
        ];

        return view('admin/dashboard', $data);
    }
}
