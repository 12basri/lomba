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

<!-- Tabel Data Pendaftar Audisi -->
<div class="bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden shadow-xl">
    <div class="p-5 border-b border-slate-700 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        <div>
            <h2 class="text-lg font-bold text-white">Daftar Pendaftar Audisi</h2>
            <p class="text-xs text-slate-400 mt-0.5">Kelola, periksa kelengkapan berkas, dan verifikasi status pendaftar audisi.</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300">
            <thead class="bg-slate-900/60 text-slate-400 uppercase text-xs tracking-wider border-b border-slate-700">
                <tr>
                    <th class="py-3.5 px-4 text-center">No. Urut</th>
                    <th class="py-3.5 px-4">Nama Peserta</th>
                    <th class="py-3.5 px-4 text-center">No. WA</th>
                    <th class="py-3.5 px-4 text-center">Gender</th>
                    <th class="py-3.5 px-4 text-center">Berkas Dokumen</th>
                    <th class="py-3.5 px-4 text-center">Status</th>
                    <th class="py-3.5 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700/50">
                <?php if (!empty($pendaftar)) : ?>
                    <?php foreach ($pendaftar as $row) : ?>
                        <tr class="hover:bg-slate-700/30 transition">
                            <!-- Nomor Urut -->
                            <td class="py-3 px-4 text-center font-mono font-bold text-purple-400">
                                <?php if (!empty($row['nomor_urut'])) : ?>
                                    <?= sprintf('%02d', $row['nomor_urut']) ?>
                                <?php else : ?>
                                    <span class="text-slate-500 font-normal">-</span>
                                <?php endif; ?>
                            </td>

                            <!-- Profil Pendaftar -->
                            <td class="py-3 px-4 font-medium text-white">
                                <div class="flex items-center gap-3">
                                    <?php if (!empty($row['foto'])) : ?>
                                        <img src="<?= base_url('uploads/peserta/' . $row['foto']) ?>" alt="Foto" class="w-9 h-9 rounded-full object-cover border border-slate-600">
                                    <?php else : ?>
                                        <div class="w-9 h-9 rounded-full bg-slate-700 border border-slate-600 flex items-center justify-center text-xs font-bold text-slate-300">
                                            <?= strtoupper(substr($row['nama_peserta'] ?? 'P', 0, 1)) ?>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <p class="font-semibold text-white"><?= esc($row['nama_peserta']) ?></p>
                                        <p class="text-[11px] text-slate-400 truncate max-w-xs"><?= esc($row['alamat'] ?? 'Alamat tidak diisi') ?></p>
                                    </div>
                                </div>
                            </td>

                            <!-- Nomor WA -->
                            <td class="py-3 px-4 text-center font-mono text-amber-400">
                                <?= esc($row['no_wa'] ?? '-') ?>
                            </td>

                            <!-- Gender -->
                            <td class="py-3 px-4 text-center">
                                <?php if (($row['jenis_kelamin'] ?? '') === 'L') : ?>
                                    <span class="bg-blue-500/10 text-blue-400 border border-blue-500/30 text-xs px-2.5 py-1 rounded-full">Laki-laki</span>
                                <?php else : ?>
                                    <span class="bg-pink-500/10 text-pink-400 border border-pink-500/30 text-xs px-2.5 py-1 rounded-full">Perempuan</span>
                                <?php endif; ?>
                            </td>

                            <!-- Berkas Dokumen -->
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5 flex-wrap">
                                    <?php if (!empty($row['ktp_pelajar'])) : ?>
                                        <a href="<?= base_url('uploads/peserta/' . $row['ktp_pelajar']) ?>" target="_blank" class="px-2 py-1 bg-slate-700 hover:bg-slate-600 text-xs text-slate-200 rounded-md border border-slate-600 transition" title="KTP/Kartu Pelajar">KTP</a>
                                    <?php endif; ?>

                                    <?php if (!empty($row['bukti_bayar'])) : ?>
                                        <a href="<?= base_url('uploads/peserta/' . $row['bukti_bayar']) ?>" target="_blank" class="px-2 py-1 bg-emerald-900/40 hover:bg-emerald-800/40 text-xs text-emerald-300 rounded-md border border-emerald-600/50 transition" title="Bukti Pembayaran">Bayar</a>
                                    <?php endif; ?>

                                    <?php if (!empty($row['formulir_doc'])) : ?>
                                        <a href="<?= base_url('uploads/peserta/' . $row['formulir_doc']) ?>" target="_blank" class="px-2 py-1 bg-purple-900/40 hover:bg-purple-800/40 text-xs text-purple-300 rounded-md border border-purple-600/50 transition" title="Formulir Pendaftaran">Form</a>
                                    <?php endif; ?>

                                    <?php if (!empty($row['kartu_identitas'])) : ?>
                                        <a href="<?= base_url('uploads/peserta/' . $row['kartu_identitas']) ?>" target="_blank" class="px-2 py-1 bg-blue-900/40 hover:bg-blue-800/40 text-xs text-blue-300 rounded-md border border-blue-600/50 transition" title="Kartu Identitas">Identitas</a>
                                    <?php endif; ?>

                                    <?php if (empty($row['ktp_pelajar']) && empty($row['bukti_bayar']) && empty($row['formulir_doc']) && empty($row['kartu_identitas'])) : ?>
                                        <span class="text-xs text-slate-500 italic">Tidak ada berkas</span>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <!-- Badge Status -->
                            <td class="py-3 px-4 text-center">
                                <?php if (($row['status'] ?? '') === 'diterima') : ?>
                                    <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 text-xs px-2.5 py-1 rounded-full font-medium">Diterima</span>
                                <?php elseif (($row['status'] ?? '') === 'ditolak') : ?>
                                    <span class="bg-red-500/10 text-red-400 border border-red-500/30 text-xs px-2.5 py-1 rounded-full font-medium">Ditolak</span>
                                <?php else : ?>
                                    <span class="bg-amber-500/10 text-amber-400 border border-amber-500/30 text-xs px-2.5 py-1 rounded-full font-medium">Pending</span>
                                <?php endif; ?>
                            </td>

                            <!-- Aksi Verifikasi & Hapus -->
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Tombol Terima / Verifikasi -->
                                    <?php if (($row['status'] ?? '') !== 'diterima') : ?>
                                        <a href="<?= base_url('admin/audisi/verifikasi/' . $row['id'] . '?status=diterima') ?>" onclick="return confirm('Terima pendaftar ini sebagai peserta resmi?')" class="p-1.5 bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 rounded-lg transition" title="Terima Pendaftar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </a>
                                    <?php endif; ?>

                                    <!-- Tombol Tolak -->
                                    <?php if (($row['status'] ?? '') !== 'ditolak') : ?>
                                        <a href="<?= base_url('admin/audisi/verifikasi/' . $row['id'] . '?status=ditolak') ?>" onclick="return confirm('Tolak pendaftaran audisi ini?')" class="p-1.5 bg-amber-500/10 hover:bg-amber-500/20 text-amber-400 border border-amber-500/30 rounded-lg transition" title="Tolak Pendaftar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </a>
                                    <?php endif; ?>

                                    <!-- Tombol Hapus -->
                                    <a href="<?= base_url('admin/audisi/delete/' . $row['id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data pendaftar ini?')" class="p-1.5 bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/30 rounded-lg transition" title="Hapus Data">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="py-8 text-center text-slate-500">
                            Belum ada data pendaftar audisi.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>