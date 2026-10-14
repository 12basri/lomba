<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Peserta extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data = [
            'title'   => 'Data Peserta Resmi',
            'peserta' => $this->db->table('peserta')
                ->where('status', 'diterima')
                ->orderBy('nomor_urut', 'ASC')
                ->get()
                ->getResultArray()
        ];

        return view('admin/peserta/index', $data);
    }

    public function store()
    {
        $fileFoto = $this->request->getFile('foto');
        $namaFoto = 'default.jpg';

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move(FCPATH . 'uploads/peserta', $namaFoto);
        }

        $nomorUrut = $this->request->getPost('nomor_urut');
        if (empty($nomorUrut)) {
            $lastPeserta = $this->db->table('peserta')
                ->selectMax('nomor_urut')
                ->where('status', 'diterima')
                ->get()
                ->getRowArray();
            $nomorUrut = ($lastPeserta['nomor_urut'] ?? 0) + 1;
        }

        $data = [
            'nomor_urut'   => $nomorUrut,
            'nama_peserta' => $this->request->getPost('nama_peserta'),
            'alamat'       => $this->request->getPost('alamat') ?? $this->request->getPost('asal_daerah'),
            'no_wa'        => $this->request->getPost('no_wa'),
            'foto'         => $namaFoto,
            'status'       => 'diterima',
            'created_at'   => date('Y-m-d H:i:s')
        ];

        $this->db->table('peserta')->insert($data);

        return redirect()->to(base_url('admin/peserta'))->with('success', 'Data peserta berhasil ditambahkan!');
    }

    public function update($id)
    {
        $pesertaLama = $this->db->table('peserta')->where('id', $id)->get()->getRowArray();

        if (!$pesertaLama) {
            return redirect()->to(base_url('admin/peserta'))->with('error', 'Data peserta tidak ditemukan!');
        }

        $fileFoto = $this->request->getFile('foto');
        $namaFoto = $pesertaLama['foto'] ?? 'default.jpg';

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move(FCPATH . 'uploads/peserta', $namaFoto);

            if (!empty($pesertaLama['foto']) && $pesertaLama['foto'] !== 'default.jpg' && file_exists(FCPATH . 'uploads/peserta/' . $pesertaLama['foto'])) {
                @unlink(FCPATH . 'uploads/peserta/' . $pesertaLama['foto']);
            }
        }

        $data = [
            'nomor_urut'   => $this->request->getPost('nomor_urut') ?? $pesertaLama['nomor_urut'],
            'nama_peserta' => $this->request->getPost('nama_peserta'),
            'alamat'       => $this->request->getPost('alamat') ?? $this->request->getPost('asal_daerah'),
            'no_wa'        => $this->request->getPost('no_wa') ?? $pesertaLama['no_wa'],
            'foto'         => $namaFoto,
        ];

        $this->db->table('peserta')->where('id', $id)->update($data);

        return redirect()->to(base_url('admin/peserta'))->with('success', 'Data peserta berhasil diperbarui!');
    }

    public function delete($id)
    {
        $peserta = $this->db->table('peserta')->where('id', $id)->get()->getRowArray();

        if ($peserta) {
            $files = ['foto', 'ktp_pelajar', 'bukti_bayar', 'formulir_doc', 'kartu_identitas'];
            foreach ($files as $file) {
                if (!empty($peserta[$file]) && $peserta[$file] !== 'default.jpg') {
                    $filePath = FCPATH . 'uploads/peserta/' . $peserta[$file];
                    if (file_exists($filePath)) {
                        @unlink($filePath);
                    }
                }
            }

            $this->db->table('peserta')->where('id', $id)->delete();
            return redirect()->to(base_url('admin/peserta'))->with('success', 'Data peserta berhasil dihapus!');
        }

        return redirect()->to(base_url('admin/peserta'))->with('error', 'Data peserta tidak ditemukan!');
    }
}
