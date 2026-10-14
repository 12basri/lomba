<?= $this->extend('sosmed/layout/main') ?>

<?= $this->section('content') ?>

<!-- Alert Success / Error -->
<?php if (session()->getFlashdata('success')) : ?>
    <div class="mb-4 p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-2xl text-emerald-400 text-xs font-semibold flex items-center justify-between">
        <span><?= session()->getFlashdata('success') ?></span>
        <button onclick="this.parentElement.remove()" class="text-emerald-400 font-bold">&times;</button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="mb-4 p-4 bg-rose-500/10 border border-rose-500/30 rounded-2xl text-rose-400 text-xs font-semibold flex items-center justify-between">
        <span><?= session()->getFlashdata('error') ?></span>
        <button onclick="this.parentElement.remove()" class="text-rose-400 font-bold">&times;</button>
    </div>
<?php endif; ?>

<!-- Header & Filter Tanggal / Reset / Export PDF -->
<div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
    <div>
        <h1 class="text-xl sm:text-2xl font-bold text-white tracking-wide">Dashboard Sosmed</h1>
        <p class="text-xs sm:text-sm text-slate-400">Ringkasan progres penginputan & hasil vote sosial media (Target 1000 Total Input = 100 Skor | Bobot 10%)</p>
    </div>

    <div class="flex flex-wrap items-center gap-2">
        <!-- Form Filter Tanggal -->
        <form method="GET" action="<?= base_url('sosmed/dashboard') ?>" class="flex items-center gap-2 bg-slate-800 border border-slate-700/80 p-1.5 rounded-2xl">
            <input type="date" name="tanggal" value="<?= esc($tanggal_filter) ?>" class="bg-slate-900 text-xs text-slate-200 border border-slate-700 rounded-xl px-3 py-1.5 focus:outline-none focus:border-purple-500 font-mono">
            <button type="submit" class="px-3 py-1.5 bg-purple-600 hover:bg-purple-500 text-white rounded-xl text-xs font-semibold transition-all">
                Filter
            </button>
        </form>

        <!-- Tombol Export PDF -->
        <a href="<?= base_url('sosmed/dashboard/exportPdf?tanggal=' . $tanggal_filter) ?>" target="_blank" class="px-3 py-2 bg-emerald-600/20 hover:bg-emerald-600 text-emerald-400 hover:text-white border border-emerald-500/30 rounded-2xl text-xs font-semibold transition-all flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Export PDF
        </a>

        <!-- Tombol Reset Nilai -->
        <button onclick="openResetModal()" class="px-3 py-2 bg-rose-600/20 hover:bg-rose-600 text-rose-400 hover:text-white border border-rose-500/30 rounded-2xl text-xs font-semibold transition-all flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            Reset Nilai
        </button>
    </div>
</div>

<!-- Grid Kartu Statistik -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <!-- Total Peserta -->
    <div class="bg-slate-800/80 border border-slate-700/80 rounded-2xl p-4 sm:p-5 flex items-center gap-4 shadow-lg">
        <div class="p-3 bg-indigo-500/10 text-indigo-400 rounded-2xl border border-indigo-500/20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>
        <div>
            <p class="text-xs text-slate-400">Total Peserta Diterima</p>
            <h3 class="text-xl font-bold text-white font-mono"><?= number_format($totalPeserta) ?></h3>
        </div>
    </div>

    <!-- Sudah Dinilai Hari Ini -->
    <div class="bg-slate-800/80 border border-slate-700/80 rounded-2xl p-4 sm:p-5 flex items-center gap-4 shadow-lg">
        <div class="p-3 bg-emerald-500/10 text-emerald-400 rounded-2xl border border-emerald-500/20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="text-xs text-slate-400">Sudah Diinput Hari Ini</p>
            <h3 class="text-xl font-bold text-emerald-400 font-mono"><?= number_format($totalDinilai) ?> <span class="text-xs font-normal text-slate-400">Peserta</span></h3>
        </div>
    </div>

    <!-- Belum Dinilai Hari Ini -->
    <div class="bg-slate-800/80 border border-slate-700/80 rounded-2xl p-4 sm:p-5 flex items-center gap-4 shadow-lg">
        <div class="p-3 bg-rose-500/10 text-rose-400 rounded-2xl border border-rose-500/20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="text-xs text-slate-400">Belum Diinput Hari Ini</p>
            <h3 class="text-xl font-bold text-rose-400 font-mono"><?= number_format($belumDinilai) ?> <span class="text-xs font-normal text-slate-400">Peserta</span></h3>
        </div>
    </div>
