<!DOCTYPE html>
<html lang="id" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Formulir Pendaftaran Magello Dangdut Festival 2026') ?></title>

    <!-- Meta Tag untuk Preview saat link dibagikan (WhatsApp, FB, Twitter, dll) -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta property="og:title" content="Formulir Pendaftaran Magello Dangdut Festival 2026">
    <meta property="og:description" content="Daftarkan dirimu sekarang! Total hadiah Rp 30.000.000,-. Pengambilan formulir 11–23 September 2026 di Pendopo Kantor Camat Wonomulyo.">
    <!-- URL gambar logo/banner yang muncul saat link dishare -->
    <meta property="og:image" content="<?= base_url('assets/img/logo.png') ?>">
    <meta property="og:image:secure_url" content="<?= base_url('assets/img/logo.png') ?>">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="600">
    <meta property="og:image:height" content="600">

    <!-- Meta Tag khusus Twitter/X -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Formulir Pendaftaran Magello Dangdut Festival 2026">
    <meta name="twitter:description" content="Total Hadiah Rp 30.000.000,-. Syarat usia peserta 14-30 Tahun.">
    <meta name="twitter:image" content="<?= base_url('assets/img/logo.png') ?>">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#13031a] text-fuchsia-100 min-h-screen flex flex-col justify-center items-center p-4 font-sans selection:bg-fuchsia-600 selection:text-white">

    <div class="w-full max-w-lg bg-[#1e0729]/90 border border-fuchsia-900/60 rounded-2xl p-6 sm:p-8 shadow-2xl backdrop-blur-md relative overflow-hidden my-6">

        <!-- Header Formulir -->
        <div class="text-center mb-6 border-b border-fuchsia-800/40 pb-4 relative z-10">
            <!-- LOGO FESTIVAL -->
            <div class="flex justify-center mb-3">
                <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo Magello Dangdut Festival" class="h-20 sm:h-24 object-contain drop-shadow-[0_0_12px_rgba(217,70,239,0.5)]">
            </div>

            <h1 class="text-xl sm:text-2xl font-black text-amber-300 tracking-wider uppercase">MAGELLO DANGDUT FESTIVAL WONOMULYO</h1>
            <p class="text-xs text-fuchsia-300/80 mt-1">POLEWALI MANDAR 2026</p>
            <span class="inline-block mt-3 px-3 py-1 bg-fuchsia-950 border border-fuchsia-700/50 rounded-full text-[11px] font-semibold text-fuchsia-200 tracking-wide">
                FORMULIR PENDAFTARAN PESERTA AUDISI
            </span>
        </div>

        <!-- INFORMASI EVENT & JADWAL -->
        <div class="mb-6 bg-slate-900/70 border border-fuchsia-700/50 rounded-xl p-4 text-xs space-y-3 relative z-10 shadow-lg">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 border-b border-fuchsia-800/40 pb-3">
                <!-- Tanggal Pengambilan Formulir -->
                <div class="flex items-start gap-2">
                    <svg class="w-4 h-4 text-amber-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-amber-400">Tanggal Pengambilan Formulir</span>
                        <span class="font-semibold text-fuchsia-100">11 – 23 September 2026</span>
                    </div>
                </div>

                <!-- Lokasi Pengambilan -->
                <div class="flex items-start gap-2">
                    <svg class="w-4 h-4 text-amber-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 01-6 0 3 3 0 016 0z" />
                    </svg>
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-amber-400">Lokasi Pengambilan Formulir</span>
                        <span class="font-semibold text-fuchsia-100">Pendopo Kantor Camat Wonomulyo</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 border-b border-fuchsia-800/40 pb-3">
                <!-- Lokasi Event -->
                <div class="flex items-start gap-2">
                    <svg class="w-4 h-4 text-amber-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-amber-400">Lokasi Event</span>
                        <span class="font-semibold text-fuchsia-100">Alun-alun Kota Wonomulyo</span>
                    </div>
                </div>

                <!-- Syarat Peserta -->
                <div class="flex items-start gap-2">
                    <svg class="w-4 h-4 text-amber-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-amber-400">Syarat Peserta</span>
                        <span class="font-semibold text-fuchsia-100">Berusia 14 – 30 Tahun</span>
                    </div>
                </div>
            </div>

            <!-- Rincian Biaya -->
            <div class="flex flex-wrap items-center justify-between gap-2 border-b border-fuchsia-800/40 pb-3">
                <div class="flex items-center gap-1.5">
                    <span class="text-fuchsia-300">Biaya Formulir:</span>
                    <span class="font-bold text-amber-300">Rp 100.000 / Orang</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="text-fuchsia-300">Biaya Pendaftaran:</span>
                    <span class="font-bold text-amber-300">Rp 300.000 / Orang</span>
                </div>
            </div>

            <!-- Informasi Rekening Pembayaran -->
            <div class="bg-amber-500/10 border border-amber-500/30 rounded-lg p-2.5 text-center">
                <span class="block text-[10px] uppercase font-bold text-amber-400 mb-0.5">Pembayaran Resmi Transfer Ke:</span>
                <p class="font-mono text-sm font-bold text-amber-300 tracking-wider">1700018429443</p>
                <p class="text-[11px] font-semibold text-fuchsia-100">Bank Mandiri a.n <span class="text-amber-300">Mahmuddin</span></p>
            </div>
        </div>

        <!-- TOMBOL DOWNLOAD FORMAT FORMULIR -->
        <div class="mb-6 bg-gradient-to-r from-amber-950/40 to-fuchsia-950/40 border border-amber-500/40 rounded-xl p-4 text-center relative z-10 shadow-lg">
            <p class="text-xs text-amber-200 font-semibold mb-2">Belum memiliki berkas formulir cetak?</p>
            <a href="<?= base_url('assets/docs/FORMULIR_PESERTA_DANGDUT_MAGELLO.docx') ?>" download class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-400 text-slate-950 rounded-lg text-xs font-bold transition shadow-md active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download Format Formulir (.DOCX)
            </a>
            <p class="text-[10px] text-fuchsia-300/70 mt-2">*Unduh, isi/cetak, tanda tangani, lalu unggah fotonya/PDF-nya pada form di bawah ini.</p>
        </div>

        <!-- Alert Notifikasi -->
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="mb-4 p-3 bg-rose-500/20 border border-rose-500/40 rounded-xl text-rose-300 text-xs shadow-inner">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="mb-4 p-3 bg-emerald-500/20 border border-emerald-500/40 rounded-xl text-emerald-300 text-xs shadow-inner font-semibold">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <!-- Form Input -->
        <form action="<?= base_url('registrasi/simpan') ?>" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs sm:text-sm relative z-10">
            <?= csrf_field() ?>

            <!-- Nama Lengkap -->
            <div>
                <label for="nama_peserta" class="block font-semibold text-fuchsia-200 mb-1">Nama Lengkap (Sesuai KTP)</label>
                <input type="text" id="nama_peserta" name="nama_peserta" required value="<?= old('nama_peserta') ?>" placeholder="Masukkan nama lengkap" class="w-full bg-[#13031a] border border-fuchsia-800/60 rounded-xl px-3 py-2 text-fuchsia-100 placeholder:text-fuchsia-700 focus:outline-none focus:border-amber-400">
            </div>

            <!-- Alamat -->
            <div>
                <label for="alamat" class="block font-semibold text-fuchsia-200 mb-1">Alamat Lengkap</label>
                <textarea id="alamat" name="alamat" rows="2" required placeholder="Masukkan alamat domisili lengkap" class="w-full bg-[#13031a] border border-fuchsia-800/60 rounded-xl px-3 py-2 text-fuchsia-100 placeholder:text-fuchsia-700 focus:outline-none focus:border-amber-400"><?= old('alamat') ?></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Nomor WA -->
                <div>
                    <label for="no_wa" class="block font-semibold text-fuchsia-200 mb-1">Nomor WhatsApp</label>
                    <input type="tel" id="no_wa" name="no_wa" required value="<?= old('no_wa') ?>" placeholder="Contoh: 081234567890" class="w-full bg-[#13031a] border border-fuchsia-800/60 rounded-xl px-3 py-2 text-fuchsia-100 placeholder:text-fuchsia-700 focus:outline-none focus:border-amber-400">
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block font-semibold text-fuchsia-200 mb-1">Jenis Kelamin</label>
                    <div class="flex gap-4 items-center bg-[#13031a] border border-fuchsia-800/60 rounded-xl p-2 h-[38px]">
                        <label class="flex items-center gap-1.5 cursor-pointer text-xs">
                            <input type="radio" name="jenis_kelamin" value="L" <?= old('jenis_kelamin', 'L') == 'L' ? 'checked' : '' ?> class="accent-amber-400">
                            <span>LAKI-LAKI</span>
                        </label>
                        <label class="flex items-center gap-1.5 cursor-pointer text-xs">
                            <input type="radio" name="jenis_kelamin" value="P" <?= old('jenis_kelamin') == 'P' ? 'checked' : '' ?> class="accent-amber-400">
                            <span>PEREMPUAN</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="border-t border-fuchsia-900/50 pt-4 space-y-4">
                <!-- Upload Foto Peserta -->
                <div>
                    <label for="foto" class="block font-semibold text-fuchsia-200 mb-1">Upload Foto Peserta (Maks 3MB)</label>
                    <input type="file" id="foto" name="foto" accept="image/*" required class="w-full bg-[#13031a] border border-fuchsia-800/60 rounded-xl px-3 py-1.5 text-xs text-fuchsia-300 file:mr-3 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:bg-fuchsia-800 file:text-fuchsia-100 cursor-pointer">
                    <p class="text-[10px] text-fuchsia-400/60 mt-1">*Foto terbaru ukuran 3R / Close UP. Format: JPG, PNG.</p>
                </div>

                <!-- Upload KTP / Pelajar -->
                <div>
                    <label for="ktp_pelajar" class="block font-semibold text-fuchsia-200 mb-1">Upload Scan KTP / Kartu Pelajar (Maks 3MB)</label>
                    <input type="file" id="ktp_pelajar" name="ktp_pelajar" accept="image/*,application/pdf" required class="w-full bg-[#13031a] border border-fuchsia-800/60 rounded-xl px-3 py-1.5 text-xs text-fuchsia-300 file:mr-3 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:bg-fuchsia-800 file:text-fuchsia-100 cursor-pointer">
                    <p class="text-[10px] text-fuchsia-400/60 mt-1">*Format: JPG, PNG, atau PDF.</p>
                </div>

                <!-- Upload Bukti Pembayaran -->
                <div>
                    <label for="bukti_bayar" class="block font-semibold text-fuchsia-200 mb-1">Upload Bukti Pembayaran Registrasi (Maks 3MB)</label>
                    <input type="file" id="bukti_bayar" name="bukti_bayar" accept="image/*,application/pdf" required class="w-full bg-[#13031a] border border-fuchsia-800/60 rounded-xl px-3 py-1.5 text-xs text-emerald-300 file:mr-3 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:bg-emerald-800 file:text-emerald-100 cursor-pointer">
                    <p class="text-[10px] text-emerald-400/80 mt-1">*Transfer ke **Bank Mandiri 1700018429443 a.n Mahmuddin**. Format: JPG, PNG, atau PDF.</p>
                </div>

                <!-- Upload Berkas Formulir Fisik -->
                <div>
                    <label for="formulir_doc" class="block font-semibold text-amber-300 mb-1">Upload Berkas Formulir Pendaftaran (Maks 5MB)</label>
                    <input type="file" id="formulir_doc" name="formulir_doc" accept="image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" required class="w-full bg-[#13031a] border border-amber-600/60 rounded-xl px-3 py-1.5 text-xs text-amber-200 file:mr-3 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:bg-amber-600 file:text-slate-950 file:font-bold cursor-pointer">
                    <p class="text-[10px] text-amber-400/70 mt-1">*Upload formulir fisik yang telah diisi & ditandatangani. Format: PDF, DOC, DOCX, JPG, PNG.</p>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3 bg-gradient-to-r from-amber-500 via-fuchsia-600 to-pink-600 hover:from-amber-400 hover:via-fuchsia-500 hover:to-pink-500 text-white rounded-xl font-bold shadow-lg transition-all active:scale-95 flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                KIRIM FORMULIR PENDAFTARAN
            </button>
        </form>

        <!-- Informasi Kontak WhatsApp Panitia -->
        <div class="mt-6 bg-emerald-950/30 border border-emerald-800/40 rounded-xl p-3 text-[11px] text-emerald-200 relative z-10">
            <p class="font-bold text-emerald-400 mb-1.5 flex items-center gap-1.5">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z" />
                </svg>
                Informasi lebih lanjut Magello Dangdut Festival 2026:
            </p>
            <div class="flex flex-wrap gap-x-4 gap-y-1 font-medium text-emerald-100">
                <a href="https://wa.me/6285387427432" target="_blank" class="hover:underline hover:text-emerald-300">
                    +62 853-8742-7432 <span class="text-emerald-400/80">(Veny)</span>
                </a>
                <a href="https://wa.me/6282334646545" target="_blank" class="hover:underline hover:text-emerald-300">
                    +62 823-3464-6545 <span class="text-emerald-400/80">(Awhy)</span>
                </a>
            </div>
        </div>

        <!-- Media Sosial Resmi -->
        <div class="mt-4 bg-fuchsia-950/40 border border-fuchsia-800/40 rounded-xl p-3 text-[11px] relative z-10">
            <p class="font-bold text-fuchsia-300 mb-2">Ikuti Media Sosial Resmi Kami:</p>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                <!-- Instagram -->
                <a href="https://instagram.com/MagelloDfestwono" target="_blank" class="flex items-center gap-1.5 text-pink-300 hover:text-pink-200 transition">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                    </svg>
                    <span>MagelloD'festwono</span>
                </a>

                <!-- TikTok -->
                <a href="https://tiktok.com/@magelloD'festwono" target="_blank" class="flex items-center gap-1.5 text-fuchsia-300 hover:text-fuchsia-200 transition">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 11-5.2-1.74 2.89 2.89 0 012.31-1.28V9.12a6.34 6.34 0 00-6.12 6.34 6.33 6.33 0 0010.8 4.47V10.8a8.28 8.28 0 005.43 1.95V9.3a4.85 4.85 0 01-3.77-2.61z" />
                    </svg>
                    <span>magelloD'festwono</span>
                </a>

                <!-- YouTube -->
                <a href="https://youtube.com/@magelloD'festwono" target="_blank" class="flex items-center gap-1.5 text-rose-400 hover:text-rose-300 transition">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                    </svg>
                    <span>magelloD'festwono</span>
                </a>
            </div>
        </div>

        <div class="mt-4 text-center border-t border-fuchsia-900/40 pt-3 relative z-10">
        </div>
    </div>

</body>

</html>