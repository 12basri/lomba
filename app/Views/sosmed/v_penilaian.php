<?= $this->extend('sosmed/layout/main') ?>

<?= $this->section('content') ?>

<!-- Alert Notifikasi -->
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

<!-- Header & Filter Tanggal -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h1 class="text-xl sm:text-2xl font-bold text-white tracking-wide">Input Nilai Sosial Media</h1>
        <p class="text-xs sm:text-sm text-slate-400">Nilai terhitung otomatis (Maksimal 100 jika akumulasi Likes, Followers, & Views &ge; 1000)</p>
    </div>

    <!-- Form Filter Tanggal -->
    <form method="GET" action="<?= base_url('sosmed/penilaian') ?>" class="flex items-center gap-2 bg-slate-800 border border-slate-700/80 p-1.5 rounded-2xl">
        <input type="date" name="tanggal" value="<?= esc($tanggal_filter) ?>" class="bg-slate-900 text-xs text-slate-200 border border-slate-700 rounded-xl px-3 py-1.5 focus:outline-none focus:border-purple-500 font-mono">
        <button type="submit" class="px-3 py-1.5 bg-purple-600 hover:bg-purple-500 text-white rounded-xl text-xs font-semibold transition-all">
            Pilih Tanggal
        </button>
    </form>
</div>

<!-- List Peserta dengan Form Mandiri Per-Orang -->
<div class="space-y-4 mb-6">
    <?php if (!empty($peserta)) : ?>
        <?php foreach ($peserta as $p) : ?>
            <form action="<?= base_url('sosmed/penilaian/store') ?>" method="POST" class="bg-slate-800 border border-slate-700/80 hover:border-purple-500/40 rounded-2xl p-4 sm:p-5 shadow-lg transition-all">
                <?= csrf_field() ?>
                <input type="hidden" name="peserta_id" value="<?= $p['id'] ?>">
                <input type="hidden" name="tgl_vote" value="<?= esc($tanggal_filter) ?>">

                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">

                    <!-- Informasi Peserta -->
                    <div class="flex items-center gap-3 w-full lg:w-1/4">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-500/20 text-purple-300 font-mono font-bold rounded-xl flex items-center justify-center text-sm sm:text-base border border-purple-500/30 flex-shrink-0">
                            <?= sprintf('%02d', $p['nomor_urut']) ?>
                        </div>
                        <div class="overflow-hidden">
                            <h3 class="font-bold text-white text-sm sm:text-base truncate"><?= esc($p['nama_peserta']) ?></h3>
                            <p class="text-xs text-slate-400 truncate"><?= esc($p['asal_daerah'] ?? '-') ?></p>
                        </div>
                    </div>

                    <!-- Input Statistik & Kalkulasi otomatis -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 w-full lg:w-3/4 items-end">
                        <!-- Likes -->
                        <div>
                            <label class="block text-[10px] text-slate-400 mb-1 font-mono uppercase">Likes</label>
                            <input type="number" min="0" name="likes" value="<?= esc($p['likes'] ?? 0) ?>" oninput="hitungOtomatis(<?= $p['id'] ?>)" id="likes_<?= $p['id'] ?>" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-purple-500 font-mono">
                        </div>

                        <!-- Followers -->
                        <div>
                            <label class="block text-[10px] text-slate-400 mb-1 font-mono uppercase">Followers</label>
                            <input type="number" min="0" name="followers" value="<?= esc($p['followers'] ?? 0) ?>" oninput="hitungOtomatis(<?= $p['id'] ?>)" id="followers_<?= $p['id'] ?>" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-purple-500 font-mono">
                        </div>

                        <!-- Views -->
                        <div>
                            <label class="block text-[10px] text-slate-400 mb-1 font-mono uppercase">Views</label>
                            <input type="number" min="0" name="views" value="<?= esc($p['views'] ?? 0) ?>" oninput="hitungOtomatis(<?= $p['id'] ?>)" id="views_<?= $p['id'] ?>" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-purple-500 font-mono">
                        </div>

                        <!-- Nilai Sosmed (Otomatis berdasarkan total 1000) -->
                        <div>
                            <label class="block text-[10px] text-pink-400 font-bold mb-1 font-mono uppercase">Nilai (0-100)</label>
                            <input type="number" step="0.01" min="0" max="100" name="nilai" value="<?= esc($p['nilai_sosmed'] ?? '') ?>" id="nilai_<?= $p['id'] ?>" placeholder="0.00" readonly class="w-full bg-slate-950 border-2 border-pink-500/50 rounded-xl px-3 py-2 text-xs text-pink-300 font-mono font-bold cursor-not-allowed focus:outline-none">
                        </div>
                    </div>

                    <!-- Tombol Simpan Individual -->
                    <div class="flex items-end justify-end mt-2 lg:mt-0">
                        <button type="submit" class="w-full lg:w-auto px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 hover:opacity-90 active:scale-95 text-white font-bold text-xs rounded-xl shadow-lg transition-all flex items-center justify-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan
                        </button>
                    </div>

                </div>
            </form>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="text-center py-12 bg-slate-800 rounded-2xl border border-slate-700 text-slate-500 text-sm">
            Belum ada data peserta yang terdaftar.
        </div>
    <?php endif; ?>
</div>

<!-- JavaScript Kalkulasi Nilai Otomatis (Target 1000 = Skor 100) -->
<script>
    function hitungOtomatis(id) {
        let likes = parseFloat(document.getElementById('likes_' + id).value) || 0;
        let followers = parseFloat(document.getElementById('followers_' + id).value) || 0;
        let views = parseFloat(document.getElementById('views_' + id).value) || 0;

        // Total akumulasi inputan ketiga indikator
        let totalInput = likes + followers + views;

        // Kalkulasi nilai persentase dengan batas maksimal 1000 total inputan
        let nilaiAkhir = Math.min((totalInput / 1000) * 100, 100);

        document.getElementById('nilai_' + id).value = nilaiAkhir.toFixed(2);
    }

    // Jalankan kalkulasi awal saat halaman selesai di-load
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (!empty($peserta)) : ?>
            <?php foreach ($peserta as $p) : ?>
                hitungOtomatis(<?= $p['id'] ?>);
            <?php endforeach; ?>
        <?php endif; ?>
    });
</script>

<?= $this->endSection() ?>