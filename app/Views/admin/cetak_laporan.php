<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Laporan Akumulasi Nilai Peserta') ?> - <?= date('d-m-Y', strtotime($tanggal ?? date('Y-m-d'))) ?></title>
    <style>
        /* Setting Halaman Cetak A4 */
        @page {
            size: A4 portrait;
            margin: 15mm 15mm 20mm 15mm;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            font-size: 11pt;
            line-height: 1.4;
        }

        /* Kop Surat / Header Laporan */
        .header {
            text-align: center;
            border-bottom: 3px double #0f172a;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 18pt;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #0f172a;
        }

        .header h2 {
            margin: 4px 0 0 0;
            font-size: 13pt;
            font-weight: 500;
            color: #475569;
        }

        .header p {
            margin: 4px 0 0 0;
            font-size: 9pt;
            color: #64748b;
        }

        /* Styling Tabel Hasil */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.data-table th {
            background-color: #0f172a;
            color: #ffffff;
            font-size: 8.5pt;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 8px 6px;
            border: 1px solid #0f172a;
            text-align: center;
        }

        table.data-table td {
            padding: 7px 8px;
            border: 1px solid #cbd5e1;
            font-size: 9pt;
        }

        table.data-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }

        .rank-badge {
            font-weight: bold;
            display: inline-block;
            width: 20px;
            text-align: center;
        }

        /* Tanda Tangan / Pengesahan */
        .footer-signature {
            margin-top: 40px;
            width: 100%;
            page-break-inside: avoid;
        }

        .signature-box {
            float: right;
            width: 220px;
            text-align: center;
            font-size: 9.5pt;
        }

        .signature-space {
            height: 65px;
        }

        /* Menyembunyikan tombol saat dicetak */
        @media print {
            .no-print {
                display: none !important;
            }
        }

        /* Floating Action Bar (Hanya Muncul di Layar Web) */
        .no-print-bar {
            background: #1e293b;
            color: white;
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12px;
            cursor: pointer;
            border: none;
            text-decoration: none;
            display: inline-block;
        }

        .btn-print {
            background-color: #10b981;
            color: white;
        }

        .btn-close {
            background-color: #64748b;
            color: white;
        }
    </style>
</head>

<body>

    <!-- Panel Tombol Cetak (Otomatis Sembunyi Saat Print) -->
    <div class="no-print-bar no-print">
        <div>
            <strong>Mode Pratinjau Cetak</strong> — Silakan periksa dokumen sebelum dicetak.
        </div>
        <div>
            <button onclick="window.print()" class="btn btn-print">🖨️ Cetak / Simpan PDF</button>
            <button onclick="window.close()" class="btn btn-close">Tutup</button>
        </div>
    </div>

    <!-- Header Laporan -->
    <div class="header">
        <h1>Laporan Akumulasi Nilai Peserta</h1>
        <h2>Rekapitulasi Peringkat Voting & Penilaian Juri</h2>
        <p>Tanggal Sesi: <strong><?= date('d F Y', strtotime($tanggal ?? date('Y-m-d'))) ?></strong></p>
    </div>

    <!-- Metadata Informasi -->
    <table style="width: 100%; margin-bottom: 12px; font-size: 9pt;">
        <tr>
            <td width="15%"><strong>Total Juri</strong></td>
            <td width="35%">: <?= $total_juri ?? 0 ?> Orang (Tetap: <?= $total_juri_tetap ?? 0 ?>, Sementara: <?= $total_juri_sementara ?? 0 ?>)</td>
            <td width="20%"><strong>Waktu Cetak</strong></td>
            <td width="30%">: <?= date('d/m/Y H:i') ?> WITA</td>
        </tr>
        <tr>
            <td><strong>Total Peserta</strong></td>
            <td>: <?= count($peringkat ?? []) ?> Orang</td>
            <td><strong>Dicetak Oleh</strong></td>
            <td>: Administrator</td>
        </tr>
    </table>

    <!-- Tabel Data Akumulasi -->
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">Rank</th>
                <th width="7%">No. Urut</th>
                <th width="23%" style="text-align: left;">Nama Peserta</th>
                <th width="15%" style="text-align: left;">Asal Daerah</th>
                <th width="12%">Juri Tetap<br><small>(50%)</small></th>
                <th width="12%">Juri Sementara<br><small>(40%)</small></th>
                <th width="12%">Sosmed<br><small>(10%)</small></th>
                <th width="14%">Nilai Akhir</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($peringkat)) : ?>
                <?php $rank = 1; ?>
                <?php foreach ($peringkat as $row) : ?>
                    <?php
                    // Menangani pembacaan properti nilai akhir
                    $nilaiAkhir = $row['nilai_akhir'] ?? $row['total_nilai'] ?? 0;
                    ?>
                    <tr>
                        <td class="text-center font-bold">
                            <span class="rank-badge"><?= $rank ?></span>
                        </td>
                        <td class="text-center font-bold">
                            <?= sprintf('%02d', $row['nomor_urut'] ?? 0) ?>
                        </td>
                        <td class="font-bold"><?= esc($row['nama_peserta'] ?? '-') ?></td>
                        <td><?= esc($row['asal_daerah'] ?? '-') ?></td>
                        <td class="text-center"><?= number_format((float)($row['avg_juri_tetap'] ?? 0), 2) ?></td>
                        <td class="text-center"><?= number_format((float)($row['avg_juri_sementara'] ?? 0), 2) ?></td>
                        <td class="text-center"><?= number_format((float)($row['nilai_sosmed'] ?? 0), 2) ?></td>
                        <td class="text-center font-bold" style="font-size: 10pt; background-color: #f8fafc;">
                            <?= number_format((float)$nilaiAkhir, 2) ?>
                        </td>
                    </tr>
                    <?php $rank++; ?>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="8" class="text-center" style="padding: 20px;">
                        <em>Tidak ada data penilaian pada tanggal ini.</em>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Lembar Pengesahan / Tanda Tangan -->
    <div class="footer-signature">
        <div class="signature-box">
            <p>Panitia Pelaksana,<br>Ketua / Koordinator Juri</p>
            <div class="signature-space"></div>
            <p><u>( ............................................ )</u><br>NIP / ID:</p>
        </div>
        <div style="clear: both;"></div>
    </div>

    <!-- Auto Dialog Print saat halaman terbuka (Opsional) -->
    <script>
        window.onload = function() {
            // Un-comment baris di bawah ini jika ingin dialog print langsung muncul begitu halaman dibuka:
            // window.print();
        }
    </script>
</body>

</html>