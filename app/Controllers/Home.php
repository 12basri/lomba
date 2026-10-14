<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index(): string
    {
        $tanggal = $this->request->getGet('tanggal') ?? date('Y-m-d');
        return view('pages/publik_grafik', ['tanggal_filter' => $tanggal]);
    }

    public function getData()
    {
        $tanggal = $this->request->getGet('tanggal') ?? date('Y-m-d');

        // 1. Ambil Mode Grafik Aktif dari Settings (akumulasi / sosmed)
        $setting = $this->db->table('settings')->where('key', 'mode_grafik')->get()->getRowArray();
        $modeGrafik = $setting['value'] ?? 'akumulasi';

        // 2. Ambil seluruh peserta menggunakan kolom `alamat`
        $pesertaList = $this->db->table('peserta')
            ->select('id, nomor_urut, nama_peserta, alamat, foto')
            ->get()
            ->getResultArray();

        // 3. Ambil data penilaian berdasarkan tanggal
        $penilaian = $this->db->table('penilaian pen')
            ->select('pen.*, u.role')
            ->join('users u', 'u.id = pen.juri_id', 'left')
            ->where('pen.tgl_vote', $tanggal)
            ->get()
            ->getResultArray();

        // Grouping penilaian berdasarkan peserta_id dan role
        $scores = [];
        $maxSosmedEngagement = 0;

        foreach ($penilaian as $row) {
            $pId = $row['peserta_id'];

            if (!isset($scores[$pId])) {
                $scores[$pId] = [
                    'juri_tetap' => [],
                    'juri_tamu'  => [],
                    'sosmed_raw' => 0
                ];
            }

            if ($row['role'] === 'juri_tetap') {
                $scores[$pId]['juri_tetap'][] = (float) $row['nilai'];
            } elseif (in_array($row['role'], ['juri_tamu', 'juri'])) {
                $scores[$pId]['juri_tamu'][] = (float) $row['nilai'];
            } elseif ($row['role'] === 'sosmed') {
                // Hitung total engagement dari kolom likes, followers, views
                $engagement = (int)$row['likes'] + (int)$row['followers'] + (int)$row['views'];
                $scores[$pId]['sosmed_raw'] += $engagement;

                if ($scores[$pId]['sosmed_raw'] > $maxSosmedEngagement) {
                    $maxSosmedEngagement = $scores[$pId]['sosmed_raw'];
                }
            }
        }

        // 4. Kalkulasi Nilai Akhir Per Peserta
        $peringkat = [];

        foreach ($pesertaList as $p) {
            $pId = $p['id'];
            $dataNilai = $scores[$pId] ?? ['juri_tetap' => [], 'juri_tamu' => [], 'sosmed_raw' => 0];

            // Rata-rata Juri Tetap
            $avgTetap = !empty($dataNilai['juri_tetap'])
                ? array_sum($dataNilai['juri_tetap']) / count($dataNilai['juri_tetap'])
                : 0;

            // Rata-rata Juri Tamu / Sementara
            $avgTamu = !empty($dataNilai['juri_tamu'])
                ? array_sum($dataNilai['juri_tamu']) / count($dataNilai['juri_tamu'])
                : 0;

            // Normalisasi Nilai Sosmed ke Skala 0-100
            $nilaiSosmed = 0;
            if ($maxSosmedEngagement > 0) {
                $nilaiSosmed = ($dataNilai['sosmed_raw'] / $maxSosmedEngagement) * 100;
            }

            // Hitung nilai akhir sesuai persentase bobot (50% Tetap, 40% Tamu, 10% Sosmed)
            $nilaiAkhir = ($avgTetap * 0.50) + ($avgTamu * 0.40) + ($nilaiSosmed * 0.10);
            $skorDisplay = ($modeGrafik === 'sosmed') ? $nilaiSosmed : $nilaiAkhir;

            $peringkat[] = [
                'id'           => $p['id'],
                'nomor_urut'   => $p['nomor_urut'],
                'nama_peserta' => $p['nama_peserta'],
                'alamat'       => $p['alamat'] ?? '-',
                'judul_lagu'   => '-',
                'foto'         => $p['foto'],
                'total_nilai'  => round((float)$skorDisplay, 2),
                'nilai_akhir'  => round((float)$nilaiAkhir, 2)
            ];
        }

        // 5. Urutkan Peserta Berdasarkan Skor Tertinggi
        usort($peringkat, function ($a, $b) {
            return $b['total_nilai'] <=> $a['total_nilai'];
        });

        return $this->response->setJSON([
            'status'      => 'success',
            'tanggal'     => $tanggal,
            'mode_grafik' => $modeGrafik,
            'peringkat'   => $peringkat
        ]);
    }
}
