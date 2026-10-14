<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Kriteria extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $dataKriteria = $this->db->table('kriteria_penilaian')
            ->get()
            ->getResultArray();

        $data = [
            'title'    => 'Data Kriteria - Penilaian Dangdut',
            'kriteria' => $dataKriteria,
        ];

        return view('admin/kriteria/index', $data);
    }

    public function store()
    {
        $rules = [
            'nama_kriteria' => 'required',
            'bobot'         => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Inputan kriteria tidak valid.');
        }

        $data = [
            'nama_kriteria' => $this->request->getPost('nama_kriteria'),
            'bobot'         => $this->request->getPost('bobot'),
        ];

        $this->db->table('kriteria_penilaian')->insert($data);

        return redirect()->to(base_url('admin/kriteria'))->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function update($id)
    {
        $rules = [
            'nama_kriteria' => 'required',
            'bobot'         => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui kriteria.');
        }

        $data = [
            'nama_kriteria' => $this->request->getPost('nama_kriteria'),
            'bobot'         => $this->request->getPost('bobot'),
        ];

        $this->db->table('kriteria_penilaian')->where('id', $id)->update($data);

        return redirect()->to(base_url('admin/kriteria'))->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->db->table('kriteria_penilaian')->where('id', $id)->delete();
        return redirect()->to(base_url('admin/kriteria'))->with('success', 'Kriteria berhasil dihapus.');
    }
}
