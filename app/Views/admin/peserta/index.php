<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Notification Flash Data -->
<?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-emerald-500/10 border border-emerald-500/50 text-emerald-400 text-sm p-4 rounded-xl flex items-center gap-3 mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="bg-red-500/10 border border-red-500/50 text-red-400 text-sm p-4 rounded-xl flex items-center gap-3 mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span><?= session()->getFlashdata('error') ?></span>
    </div>
<?php endif; ?>

<div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 shadow-xl">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Kelola Data Peserta Resmi
            </h2>
            <p class="text-xs text-slate-400">Daftar peserta yang telah diterima & lolos audisi</p>
        </div>

        <button onclick="openModalTambah()" class="px-4 py-2.5 bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-purple-600/20 transition flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            Tambah Peserta Baru
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300">
            <thead class="bg-slate-900/60 text-slate-400 uppercase text-xs tracking-wider border-b border-slate-700">
                <tr>
                    <th class="py-3.5 px-4 text-center w-20">No Urut</th>
                    <th class="py-3.5 px-4">Foto</th>
                    <th class="py-3.5 px-4">Nama Peserta</th>
                    <th class="py-3.5 px-4">Alamat / Asal</th>
                    <th class="py-3.5 px-4">No. WhatsApp</th>
                    <th class="py-3.5 px-4 text-center w-40">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700/50">
                <?php if (!empty($peserta)) : ?>
                    <?php foreach ($peserta as $row) : ?>
                        <tr class="hover:bg-slate-700/30 transition">
                            <td class="py-3 px-4 text-center font-bold text-white">
                                <span class="bg-purple-600/20 text-purple-300 px-2.5 py-1 rounded-lg border border-purple-500/30 font-mono">
                                    <?= sprintf('%02d', $row['nomor_urut']) ?>
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <img src="<?= base_url('uploads/peserta/' . (!empty($row['foto']) ? $row['foto'] : 'default.jpg')) ?>"
                                    alt="<?= esc($row['nama_peserta']) ?>"
                                    class="w-10 h-10 rounded-xl object-cover border border-slate-600 bg-slate-900 shadow-sm">
                            </td>
                            <td class="py-3 px-4 text-white font-semibold"><?= esc($row['nama_peserta']) ?></td>
                            <td class="py-3 px-4 text-slate-400"><?= esc($row['alamat'] ?? $row['asal_daerah'] ?? '-') ?></td>
                            <td class="py-3 px-4 text-slate-400">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <?= esc($row['no_wa'] ?? '-') ?>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="openModalEdit(<?= htmlspecialchars(json_encode($row)) ?>)" title="Edit Peserta" class="inline-flex items-center gap-1.5 text-xs bg-amber-500/10 text-amber-400 border border-amber-500/20 px-3 py-1.5 rounded-lg hover:bg-amber-500/20 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </button>
                                    <a href="<?= base_url('admin/peserta/delete/' . $row['id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus peserta ini?')" title="Hapus Peserta" class="inline-flex items-center gap-1.5 text-xs bg-red-500/10 text-red-400 border border-red-500/20 px-3 py-1.5 rounded-lg hover:bg-red-500/20 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.998-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500">
                            Belum ada peserta resmi (diterima).
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL TAMBAH PESERTA -->
<div id="modalTambah" class="fixed inset-0 z-50 hidden bg-slate-950/70 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-slate-800 border border-slate-700 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl">
        <div class="p-5 border-b border-slate-700 flex justify-between items-center">
            <h3 class="text-lg font-bold text-white">Tambah Peserta Baru</h3>
            <button onclick="closeModalTambah()" class="text-slate-400 hover:text-white">&times;</button>
        </div>
        <form action="<?= base_url('admin/peserta/store') ?>" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-xs font-medium text-slate-300 uppercase mb-1">Nomor Urut <span class="text-slate-500 font-normal">(Kosongkan untuk otomatis)</span></label>
                <input type="number" name="nomor_urut" placeholder="Otomatis berurut" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-purple-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-300 uppercase mb-1">Nama Peserta</label>
                <input type="text" name="nama_peserta" required placeholder="Nama Lengkap" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-purple-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-300 uppercase mb-1">Alamat / Asal Daerah</label>
                <input type="text" name="alamat" required placeholder="Kota / Alamat Lengkap" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-purple-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-300 uppercase mb-1">Nomor WhatsApp</label>
                <input type="text" name="no_wa" placeholder="081234567890" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-purple-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-300 uppercase mb-1">Foto Peserta</label>
                <input type="file" name="foto" accept="image/*" class="w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-purple-600 file:text-white hover:file:bg-purple-700 bg-slate-900 border border-slate-700 rounded-xl">
            </div>
            <div class="flex justify-end gap-3 pt-3">
                <button type="button" onclick="closeModalTambah()" class="px-4 py-2 bg-slate-700 text-slate-300 rounded-xl text-sm font-semibold">Batal</button>
                <button type="submit" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-sm font-semibold">Simpan Peserta</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT PESERTA -->
