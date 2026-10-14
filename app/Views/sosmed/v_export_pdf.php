<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Vote Sosial Media</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11pt;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            text-transform: uppercase;
            font-size: 16pt;
        }

        .header p {
            margin: 3px 0 0;
            font-size: 9pt;
            color: #666;
        }

        .info-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 9pt;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.data th,
        table.data td {
            border: 1px solid #777;
            padding: 6px 8px;
            text-align: center;
            font-size: 9pt;
        }

        table.data th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
        }

        table.data td.left {
            text-align: left;
        }

        .rank-1 {
            background-color: #fff9e6;
            font-weight: bold;
        }

        .rank-2 {
            background-color: #f5f5f5;
        }

        .rank-3 {
            background-color: #fff0e6;
        }

        .footer {
            margin-top: 30px;
            float: right;
            text-align: center;
            width: 200px;
            font-size: 9pt;
        }

        .footer .space {
            height: 60px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>Laporan Hasil Vote Sosial Media</h2>
        <p>Rekapitulasi Perolehan Poin & Peringkat Peserta (Bobot 40%)</p>
    </div>

    <table class="info-table">
        <tr>
            <td><strong>Tanggal Cetak:</strong> <?= date('d-m-Y H:i') ?> WIB</td>
            <td style="text-align: right;"><strong>Filter Per S/D:</strong> <?= date('d-m-Y', strtotime($tanggal)) ?></td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th width="5%">Rank</th>
                <th width="8%">No</th>
                <th width="27%">Nama Peserta</th>
                <th width="12%">Likes</th>
                <th width="12%">Followers</th>
                <th width="12%">Views</th>
                <th width="12%">Rata-Rata</th>
                <th width="12%">Nilai (40%)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($rekapHasilVote)) : ?>
                <?php $rank = 1; ?>
                <?php foreach ($rekapHasilVote as $r) : ?>
                    <tr class="<?= ($rank == 1) ? 'rank-1' : (($rank == 2) ? 'rank-2' : (($rank == 3) ? 'rank-3' : '')) ?>">
                        <td><strong>#<?= $rank ?></strong></td>
                        <td><?= sprintf('%02d', $r['nomor_urut']) ?></td>
                        <td class="left">
                            <strong><?= esc($r['nama_peserta']) ?></strong>
                            <br><small style="color:#666;"><?= esc($r['asal_daerah'] ?? '-') ?></small>
                        </td>
                        <td><?= number_format($r['total_likes']) ?></td>
                        <td><?= number_format($r['total_followers']) ?></td>
                        <td><?= number_format($r['total_views']) ?></td>
                        <td><?= number_format($r['rata_nilai'], 2) ?></td>
                        <td><strong><?= number_format($r['nilai_bobot_40'], 2) ?></strong></td>
                    </tr>
                    <?php $rank++; ?>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="8">Belum ada data hasil vote.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Petugas Penilai Sosmed,</p>
        <div class="space"></div>
        <p><strong>( ..................................... )</strong></p>
    </div>

</body>

</html>