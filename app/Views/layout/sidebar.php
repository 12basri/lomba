<?php $uri = service('uri'); ?>

<!-- Mobile Top Bar Navbar (Muncul di layar HP paling atas) -->
<header class="md:hidden bg-slate-800 border-b border-slate-700 p-4 flex items-center justify-between w-full sticky top-0 z-30 shadow-md">
    <div class="flex items-center gap-2">
        <div class="p-1.5 bg-purple-600/20 text-purple-400 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12 0c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
            </svg>
        </div>
        <span class="font-bold text-white text-base">Panel Admin</span>
    </div>
    <button id="toggleSidebar" type="button" aria-label="Buka Menu Navigasi" class="text-slate-300 hover:text-white p-2 rounded-lg bg-slate-700/50 hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-purple-500 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
</header>

<!-- Overlay Mobile -->
<div id="sidebarOverlay" class="fixed inset-0 bg-slate-950/80 z-40 hidden md:hidden transition-opacity duration-300 backdrop-blur-sm"></div>

<!-- Sidebar Layout Admin -->
<aside id="sidebar" class="fixed md:static inset-y-0 left-0 z-50 w-64 bg-slate-800 border-r border-slate-700 flex-shrink-0 hidden md:flex flex-col justify-between h-screen overflow-y-auto select-none transition-all duration-300">
    <div class="flex flex-col flex-1">
        <!-- Header Sidebar -->
        <div class="p-5 flex items-center justify-between border-b border-slate-700/80 shrink-0">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-purple-600/20 text-purple-400 rounded-lg shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12 0c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-white text-base leading-tight truncate">Dangdut Event</h2>
                    <span class="text-[10px] text-purple-400 font-semibold uppercase tracking-wider bg-purple-500/10 px-1.5 py-0.5 rounded border border-purple-500/20">Panel Admin</span>
                </div>
            </div>
            <!-- Close Button (Mobile) -->
            <button id="closeSidebar" type="button" aria-label="Tutup Menu Navigasi" class="md:hidden text-slate-400 hover:text-white p-1 rounded-lg hover:bg-slate-700/50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Menu Navigasi Admin -->
        <nav class="p-4 space-y-1.5 flex-1 overflow-y-auto">
            <!-- Dashboard -->
            <a href="<?= base_url('admin/dashboard') ?>" class="flex items-center gap-3 px-3.5 py-2.5 text-sm font-medium rounded-xl transition-all <?= ($uri->getSegment(2) == 'dashboard' || $uri->getSegment(2) == '') ? 'text-white bg-purple-600/20 border border-purple-500/30 font-semibold shadow-sm' : 'text-slate-400 hover:bg-slate-700/50 hover:text-slate-200' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- Data Juri -->
            <a href="<?= base_url('admin/juri') ?>" class="flex items-center justify-between px-3.5 py-2.5 text-sm font-medium rounded-xl transition-all <?= ($uri->getSegment(2) == 'juri') ? 'text-white bg-purple-600/20 border border-purple-500/30 font-semibold shadow-sm' : 'text-slate-400 hover:bg-slate-700/50 hover:text-slate-200' ?>">
                <div class="flex items-center gap-3 truncate">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="truncate">Data Juri</span>
                </div>
                <div class="flex items-center gap-1 shrink-0 ml-2">
                    <span class="bg-purple-900/60 text-purple-300 text-[10px] px-1.5 py-0.5 rounded font-mono font-semibold border border-purple-500/20" title="Juri Tetap">
                        T:<?= $total_juri_tetap ?? 0 ?>
                    </span>
                    <span class="bg-indigo-900/60 text-indigo-300 text-[10px] px-1.5 py-0.5 rounded font-mono font-semibold border border-indigo-500/20" title="Juri Sementara">
                        S:<?= $total_juri_sementara ?? 0 ?>
                    </span>
                </div>
            </a>

            <!-- Data Peserta -->
            <a href="<?= base_url('admin/peserta') ?>" class="flex items-center justify-between px-3.5 py-2.5 text-sm font-medium rounded-xl transition-all <?= ($uri->getSegment(2) == 'peserta') ? 'text-white bg-purple-600/20 border border-purple-500/30 font-semibold shadow-sm' : 'text-slate-400 hover:bg-slate-700/50 hover:text-slate-200' ?>">
                <div class="flex items-center gap-3 truncate">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="truncate">Data Peserta</span>
                </div>
                <span class="bg-slate-700/80 text-slate-300 text-xs px-2 py-0.5 rounded-full font-semibold border border-slate-600/50 shrink-0 ml-2">
                    <?= $total_peserta ?? 0 ?>
                </span>
            </a>

            <!-- Pendaftaran / Audisi -->
            <a href="<?= base_url('admin/audisi') ?>" class="flex items-center justify-between px-3.5 py-2.5 text-sm font-medium rounded-xl transition-all <?= ($uri->getSegment(2) == 'audisi') ? 'text-white bg-purple-600/20 border border-purple-500/30 font-semibold shadow-sm' : 'text-slate-400 hover:bg-slate-700/50 hover:text-slate-200' ?>">
                <div class="flex items-center gap-3 truncate">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="truncate">Mendaftar Audisi</span>
                </div>
                <?php if (isset($total_pendaftar_audisi) && $total_pendaftar_audisi > 0) : ?>
                    <span class="bg-amber-500/20 text-amber-400 border border-amber-500/30 text-xs px-2 py-0.5 rounded-full font-semibold shrink-0 ml-2">
                        <?= $total_pendaftar_audisi ?>
                    </span>
                <?php endif; ?>
            </a>

            <!-- Hasil Vote Juri -->
            <a href="<?= base_url('admin/hasil-vote') ?>" class="flex items-center gap-3 px-3.5 py-2.5 text-sm font-medium rounded-xl transition-all <?= ($uri->getSegment(2) == 'hasil-vote') ? 'text-white bg-purple-600/20 border border-purple-500/30 font-semibold shadow-sm' : 'text-slate-400 hover:bg-slate-700/50 hover:text-slate-200' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="truncate">Hasil Vote Juri</span>
            </a>

            <!-- Menu Grafik / Analisis Nilai -->
            <a href="<?= base_url('admin/grafik') ?>" class="flex items-center gap-3 px-3.5 py-2.5 text-sm font-medium rounded-xl transition-all <?= ($uri->getSegment(2) == 'grafik') ? 'text-white bg-purple-600/20 border border-purple-500/30 font-semibold shadow-sm' : 'text-slate-400 hover:bg-slate-700/50 hover:text-slate-200' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                </svg>
                <span class="truncate">Grafik & Analisis</span>
            </a>
        </nav>
    </div>

    <!-- Logout Button -->
    <div class="p-4 border-t border-slate-700/60 shrink-0">
        <a href="<?= base_url('auth/logout') ?>" class="flex items-center gap-3 px-3.5 py-2.5 text-sm font-medium rounded-xl text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span class="truncate">Keluar (Logout)</span>
        </a>
    </div>
</aside>

<!-- Script Toggle Responsive -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleBtn = document.getElementById('toggleSidebar');
        const closeBtn = document.getElementById('closeSidebar');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function openMenu() {
            sidebar.classList.remove('hidden');
            sidebar.classList.add('flex');
            overlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden', 'md:overflow-auto');
        }

        function closeMenu() {
            sidebar.classList.add('hidden');
            sidebar.classList.remove('flex');
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden', 'md:overflow-auto');
        }

        if (toggleBtn) toggleBtn.addEventListener('click', openMenu);
        if (closeBtn) closeBtn.addEventListener('click', closeMenu);
        if (overlay) overlay.addEventListener('click', closeMenu);

        // Otomatis tutup sidebar jika layar di-resize ke ukuran desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                closeMenu();
            }
        });
    });
</script>