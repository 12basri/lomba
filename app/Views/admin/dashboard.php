<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<!-- Notification Success / Error -->
<?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-emerald-500/10 border border-emerald-500/50 text-emerald-400 text-sm p-4 rounded-xl flex items-center gap-2 mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="bg-red-500/10 border border-red-500/50 text-red-400 text-sm p-4 rounded-xl flex items-center gap-2 mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span><?= session()->getFlashdata('error') ?></span>
    </div>
<?php endif; ?>

<!-- Section Card Statistics -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    <!-- Total Peserta -->
    <div class="bg-slate-800 border border-slate-700 p-5 rounded-2xl flex items-center justify-between shadow-lg">
        <div>
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Peserta</p>
            <h3 class="text-2xl font-bold text-white mt-1"><?= $total_peserta ?? 0 ?></h3>
        </div>
        <div class="p-3 bg-blue-500/10 text-blue-400 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>
    </div>

    <!-- Total Juri (Tetap & Tamu) -->
    <div class="bg-slate-800 border border-slate-700 p-5 rounded-2xl flex items-center justify-between shadow-lg">
        <div>
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Juri</p>
            <h3 class="text-2xl font-bold text-white mt-1"><?= $total_juri ?? 0 ?></h3>
            <p class="text-[11px] text-slate-400 mt-0.5">
                <span class="text-purple-400 font-semibold"><?= $total_juri_tetap ?? 0 ?> Tetap</span> •
                <span class="text-amber-400 font-semibold"><?= $total_juri_tamu ?? 0 ?> Tamu</span>
            </p>
        </div>
        <div class="p-3 bg-purple-500/10 text-purple-400 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </div>
    </div>

    <!-- Progress Input Vote -->
    <div class="bg-slate-800 border border-slate-700 p-5 rounded-2xl flex items-center justify-between shadow-lg">
        <div>
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Vote Masuk</p>
            <h3 class="text-2xl font-bold text-emerald-400 mt-1"><?= number_format($progress ?? 0, 1) ?>%</h3>
        </div>
        <div class="p-3 bg-emerald-500/10 text-emerald-400 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>

    <!-- Status Event -->
    <div class="bg-slate-800 border border-slate-700 p-5 rounded-2xl flex items-center justify-between shadow-lg">
        <div>
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Status Voting</p>
            <h3 class="text-lg font-bold text-amber-400 mt-1">
                <?= (($progress ?? 0) >= 100 && ($total_peserta ?? 0) > 0) ? 'Selesai' : 'Berlangsung' ?>
            </h3>
        </div>
        <div class="p-3 bg-amber-500/10 text-amber-400 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
        </div>
    </div>

</div>

