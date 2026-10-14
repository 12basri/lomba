<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-emerald-500/10 border border-emerald-500/50 text-emerald-400 text-sm p-4 rounded-xl flex items-center gap-3 mb-6 shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="bg-rose-500/10 border border-rose-500/50 text-rose-400 text-sm p-4 rounded-xl flex items-center gap-3 mb-6 shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span><?= session()->getFlashdata('error') ?></span>
    </div>
<?php endif; ?>

<!-- TABEL REKAP AKUMULASI NILAI (STANDINGS) -->
<div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 shadow-xl mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Rekap Nilai Akumulasi & Peringkat
            </h2>
            <p class="text-xs text-slate-400 mt-1">Bobot: 60% Juri Tetap | 30% Juri Tamu | 10% Sosmed</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300">
            <thead class="bg-slate-900/60 text-slate-400 uppercase text-xs tracking-wider border-b border-slate-700">
                <tr>
                    <th class="py-3.5 px-4 text-center">Rank</th>
                    <th class="py-3.5 px-4">Peserta</th>
                    <th class="py-3.5 px-4 text-center">Avg Tetap (60%)</th>
                    <th class="py-3.5 px-4 text-center">Avg Tamu (30%)</th>
                    <th class="py-3.5 px-4 text-center">Sosmed (10%)</th>
                    <th class="py-3.5 px-4 text-center">Nilai Akhir</th>
                </tr>
            </thead>
            <tbody id="tabel-rekap" class="divide-y divide-slate-700/50">
                <?php if (!empty($rekapNilai)) : ?>
                    <?php foreach ($rekapNilai as $rank => $rk) : ?>
                        <?php
                        $fotoPath = !empty($rk['foto']) ? base_url('uploads/peserta/' . $rk['foto']) : 'https://ui-avatars.com/api/?name=' . urlencode($rk['nama_peserta'] ?? '') . '&background=6d28d9&color=fff';
                        $noUrut = sprintf('%02d', $rk['nomor_urut'] ?? 0);
                        $isTop3 = $rank < 3;
                        $rankBadgeClass = match ($rank) {
                            0 => 'bg-amber-500/20 text-amber-300 border-amber-500/40',
                            1 => 'bg-slate-300/20 text-slate-200 border-slate-400/40',
                            2 => 'bg-amber-700/20 text-amber-400 border-amber-700/40',
                            default => 'bg-slate-800 text-slate-400 border-slate-700'
                        };
                        ?>
                        <tr class="hover:bg-slate-700/30 transition <?= $isTop3 ? 'bg-slate-800/40' : '' ?>">
                            <td class="py-3 px-4 text-center font-mono">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-bold border <?= $rankBadgeClass ?>">
                                    <?= $rank + 1 ?>
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <img src="<?= $fotoPath ?>"
                                        onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=<?= urlencode($rk['nama_peserta'] ?? '') ?>&background=6d28d9&color=fff';"
                                        class="w-9 h-9 rounded-xl object-cover border border-slate-600 bg-slate-900">
                                    <div>
                                        <div class="font-semibold text-white"><?= esc($rk['nama_peserta'] ?? '-') ?> <span class="text-xs text-slate-400 font-mono">(No. <?= $noUrut ?>)</span></div>
                                        <div class="text-xs text-slate-400"><?= esc($rk['asal_daerah'] ?? $rk['alamat'] ?? '-') ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-center font-mono text-purple-300"><?= number_format((float)($rk['avg_juri_tetap'] ?? 0), 2) ?></td>
                            <td class="py-3 px-4 text-center font-mono text-amber-300"><?= number_format((float)($rk['avg_juri_tamu'] ?? ($rk['avg_juri_sementara'] ?? 0)), 2) ?></td>
                            <td class="py-3 px-4 text-center font-mono text-sky-300"><?= number_format((float)($rk['nilai_sosmed'] ?? 0), 2) ?></td>
                            <td class="py-3 px-4 text-center">
                                <span class="text-base font-bold text-amber-400 bg-amber-500/10 border border-amber-500/20 px-3 py-1 rounded-xl font-mono">
                                    <?= number_format((float)($rk['nilai_akhir'] ?? 0), 2) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500">
                            Belum ada rekapitulasi penilaian.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- TABEL RINCIAN TRANSAKSI VOTE -->