<div id="modalEdit" class="fixed inset-0 z-50 hidden bg-slate-950/70 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-slate-800 border border-slate-700 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl">
        <div class="p-5 border-b border-slate-700 flex justify-between items-center">
            <h3 class="text-lg font-bold text-white">Edit Data Peserta</h3>
            <button onclick="closeModalEdit()" class="text-slate-400 hover:text-white">&times;</button>
        </div>
        <form id="formEdit" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-xs font-medium text-slate-300 uppercase mb-1">Nomor Urut Peserta</label>
                <input type="number" id="edit_nomor_urut" name="nomor_urut" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-purple-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-300 uppercase mb-1">Nama Peserta</label>
                <input type="text" id="edit_nama_peserta" name="nama_peserta" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-purple-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-300 uppercase mb-1">Alamat / Asal Daerah</label>
                <input type="text" id="edit_alamat" name="alamat" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-purple-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-300 uppercase mb-1">Nomor WhatsApp</label>
                <input type="text" id="edit_no_wa" name="no_wa" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-purple-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-300 uppercase mb-1">Foto Peserta</label>
                <div class="flex items-center gap-3 mb-2">
                    <img id="edit_preview_foto" src="" class="w-12 h-12 rounded-xl object-cover border border-slate-600 bg-slate-900">
                    <span class="text-xs text-slate-400">Pilih foto baru jika ingin mengganti</span>
                </div>
                <input type="file" name="foto" accept="image/*" class="w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-purple-600 file:text-white hover:file:bg-purple-700 bg-slate-900 border border-slate-700 rounded-xl">
            </div>
            <div class="flex justify-end gap-3 pt-3">
                <button type="button" onclick="closeModalEdit()" class="px-4 py-2 bg-slate-700 text-slate-300 rounded-xl text-sm font-semibold">Batal</button>
                <button type="submit" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-sm font-semibold">Update Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModalTambah() {
        document.getElementById('modalTambah').classList.remove('hidden');
    }

    function closeModalTambah() {
        document.getElementById('modalTambah').classList.add('hidden');
    }

    function openModalEdit(data) {
        document.getElementById('formEdit').action = "<?= base_url('admin/peserta/update') ?>/" + data.id;
        document.getElementById('edit_nomor_urut').value = data.nomor_urut;
        document.getElementById('edit_nama_peserta').value = data.nama_peserta;
        document.getElementById('edit_alamat').value = data.alamat || data.asal_daerah || '';
        document.getElementById('edit_no_wa').value = data.no_wa || '';

        const fotoUrl = data.foto ? "<?= base_url('uploads/peserta/') ?>/" + data.foto : "<?= base_url('uploads/peserta/default.jpg') ?>";
        document.getElementById('edit_preview_foto').src = fotoUrl;

        document.getElementById('modalEdit').classList.remove('hidden');
    }

    function closeModalEdit() {
        document.getElementById('modalEdit').classList.add('hidden');
    }
</script>

<?= $this->endSection() ?>