<!-- Tabel Peringkat Akumulasi Nilai Pembobotan -->
<div class="bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden shadow-xl">
    <div class="p-5 border-b border-slate-700 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        <div>
            <h2 class="text-lg font-bold text-white">Akumulasi Peringkat & Nilai Terbobot</h2>
            <p class="text-xs text-slate-400 mt-0.5">Bobot Penilaian: Juri Tetap (60%), Juri Tamu (30%), Sosmed (10%)</p>
        </div>

        <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
            <!-- Filter Tanggal -->
            <form method="GET" action="<?= base_url('admin/dashboard') ?>" class="flex items-center gap-2">
                <input type="date" name="tanggal" id="input_tanggal" value="<?= $tanggal_filter ?? date('Y-m-d') ?>" onchange="this.form.submit()" class="bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-purple-500 font-mono">
            </form>

            <!-- Cetak Laporan -->
            <a href="<?= base_url('admin/dashboard/export?tanggal=' . ($tanggal_filter ?? date('Y-m-d'))) ?>" target="_blank" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-lg shadow-emerald-600/20 transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Cetak Laporan
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300">
            <thead class="bg-slate-900/60 text-slate-400 uppercase text-xs tracking-wider border-b border-slate-700">
                <tr>
                    <th class="py-3.5 px-4 text-center">Rank</th>
                    <th class="py-3.5 px-4 text-center">No. Urut</th>
                    <th class="py-3.5 px-4">Nama Peserta</th>
                    <th class="py-3.5 px-4 text-center">Juri Tetap <br><span class="text-[10px] text-purple-400 normal-case">(Bobot 60%)</span></th>
                    <th class="py-3.5 px-4 text-center">Juri Tamu <br><span class="text-[10px] text-amber-400 normal-case">(Bobot 30%)</span></th>
                    <th class="py-3.5 px-4 text-center">Sosmed <br><span class="text-[10px] text-sky-400 normal-case">(Bobot 10%)</span></th>
                    <th class="py-3.5 px-4 text-center">Nilai Akhir</th>
                </tr>
            </thead>
            <tbody id="tabel-klasemen" class="divide-y divide-slate-700/50">
                <?php if (!empty($peringkat)) : ?>
                    <?php $rank = 1; ?>
                    <?php foreach ($peringkat as $row) : ?>
                        <tr class="hover:bg-slate-700/30 transition">
                            <td class="py-3 px-4 text-center font-bold">
                                <?php if ($rank === 1) : ?>
                                    <span class="inline-flex items-center justify-center w-7 h-7 bg-amber-400/10 border border-amber-400/30 text-amber-400 rounded-full">1</span>
                                <?php elseif ($rank === 2) : ?>
                                    <span class="inline-flex items-center justify-center w-7 h-7 bg-slate-400/10 border border-slate-400/30 text-slate-300 rounded-full">2</span>
                                <?php elseif ($rank === 3) : ?>
                                    <span class="inline-flex items-center justify-center w-7 h-7 bg-amber-600/10 border border-amber-600/30 text-amber-500 rounded-full">3</span>
                                <?php else : ?>
                                    <span class="text-slate-400"><?= $rank ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-4 font-semibold text-white text-center font-mono">
                                <?= sprintf('%02d', $row['nomor_urut']) ?>
                            </td>
                            <td class="py-3 px-4 font-medium text-white">
                                <div class="flex items-center gap-3">
                                    <?php if (!empty($row['foto'])) : ?>
                                        <img src="<?= base_url('uploads/peserta/' . $row['foto']) ?>" alt="Foto" class="w-8 h-8 rounded-full object-cover border border-slate-600">
                                    <?php else : ?>
                                        <div class="w-8 h-8 rounded-full bg-slate-700 border border-slate-600 flex items-center justify-center text-xs text-slate-400">
                                            <?= strtoupper(substr($row['nama_peserta'], 0, 1)) ?>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <p class="font-semibold text-white"><?= esc($row['nama_peserta']) ?></p>
                                        <p class="text-[11px] text-slate-400">
                                            <span class="text-amber-400 font-mono"><?= esc($row['no_wa'] ?? '-') ?></span> •
                                            <span><?= $row['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></span>
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-center font-mono font-semibold text-purple-300">
                                <?= number_format($row['avg_juri_tetap'] ?? 0, 2) ?>
                            </td>
                            <td class="py-3 px-4 text-center font-mono font-semibold text-amber-300">
                                <?= number_format($row['avg_juri_tamu'] ?? ($row['avg_juri_sementara'] ?? 0), 2) ?>
                            </td>
                            <td class="py-3 px-4 text-center font-mono font-semibold text-sky-300">
                                <?= number_format($row['nilai_sosmed'] ?? 0, 2) ?>
                            </td>
                            <td class="py-3 px-4 text-center font-mono font-bold text-emerald-400 text-base">
                                <?= number_format($row['nilai_akhir'] ?? 0, 2) ?>
                            </td>
                        </tr>
                        <?php $rank++; ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="py-8 text-center text-slate-500">
                            Belum ada data akumulasi nilai peserta yang masuk pada tanggal ini.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Auto Reload Halaman Tiap 5 Detik untuk Live Monitor Klasemen -->
<script>
    setInterval(() => {
        // Hanya reload jika user sedang tidak aktif berinteraksi dengan form/input
        if (document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'BUTTON') {
            window.location.reload();
        }
    }, 5000);
</script>

<?= $this->endSection() ?>