<?php

namespace App\Controllers\Sosmed;

use App\Controllers\BaseController;

class Penilaian extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $tanggal   = $this->request->getGet('tanggal') ?? date('Y-m-d');
        $sosmed_id = session()->get('user_id') ?? session()->get('id') ?? 0;

        $peserta = $this->db->table('peserta p')
            ->select('
                p.id, 
                p.nomor_urut, 
                p.nama_peserta, 
                p.alamat, 
                pen.likes, 
                pen.followers, 
                pen.views, 
                pen.nilai as nilai_sosmed
            ')
            ->join(
                'penilaian pen',
                "pen.peserta_id = p.id AND pen.juri_id = " . $this->db->escape($sosmed_id) . " AND pen.tgl_vote = " . $this->db->escape($tanggal),
                'left'
            )
            ->where('p.status', 'diterima')
            ->orderBy('p.nomor_urut', 'ASC')
            ->get()->getResultArray();

        $data = [
            'title'          => 'Input Nilai Sosial Media',
            'tanggal_filter' => $tanggal,
            'peserta'        => $peserta,
        ];

        return view('sosmed/v_penilaian', $data);
    }

    /**
     * Menyimpan/Update Nilai Per-Peserta (Individual)
     */
    public function store()
    {
        $sosmed_id  = session()->get('user_id') ?? session()->get('id');
        $peserta_id = $this->request->getPost('peserta_id');
        $tgl_vote   = $this->request->getPost('tgl_vote');
        $likes      = (int) $this->request->getPost('likes');
        $followers  = (int) $this->request->getPost('followers');
        $views      = (int) $this->request->getPost('views');

        if (!$peserta_id || !$tgl_vote || !$sosmed_id) {
            return redirect()->back()->with('error', 'Data atau sesi pengguna tidak valid.');
        }

        // 1. Hitung total inputan dari Likes + Followers + Views
        $total_input = $likes + $followers + $views;

        // 2. Kalkulasi Nilai otomatis (Batas Maksimal = 1000 Total Inputan)
        // Jika total >= 1000, nilai dikunci pada angka 100. Jika kurang, dihitung secara proporsional.
        $nilai_kalkulasi = min(100, ($total_input / 1000) * 100);

        // Cek apakah data sudah pernah dimasukkan
        $existing = $this->db->table('penilaian')
            ->where('peserta_id', $peserta_id)
            ->where('juri_id', $sosmed_id)
            ->where('tgl_vote', $tgl_vote)
            ->get()->getRowArray();

        $dataInput = [
            'peserta_id' => $peserta_id,
            'juri_id'    => $sosmed_id,
            'tgl_vote'   => $tgl_vote,
            'likes'      => $likes,
            'followers'  => $followers,
            'views'      => $views,
            'nilai'      => round($nilai_kalkulasi, 2), // Menyimpan hasil perhitungan 0-100
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if ($existing) {
            $this->db->table('penilaian')
                ->where('id', $existing['id'])
                ->update($dataInput);
        } else {
            $dataInput['created_at'] = date('Y-m-d H:i:s');
            $this->db->table('penilaian')->insert($dataInput);
        }

        return redirect()->to(base_url('sosmed/penilaian?tanggal=' . $tgl_vote))
            ->with('success', 'Nilai peserta berhasil diperbarui.');
    }
}
