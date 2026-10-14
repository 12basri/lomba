<?php
$uri = service('uri');
$segment2 = $uri->getTotalSegments() >= 2 ? $uri->getSegment(2) : '';
?>

<!-- Mobile Navbar Top -->
<div class="md:hidden bg-slate-800 border-b border-slate-700 p-4 flex items-center justify-between w-full sticky top-0 z-30 shadow-md">
    <div class="flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12 0c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
        </svg>
        <span class="font-bold text-white text-base">Panel Juri</span>
    </div>
    <button id="toggleSidebar" type="button" class="text-slate-300 hover:text-white p-2 rounded-lg bg-slate-700/50 focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
</div>

<!-- Overlay Background Mobile -->
<div id="sidebarOverlay" class="fixed inset-0 bg-slate-950/80 z-40 hidden md:hidden transition-opacity"></div>

<!-- Sidebar Component -->
<aside id="sidebar" class="fixed md:static inset-y-0 left-0 z-50 w-64 bg-slate-800 border-r border-slate-700 flex-shrink-0 hidden md:flex flex-col justify-between h-screen sticky top-0 transition-all duration-300">
    <div>
        <!-- Sidebar Header -->
        <div class="p-5 border-b border-slate-700 flex items-center justify-between">
            <div>
                <h1 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12 0c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                    </svg>
                    Panel Juri
                </h1>
                <p class="text-xs text-slate-400 mt-0.5">Sistem Penilaian Event Dangdut</p>
            </div>
            <!-- Close Button (Mobile Only) -->
            <button id="closeSidebar" type="button" class="md:hidden text-slate-400 hover:text-white p-1 rounded-lg hover:bg-slate-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Profil Ringkas Juri -->
        <div class="mx-4 my-3 p-3 rounded-xl bg-slate-900/50 border border-slate-700/50 flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-purple-600/30 border border-purple-500/40 flex items-center justify-center font-bold text-purple-300 text-sm flex-shrink-0">
                <?= strtoupper(substr(session()->get('nama_lengkap') ?? 'J', 0, 1)) ?>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-xs font-semibold text-slate-200 truncate"><?= esc(session()->get('nama_lengkap') ?? 'Juri Penilai') ?></p>
                <p class="text-[10px] text-purple-400">Juri Aktif</p>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="px-4 space-y-1">
            <a href="<?= base_url('juri/dashboard') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition <?= ($segment2 === 'dashboard' || $segment2 === '') ? 'bg-purple-600 text-white shadow-lg shadow-purple-600/30' : 'text-slate-300 hover:bg-purple-600/20 hover:text-purple-400' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>

            <a href="<?= base_url('juri/penilaian') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition <?= ($segment2 === 'penilaian') ? 'bg-purple-600 text-white shadow-lg shadow-purple-600/30' : 'text-slate-300 hover:bg-purple-600/20 hover:text-purple-400' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Lembar Penilaian
            </a>
        </nav>
    </div>

    <!-- Bottom Actions / Logout -->
    <div class="p-4 border-t border-slate-700/50">
        <a href="<?= base_url('auth/logout') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-red-400 hover:bg-red-500/10 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            Logout
        </a>
    </div>
</aside>

<!-- Script Toggle Menu Mobile -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
    });
</script>