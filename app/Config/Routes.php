<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ==========================================
// RUTE KHUSUS UNTUK MEMBACA FILE UPLOADS
// ==========================================
$routes->get('uploads/peserta/(:any)', function ($fileName) {
    $filePath = FCPATH . 'uploads/peserta/' . $fileName;

    if (!file_exists($filePath)) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Berkas '$fileName' tidak ditemukan.");
    }

    $mime = mime_content_type($filePath);
    header("Content-Type: " . $mime);
    readfile($filePath);
    exit;
});

// ==========================================
// RUTE PUBLIK (Grafik & AJAX Data)
// ==========================================
$routes->get('/', 'Home::index');
$routes->get('home/getData', 'Home::getData');

// Rute Tampilan Login (GET)
$routes->get('auth', 'Auth::index');
$routes->get('auth/login', 'Auth::index');

// Route Registrasi Peserta (Publik)
$routes->get('registrasi', 'Registrasi::index');
$routes->post('registrasi/simpan', 'Registrasi::simpan');

// Rute Proses Submit Form Login (POST)
$routes->post('auth/login', 'Auth::loginProcess');

// Rute Logout
$routes->get('auth/logout', 'Auth::logout');

$routes->post('admin/grafik/set-mode', 'Admin\Grafik::setMode');
$routes->post('admin/hasil-vote/reset', 'Admin\HasilVote::reset');

// ==========================================
// RUTE KHUSUS ADMIN (Filter: admin)
// ==========================================
$routes->group('admin', ['filter' => 'authFilter:admin'], function ($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
    $routes->get('dashboard/export', 'Admin\Dashboard::export');
    $routes->post('dashboard/reset-vote', 'Admin\Dashboard::resetVote');

    // Route Grafik & Analisis
    $routes->get('grafik', 'Admin\Grafik::index');

    // Route Modul Juri
    $routes->get('juri', 'Admin\Juri::index');
    $routes->post('juri/store', 'Admin\Juri::store');
    $routes->post('juri/update/(:num)', 'Admin\Juri::update/$1');
    $routes->get('juri/delete/(:num)', 'Admin\Juri::delete/$1');

    // Route Modul Peserta
    $routes->get('peserta', 'Admin\Peserta::index');
    $routes->post('peserta/store', 'Admin\Peserta::store');
    $routes->post('peserta/update/(:num)', 'Admin\Peserta::update/$1');
    $routes->get('peserta/delete/(:num)', 'Admin\Peserta::delete/$1');

    // Route Modul Audisi / Pendaftaran
    $routes->get('audisi', 'Admin\Audisi::index');
    $routes->post('audisi/store', 'Admin\Audisi::store');
    $routes->post('audisi/update/(:num)', 'Admin\Audisi::update/$1');
    $routes->get('audisi/delete/(:num)', 'Admin\Audisi::delete/$1');
    $routes->get('audisi/verifikasi/(:num)', 'Admin\Audisi::verifikasi/$1');

    // Rute Hasil Vote Juri & Cetak Laporan
    $routes->get('hasil-vote', 'Admin\HasilVote::index');
    $routes->get('hasil-vote/export', 'Admin\HasilVote::export');
});

// ==========================================
// RUTE KHUSUS JURI
// ==========================================
$routes->group('juri', ['filter' => 'authFilter:juri_tetap,juri_tamu,juri'], function ($routes) {
    $routes->get('dashboard', 'Juri\Dashboard::index');
    $routes->get('penilaian', 'Juri\Penilaian::index');
    $routes->post('penilaian/store', 'Juri\Penilaian::store');
});

// ==========================================
// RUTE KHUSUS PETUGAS SOSMED (Filter: sosmed)
// ==========================================
$routes->group('sosmed', ['filter' => 'authFilter:sosmed'], function ($routes) {
    $routes->get('dashboard', 'Sosmed\Dashboard::index');
    $routes->post('dashboard/reset-vote', 'Sosmed\Dashboard::resetVote');
    $routes->get('export-pdf', 'Sosmed\Dashboard::exportPdf');
    $routes->get('penilaian', 'Sosmed\Penilaian::index');
    $routes->post('penilaian/store', 'Sosmed\Penilaian::store');
});
