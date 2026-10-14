<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Juri extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    // Tampil Halaman Data Juri
    public function index()
    {
        // Ambil data juri
        $dataJuri = $this->db->table('users')
            ->whereIn('role', ['juri', 'juri_tetap', 'juri_tamu'])
            ->get()
            ->getResultArray();

        $totalJuriTetap = $this->db->table('users')
            ->whereIn('role', ['juri', 'juri_tetap'])
            ->countAllResults();

        $totalJuriTamu = $this->db->table('users')
            ->where('role', 'juri_tamu')
            ->countAllResults();

        $totalPeserta = $this->db->table('peserta')->countAllResults();

        $data = [
            'title'              => 'Data Juri - Penilaian Dangdut',
            'page_title'         => 'Kelola Data Juri',
            'juri'               => $dataJuri,
            'total_juri'         => count($dataJuri),
            'total_juri_tetap'   => $totalJuriTetap,
            'total_juri_tamu'    => $totalJuriTamu,
            'total_peserta'      => $totalPeserta,
        ];

        return view('admin/juri/index', $data);
    }

    // Proses Tambah Juri Baru
    public function store()
    {
        $rules = [
            'username'     => 'required|is_unique[users.username]',
            'password'     => 'required|min_length[4]',
            'nama_lengkap' => 'required',
            'role'         => 'required|in_list[juri,juri_tetap,juri_tamu]',
            'status'       => 'required|in_list[aktif,tidak_aktif]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Username sudah digunakan atau inputan tidak valid.');
        }

        $data = [
            'username'     => trim((string)$this->request->getPost('username')),
            'password'     => password_hash((string)$this->request->getPost('password'), PASSWORD_BCRYPT),
            'nama_lengkap' => trim((string)$this->request->getPost('nama_lengkap')),
            'role'         => $this->request->getPost('role'),
            'status'       => $this->request->getPost('status'),
        ];

        $this->db->table('users')->insert($data);

        return redirect()->to(base_url('admin/juri'))->with('success', 'Data juri berhasil ditambahkan.');
    }

    // Proses Update Data Juri
    public function update($id = null)
    {
        if (!$id) {
            return redirect()->to(base_url('admin/juri'))->with('error', 'ID Juri tidak ditemukan.');
        }

        $rules = [
            'username'     => "required|is_unique[users.username,id,{$id}]",
            'nama_lengkap' => 'required',
            'role'         => 'required|in_list[juri,juri_tetap,juri_tamu]',
            'status'       => 'required|in_list[aktif,tidak_aktif]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data juri. Cek kembali inputan Anda.');
        }

        $data = [
            'username'     => trim((string)$this->request->getPost('username')),
            'nama_lengkap' => trim((string)$this->request->getPost('nama_lengkap')),
            'role'         => $this->request->getPost('role'),
            'status'       => $this->request->getPost('status'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash((string)$password, PASSWORD_BCRYPT);
        }

        $this->db->table('users')->where('id', $id)->update($data);

        return redirect()->to(base_url('admin/juri'))->with('success', 'Data juri berhasil diperbarui.');
    }

    // Proses Hapus Juri
    public function delete($id = null)
    {
        if (!$id) {
            return redirect()->to(base_url('admin/juri'))->with('error', 'ID Juri tidak ditemukan.');
        }

        $this->db->table('users')
            ->where('id', $id)
            ->whereIn('role', ['juri', 'juri_tetap', 'juri_tamu'])
            ->delete();

        return redirect()->to(base_url('admin/juri'))->with('success', 'Data juri berhasil dihapus.');
    }
}
