<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Grafik extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $tanggal = $this->request->getGet('tanggal') ?? date('Y-m-d');

        // Total Counts untuk Badge Sidebar
        $totalJuriTetap = $this->db->table('users')->where('role', 'juri_tetap')->countAllResults();
        $totalJuriTamu  = $this->db->table('users')->whereIn('role', ['juri_tamu', 'juri_sementara'])->countAllResults();
        $totalPeserta   = $this->db->table('peserta')->countAllResults();

        // Ambil Mode Grafik Aktif dari Database
        $setting    = $this->db->table('settings')->where('key', 'mode_grafik')->get()->getRowArray();
        $activeMode = $setting['value'] ?? 'akumulasi';

        // Query Rekap Penilaian Peserta Terbobot (Per Tanggal Filter)
        // Bobot: Juri Tetap (60%), Juri Tamu (30%), Sosmed (10%)
        $rekapHasil = $this->db->table('peserta p')
            ->select('
                p.nomor_urut,
                p.nama_peserta,
                COALESCE(AVG(CASE WHEN u.role = \'juri_tetap\' THEN pen.nilai END), 0) as avg_juri_tetap,
                COALESCE(AVG(CASE WHEN u.role IN (\'juri_tamu\', \'juri_sementara\') THEN pen.nilai END), 0) as avg_juri_tamu,
                COALESCE(AVG(CASE WHEN u.role = \'sosmed\' THEN pen.nilai END), 0) as nilai_sosmed,
                (
                    (COALESCE(AVG(CASE WHEN u.role = \'juri_tetap\' THEN pen.nilai END), 0) * 0.60) +
                    (COALESCE(AVG(CASE WHEN u.role IN (\'juri_tamu\', \'juri_sementara\') THEN pen.nilai END), 0) * 0.30) +
                    (COALESCE(AVG(CASE WHEN u.role = \'sosmed\' THEN pen.nilai END), 0) * 0.10)
                ) as nilai_akhir
            ')
            ->join('penilaian pen', 'pen.peserta_id = p.id AND pen.tgl_vote = ' . $this->db->escape($tanggal), 'left')
            ->join('users u', 'u.id = pen.juri_id', 'left')
            ->groupBy('p.id')
            ->orderBy('p.nomor_urut', 'ASC')
            ->get()->getResultArray();

        // Format data untuk Chart.js (Label & Dataset)
        $labels         = [];
        $dataJuriTetap  = [];
        $dataJuriTamu   = [];
        $dataSosmed     = [];
        $dataNilaiAkhir = [];

        foreach ($rekapHasil as $row) {
            $labels[]         = 'No. ' . $row['nomor_urut'] . ' - ' . $row['nama_peserta'];
            $dataJuriTetap[]  = round((float)$row['avg_juri_tetap'], 2);
            $dataJuriTamu[]   = round((float)$row['avg_juri_tamu'], 2);
            $dataSosmed[]     = round((float)$row['nilai_sosmed'], 2);
            $dataNilaiAkhir[] = round((float)$row['nilai_akhir'], 2);
        }

        $data = [
            'title'                => 'Grafik & Analisis Perolehan Nilai',
            'tanggal_filter'       => $tanggal,
            'active_mode'          => $activeMode,
            'total_juri_tetap'     => $totalJuriTetap,
            'total_juri_sementara' => $totalJuriTamu,
            'total_juri_tamu'      => $totalJuriTamu,
            'total_peserta'        => $totalPeserta,
            'chartLabels'          => json_encode($labels),
            'chartDataJuriTetap'   => json_encode($dataJuriTetap),
            'chartDataJuriTamu'    => json_encode($dataJuriTamu),
            'chartDataSosmed'      => json_encode($dataSosmed),
            'chartDataTotal'       => json_encode($dataNilaiAkhir),
        ];

        return view('admin/v_grafik', $data);
    }

    /**
     * Endpoint AJAX untuk menyimpan mode grafik yang dipilih oleh Admin
     */
    public function setMode()
    {
        $mode = $this->request->getPost('mode'); // 'akumulasi' atau 'sosmed'

        if (in_array($mode, ['akumulasi', 'sosmed'])) {
            // Menggunakan replace untuk Insert or Update otomatis
            $this->db->table('settings')->replace([
                'key'   => 'mode_grafik',
                'value' => $mode
            ]);

            return $this->response->setJSON([
                'status' => 'success',
                'mode'   => $mode
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Mode tidak valid'
        ], 400);
    }
}
