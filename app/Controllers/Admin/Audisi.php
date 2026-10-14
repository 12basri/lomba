<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PesertaModel;
use App\Models\UserModel;

class Audisi extends BaseController
{
    protected $pesertaModel;
    protected $userModel;

    public function __construct()
    {
        $this->pesertaModel = new PesertaModel();
        $this->userModel    = new UserModel();
    }

    public function index()
    {
        // Hitung total juri berdasarkan role
        $totalJuriTetap     = $this->userModel->where('role', 'juri_tetap')->countAllResults();
        $totalJuriSementara = $this->userModel->where('role', 'juri_sementara')->countAllResults();

        // Hitung statistik pendaftar & peserta resmi
        $totalPendaftarAudisi = $this->pesertaModel->countAllResults();
        $totalPesertaLolos    = $this->pesertaModel->where('status', 'diterima')->countAllResults();

        $data = [
            'title'                  => 'Data Mendaftar Audisi',
            'pendaftar'              => $this->pesertaModel->orderBy('id', 'DESC')->findAll(),
            'total_peserta'          => $totalPesertaLolos, // Hanya yang sudah diverifikasi/diterima
            'total_pendaftar_audisi' => $totalPendaftarAudisi, // Total semua pendaftar
            'total_juri_tetap'       => $totalJuriTetap,
            'total_juri_sementara'   => $totalJuriSementara,
        ];

        return view('admin/audisi/index', $data);
    }

    /**
     * Verifikasi Pendaftar menjadi Peserta Lomba/Audisi
     */
    public function verifikasi($id = null)
    {
        $pendaftar = $this->pesertaModel->find($id);

        if (!$pendaftar) {
            return redirect()->to(base_url('admin/audisi'))->with('error', 'Data pendaftar tidak ditemukan.');
        }

        // Ambil status dari form request atau query string (default: diterima)
        $status = $this->request->getPost('status') ?? $this->request->getGet('status') ?? 'diterima';

        if ($status === 'diterima') {
            // Jika belum memiliki nomor urut, buatkan nomor urut peserta resmi secara otomatis
            $nomorUrut = $pendaftar['nomor_urut'];

            if (empty($nomorUrut)) {
                $lastPeserta = $this->pesertaModel
                    ->selectMax('nomor_urut')
                    ->where('status', 'diterima')
                    ->first();

                $nomorUrut = ($lastPeserta['nomor_urut'] ?? 0) + 1;
            }

            $this->pesertaModel->update($id, [
                'status'     => 'diterima',
                'nomor_urut' => $nomorUrut
            ]);

            return redirect()->to(base_url('admin/audisi'))->with('success', 'Pendaftar berhasil diverifikasi menjadi peserta resmi (No. Urut: ' . sprintf('%02d', $nomorUrut) . ').');
        } elseif ($status === 'ditolak') {
            $this->pesertaModel->update($id, [
                'status'     => 'ditolak',
                'nomor_urut' => null
            ]);

            return redirect()->to(base_url('admin/audisi'))->with('success', 'Status pendaftar berhasil diubah menjadi Ditolak.');
        }

        return redirect()->to(base_url('admin/audisi'))->with('error', 'Aksi verifikasi tidak valid.');
    }

    public function delete($id = null)
    {
        $peserta = $this->pesertaModel->find($id);

        if ($peserta) {
            // Hapus file fisik jika ada
            $files = ['foto', 'ktp_pelajar', 'bukti_bayar', 'formulir_doc', 'kartu_identitas'];
            foreach ($files as $file) {
                if (!empty($peserta[$file]) && $peserta[$file] !== 'default.jpg') {
                    $filePath = FCPATH . 'uploads/peserta/' . $peserta[$file];
                    if (file_exists($filePath)) {
                        @unlink($filePath);
                    }
                }
            }

            $this->pesertaModel->delete($id);
            return redirect()->to(base_url('admin/audisi'))->with('success', 'Data pendaftar berhasil dihapus.');
        }

        return redirect()->to(base_url('admin/audisi'))->with('error', 'Data pendaftar tidak ditemukan.');
    }
}
