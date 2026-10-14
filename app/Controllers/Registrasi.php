<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Registrasi extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data = [
            'title' => 'Formulir Pendaftaran - Magello Dangdut Festival 2026'
        ];

        return view('pages/registrasi', $data);
    }

    public function simpan()
    {
        // 1. Validasi Input & Berkas File
        $rules = [
            'nama_peserta'  => [
                'rules'  => 'required|min_length[3]|max_length[100]',
                'errors' => ['required' => 'Nama lengkap wajib diisi.']
            ],
            'alamat'        => [
                'rules'  => 'required',
                'errors' => ['required' => 'Alamat lengkap wajib diisi.']
            ],
            'no_wa'         => [
                'rules'  => 'required|numeric|min_length[8]|max_length[20]',
                'errors' => [
                    'required'   => 'Nomor WhatsApp wajib diisi.',
                    'numeric'    => 'Nomor WA harus berupa angka.',
                    'min_length' => 'Nomor WhatsApp minimal 8 digit.'
                ]
            ],
            'jenis_kelamin' => [
                'rules'  => 'required|in_list[L,P]',
                'errors' => ['required' => 'Jenis kelamin wajib dipilih.']
            ],
            'foto'          => [
                'rules'  => 'uploaded[foto]|max_size[foto,3072]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Foto peserta wajib diunggah.',
                    'max_size' => 'Ukuran foto maksimal 3MB.',
                    'is_image' => 'File foto harus berupa gambar.',
                    'mime_in'  => 'Format foto harus JPG, JPEG, atau PNG.'
                ]
            ],
            'ktp_pelajar'   => [
                'rules'  => 'uploaded[ktp_pelajar]|max_size[ktp_pelajar,3072]|ext_in[ktp_pelajar,jpg,jpeg,png,pdf]',
                'errors' => [
                    'uploaded' => 'Scan KTP/Kartu Pelajar wajib diunggah.',
                    'max_size' => 'Ukuran file KTP/Pelajar maksimal 3MB.',
                    'ext_in'   => 'Format KTP/Pelajar harus JPG, PNG, atau PDF.'
                ]
            ],
            'bukti_bayar'   => [
                'rules'  => 'uploaded[bukti_bayar]|max_size[bukti_bayar,3072]|ext_in[bukti_bayar,jpg,jpeg,png,pdf]',
                'errors' => [
                    'uploaded' => 'Bukti pembayaran wajib diunggah.',
                    'max_size' => 'Ukuran file bukti bayar maksimal 3MB.',
                    'ext_in'   => 'Format bukti bayar harus JPG, PNG, atau PDF.'
                ]
            ],
            'formulir_doc'  => [
                'rules'  => 'uploaded[formulir_doc]|max_size[formulir_doc,5120]|ext_in[formulir_doc,pdf,doc,docx,jpg,jpeg,png]',
                'errors' => [
                    'uploaded' => 'Berkas Formulir Pendaftaran wajib diunggah.',
                    'max_size' => 'Ukuran berkas formulir maksimal 5MB.',
                    'ext_in'   => 'Format formulir harus PDF, DOC, DOCX, JPG, atau PNG.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        // 2. Folder Tujuan Upload File
        $uploadPath = FCPATH . 'uploads/peserta';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Upload File
        $fileFoto = $this->request->getFile('foto');
        $namaFoto = $fileFoto->getRandomName();
        $fileFoto->move($uploadPath, $namaFoto);

        $fileKtp = $this->request->getFile('ktp_pelajar');
        $namaKtp = $fileKtp->getRandomName();
        $fileKtp->move($uploadPath, $namaKtp);

        $fileBayar = $this->request->getFile('bukti_bayar');
        $namaBayar = $fileBayar->getRandomName();
        $fileBayar->move($uploadPath, $namaBayar);

        $fileForm = $this->request->getFile('formulir_doc');
        $namaForm = $fileForm->getRandomName();
        $fileForm->move($uploadPath, $namaForm);

        // 3. Insert ke Database (nomor_urut diisi 0 karena belum disetujui)
        $this->db->table('peserta')->insert([
            'nomor_urut'    => 0,
            'nama_peserta'  => $this->request->getPost('nama_peserta'),
            'alamat'        => $this->request->getPost('alamat'),
            'no_wa'         => $this->request->getPost('no_wa'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'foto'          => $namaFoto,
            'ktp_pelajar'   => $namaKtp,
            'bukti_bayar'   => $namaBayar,
            'formulir_doc'  => $namaForm,
            'status'        => 'pending',
            'created_at'    => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/registrasi')->with('success', 'Pendaftaran berhasil dikirim! Silakan menunggu verifikasi dari panitia.');
    }
}