</div>

<!-- SECTION 1: TABEL REKAP HASIL VOTE & PERINGKAT SOSMED -->
<div class="bg-slate-800 border border-slate-700/80 rounded-2xl overflow-hidden shadow-xl mb-8">
    <div class="p-4 sm:p-5 border-b border-slate-700/80 flex justify-between items-center bg-slate-900/40">
        <div>
            <h2 class="text-base font-bold text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                </svg>
                Rekap Hasil Vote Sosial Media (Klasemen Sementara)
            </h2>
            <p class="text-xs text-slate-400 mt-0.5">Peringkat berdasarkan Skor Konversi (Maks 100) x Bobot 10% (Maksimal 10 Poin Akhir)</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-slate-300">
            <thead class="bg-slate-900/80 text-slate-400 uppercase font-mono border-b border-slate-700/60">
                <tr>
                    <th class="px-4 py-3 text-center">Rank</th>
                    <th class="px-4 py-3 text-center">No Urut</th>
                    <th class="px-4 py-3">Nama Peserta</th>
                    <th class="px-4 py-3 text-center">Likes</th>
                    <th class="px-4 py-3 text-center">Followers</th>
                    <th class="px-4 py-3 text-center">Views</th>
                    <th class="px-4 py-3 text-center">Skor (0-100)</th>
                    <th class="px-4 py-3 text-center text-pink-400 font-bold">Poin Akhir (10%)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700/50">
                <?php if (!empty($rekapHasilVote)) : ?>
                    <?php $rank = 1; ?>
                    <?php foreach ($rekapHasilVote as $r) : ?>
                        <?php $nilaiBobot = $r['nilai_bobot_10'] ?? 0; ?>
                        <tr class="hover:bg-slate-700/30 transition-colors <?= ($rank <= 3) ? 'bg-purple-900/10' : '' ?>">
                            <td class="px-4 py-3 text-center font-bold font-mono">
                                <?php if ($rank == 1): ?>
                                    <span class="px-2.5 py-1 bg-amber-500/20 text-amber-300 border border-amber-500/40 rounded-full">🥇 #1</span>
                                <?php elseif ($rank == 2): ?>
                                    <span class="px-2.5 py-1 bg-slate-400/20 text-slate-300 border border-slate-400/40 rounded-full">🥈 #2</span>
                                <?php elseif ($rank == 3): ?>
                                    <span class="px-2.5 py-1 bg-amber-700/20 text-amber-500 border border-amber-700/40 rounded-full">🥉 #3</span>
                                <?php else: ?>
                                    <span class="text-slate-400">#<?= $rank ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 text-center font-mono font-bold text-slate-400"><?= sprintf('%02d', $r['nomor_urut'] ?? 0) ?></td>
                            <td class="px-4 py-3 font-semibold text-white">
                                <?= esc($r['nama_peserta'] ?? '-') ?>
                                <span class="block text-[10px] text-slate-400 font-normal"><?= esc($r['alamat'] ?? '-') ?></span>
                            </td>
                            <td class="px-4 py-3 text-center font-mono text-emerald-400 font-semibold"><?= number_format((float)($r['total_likes'] ?? 0)) ?></td>
                            <td class="px-4 py-3 text-center font-mono text-blue-400 font-semibold"><?= number_format((float)($r['total_followers'] ?? 0)) ?></td>
                            <td class="px-4 py-3 text-center font-mono text-purple-400 font-semibold"><?= number_format((float)($r['total_views'] ?? 0)) ?></td>
                            <td class="px-4 py-3 text-center font-mono font-bold text-white"><?= number_format((float)($r['rata_nilai'] ?? 0), 2) ?></td>
                            <td class="px-4 py-3 text-center font-mono font-bold text-pink-400 text-sm bg-pink-500/5">
                                <?= number_format((float)$nilaiBobot, 2) ?>
                            </td>
                        </tr>
                        <?php $rank++; ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" class="text-center py-6 text-slate-500">Belum ada rekap hasil vote.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- SECTION 2: STATUS INPUT PENILAIAN HARIAN -->
