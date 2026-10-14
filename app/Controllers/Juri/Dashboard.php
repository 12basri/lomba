<?php

namespace App\Controllers\Juri;

use App\Controllers\BaseController;

class Dashboard extends BaseController
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
        $userRole = session('role');

        // Tentukan bobot dinamis berdasarkan role juri
        $bobotPersen = ($userRole === 'juri_tetap') ? 60 : 30;
        $multiplier  = $bobotPersen / 100;

        // 1. Hitung total peserta yang berstatus 'diterima'
        $totalPeserta = $this->db->table('peserta')
            ->where('status', 'diterima')
            ->countAllResults();

        // 2. Hitung jumlah peserta unik yang sudah dinilai oleh juri ini
        $pesertaDinilai = 0;
        if ($juriId) {
            $row = $this->db->table('penilaian p')
                ->select('COUNT(DISTINCT p.peserta_id) as total')
                ->join('peserta ps', 'ps.id = p.peserta_id')
                ->where('p.juri_id', $juriId)
                ->where('ps.status', 'diterima')
                ->get()
                ->getRowArray();

            $pesertaDinilai = (int) ($row['total'] ?? 0);
        }

        // 3. Hitung sisa peserta yang belum dinilai
        $pesertaBelum = max(0, $totalPeserta - $pesertaDinilai);

        // 4. Ambil 5 riwayat penilaian terbaru juri ini
        $penilaianTerbaru = [];
        if ($juriId) {
            $penilaianTerbaru = $this->db->table('penilaian p')
                ->select("
                    p.id, 
                    p.nilai as nilai_murni, 
                    (p.nilai * {$multiplier}) as nilai_bobot,
                    p.catatan, 
                    p.created_at, 
                    ps.nama_peserta, 
                    ps.nomor_urut, 
                    ps.alamat,
                    ps.foto
                ")
                ->join('peserta ps', 'ps.id = p.peserta_id')
                ->where('p.juri_id', $juriId)
                ->orderBy('p.created_at', 'DESC')
                ->limit(5)
                ->get()
                ->getResultArray();
        }

        $data = [
            'title'            => 'Dashboard Juri',
            'page_title'       => 'Dashboard Juri',
            'totalPeserta'     => $totalPeserta,
            'pesertaDinilai'   => $pesertaDinilai,
            'pesertaBelum'     => $pesertaBelum,
            'penilaianTerbaru' => $penilaianTerbaru,
        ];

        return view('juri/dashboard', $data);
    }
}
