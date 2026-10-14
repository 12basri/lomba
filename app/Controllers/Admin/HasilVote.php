<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class HasilVote extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        // Jika jam < 05:00 Pagi, sistem menganggap masih sesi hari kemarin
        $defaultTanggal = (date('H') < 5) ? date('Y-m-d', strtotime('-1 day')) : date('Y-m-d');

        // Ambil tanggal dari GET parameter, jika kosong pakai default
        $tanggal = $this->request->getGet('tanggal') ?? $defaultTanggal;

        $penilaian  = $this->getPenilaianData($tanggal);
        $rekapNilai = $this->getRekapAkumulasi($tanggal);

        // Jika dipanggil via AJAX (Live Update UI)
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'penilaian'  => $penilaian,
                'rekapNilai' => $rekapNilai
            ]);
        }

        $data = [
            'title'          => 'Hasil Vote Juri',
            'page_title'     => 'Hasil Vote Juri',
            'penilaian'      => $penilaian,
            'rekapNilai'     => $rekapNilai,
            'tanggal_filter' => $tanggal,
        ];

        return view('admin/hasil_vote/index', $data);
    }

    // Method untuk Mencetak/Export Laporan Sesi Vote
    public function export()
    {
        $defaultTanggal = (date('H') < 5) ? date('Y-m-d', strtotime('-1 day')) : date('Y-m-d');
        $tanggal = $this->request->getGet('tanggal') ?? $defaultTanggal;

        $data = [
            'title'          => 'Laporan Hasil Vote - ' . date('d/m/Y', strtotime($tanggal)),
            'penilaian'      => $this->getPenilaianData($tanggal),
            'rekapNilai'     => $this->getRekapAkumulasi($tanggal),
            'tanggal_filter' => $tanggal,
        ];

        return view('admin/hasil_vote/cetak', $data);
    }

    /**
     * Method untuk Menghapus/Reset SELURUH Data Vote
     */
    public function reset()
    {
        try {
            $this->db->transStart();

            // Mengosongkan seluruh isi tabel penilaian
            $this->db->table('penilaian')->emptyTable();

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                return redirect()->to(base_url('admin/hasil-vote'))
                    ->with('error', 'Gagal mereset data vote.');
            }

            return redirect()->to(base_url('admin/hasil-vote'))
                ->with('success', 'Berhasil mereset SELURUH data vote dari sistem.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('admin/hasil-vote'))
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Mengambil Rincian Seluruh Transaksi Vote yang Masuk
     */
    private function getPenilaianData($tanggal)
    {
        $escapedTanggal = $this->db->escape($tanggal);

        $builder = $this->db->table('penilaian p');
        $builder->select('p.*, u.nama_lengkap as nama_juri, u.role as role_juri, pes.nama_peserta, pes.nomor_urut, pes.foto, pes.alamat as asal_daerah');
        $builder->join('users u', 'u.id = p.juri_id');
        $builder->join('peserta pes', 'pes.id = p.peserta_id');

        $builder->where("(DATE(p.tgl_vote) = {$escapedTanggal} OR DATE(p.created_at) = {$escapedTanggal})");
        $builder->orderBy('p.created_at', 'DESC');

        return $builder->get()->getResultArray();
    }

    /**
     * Mengambil Rekap Akumulasi Terbobot (60% Juri Tetap, 30% Juri Tamu, 10% Sosmed)
     */
    private function getRekapAkumulasi($tanggal)
    {
        $escapedTanggal = $this->db->escape($tanggal);

        return $this->db->table('peserta p')
            ->select('
                p.id, 
                p.nomor_urut, 
                p.nama_peserta, 
                p.alamat as asal_daerah, 
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
            ->join('penilaian pn', 'pn.peserta_id = p.id AND (DATE(pn.tgl_vote) = ' . $escapedTanggal . ' OR DATE(pn.created_at) = ' . $escapedTanggal . ')', 'left')
            ->join('users u', 'u.id = pn.juri_id', 'left')
            ->where('p.status', 'diterima')
            ->groupBy('p.id')
            ->orderBy('nilai_akhir', 'DESC')
            ->get()
            ->getResultArray();
    }
}
