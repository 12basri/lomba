<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

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
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                Kelola Kriteria Penilaian
            </h2>
            <p class="text-xs text-slate-400">Atur kriteria dan bobot presentase penilaian</p>
        </div>

        <button onclick="openModalTambah()" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-emerald-600/20 transition flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Kriteria
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300">
            <thead class="bg-slate-900/60 text-slate-400 uppercase text-xs tracking-wider border-b border-slate-700">
                <tr>
                    <th class="py-3.5 px-4 text-center w-16">No</th>
                    <th class="py-3.5 px-4">Nama Kriteria</th>
                    <th class="py-3.5 px-4 text-center w-32">Bobot (%)</th>
                    <th class="py-3.5 px-4 text-center w-40">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700/50">
                <?php if (!empty($kriteria)) : ?>
                    <?php $no = 1;
                    foreach ($kriteria as $row) : ?>
                        <tr class="hover:bg-slate-700/30 transition">
                            <td class="py-3 px-4 text-center text-slate-400 font-mono"><?= $no++ ?></td>
                            <td class="py-3 px-4 text-white font-semibold"><?= esc($row['nama_kriteria']) ?></td>
                            <td class="py-3 px-4 text-center font-mono font-bold text-emerald-400">
                                <span class="bg-emerald-500/10 border border-emerald-500/20 px-2.5 py-1 rounded-lg">
                                    <?= esc($row['bobot']) ?>%
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="openModalEdit(<?= htmlspecialchars(json_encode($row)) ?>)" title="Edit" class="inline-flex items-center gap-1.5 text-xs bg-amber-500/10 text-amber-400 border border-amber-500/20 px-3 py-1.5 rounded-lg hover:bg-amber-500/20 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </button>
                                    <a href="<?= base_url('admin/kriteria/delete/' . $row['id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus kriteria ini?')" title="Hapus" class="inline-flex items-center gap-1.5 text-xs bg-red-500/10 text-red-400 border border-red-500/20 px-3 py-1.5 rounded-lg hover:bg-red-500/20 transition">
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
                        <td colspan="4" class="py-8 text-center text-slate-500">Belum ada data kriteria.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL TAMBAH KRITERIA -->
<div id="modalTambah" class="fixed inset-0 z-50 hidden bg-slate-950/70 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-slate-800 border border-slate-700 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl">
        <div class="p-5 border-b border-slate-700 flex justify-between items-center">
            <h3 class="text-lg font-bold text-white">Tambah Kriteria Baru</h3>
            <button onclick="closeModalTambah()" class="text-slate-400 hover:text-white">&times;</button>
        </div>
        <form action="<?= base_url('admin/kriteria/store') ?>" method="POST" class="p-5 space-y-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-xs font-medium text-slate-300 uppercase mb-1">Nama Kriteria</label>
                <input type="text" name="nama_kriteria" required placeholder="Vokal & Intonasi" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-emerald-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-300 uppercase mb-1">Bobot (%)</label>
                <input type="number" name="bobot" required placeholder="30" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-emerald-500">
            </div>
            <div class="flex justify-end gap-3 pt-3">
                <button type="button" onclick="closeModalTambah()" class="px-4 py-2 bg-slate-700 text-slate-300 rounded-xl text-sm font-semibold">Batal</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT KRITERIA -->
<div id="modalEdit" class="fixed inset-0 z-50 hidden bg-slate-950/70 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-slate-800 border border-slate-700 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl">
        <div class="p-5 border-b border-slate-700 flex justify-between items-center">
            <h3 class="text-lg font-bold text-white">Edit Kriteria</h3>
            <button onclick="closeModalEdit()" class="text-slate-400 hover:text-white">&times;</button>
        </div>
        <form id="formEdit" method="POST" class="p-5 space-y-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-xs font-medium text-slate-300 uppercase mb-1">Nama Kriteria</label>
                <input type="text" id="edit_nama_kriteria" name="nama_kriteria" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-emerald-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-300 uppercase mb-1">Bobot (%)</label>
                <input type="number" id="edit_bobot" name="bobot" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-emerald-500">
            </div>
            <div class="flex justify-end gap-3 pt-3">
                <button type="button" onclick="closeModalEdit()" class="px-4 py-2 bg-slate-700 text-slate-300 rounded-xl text-sm font-semibold">Batal</button>
                <button type="submit" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-sm font-semibold">Update</button>
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
        document.getElementById('formEdit').action = "<?= base_url('admin/kriteria/update') ?>/" + data.id;
        document.getElementById('edit_nama_kriteria').value = data.nama_kriteria;
        document.getElementById('edit_bobot').value = data.bobot;
        document.getElementById('modalEdit').classList.remove('hidden');
    }

    function closeModalEdit() {
        document.getElementById('modalEdit').classList.add('hidden');
    }
</script>

<?= $this->endSection() ?>