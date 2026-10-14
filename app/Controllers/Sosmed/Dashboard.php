<?php

namespace App\Controllers\Sosmed;

use App\Controllers\BaseController;
use Dompdf\Dompdf;
use Dompdf\Options;

class Dashboard extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $tanggal   = $this->request->getGet('tanggal') ?? date('Y-m-d');
        $sosmed_id = session()->get('user_id') ?? session()->get('id');

        // 1. Total Seluruh Peserta Berstatus 'diterima'
        $totalPeserta = $this->db->table('peserta')
            ->where('status', 'diterima')
            ->countAllResults();

        // 2. Total Peserta yang Sudah Diinput Nilai Sosmednya Hari Ini oleh User Ini
        $totalDinilai = $this->db->table('penilaian')
            ->where('juri_id', $sosmed_id)
            ->where('tgl_vote', $tanggal)
            ->countAllResults();

        // 3. Detail Penilaian Hari Ini (Kalkulasi otomatis skala 0-100)
        $penilaianHariIni = $this->db->table('peserta p')
            ->select('
                p.nomor_urut, 
                p.nama_peserta, 
                pen.likes, 
                pen.followers, 
                pen.views, 
                pen.updated_at,
                LEAST(100, ((COALESCE(pen.likes, 0) + COALESCE(pen.followers, 0) + COALESCE(pen.views, 0)) / 10)) as nilai_sosmed
            ')
            ->join('penilaian pen', "pen.peserta_id = p.id AND pen.juri_id = '$sosmed_id' AND pen.tgl_vote = '$tanggal'", 'left')
            ->where('p.status', 'diterima')
            ->orderBy('p.nomor_urut', 'ASC')
            ->get()->getResultArray();

        // 4. Rekap Perolehan Hasil Vote Sosmed Keseluruhan (Bobot 10%)
        $rekapHasilVote = $this->getRekapHasilVoteData($tanggal);

        $data = [
            'title'            => 'Dashboard & Hasil Vote Sosmed',
            'tanggal_filter'   => $tanggal,
            'totalPeserta'     => $totalPeserta,
            'totalDinilai'     => $totalDinilai,
            'belumDinilai'     => max(0, $totalPeserta - $totalDinilai),
            'penilaianHariIni' => $penilaianHariIni,
            'rekapHasilVote'   => $rekapHasilVote,
        ];

        return view('sosmed/v_dashboard', $data);
    }

    /**
     * Method untuk Export/Cetak Laporan PDF Hasil Vote
     */
    public function exportPdf()
    {
        if (file_exists(ROOTPATH . 'vendor/autoload.php')) {
            require_once ROOTPATH . 'vendor/autoload.php';
        }

        $tanggal = $this->request->getGet('tanggal') ?? date('Y-m-d');

        // Fetch Rekap Perolehan Hasil Vote Sosmed
        $rekapHasilVote = $this->getRekapHasilVoteData($tanggal);

        $data = [
            'rekapHasilVote' => $rekapHasilVote,
            'tanggal'        => $tanggal,
        ];

        // Render HTML view khusus PDF
        $html = view('sosmed/v_export_pdf', $data);

        // Inisialisasi Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Preview langsung di browser
        $dompdf->stream('Laporan_Hasil_Vote_Sosmed_' . $tanggal . '.pdf', ['Attachment' => false]);
    }

    /**
     * Helper Query Rekap Perolehan Hasil Vote Sosmed Ter-Kalkulasi
     */
    private function getRekapHasilVoteData($tanggal)
    {
        $escapedTanggal = $this->db->escape($tanggal);

        return $this->db->table('peserta p')
            ->select('
                p.id,
                p.nomor_urut,
                p.nama_peserta,
                p.alamat,
                COALESCE(SUM(CASE WHEN pen.tgl_vote = ' . $escapedTanggal . ' THEN pen.likes ELSE 0 END), 0) as total_likes,
                COALESCE(SUM(CASE WHEN pen.tgl_vote = ' . $escapedTanggal . ' THEN pen.followers ELSE 0 END), 0) as total_followers,
                COALESCE(SUM(CASE WHEN pen.tgl_vote = ' . $escapedTanggal . ' THEN pen.views ELSE 0 END), 0) as total_views,
                LEAST(100, (
                    (COALESCE(SUM(CASE WHEN pen.tgl_vote = ' . $escapedTanggal . ' THEN pen.likes ELSE 0 END), 0) +
                     COALESCE(SUM(CASE WHEN pen.tgl_vote = ' . $escapedTanggal . ' THEN pen.followers ELSE 0 END), 0) +
                     COALESCE(SUM(CASE WHEN pen.tgl_vote = ' . $escapedTanggal . ' THEN pen.views ELSE 0 END), 0)) / 10
                )) as rata_nilai,
                (LEAST(100, (
                    (COALESCE(SUM(CASE WHEN pen.tgl_vote = ' . $escapedTanggal . ' THEN pen.likes ELSE 0 END), 0) +
                     COALESCE(SUM(CASE WHEN pen.tgl_vote = ' . $escapedTanggal . ' THEN pen.followers ELSE 0 END), 0) +
                     COALESCE(SUM(CASE WHEN pen.tgl_vote = ' . $escapedTanggal . ' THEN pen.views ELSE 0 END), 0)) / 10
                )) * 0.10) as nilai_bobot_10
            ')
            ->join('penilaian pen', 'pen.peserta_id = p.id', 'left')
            ->join('users u', 'u.id = pen.juri_id AND u.role = \'sosmed\'', 'left')
            ->where('p.status', 'diterima')
            ->groupBy(['p.id', 'p.nomor_urut', 'p.nama_peserta', 'p.alamat'])
            ->orderBy('rata_nilai', 'DESC')
            ->orderBy('total_likes', 'DESC')
            ->get()->getResultArray();
    }

    /**
     * Method untuk memproses Reset Vote Sosmed
     */
    public function resetVote()
    {
        $tanggal   = $this->request->getPost('tanggal');
        $type      = $this->request->getPost('type'); // 'hari_ini' atau 'semua'
        $sosmed_id = session()->get('user_id') ?? session()->get('id');

        $builder = $this->db->table('penilaian');

        if ($type === 'hari_ini' && !empty($tanggal)) {
            $builder->where('tgl_vote', $tanggal);
            if ($sosmed_id) {
                $builder->where('juri_id', $sosmed_id);
            }
            $builder->delete();
            return redirect()->to(base_url('sosmed/dashboard?tanggal=' . $tanggal))->with('success', "Data nilai sosmed tanggal $tanggal berhasil di-reset.");
        } elseif ($type === 'semua') {
            if ($sosmed_id) {
                $builder->where('juri_id', $sosmed_id);
            }
            $builder->delete();
            return redirect()->to(base_url('sosmed/dashboard'))->with('success', 'Seluruh data nilai sosmed berhasil di-reset.');
        }

        return redirect()->to(base_url('sosmed/dashboard'))->with('error', 'Gagal memproses reset nilai.');
    }
}