<div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 shadow-xl">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Rincian Transaksi Vote Juri
            </h2>
            <p class="text-xs text-slate-400 mt-1">Daftar nilai dan catatan perolehan suara secara rinci</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <form method="GET" action="<?= base_url('admin/hasil-vote') ?>" class="flex items-center gap-2">
                <input type="date" name="tanggal" id="input_tanggal" value="<?= $tanggal_filter ?>" onchange="this.form.submit()" class="bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-purple-500 font-mono">
            </form>

            <a href="<?= base_url('admin/hasil-vote/export?tanggal=' . $tanggal_filter) ?>" target="_blank" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold transition flex items-center gap-2 shadow-md shadow-emerald-600/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Cetak Laporan
            </a>

            <form id="form-reset-vote" action="<?= base_url('admin/hasil-vote/reset') ?>" method="POST" onsubmit="handleResetSubmit(event)">
                <?= csrf_field() ?>
                <button type="submit" class="px-3.5 py-2 bg-rose-600/20 hover:bg-rose-600 text-rose-400 hover:text-white border border-rose-500/30 rounded-xl text-xs font-semibold transition flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Reset Semua Vote
                </button>
            </form>

            <div class="flex items-center gap-2 bg-purple-500/10 border border-purple-500/20 px-3 py-2 rounded-xl">
                <span class="w-2 h-2 rounded-full bg-purple-400 animate-ping"></span>
                <span class="text-xs font-semibold text-purple-400">Live Updating</span>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300">
            <thead class="bg-slate-900/60 text-slate-400 uppercase text-xs tracking-wider border-b border-slate-700">
                <tr>
                    <th class="py-3.5 px-4 text-center">No</th>
                    <th class="py-3.5 px-4">Juri</th>
                    <th class="py-3.5 px-4">Peserta</th>
                    <th class="py-3.5 px-4 text-center">Nilai</th>
                    <th class="py-3.5 px-4">Catatan</th>
                    <th class="py-3.5 px-4 text-center">Waktu Vote</th>
                </tr>
            </thead>
            <tbody id="tabel-penilaian" class="divide-y divide-slate-700/50">
                <?php if (!empty($penilaian)) : ?>
                    <?php foreach ($penilaian as $index => $row) : ?>
                        <?php
                        $fotoPath = !empty($row['foto']) ? base_url('uploads/peserta/' . $row['foto']) : 'https://ui-avatars.com/api/?name=' . urlencode($row['nama_peserta'] ?? '') . '&background=6d28d9&color=fff';
                        $noUrut = sprintf('%02d', $row['nomor_urut'] ?? 0);

                        $roleClass = 'bg-purple-500/10 text-purple-400 border-purple-500/20';
                        $roleLabel = 'Juri Tetap';
                        if (($row['role_juri'] ?? '') === 'juri_tamu' || ($row['role_juri'] ?? '') === 'juri_sementara') {
                            $roleClass = 'bg-amber-500/10 text-amber-400 border-amber-500/20';
                            $roleLabel = 'Juri Tamu';
                        } elseif (($row['role_juri'] ?? '') === 'sosmed') {
                            $roleClass = 'bg-sky-500/10 text-sky-400 border-sky-500/20';
                            $roleLabel = 'Sosmed';
                        }
                        ?>
                        <tr class="hover:bg-slate-700/30 transition">
                            <td class="py-3 px-4 text-center text-slate-400 font-mono"><?= $index + 1 ?></td>
                            <td class="py-3 px-4 font-semibold text-white">
                                <div class="flex flex-col gap-1">
                                    <span class="text-white font-medium"><?= esc($row['nama_juri'] ?? '-') ?></span>
                                    <span class="inline-block w-max text-[10px] px-2 py-0.5 rounded border <?= $roleClass ?>">
                                        <?= $roleLabel ?>
                                    </span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <img src="<?= $fotoPath ?>"
                                        onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=<?= urlencode($row['nama_peserta'] ?? '') ?>&background=6d28d9&color=fff';"
                                        class="w-9 h-9 rounded-xl object-cover border border-slate-600 bg-slate-900">
                                    <div>
                                        <div class="font-semibold text-white"><?= esc($row['nama_peserta'] ?? '-') ?> <span class="text-xs text-slate-400 font-mono">(No. <?= $noUrut ?>)</span></div>
                                        <div class="text-xs text-purple-400"><?= esc($row['judul_lagu'] ?? '-') ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="text-base font-bold text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-3 py-1 rounded-xl font-mono">
                                    <?= number_format((float)($row['nilai'] ?? 0), 2) ?>
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-300 italic text-xs max-w-xs truncate">
                                "<?= esc($row['catatan'] ?? '-') ?>"
                            </td>
                            <td class="py-3 px-4 text-center text-xs text-slate-400 font-mono">
                                <?= isset($row['created_at']) ? date('d M Y, H:i', strtotime($row['created_at'])) : '-' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500">
                            Belum ada hasil voting juri pada tanggal ini.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    let pollInterval = null;

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    function handleResetSubmit(event) {
        event.preventDefault();
        const yakin = confirm('PERINGATAN!\n\nApakah Anda yakin ingin MENGHAPUS SELURUH DATA VOTE dari sistem?\n\nSemua data penilaian akan dibersihkan tanpa memandang tanggal.');
        if (yakin) {
            if (pollInterval) clearInterval(pollInterval);
            document.getElementById('form-reset-vote').submit();
        }
    }

    function loadHasilVote() {
        const tanggalFilter = document.getElementById('input_tanggal').value;

        fetch("<?= base_url('admin/hasil-vote') ?>?tanggal=" + tanggalFilter, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(response => response.json())
            .then(res => {
                // Update Tabel Penilaian
                const listPenilaian = res.penilaian || [];
                let htmlPenilaian = '';
                if (Array.isArray(listPenilaian) && listPenilaian.length > 0) {
                    listPenilaian.forEach((row, index) => {
                        const fotoPath = row.foto ? '<?= base_url('uploads/peserta/') ?>/' + row.foto : `https://ui-avatars.com/api/?name=${encodeURIComponent(row.nama_peserta || '')}&background=6d28d9&color=fff`;
                        const noUrut = String(row.nomor_urut || 0).padStart(2, '0');

                        let formattedDate = '-';
                        if (row.created_at) {
                            const date = new Date(row.created_at);
                            formattedDate = date.toLocaleDateString('id-ID', {
                                day: '2-digit',
                                month: 'short',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                        }

                        let roleClass = 'bg-purple-500/10 text-purple-400 border-purple-500/20';
                        let roleLabel = 'Juri Tetap';
                        if (row.role_juri === 'juri_tamu' || row.role_juri === 'juri_sementara') {
                            roleClass = 'bg-amber-500/10 text-amber-400 border-amber-500/20';
                            roleLabel = 'Juri Tamu';
                        } else if (row.role_juri === 'sosmed') {
                            roleClass = 'bg-sky-500/10 text-sky-400 border-sky-500/20';
                            roleLabel = 'Sosmed';
                        }

                        const nilaiFormatted = parseFloat(row.nilai || 0).toFixed(2);

                        htmlPenilaian += `
                        <tr class="hover:bg-slate-700/30 transition">
                            <td class="py-3 px-4 text-center text-slate-400 font-mono">${index + 1}</td>
                            <td class="py-3 px-4 font-semibold text-white">
                                <div class="flex flex-col gap-1">
                                    <span class="text-white font-medium">${escapeHtml(row.nama_juri || '-')}</span>
                                    <span class="inline-block w-max text-[10px] px-2 py-0.5 rounded border ${roleClass}">
                                        ${roleLabel}
                                    </span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <img src="${fotoPath}" 
                                         onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(row.nama_peserta || '')}&background=6d28d9&color=fff';" 
                                         class="w-9 h-9 rounded-xl object-cover border border-slate-600 bg-slate-900">
                                    <div>
                                        <div class="font-semibold text-white">${escapeHtml(row.nama_peserta || '-')} <span class="text-xs text-slate-400 font-mono">(No. ${noUrut})</span></div>
                                        <div class="text-xs text-purple-400">${escapeHtml(row.judul_lagu || '-')}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="text-base font-bold text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-3 py-1 rounded-xl font-mono">
                                    ${nilaiFormatted}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-300 italic text-xs max-w-xs truncate">
                                "${escapeHtml(row.catatan || '-')}"
                            </td>
                            <td class="py-3 px-4 text-center text-xs text-slate-400 font-mono">
                                ${formattedDate}
                            </td>
                        </tr>`;
                    });
                } else {
                    htmlPenilaian = `
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500">
                            Belum ada hasil voting juri pada tanggal ini.
                        </td>
                    </tr>`;
                }
                document.getElementById('tabel-penilaian').innerHTML = htmlPenilaian;

                // Update Tabel Rekap
                const listRekap = res.rekapNilai || [];
                let htmlRekap = '';
                if (Array.isArray(listRekap) && listRekap.length > 0) {
                    listRekap.forEach((rk, rank) => {
                        const fotoPath = rk.foto ? '<?= base_url('uploads/peserta/') ?>/' + rk.foto : `https://ui-avatars.com/api/?name=${encodeURIComponent(rk.nama_peserta || '')}&background=6d28d9&color=fff`;
                        const noUrut = String(rk.nomor_urut || 0).padStart(2, '0');
                        const isTop3 = rank < 3;
                        let rankBadgeClass = 'bg-slate-800 text-slate-400 border-slate-700';
                        if (rank === 0) rankBadgeClass = 'bg-amber-500/20 text-amber-300 border-amber-500/40';
                        else if (rank === 1) rankBadgeClass = 'bg-slate-300/20 text-slate-200 border-slate-400/40';
                        else if (rank === 2) rankBadgeClass = 'bg-amber-700/20 text-amber-400 border-amber-700/40';

                        const daerahText = rk.asal_daerah || rk.alamat || '-';
                        const avgJuriTamu = rk.avg_juri_tamu !== undefined ? rk.avg_juri_tamu : (rk.avg_juri_sementara || 0);

                        htmlRekap += `
                        <tr class="hover:bg-slate-700/30 transition ${isTop3 ? 'bg-slate-800/40' : ''}">
                            <td class="py-3 px-4 text-center font-mono">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-bold border ${rankBadgeClass}">
                                    ${rank + 1}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <img src="${fotoPath}"
                                         onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(rk.nama_peserta || '')}&background=6d28d9&color=fff';"
                                         class="w-9 h-9 rounded-xl object-cover border border-slate-600 bg-slate-900">
                                    <div>
                                        <div class="font-semibold text-white">${escapeHtml(rk.nama_peserta || '-')} <span class="text-xs text-slate-400 font-mono">(No. ${noUrut})</span></div>
                                        <div class="text-xs text-slate-400">${escapeHtml(daerahText)}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-center font-mono text-purple-300">${parseFloat(rk.avg_juri_tetap || 0).toFixed(2)}</td>
                            <td class="py-3 px-4 text-center font-mono text-amber-300">${parseFloat(avgJuriTamu || 0).toFixed(2)}</td>
                            <td class="py-3 px-4 text-center font-mono text-sky-300">${parseFloat(rk.nilai_sosmed || 0).toFixed(2)}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="text-base font-bold text-amber-400 bg-amber-500/10 border border-amber-500/20 px-3 py-1 rounded-xl font-mono">
                                    ${parseFloat(rk.nilai_akhir || 0).toFixed(2)}
                                </span>
                            </td>
                        </tr>`;
                    });
                } else {
                    htmlRekap = `
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500">
                            Belum ada rekapitulasi penilaian.
                        </td>
                    </tr>`;
                }
                document.getElementById('tabel-rekap').innerHTML = htmlRekap;
            })
            .catch(error => console.error('Error fetching live data:', error));
    }

    pollInterval = setInterval(loadHasilVote, 3000);
</script>

<?= $this->endSection() ?>