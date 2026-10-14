<?php

namespace App\Models;

use CodeIgniter\Model;

class PesertaModel extends Model
{
    protected $table            = 'peserta';
    protected $primaryKey       = 'id';

    // TAMBAHKAN 'status' DI SINI
    protected $allowedFields    = [
        'nomor_urut',
        'nama_peserta',
        'alamat',
        'no_wa',
        'jenis_kelamin',
        'foto',
        'ktp_pelajar',
        'bukti_bayar',
        'formulir_doc',
        'status',          // <--- Masukkan di sini
        'created_at'
    ];
}
