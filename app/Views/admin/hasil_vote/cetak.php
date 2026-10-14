<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #1e293b;
            margin: 15px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 8px;
        }

        .header h2 {
            margin: 0;
            text-transform: uppercase;
            font-size: 16px;
            letter-spacing: 0.5px;
        }

        .header p {
            margin: 4px 0 0 0;
            color: #475569;
            font-size: 11px;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 8px;
            text-transform: uppercase;
            color: #0f172a;
            border-left: 3px solid #6366f1;
            padding-left: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            margin-bottom: 15px;
        }

        table,
        th,
        td {
            border: 1px solid #94a3b8;
        }

        th {
            background-color: #f1f5f9;
            padding: 6px 8px;
            text-transform: uppercase;
            font-size: 10px;
            color: #1e293b;
        }

        td {
            padding: 6px 8px;
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

        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 9px;
            font-weight: bold;
            border-radius: 4px;
            text-transform: uppercase;
        }

        .badge-tetap {
            background-color: #f3e8ff;
            color: #6b21a8;
            border: 1px solid #d8b4fe;
        }

        .badge-tamu {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .badge-sosmed {
            background-color: #e0f2fe;
            color: #075985;
            border: 1px solid #bae6fd;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 12mm;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <!-- Tombol Cetak Manual -->
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #059669; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 12px;">
            Click / Print Laporan
        </button>
        <button onclick="window.close()" style="padding: 8px 16px; background: #6b7280; color: white; border: none; border-radius: 6px; cursor: pointer; margin-left: 8px; font-size: 12px;">
            Tutup Halaman
        </button>
    </div>

    <!-- Header Laporan -->
    <div class="header">
        <h2>LAPORAN HASIL REKAPITULASI & VOTING JURI</h2>
        <p>Tanggal / Sesi: <strong><?= date('d F Y', strtotime($tanggal_filter)) ?></strong></p>
    </div>

    <!-- Section 1: Ringkasan Akumulasi Nilai Terbobot -->
    <div class="section-title">1. Rekapitulasi Akumulasi Nilai Terbobot</div>
    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">Peringkat</th>
                <th width="8%" class="text-center">No Urut</th>
                <th width="27%">Nama Peserta</th>
                <th width="15%" class="text-center">Juri Tetap<br><small>(60%)</small></th>
                <th width="15%" class="text-center">Juri Tamu<br><small>(30%)</small></th>
                <th width="15%" class="text-center">Sosmed<br><small>(10%)</small></th>
                <th width="15%" class="text-center">Nilai Akhir</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($rekapNilai)) : ?>
                <?php foreach ($rekapNilai as $rank => $res) : ?>
                    <?php
                    $avgJuriTamu = $res['avg_juri_tamu'] ?? ($res['avg_juri_sementara'] ?? 0);
                    ?>
                    <tr>
                        <td class="text-center font-bold"><?= $rank + 1 ?></td>
                        <td class="text-center"><?= sprintf('%02d', $res['nomor_urut'] ?? 0) ?></td>
                        <td>
                            <strong><?= esc($res['nama_peserta'] ?? '-') ?></strong><br>
                            <small style="color: #64748b;"><?= esc($res['asal_daerah'] ?? $res['alamat'] ?? '-') ?></small>
                        </td>
                        <td class="text-center"><?= number_format((float)($res['avg_juri_tetap'] ?? 0), 2) ?></td>
                        <td class="text-center"><?= number_format((float)$avgJuriTamu, 2) ?></td>
                        <td class="text-center"><?= number_format((float)($res['nilai_sosmed'] ?? 0), 2) ?></td>
                        <td class="text-center font-bold" style="background-color: #f8fafc; font-size: 12px;">
                            <?= number_format((float)($res['nilai_akhir'] ?? 0), 2) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="7" class="text-center" style="padding: 12px; color: #64748b;">
                        Belum ada data akumulasi nilai pada tanggal ini.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Section 2: Rincian Seluruh Transaksi Vote -->
    <div class="section-title">2. Rincian Vote Masuk</div>
    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="22%">Nama Juri</th>
                <th width="25%">Nama Peserta</th>
                <th width="8%" class="text-center">No Urut</th>
                <th width="10%" class="text-center">Nilai</th>
                <th width="30%">Catatan / Catatan Juri</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($penilaian)) : ?>
                <?php foreach ($penilaian as $index => $row) : ?>
                    <?php
                    $roleJuri = $row['role_juri'] ?? '';
                    $roleBadge = '<span class="badge badge-tetap">Juri Tetap</span>';
                    if ($roleJuri === 'juri_tamu' || $roleJuri === 'juri_sementara') {
                        $roleBadge = '<span class="badge badge-tamu">Juri Tamu</span>';
                    } elseif ($roleJuri === 'sosmed') {
                        $roleBadge = '<span class="badge badge-sosmed">Sosmed</span>';
                    }
                    ?>
                    <tr>
                        <td class="text-center"><?= $index + 1 ?></td>
                        <td>
                            <strong><?= esc($row['nama_juri'] ?? '-') ?></strong><br>
                            <?= $roleBadge ?>
                        </td>
                        <td>
                            <strong><?= esc($row['nama_peserta'] ?? '-') ?></strong><br>
                            <small style="color: #64748b;"><?= esc($row['judul_lagu'] ?? '-') ?></small>
                        </td>
                        <td class="text-center"><?= sprintf('%02d', $row['nomor_urut'] ?? 0) ?></td>
                        <td class="text-center font-bold" style="font-size: 12px;">
                            <?= number_format((float)($row['nilai'] ?? 0), 2) ?>
                        </td>
                        <td><em><?= !empty($row['catatan']) ? '"' . esc($row['catatan']) . '"' : '-' ?></em></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6" class="text-center" style="padding: 12px; color: #64748b;">
                        Tidak ada detail transaksi voting pada tanggal ini.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Tanda Tangan / Pengesahan -->
    <div style="margin-top: 30px; width: 100%;">
        <table style="border: none; width: 100%;">
            <tr style="border: none;">
                <td style="border: none; text-align: left;" width="50%"></td>
                <td style="border: none; text-align: center;" width="50%">
                    <p style="margin-bottom: 2px;">Dicetak pada: <?= date('d/m/Y H:i') ?></p>
                    <p style="margin-top: 0;">Panitia / Admin Koordinator,</p>
                    <div style="height: 50px;"></div>
                    <p><strong>( ............................................ )</strong></p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Otomatis Panggil Dialog Print Saat Halaman Terbuka -->
    <script>
        window.onload = function() {
            window.print();
        }
    </script>

</body>

</html>