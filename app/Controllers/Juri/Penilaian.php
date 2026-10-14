<?php

namespace App\Controllers\Juri;

use App\Controllers\BaseController;

class Penilaian extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    private function getJuriId()
    {
        return session('user_id')
            ?? session('id')
            ?? session('id_user')
            ?? session('juri_id');
    }

    public function index()
    {
        $juriId   = $this->getJuriId();
        $userRole = session('role'); // juri_tetap atau juri_sementara
        $today    = date('Y-m-d');

        // Tentukan bobot berdasarkan role (Juri Tetap: 60%, Juri Sementara: 30%)
        $bobotPersen = ($userRole === 'juri_tetap') ? 60 : 30;
        $labelRole   = ($userRole === 'juri_tetap') ? 'Juri Tetap' : 'Juri Sementara';

        // Ambil data peserta yang statusnya diterima
        $peserta = $this->db->table('peserta')
            ->where('status', 'diterima')
            ->orderBy('nomor_urut', 'ASC')
            ->get()
            ->getResultArray();

        // Ambil vote yang dilakukan HARI INI oleh juri ini
        $penilaian = [];
        $catatan   = [];

        if ($juriId) {
            $penilaianRaw = $this->db->table('penilaian')
                ->where('juri_id', $juriId)
                ->where('tgl_vote', $today)
                ->get()
                ->getResultArray();

            foreach ($penilaianRaw as $p) {
                $penilaian[$p['peserta_id']] = $p['nilai'];
                $catatan[$p['peserta_id']]   = $p['catatan'];
            }
        }

        $data = [
            'title'       => "Lembar Vote / Penilaian ($labelRole - Bobot $bobotPersen%)",
            'peserta'     => $peserta,
            'penilaian'   => $penilaian,
            'catatan'     => $catatan,
            'today'       => $today,
            'userRole'    => $userRole,
            'labelRole'   => $labelRole,
            'bobotPersen' => $bobotPersen
        ];

        return view('juri/penilaian/index', $data);
    }

    public function store()
    {
        $juriId    = $this->getJuriId();
        $pesertaId = $this->request->getPost('peserta_id');
        $nilai     = $this->request->getPost('nilai');
        $catatan   = $this->request->getPost('catatan');
        $today     = date('Y-m-d');

        if (!$juriId) {
            return redirect()->to(base_url('auth'))->with('error', 'Sesi login telah berakhir.');
        }

        if (!$pesertaId || $nilai === null || $nilai === '') {
            return redirect()->back()->with('error', 'Data vote tidak lengkap!');
        }

        // Pastikan nilai berada pada rentang 0 - 100
        if ($nilai < 0 || $nilai > 100) {
            return redirect()->back()->with('error', 'Nilai harus berada dalam rentang 0 hingga 100!');
        }

        // Cek apakah juri SUDAH pernah vote peserta ini HARI INI
        $existing = $this->db->table('penilaian')
            ->where('juri_id', $juriId)
            ->where('peserta_id', $pesertaId)
            ->where('tgl_vote', $today)
            ->get()
            ->getRowArray();

        if ($existing) {
            return redirect()->back()->with('error', 'Anda sudah memberikan vote untuk peserta ini hari ini dan tidak dapat diubah!');
        }

        // INSERT VOTE BARU
        $dataSave = [
            'juri_id'    => $juriId,
            'peserta_id' => $pesertaId,
            'tgl_vote'   => $today,
            'nilai'      => $nilai,
            'catatan'    => $catatan,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('penilaian')->insert($dataSave);

        return redirect()->to(base_url('juri/penilaian'))->with('success', 'Vote berhasil disimpan dan terkunci!');
    }
}
