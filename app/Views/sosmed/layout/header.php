<!DOCTYPE html>
<html lang="id" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Dashboard Sosmed') ?></title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: {
                            bg: '#0f172a',
                            card: '#1e293b',
                            border: '#334155'
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-slate-900 text-slate-100 min-h-screen flex flex-col font-sans selection:bg-purple-500 selection:text-white">

    <!-- Top Navbar -->
    <header class="bg-slate-800/80 backdrop-blur-md border-b border-slate-700/60 sticky top-0 z-40">
        <div class="px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">

            <!-- Mobile Menu Toggle Button & Brand -->
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-700 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="flex items-center gap-2">
                    <div class="p-2 bg-gradient-to-tr from-pink-500 to-purple-600 rounded-xl shadow-lg shadow-pink-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="font-bold text-base sm:text-lg text-white tracking-wide">Panel Sosmed</span>
                </div>
            </div>

            <!-- Profile Info & Logout -->
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-semibold text-white"><?= esc(session()->get('nama_lengkap') ?? 'Petugas Sosmed') ?></p>
                    <p class="text-[10px] text-pink-400 font-mono uppercase">Role: Sosmed (10%)</p>
                </div>

                <a href="<?= base_url('auth/logout') ?>" class="p-2 bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 rounded-xl text-xs font-semibold flex items-center gap-1.5 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    <span class="hidden sm:inline">Keluar</span>
                </a>
            </div>

        </div>
    </header>

    <div class="flex flex-1 relative">