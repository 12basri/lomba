<!-- Overlay untuk Mobile -->
<div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-40 hidden lg:hidden"></div>

<!-- Sidebar Container -->
<aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-slate-800/90 border-r border-slate-700/60 flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">

    <div class="p-4 flex flex-col gap-1 border-b border-slate-700/50 lg:hidden">
        <p class="text-xs text-slate-400">Login sebagai:</p>
        <p class="text-sm font-bold text-white"><?= esc(session()->get('nama_lengkap')) ?></p>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-3 mb-2">Menu Utama</div>

        <!-- Dashboard Link -->
        <a href="<?= base_url('sosmed/dashboard') ?>" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-medium transition-all duration-200 <?= (uri_string() == 'sosmed/dashboard') ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-md shadow-purple-500/20' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-700/50' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Dashboard</span>
        </a>

        <!-- Form Penilaian Sosmed Link -->
        <a href="<?= base_url('sosmed/penilaian') ?>" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-medium transition-all duration-200 <?= (uri_string() == 'sosmed/penilaian') ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-md shadow-purple-500/20' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-700/50' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            <span>Input Nilai Sosmed</span>
        </a>

        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-3 pt-4 mb-2">Halaman Publik</div>

        <!-- Lihat Live Score -->
        <a href="<?= base_url('/') ?>" target="_blank" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-medium text-slate-400 hover:text-slate-200 hover:bg-slate-700/50 transition-all duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
            <span>Lihat Live Score</span>
        </a>
    </nav>

    <div class="p-4 border-t border-slate-700/50 text-[11px] text-slate-400 text-center">
        Bobot Nilai Sosmed: <span class="font-bold text-pink-400">40%</span>
    </div>
</aside>