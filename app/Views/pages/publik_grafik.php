<!DOCTYPE html>
<html lang="id" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Grafik Perolehan Nilai Live - Magello Dangdut Festival 2026') ?></title>

    <!-- Meta Tag untuk Preview saat link dibagikan (WhatsApp, FB, Twitter, dll) -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta property="og:title" content="Grafik Live Scoring - Magello Dangdut Festival 2026">
    <meta property="og:description" content="Pantau klasemen dan perolehan nilai peserta secara realtime di Magello Dangdut Festival Wonomulyo 2026. Total hadiah Rp 30.000.000,-.">
    <!-- URL gambar logo/banner yang muncul saat link dishare -->
    <meta property="og:image" content="<?= base_url('assets/img/logo.png') ?>">
    <meta property="og:image:secure_url" content="<?= base_url('assets/img/logo.png') ?>">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="600">
    <meta property="og:image:height" content="600">

    <!-- Meta Tag khusus Twitter/X -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Grafik Live Scoring - Magello Dangdut Festival 2026">
    <meta name="twitter:description" content="Pantau klasemen dan perolehan nilai peserta secara realtime di Magello Dangdut Festival Wonomulyo 2026.">
    <meta name="twitter:image" content="<?= base_url('assets/img/logo.png') ?>">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-[#13031a] text-fuchsia-100 min-h-screen flex flex-col font-sans selection:bg-fuchsia-600 selection:text-white">

    <!-- Header / Navbar Publik -->
    <header class="bg-[#1e0729]/80 backdrop-blur-md border-b border-fuchsia-900/50 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-2">

            <!-- Logo & Title -->
            <div class="flex items-center gap-2 sm:gap-3">
                <div class="p-1 sm:p-1.5 bg-gradient-to-tr from-fuchsia-600 to-pink-500 rounded-xl shadow-lg shadow-fuchsia-600/30">
                    <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo Magello Dangdut Festival" class="w-7 h-7 sm:w-8 sm:h-8 object-contain">
                </div>
                <div>
                    <h1 class="font-bold text-sm sm:text-lg text-amber-300 tracking-wide uppercase leading-tight">Live Poin</h1>
                    <p class="text-[10px] sm:text-xs text-fuchsia-300/70">Magello Dangdut Festival Wonomulyo 2026</p>
                </div>
            </div>

            <!-- Filter Tanggal, Indikator Live, Tombol Registrasi & Login -->
            <div class="flex items-center gap-2 sm:gap-3">
                <input type="date" id="input_tanggal" value="<?= esc($tanggal_filter ?? date('Y-m-d')) ?>" onchange="fetchRealtimeData()" class="bg-[#13031a] border border-fuchsia-800/60 rounded-xl px-2 sm:px-3 py-1.5 text-xs text-fuchsia-200 focus:outline-none focus:border-fuchsia-500 font-mono w-28 sm:w-auto">

                <div class="hidden md:flex items-center gap-2 px-3 py-1.5 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 rounded-full text-xs font-medium">
                    <span class="w-2 h-2 bg-emerald-400 rounded-full animate-ping"></span>
                    <span>Live AJAX</span>
                </div>

                <!-- Tombol Registrasi -->
                <a href="<?= base_url('registrasi') ?>" class="flex items-center gap-1.5 px-3 py-1.5 bg-fuchsia-900/60 hover:bg-fuchsia-800/80 active:scale-95 text-fuchsia-200 hover:text-white border border-fuchsia-700/60 rounded-xl text-xs font-semibold transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    <span>Registrasi</span>
                </a>

                <!-- Tombol Login -->
                <a href="<?= base_url('auth') ?>" class="flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-pink-600 to-fuchsia-600 hover:from-pink-500 hover:to-fuchsia-500 active:scale-95 text-white rounded-xl text-xs font-semibold shadow-md shadow-pink-600/30 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    <span>Login</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8 space-y-6 sm:space-y-8">

        <!-- Top 3 Podium Highlights -->
        <div id="podium-container" class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-4">
            <!-- Render via JavaScript -->
        </div>

        <!-- Container Grafik Batang -->
        <div class="bg-[#1e0729]/80 border border-fuchsia-900/60 rounded-2xl p-4 sm:p-6 shadow-2xl shadow-fuchsia-950/50">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mb-4 sm:mb-6">
                <div>
                    <!-- Judul Dinamis berdasarkan Mode dari Admin -->
                    <h2 id="judul-grafik" class="text-base sm:text-lg font-bold text-amber-300">Grafik Perolehan Nilai</h2>
                    <p id="sub-judul-grafik" class="text-[11px] sm:text-xs text-fuchsia-300/70">Memuat data...</p>
                </div>
            </div>

            <!-- Canvas Chart.js -->
            <div class="relative w-full h-[320px] sm:h-[450px]">
                <canvas id="chartBatangPeserta"></canvas>
            </div>
        </div>

        <!-- Tabel List Seluruh Peserta -->
        <div class="bg-[#1e0729]/80 border border-fuchsia-900/60 rounded-2xl p-4 sm:p-6 shadow-2xl shadow-fuchsia-950/50 overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base sm:text-lg font-bold text-amber-300">Daftar Peringkat & Nilai Peserta</h3>
                    <p class="text-[11px] sm:text-xs text-fuchsia-300/70">Klasemen lengkap seluruh peserta Magello Dangdut Festival 2026</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm text-fuchsia-100">
                    <thead class="bg-[#13031a]/80 uppercase text-[10px] sm:text-xs text-fuchsia-300 border-b border-fuchsia-900/60">
                        <tr>
                            <th scope="col" class="py-3 px-3 text-center">Rank</th>
                            <th scope="col" class="py-3 px-3">Peserta</th>
                            <th scope="col" class="py-3 px-3">Alamat</th>
                            <th scope="col" class="py-3 px-3 text-right">Poin Akhir</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-peserta-body" class="divide-y divide-fuchsia-900/40 font-medium">
                        <!-- Render via JavaScript -->
                        <tr>
                            <td colspan="4" class="py-6 text-center text-fuchsia-400/60">Memuat data klasemen...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <footer class="border-t border-fuchsia-950 bg-[#0a010e] py-4 text-center text-xs text-fuchsia-400/60">
        &copy; <?= date('Y') ?> Magello Dangdut Festival Wonomulyo. Live Scoring System auto-updated.
    </footer>

    <!-- Script Chart & Real-Time AJAX -->
    <script>
        let chartPeserta = null;
        let currentMode = '';

        function initChart() {
            const ctx = document.getElementById('chartBatangPeserta').getContext('2d');

            chartPeserta = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Total Poin',
                        data: [],
                        backgroundColor: 'rgba(217, 70, 239, 0.85)', // Magenta / Pink Neon
                        borderColor: 'rgba(244, 114, 182, 1)',
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                        barPercentage: 0.6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 500
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1e0729',
                            titleColor: '#fef08a',
                            bodyColor: '#f472b6',
                            bodyFont: {
                                weight: 'bold',
                                size: 14
                            },
                            borderColor: '#86198f',
                            borderWidth: 1,
                            padding: 12,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return ' Nilai: ' + context.parsed.y + ' Poin';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#f0abfc',
                                font: {
                                    size: window.innerWidth < 640 ? 9 : 11,
                                    weight: '600'
                                },
                                maxRotation: 45,
                                minRotation: 0
                            }
                        },
                        y: {
                            beginAtZero: true,
                            max: 100,
                            grid: {
                                color: 'rgba(134, 25, 143, 0.25)'
                            },
                            ticks: {
                                color: '#f0abfc',
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });
        }

        function formatNumber(num) {
            return (Math.round(num * 100) / 100).toFixed(2);
        }

        function renderPodium(peringkat) {
            const podiumEl = document.getElementById('podium-container');
            if (!peringkat || peringkat.length === 0) {
                podiumEl.innerHTML = `
                    <div class="col-span-1 md:col-span-3 text-center py-6 text-fuchsia-300/60 bg-[#1e0729]/40 rounded-2xl border border-fuchsia-900/50 text-xs sm:text-sm">
                        Belum ada data nilai peserta pada tanggal ini.
                    </div>`;
                return;
            }

            let html = '';

            if (peringkat[0]) {
                html += `
                <div class="bg-gradient-to-b from-amber-500/20 via-[#1e0729] to-[#13031a] border-2 border-amber-400/80 rounded-2xl p-4 sm:p-6 flex items-center gap-4 order-1 md:order-2 shadow-xl shadow-amber-500/10 relative overflow-hidden">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-tr from-amber-500 to-yellow-300 text-slate-950 font-black rounded-2xl flex-shrink-0 flex items-center justify-center text-xl sm:text-2xl shadow-md border border-amber-200">1</div>
                    <div class="overflow-hidden">
                        <span class="px-2 py-0.5 bg-amber-400/20 text-amber-300 text-[9px] sm:text-[10px] font-bold uppercase rounded-full tracking-wider border border-amber-400/30">Pemimpin Klasemen</span>
                        <h3 class="font-bold text-white text-base sm:text-lg truncate mt-0.5">${peringkat[0].nama_peserta}</h3>
                        <p class="text-xs text-fuchsia-300 truncate">${peringkat[0].alamat || '-'}</p>
                        <p class="text-sm sm:text-base font-mono font-bold text-amber-300 mt-0.5 sm:mt-1">${formatNumber(peringkat[0].total_nilai)} Poin</p>
                    </div>
                </div>`;
            }

            if (peringkat[1]) {
                html += `
                <div class="bg-[#1e0729]/70 border border-fuchsia-800/60 rounded-2xl p-4 sm:p-5 flex items-center gap-4 order-2 md:order-1 shadow-lg relative overflow-hidden">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-fuchsia-500/20 text-fuchsia-300 font-bold rounded-2xl flex-shrink-0 flex items-center justify-center text-lg sm:text-xl border border-fuchsia-400/30">2</div>
                    <div class="overflow-hidden">
                        <p class="text-[10px] sm:text-xs text-fuchsia-300/70">Peringkat 2</p>
                        <h3 class="font-bold text-white text-sm sm:text-base truncate">${peringkat[1].nama_peserta}</h3>
                        <p class="text-xs text-fuchsia-300 truncate">${peringkat[1].alamat || '-'}</p>
                        <p class="text-xs sm:text-sm font-mono font-bold text-amber-300 mt-0.5 sm:mt-1">${formatNumber(peringkat[1].total_nilai)} Poin</p>
                    </div>
                </div>`;
            }

            if (peringkat[2]) {
                html += `
                <div class="bg-[#1e0729]/70 border border-fuchsia-800/60 rounded-2xl p-4 sm:p-5 flex items-center gap-4 order-3 shadow-lg relative overflow-hidden">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-pink-700/30 text-pink-300 font-bold rounded-2xl flex-shrink-0 flex items-center justify-center text-lg sm:text-xl border border-pink-500/30">3</div>
                    <div class="overflow-hidden">
                        <p class="text-[10px] sm:text-xs text-fuchsia-300/70">Peringkat 3</p>
                        <h3 class="font-bold text-white text-sm sm:text-base truncate">${peringkat[2].nama_peserta}</h3>
                        <p class="text-xs text-fuchsia-300 truncate">${peringkat[2].alamat || '-'}</p>
                        <p class="text-xs sm:text-sm font-mono font-bold text-amber-300 mt-0.5 sm:mt-1">${formatNumber(peringkat[2].total_nilai)} Poin</p>
                    </div>
                </div>`;
            }

            podiumEl.innerHTML = html;
        }

        function renderTable(peringkat) {
            const tableBody = document.getElementById('tabel-peserta-body');
            if (!peringkat || peringkat.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="4" class="py-6 text-center text-fuchsia-300/50">Tidak ada data peserta ditemukan.</td>
                    </tr>`;
                return;
            }

            let rowsHtml = '';
            peringkat.forEach((item, index) => {
                const rank = index + 1;
                let badgeRankClass = 'bg-fuchsia-950/60 text-fuchsia-300 border border-fuchsia-800/40';

                if (rank === 1) badgeRankClass = 'bg-amber-400/20 text-amber-300 border border-amber-400/60 font-bold';
                else if (rank === 2) badgeRankClass = 'bg-fuchsia-500/20 text-fuchsia-200 border border-fuchsia-400/50 font-bold';
                else if (rank === 3) badgeRankClass = 'bg-pink-600/20 text-pink-300 border border-pink-500/50 font-bold';

                const fotoUrl = item.foto && item.foto !== 'default.jpg' ?
                    `<?= base_url('uploads/peserta/') ?>/${item.foto}` :
                    `https://ui-avatars.com/api/?name=${encodeURIComponent(item.nama_peserta)}&background=3b0764&color=f472b6`;

                rowsHtml += `
                    <tr class="hover:bg-fuchsia-900/20 transition-colors">
                        <td class="py-3 px-3 text-center">
                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs ${badgeRankClass}">${rank}</span>
                        </td>
                        <td class="py-3 px-3">
                            <div class="flex items-center gap-3">
                                <img src="${fotoUrl}" alt="${item.nama_peserta}" class="w-9 h-9 rounded-xl object-cover border border-fuchsia-800/60 flex-shrink-0">
                                <div>
                                    <div class="font-bold text-white leading-tight">[${String(item.nomor_urut).padStart(2, '0')}] ${item.nama_peserta}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-3 text-fuchsia-200/60">${item.alamat || '-'}</td>
                        <td class="py-3 px-3 text-right font-mono font-bold text-amber-300 text-sm sm:text-base">
                            ${formatNumber(item.total_nilai)}
                        </td>
                    </tr>`;
            });

            tableBody.innerHTML = rowsHtml;
        }

        // Fetch Data via AJAX (Fetch API)
        function fetchRealtimeData() {
            const tanggal = document.getElementById('input_tanggal').value;
            const url = `<?= base_url('home/getData') ?>?tanggal=${tanggal}`;

            fetch(url)
                .then(response => response.json())
                .then(res => {
                    if (res.status === 'success') {
                        const peringkat = res.peringkat;
                        const mode = res.mode_grafik;

                        // Ubah Judul & Warna Grafik Berdasarkan Mode Pilihan Admin
                        if (currentMode !== mode) {
                            currentMode = mode;
                            const judulEl = document.getElementById('judul-grafik');
                            const subJudulEl = document.getElementById('sub-judul-grafik');

                            if (mode === 'sosmed') {
                                judulEl.innerText = 'Grafik Special Vote Sosmed';
                                subJudulEl.innerText = 'Hasil perolehan poin murni dari vote Sosial Media';
                                chartPeserta.data.datasets[0].backgroundColor = 'rgba(236, 72, 153, 0.85)'; // Hot Pink Neon
                                chartPeserta.data.datasets[0].borderColor = 'rgba(244, 114, 182, 1)';
                            } else {
                                judulEl.innerText = 'Grafik Akumulasi Perolehan Nilai';
                                subJudulEl.innerText = 'Nilai terbobot: Juri Tetap (50%), Juri Sementara (40%), Sosmed (10%)';
                                chartPeserta.data.datasets[0].backgroundColor = 'rgba(217, 70, 239, 0.85)'; // Magenta / Magenta Neon
                                chartPeserta.data.datasets[0].borderColor = 'rgba(244, 114, 182, 1)';
                            }
                        }

                        // 1. Update Podium Top 3
                        renderPodium(peringkat);

                        // 2. Update Dataset Chart.js
                        const labels = peringkat.map(p => `[${String(p.nomor_urut).padStart(2, '0')}] ${p.nama_peserta}`);
                        const scores = peringkat.map(p => parseFloat(p.total_nilai));

                        chartPeserta.data.labels = labels;
                        chartPeserta.data.datasets[0].data = scores;
                        chartPeserta.update();

                        // 3. Update Tabel List Peserta
                        renderTable(peringkat);
                    }
                })
                .catch(err => console.error('Error fetching data:', err));
        }

        document.addEventListener('DOMContentLoaded', () => {
            initChart();
            fetchRealtimeData();
            setInterval(fetchRealtimeData, 3000);
        });
    </script>
</body>

</html>