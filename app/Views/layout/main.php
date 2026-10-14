<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard Admin - Event Dangdut'; ?></title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-900 text-slate-100 min-h-screen flex flex-col md:flex-row antialiased">

    <!-- INCLUDE SIDEBAR -->
    <?= $this->include('layout/sidebar') ?>

    <!-- AREA KONTEN UTAMA -->
    <div class="flex-1 flex flex-col min-h-screen min-w-0 w-full overflow-y-auto">

        <!-- HEADER TOP BAR -->
        <header class="bg-slate-800/80 border-b border-slate-700 p-4 px-6 flex justify-between items-center backdrop-blur-md sticky top-0 z-10">
            <div>
                <h1 class="text-xl font-bold text-white"><?= $page_title ?? 'Data Peserta' ?></h1>
                <p class="text-xs text-slate-400">Sistem Penilaian Real-time Event Dangdut</p>
            </div>

            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-semibold text-slate-200"><?= session()->get('nama_lengkap') ?? 'Admin Utama' ?></p>
                    <span class="text-xs text-purple-400 bg-purple-500/10 px-2 py-0.5 rounded border border-purple-500/20">Administrator</span>
                </div>
            </div>
        </header>

        <!-- KONTEN HALAMAN (Padding berlebih dihapus di sini) -->
        <main class="flex-1 w-full min-w-0">
            <?= $this->renderSection('content') ?>
        </main>

        <!-- FOOTER -->
        <footer class="bg-slate-800/80 border-t border-slate-700/60 py-4 px-6 text-center text-xs text-slate-400 backdrop-blur-sm mt-auto">
            <p class="flex items-center justify-center gap-1.5">
                &copy; <?= date('Y') ?> <span class="font-semibold text-purple-400">Event Penilaian Dangdut System</span>. Built with CodeIgniter 4 & Tailwind CSS.
            </p>
        </footer>

    </div>

</body>

</html>