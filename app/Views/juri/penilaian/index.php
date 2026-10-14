<?= $this->extend('juri/layout/main') ?>

<?= $this->section('content') ?>

<?php
// Penentuan label role dan bobot secara otomatis
$userRole    = session('role');
$isJuriTetap = ($userRole === 'juri_tetap');
$labelRole   = $isJuriTetap ? 'Juri Tetap' : 'Juri Sementara';
$bobotPersen = $isJuriTetap ? 60 : 30;
?>

<!-- Alert Flashdata Success -->
<?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-emerald-500/10 border border-emerald-500/50 text-emerald-400 text-sm p-4 rounded-xl flex items-center gap-3 mb-6 shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<!-- Alert Flashdata Error -->
<?php if (session()->getFlashdata('error')) : ?>
    <div class="bg-rose-500/10 border border-rose-500/50 text-rose-400 text-sm p-4 rounded-xl flex items-center gap-3 mb-6 shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span><?= session()->getFlashdata('error') ?></span>
    </div>
<?php endif; ?>

<!-- Container Lembar Penilaian -->
<div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 shadow-xl">
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Lembar Vote <?= esc($labelRole) ?> (Bobot Penilaian <?= $bobotPersen ?>%)
            </h2>
            <p class="text-xs text-slate-400 mt-1">Masukkan nilai dalam skala 0 - 100. Sistem akan secara otomatis mengonsolidasi dengan bobot <?= $bobotPersen ?>% dewan <?= strtolower($labelRole) ?>.</p>
        </div>
        <div class="bg-slate-900/60 border border-slate-700 px-3.5 py-1.5 rounded-xl text-xs text-slate-300 font-mono flex items-center gap-2 self-start md:self-auto">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            Tanggal: <?= date('d M Y') ?>
        </div>
    </div>

    <!-- Tabel Peserta -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300">
            <thead class="bg-slate-900/60 text-slate-400 uppercase text-xs tracking-wider border-b border-slate-700">
                <tr>
                    <th class="py-3.5 px-4 text-center w-20">No Urut</th>
                    <th class="py-3.5 px-4">Nama Peserta</th>
                    <th class="py-3.5 px-4">Alamat / Asal</th>
                    <th class="py-3.5 px-4 text-center">Nilai Murni (0-100)</th>
                    <th class="py-3.5 px-4 text-center text-purple-400">Poin Juri (<?= $bobotPersen ?>%)</th>
                    <th class="py-3.5 px-4 text-center">Status</th>
                    <th class="py-3.5 px-4 text-center w-36">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700/50">
                <?php if (!empty($peserta)) : ?>
                    <?php foreach ($peserta as $p) :
                        $hasVoted    = isset($penilaian[$p['id']]);
                        $nilaiMurni  = $hasVoted ? (float)$penilaian[$p['id']] : 0;
                        $nilaiScore  = $hasVoted ? number_format($nilaiMurni, 2) : '-';

                        // Hitung Poin Bobot Secara Dinamis (60% / 30%)
                        $multiplier  = $bobotPersen / 100;
                        $poinBobot   = $hasVoted ? number_format($nilaiMurni * $multiplier, 2) : '-';
                    ?>
                        <tr class="hover:bg-slate-700/30 transition">
                            <td class="py-3 px-4 text-center font-bold text-white">
                                <span class="bg-slate-700 px-2.5 py-1 rounded-lg border border-slate-600 font-mono text-xs">
                                    <?= sprintf('%02d', $p['nomor_urut']) ?>
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <?php $fotoPath = !empty($p['foto']) ? 'uploads/peserta/' . $p['foto'] : 'assets/images/default.jpg'; ?>
                                    <img src="<?= base_url($fotoPath) ?>"
                                        onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=<?= urlencode($p['nama_peserta']) ?>&background=6d28d9&color=fff';"
                                        alt="<?= esc($p['nama_peserta']) ?>"
                                        class="w-9 h-9 rounded-xl object-cover border border-slate-600 bg-slate-900 flex-shrink-0">
                                    <span class="text-white font-semibold"><?= esc($p['nama_peserta']) ?></span>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-slate-400 font-medium"><?= esc($p['alamat'] ?? '-') ?></td>
                            <td class="py-3 px-4 text-center font-mono font-bold text-base <?= $hasVoted ? 'text-emerald-400' : 'text-slate-500' ?>">
                                <?= $nilaiScore ?>
                            </td>
                            <td class="py-3 px-4 text-center font-mono font-bold text-base <?= $hasVoted ? 'text-purple-400' : 'text-slate-500' ?>">
                                <?= $poinBobot ?>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <?php if ($hasVoted) : ?>
                                    <span class="inline-flex items-center gap-1 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2.5 py-1 rounded-lg text-xs font-semibold">
                                        Sudah Vote
                                    </span>
                                <?php else : ?>
                                    <span class="inline-flex items-center gap-1 bg-slate-700/60 text-slate-400 border border-slate-600 px-2.5 py-1 rounded-lg text-xs">
                                        Belum Vote
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <?php if ($hasVoted) : ?>
                                    <button type="button" disabled class="px-3.5 py-1.5 bg-slate-700 text-slate-500 border border-slate-600 rounded-xl text-xs font-semibold cursor-not-allowed flex items-center gap-1.5 mx-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        Terkunci
                                    </button>
                                <?php else : ?>
                                    <button type="button"
                                        onclick="openModalVote(<?= htmlspecialchars(json_encode($p), ENT_QUOTES, 'UTF-8') ?>)"
                                        class="px-3.5 py-1.5 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-xs font-semibold transition flex items-center gap-1.5 mx-auto shadow-md shadow-purple-600/20">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Beri Vote
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="py-10 text-center text-slate-500">Belum ada data peserta yang siap dinilai.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL FORM VOTE -->
<div id="modalVote" class="fixed inset-0 z-50 hidden bg-slate-950/75 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-slate-800 border border-slate-700 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl transition-all">
        <div class="p-5 border-b border-slate-700 flex justify-between items-center bg-slate-900/40">
            <div>
                <h3 class="text-lg font-bold text-white" id="modal_nama_peserta">Form Vote</h3>
                <p class="text-xs text-purple-400 mt-0.5" id="modal_alamat_peserta"></p>
            </div>
            <button type="button" onclick="closeModalVote()" class="text-slate-400 hover:text-white p-1 rounded-lg hover:bg-slate-700/50 transition">&times;</button>
        </div>
        <form action="<?= base_url('juri/penilaian/store') ?>" method="POST" class="p-5 space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" name="peserta_id" id="modal_peserta_id">

            <div class="bg-slate-900/40 border border-slate-700/50 p-4 rounded-xl space-y-3">
                <div>
                    <label for="modal_nilai" class="block text-xs font-semibold text-slate-200 mb-2">
                        Nilai Murni (Skala 0 - 100)
                    </label>
                    <input type="number" step="0.01" min="0" max="100" name="nilai" id="modal_nilai" required placeholder="Contoh: 85.50" oninput="calculateBobot(this.value)" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:border-purple-500 font-mono text-lg transition text-center font-bold">
                </div>

                <!-- Preview Kalkulasi Poin Bobot Secara Real-time -->
                <div class="flex justify-between items-center bg-purple-950/40 border border-purple-500/30 rounded-lg p-2.5 text-xs text-purple-300 font-mono">
                    <span>Estimasi Poin <?= esc($labelRole) ?> (<?= $bobotPersen ?>%):</span>
                    <span id="preview_bobot" class="font-bold text-sm text-purple-200">0.00</span>
                </div>
            </div>

            <div>
                <label for="modal_catatan" class="block text-xs font-semibold text-slate-300 mb-1.5">Catatan (Opsional)</label>
                <textarea name="catatan" id="modal_catatan" rows="3" placeholder="Masukkan komentar atau pertimbangan..." class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-purple-500 transition"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-2 border-t border-slate-700/50">
                <button type="button" onclick="closeModalVote()" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-slate-300 rounded-xl text-sm font-semibold transition">Batal</button>
                <button type="submit" class="px-5 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-sm font-semibold transition shadow-lg shadow-purple-600/30">Simpan Vote</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Pengali Bobot Dinamis berdasarkan Role (0.60 untuk Juri Tetap, 0.30 untuk Juri Tamu)
    const BOBOT_MULTIPLIER = <?= $bobotPersen / 100 ?>;

    function openModalVote(peserta) {
        document.getElementById('modal_peserta_id').value = peserta.id;
        document.getElementById('modal_nama_peserta').innerText = 'Vote: ' + peserta.nama_peserta;
        document.getElementById('modal_alamat_peserta').innerText = 'Alamat: ' + (peserta.alamat || '-');
        document.getElementById('modal_nilai').value = '';
        document.getElementById('preview_bobot').innerText = '0.00';
        document.getElementById('modal_catatan').value = '';

        document.getElementById('modalVote').classList.remove('hidden');
    }

    function closeModalVote() {
        document.getElementById('modalVote').classList.add('hidden');
    }

    function calculateBobot(val) {
        let num = parseFloat(val);
        if (!isNaN(num) && num >= 0 && num <= 100) {
            let bobot = num * BOBOT_MULTIPLIER;
            document.getElementById('preview_bobot').innerText = bobot.toFixed(2);
        } else {
            document.getElementById('preview_bobot').innerText = '0.00';
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModalVote();
        }
    });

    document.getElementById('modalVote').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModalVote();
        }
    });
</script>

<?= $this->endSection() ?>