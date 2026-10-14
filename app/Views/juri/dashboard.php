<?= $this->extend('juri/layout/main') ?>

<?= $this->section('content') ?>

<?php
// Penentuan label role dan bobot secara otomatis berdasarkan session
$userRole    = session('role');
$isJuriTetap = ($userRole === 'juri_tetap');

// Menangani role juri_tetap, juri_sementara, maupun juri_tamu
if ($isJuriTetap) {
    $labelRole   = 'Juri Tetap';
    $bobotPersen = 60;
} else {
    $labelRole   = ($userRole === 'juri_tamu') ? 'Juri Tamu' : 'Juri Sementara';
    $bobotPersen = 30;
}
?>

<!-- Banner Selamat Datang -->
<div class="bg-gradient-to-r from-purple-900/50 to-slate-800 border border-purple-500/20 rounded-2xl p-6 mb-6 shadow-xl">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white mb-1">
                Selamat Datang, <?= esc(session()->get('nama_lengkap') ?? $labelRole) ?>! 👋
            </h1>
            <p class="text-xs text-slate-300">
                Silakan lakukan penilaian terhadap peserta yang tampil pada lembar penilaian (Bobot <?= esc($labelRole) ?> <?= $bobotPersen ?>%).
            </p>
        </div>
        <a href="<?= base_url('juri/penilaian') ?>" class="px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-purple-600/30 transition flex items-center gap-2 shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Mulai Penilaian
        </a>
    </div>
</div>

<!-- Cards Ringkasan Statistik -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
    <!-- Card Total Peserta Diterima -->
    <div class="bg-slate-800 border border-slate-700 rounded-2xl p-5 shadow-lg flex items-center gap-4">
        <div class="p-3 bg-blue-500/10 border border-blue-500/20 text-blue-400 rounded-xl shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>
        <div>
            <p class="text-xs text-slate-400 font-medium">Total Peserta (Diterima)</p>
            <h3 class="text-2xl font-bold text-white font-mono mt-0.5"><?= esc($totalPeserta ?? 0) ?></h3>
        </div>
    </div>

    <!-- Card Sudah Dinilai -->
    <div class="bg-slate-800 border border-slate-700 rounded-2xl p-5 shadow-lg flex items-center gap-4">
        <div class="p-3 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="text-xs text-slate-400 font-medium">Sudah Dinilai</p>
            <h3 class="text-2xl font-bold text-emerald-400 font-mono mt-0.5"><?= esc($pesertaDinilai ?? 0) ?></h3>
        </div>
    </div>

    <!-- Card Belum Dinilai -->
    <div class="bg-slate-800 border border-slate-700 rounded-2xl p-5 shadow-lg flex items-center gap-4">
        <div class="p-3 bg-amber-500/10 border border-amber-500/20 text-amber-400 rounded-xl shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="text-xs text-slate-400 font-medium">Belum Dinilai</p>
            <h3 class="text-2xl font-bold text-amber-400 font-mono mt-0.5"><?= esc($pesertaBelum ?? 0) ?></h3>
        </div>
    </div>
</div>

<!-- Tabel Riwayat Penilaian Terbaru -->
<div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 shadow-xl">
    <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Penilaian Terakhir Ditambahkan
    </h2>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300">
            <thead class="bg-slate-900/60 text-slate-400 uppercase text-xs tracking-wider border-b border-slate-700">
                <tr>
                    <th class="py-3.5 px-4 text-center w-20">No Urut</th>
                    <th class="py-3.5 px-4">Peserta</th>
                    <th class="py-3.5 px-4 text-center">Nilai Murni (0-100)</th>
                    <th class="py-3.5 px-4 text-center text-purple-400">Poin <?= esc($labelRole) ?> (<?= $bobotPersen ?>%)</th>
                    <th class="py-3.5 px-4">Catatan</th>
                    <th class="py-3.5 px-4 text-center">Waktu Penilaian</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700/50">
                <?php if (!empty($penilaianTerbaru)) : ?>
                    <?php
                    $multiplier = $bobotPersen / 100;
                    foreach ($penilaianTerbaru as $pt) :
                        $nilaiMurni = (float) ($pt['nilai_murni'] ?? $pt['nilai'] ?? 0);
                        // Kalkulasi poin berbobot secara presisi
                        $poinBobot  = $nilaiMurni * $multiplier;
                        $namaPeserta = $pt['nama_peserta'] ?? $pt['nama'] ?? 'Peserta';
                        $fotoPath   = !empty($pt['foto']) ? 'uploads/peserta/' . $pt['foto'] : '';
                    ?>
                        <tr class="hover:bg-slate-700/30 transition">
                            <td class="py-3 px-4 text-center font-bold text-white">
                                <span class="bg-slate-700 px-2.5 py-1 rounded-lg border border-slate-600 font-mono">
                                    <?= sprintf('%02d', $pt['nomor_urut'] ?? 0) ?>
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <?php if ($fotoPath && file_exists(FCPATH . $fotoPath)) : ?>
                                        <img src="<?= base_url($fotoPath) ?>" alt="<?= esc($namaPeserta) ?>" class="w-9 h-9 rounded-xl object-cover border border-slate-600 bg-slate-900 shrink-0">
                                    <?php else : ?>
                                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($namaPeserta) ?>&background=6d28d9&color=fff" alt="<?= esc($namaPeserta) ?>" class="w-9 h-9 rounded-xl object-cover border border-slate-600 bg-slate-900 shrink-0">
                                    <?php endif; ?>
                                    <div>
                                        <div class="font-semibold text-white"><?= esc($namaPeserta) ?></div>
                                        <div class="text-xs text-slate-400"><?= esc($pt['alamat'] ?? '-') ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="text-sm font-bold font-mono text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-3 py-1 rounded-xl">
                                    <?= number_format($nilaiMurni, 2) ?>
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="text-sm font-bold font-mono text-purple-400 bg-purple-500/10 border border-purple-500/20 px-3 py-1 rounded-xl">
                                    <?= number_format($poinBobot, 2) ?>
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-400 italic text-xs max-w-xs truncate">
                                "<?= esc($pt['catatan'] ?? '-') ?>"
                            </td>
                            <td class="py-3 px-4 text-center text-xs text-slate-400 font-mono">
                                <?= !empty($pt['created_at']) ? date('d M Y, H:i', strtotime($pt['created_at'])) : '-' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500">
                            Belum ada riwayat penilaian.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>