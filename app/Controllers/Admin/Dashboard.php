<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        // 1. Tangkap filter tanggal (default: hari ini)
        $tanggal = $this->request->getGet('tanggal') ?? date('Y-m-d');

        // 2. Statistics Data
        $totalPeserta    = $this->db->table('peserta')->countAllResults();
        $totalJuriTetap  = $this->db->table('users')->where('role', 'juri_tetap')->where('status', 'aktif')->countAllResults();
        $totalJuriTamu   = $this->db->table('users')->where('role', 'juri_tamu')->where('status', 'aktif')->countAllResults();
        $totalSosmed     = $this->db->table('users')->where('role', 'sosmed')->where('status', 'aktif')->countAllResults();

        $totalJuri       = $totalJuriTetap + $totalJuriTamu;
        $totalUserPenilai = $totalJuri + $totalSosmed;

        // 3. Hitung persentase progress vote masuk pada tanggal terpilih
        $totalVoteHarusMasuk = $totalPeserta * $totalUserPenilai;
        $totalVoteMasuk      = $this->db->table('penilaian')
            ->where('tgl_vote', $tanggal)
            ->countAllResults();

        $progress = ($totalVoteHarusMasuk > 0)
            ? ($totalVoteMasuk / $totalVoteHarusMasuk) * 100
            : 0;

        // 4. Query Rekap Nilai Terbobot
        // Bobot Baru: Juri Tetap (60%), Juri Tamu (30%), Sosmed (10%)
        $peringkat = $this->db->table('peserta p')
            ->select('
                p.id, 
                p.nomor_urut, 
                p.nama_peserta, 
                p.alamat,
                p.no_wa,
                p.jenis_kelamin,
                p.foto,
                COALESCE(AVG(CASE WHEN u.role = \'juri_tetap\' THEN pn.nilai END), 0) as avg_juri_tetap,
                COALESCE(AVG(CASE WHEN u.role = \'juri_tamu\' THEN pn.nilai END), 0) as avg_juri_tamu,
                COALESCE(AVG(CASE WHEN u.role = \'sosmed\' THEN pn.nilai END), 0) as nilai_sosmed,
                (
                    (COALESCE(AVG(CASE WHEN u.role = \'juri_tetap\' THEN pn.nilai END), 0) * 0.60) +
                    (COALESCE(AVG(CASE WHEN u.role = \'juri_tamu\' THEN pn.nilai END), 0) * 0.30) +
                    (COALESCE(AVG(CASE WHEN u.role = \'sosmed\' THEN pn.nilai END), 0) * 0.10)
                ) as nilai_akhir
            ')
            ->join('penilaian pn', 'pn.peserta_id = p.id AND pn.tgl_vote = ' . $this->db->escape($tanggal), 'left')
            ->join('users u', 'u.id = pn.juri_id', 'left')
            ->groupBy('p.id')
            ->orderBy('nilai_akhir', 'DESC')
            ->get()
            ->getResultArray();

        // 5. Data dikirim ke View Dashboard
        $data = [
            'title'            => 'Dashboard Admin',
            'tanggal_filter'   => $tanggal,
            'total_peserta'    => $totalPeserta,
            'total_juri_tetap' => $totalJuriTetap,
            'total_juri_tamu'  => $totalJuriTamu,
            'total_juri'       => $totalJuri,
            'total_sosmed'     => $totalSosmed,
            'progress'         => round($progress, 2),
            'peringkat'        => $peringkat,
        ];

        return view('admin/dashboard', $data);
    }

    /**
     * Reset seluruh vote berdasarkan tanggal tertentu
     */
    public function resetVote()
    {
        $tanggal = $this->request->getPost('tanggal') ?? date('Y-m-d');

        $this->db->table('penilaian')->where('tgl_vote', $tanggal)->delete();

        return redirect()->to(base_url('admin/dashboard?tanggal=' . $tanggal))
            ->with('success', 'Seluruh data vote pada tanggal ' . $tanggal . ' berhasil di-reset!');
    }

    /**
     * Cetak / Export Laporan dengan Nilai Akhir Terbobot
     */
    public function export()
    {
        $tanggal = $this->request->getGet('tanggal') ?? date('Y-m-d');

        $totalPeserta    = $this->db->table('peserta')->countAllResults();
        $totalJuriTetap  = $this->db->table('users')->where('role', 'juri_tetap')->where('status', 'aktif')->countAllResults();
        $totalJuriTamu   = $this->db->table('users')->where('role', 'juri_tamu')->where('status', 'aktif')->countAllResults();
        $totalSosmed     = $this->db->table('users')->where('role', 'sosmed')->where('status', 'aktif')->countAllResults();

        $totalJuri       = $totalJuriTetap + $totalJuriTamu;

        // Data Peringkat berdasarkan akumulasi bobot nilai (60% / 30% / 10%)
        $peringkat = $this->db->table('peserta p')
            ->select('
                p.id, 
                p.nomor_urut, 
                p.nama_peserta, 
                p.alamat,
                p.no_wa,
                p.jenis_kelamin,
                COALESCE(AVG(CASE WHEN u.role = \'juri_tetap\' THEN pn.nilai END), 0) as avg_juri_tetap,
                COALESCE(AVG(CASE WHEN u.role = \'juri_tamu\' THEN pn.nilai END), 0) as avg_juri_tamu,
                COALESCE(AVG(CASE WHEN u.role = \'sosmed\' THEN pn.nilai END), 0) as nilai_sosmed,
                (
                    (COALESCE(AVG(CASE WHEN u.role = \'juri_tetap\' THEN pn.nilai END), 0) * 0.60) +
                    (COALESCE(AVG(CASE WHEN u.role = \'juri_tamu\' THEN pn.nilai END), 0) * 0.30) +
                    (COALESCE(AVG(CASE WHEN u.role = \'sosmed\' THEN pn.nilai END), 0) * 0.10)
                ) as nilai_akhir
            ')
            ->join('penilaian pn', 'pn.peserta_id = p.id AND pn.tgl_vote = ' . $this->db->escape($tanggal), 'left')
            ->join('users u', 'u.id = pn.juri_id', 'left')
            ->groupBy('p.id')
            ->orderBy('nilai_akhir', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title'            => 'Laporan Akumulasi Nilai Peserta',
            'tanggal'          => $tanggal,
            'tanggal_filter'   => $tanggal,
            'total_peserta'    => $totalPeserta,
            'total_juri_tetap' => $totalJuriTetap,
            'total_juri_tamu'  => $totalJuriTamu,
            'total_juri'       => $totalJuri,
            'total_sosmed'     => $totalSosmed,
            'peringkat'        => $peringkat,
            'rekapNilai'       => $peringkat,
        ];

        return view('admin/cetak_laporan', $data);
    }
}