<div class="bg-slate-800 border border-slate-700/80 rounded-2xl overflow-hidden shadow-xl">
    <div class="p-4 sm:p-5 border-b border-slate-700/80 flex justify-between items-center">
        <h2 class="text-base font-bold text-white">Status Penilaian Tanggal: <span class="text-purple-400 font-mono"><?= esc($tanggal_filter) ?></span></h2>
        <a href="<?= base_url('sosmed/penilaian?tanggal=' . $tanggal_filter) ?>" class="px-3 py-1.5 bg-gradient-to-r from-purple-600 to-pink-600 hover:opacity-90 text-white rounded-xl text-xs font-semibold shadow-md transition-all">
            + Input / Edit Nilai
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-slate-300">
            <thead class="bg-slate-900/60 text-slate-400 uppercase font-mono border-b border-slate-700/60">
                <tr>
                    <th class="px-4 py-3 text-center">No</th>
                    <th class="px-4 py-3">Peserta</th>
                    <th class="px-4 py-3 text-center">Likes</th>
                    <th class="px-4 py-3 text-center">Followers</th>
                    <th class="px-4 py-3 text-center">Views</th>
                    <th class="px-4 py-3 text-center">Skor (0-100)</th>
                    <th class="px-4 py-3 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700/50">
                <?php if (!empty($penilaianHariIni)) : ?>
                    <?php foreach ($penilaianHariIni as $p) : ?>
                        <tr class="hover:bg-slate-700/30 transition-colors">
                            <td class="px-4 py-3 text-center font-mono font-bold text-slate-400"><?= sprintf('%02d', $p['nomor_urut'] ?? 0) ?></td>
                            <td class="px-4 py-3 font-semibold text-white"><?= esc($p['nama_peserta'] ?? '-') ?></td>
                            <td class="px-4 py-3 text-center font-mono"><?= number_format((float)($p['likes'] ?? 0)) ?></td>
                            <td class="px-4 py-3 text-center font-mono"><?= number_format((float)($p['followers'] ?? 0)) ?></td>
                            <td class="px-4 py-3 text-center font-mono"><?= number_format((float)($p['views'] ?? 0)) ?></td>
                            <td class="px-4 py-3 text-center font-mono font-bold text-pink-400 text-sm">
                                <?= ($p['nilai_sosmed'] !== null) ? number_format((float)$p['nilai_sosmed'], 2) : '-' ?>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <?php if ($p['nilai_sosmed'] !== null) : ?>
                                    <span class="px-2 py-1 bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 rounded-full text-[10px] font-semibold">Selesai</span>
                                <?php else : ?>
                                    <span class="px-2 py-1 bg-slate-700 text-slate-400 rounded-full text-[10px]">Belum</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="text-center py-6 text-slate-500">Tidak ada data peserta ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL KONFIRMASI RESET -->
<div id="resetModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4">
    <div class="bg-slate-900 border border-slate-700/80 rounded-2xl p-6 max-w-md w-full shadow-2xl">
        <div class="flex items-center gap-3 text-rose-500 mb-4">
            <div class="p-3 bg-rose-500/10 rounded-xl border border-rose-500/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-white">Reset Nilai Sosial Media</h3>
                <p class="text-xs text-slate-400">Pilih jenis penghapusan data nilai sosmed.</p>
            </div>
        </div>

        <form action="<?= base_url('sosmed/dashboard/resetVote') ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" name="tanggal" value="<?= esc($tanggal_filter) ?>">

            <div class="space-y-2">
                <label class="flex items-center gap-3 p-3 bg-slate-800 border border-slate-700 rounded-xl cursor-pointer hover:border-rose-500/50 transition-all">
                    <input type="radio" name="type" value="hari_ini" checked class="text-rose-600 focus:ring-0">
                    <div>
                        <p class="text-xs font-bold text-white">Reset Nilai Hari Ini Saja</p>
                        <p class="text-[10px] text-slate-400">Hanya menghapus input tanggal <span class="text-purple-400 font-mono"><?= esc($tanggal_filter) ?></span></p>
                    </div>
                </label>

                <label class="flex items-center gap-3 p-3 bg-slate-800 border border-slate-700 rounded-xl cursor-pointer hover:border-rose-500/50 transition-all">
                    <input type="radio" name="type" value="semua" class="text-rose-600 focus:ring-0">
                    <div>
                        <p class="text-xs font-bold text-rose-400">Reset Seluruh Nilai Sosmed</p>
                        <p class="text-[10px] text-slate-400">Menghapus seluruh histori input nilai sosial media</p>
                    </div>
                </label>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="closeResetModal()" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-semibold">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded-xl text-xs font-bold transition-all shadow-lg shadow-rose-600/20">
                    Ya, Reset Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openResetModal() {
        document.getElementById('resetModal').classList.remove('hidden');
    }

    function closeResetModal() {
        document.getElementById('resetModal').classList.add('hidden');
    }
</script>

<?= $this->endSection() ?>