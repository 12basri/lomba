<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="p-6 md:p-8 space-y-6">
    <!-- Header & Filter Tanggal -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Grafik & Analisis Perolehan Nilai</h1>
            <p class="text-slate-400 text-sm">Visualisasi perbandingan nilai juri dan vote sosmed secara real-time.</p>
        </div>

        <!-- Filter Tanggal -->
        <form method="GET" action="<?= base_url('admin/grafik') ?>" class="flex items-center gap-2">
            <input type="date" name="tanggal" value="<?= $tanggal_filter ?>" class="bg-slate-800 border border-slate-700 text-white text-sm rounded-xl px-4 py-2 focus:ring-purple-500 focus:border-purple-500">
            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white text-sm px-4 py-2 rounded-xl font-medium transition shadow-lg shadow-purple-600/20">
                Filter
            </button>
        </form>
    </div>

    <!-- Container Chart & Tombol Navigasi -->
    <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 shadow-xl">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6 border-b border-slate-700/60 pb-4">
            <!-- Tombol Switcher Grafik (Pengontrol Tampilan Admin & Publik) -->
            <div class="flex items-center bg-slate-900/80 p-1 rounded-xl border border-slate-700/80 self-start lg:self-auto">
                <button id="btnAkumulasi" type="button" onclick="switchChart('akumulasi')" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition text-slate-400 hover:text-white cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Grafik Akumulasi (Juri & Sosmed)
                </button>
                <button id="btnSosmed" type="button" onclick="switchChart('sosmed')" class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition text-slate-400 hover:text-white cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    Grafik Special Vote Sosmed
                </button>
            </div>

            <!-- Indicator Tanggal -->
            <span class="text-xs bg-purple-500/10 text-purple-400 border border-purple-500/20 px-3 py-1.5 rounded-full font-medium self-start lg:self-auto">
                Tanggal: <?= date('d M Y', strtotime($tanggal_filter)) ?>
            </span>
        </div>

        <!-- Canvas Chart -->
        <div class="relative w-full h-[450px]">
            <canvas id="nilaiChart"></canvas>
        </div>
    </div>
</div>

<!-- Script Rendering Chart.js & Sync AJAX dengan Halaman Publik -->
<script>
    let chartInstance = null;

    // Mode Grafik Aktif saat ini dari Database (Default ke 'akumulasi')
    let activeMode = '<?= $active_mode ?? 'akumulasi' ?>';

    // Data dari Controller
    const labels = <?= $chartLabels ?>;
    const dataJuriTetap = <?= $chartDataJuriTetap ?>;
    const dataJuriTamu = <?= $chartDataJuriTamu ?>;
    const dataSosmed = <?= $chartDataSosmed ?>;
    const dataTotal = <?= $chartDataTotal ?>;

    // Dataset Akumulasi (Juri Tetap + Juri Tamu + Sosmed + Nilai Akhir)
    const datasetAkumulasi = [{
            label: 'Juri Tetap (60%)',
            data: dataJuriTetap,
            backgroundColor: 'rgba(168, 85, 247, 0.75)', // Purple
            borderColor: 'rgba(168, 85, 247, 1)',
            borderWidth: 1,
            borderRadius: 6
        },
        {
            label: 'Juri Tamu (30%)',
            data: dataJuriTamu,
            backgroundColor: 'rgba(245, 158, 11, 0.75)', // Amber / Orange
            borderColor: 'rgba(245, 158, 11, 1)',
            borderWidth: 1,
            borderRadius: 6
        },
        {
            label: 'Sosmed (10%)',
            data: dataSosmed,
            backgroundColor: 'rgba(59, 130, 246, 0.75)', // Blue
            borderColor: 'rgba(59, 130, 246, 1)',
            borderWidth: 1,
            borderRadius: 6
        },
        {
            label: 'Nilai Akhir Terbobot',
            data: dataTotal,
            backgroundColor: 'rgba(34, 197, 94, 0.75)', // Green
            borderColor: 'rgba(34, 197, 94, 1)',
            borderWidth: 1,
            borderRadius: 6
        }
    ];

    // Dataset Khusus Vote Sosmed
    const datasetSosmed = [{
        label: 'Vote Sosmed',
        data: dataSosmed,
        backgroundColor: 'rgba(59, 130, 246, 0.85)', // Blue
        borderColor: 'rgba(59, 130, 246, 1)',
        borderWidth: 1,
        borderRadius: 6
    }];

    // Fungsi Render Chart
    function renderChart(datasets) {
        const ctx = document.getElementById('nilaiChart').getContext('2d');

        if (chartInstance) {
            chartInstance.destroy();
        }

        chartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)'
                        },
                        ticks: {
                            color: '#94a3b8'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)'
                        },
                        ticks: {
                            color: '#94a3b8'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#f8fafc',
                            font: {
                                family: 'sans-serif',
                                size: 12
                            }
                        }
                    }
                }
            }
        });
    }

    // Update Tampilan UI Tombol & Render Grafik
    function updateButtonUI(type) {
        const btnAkumulasi = document.getElementById('btnAkumulasi');
        const btnSosmed = document.getElementById('btnSosmed');

        if (type === 'akumulasi') {
            btnAkumulasi.className = "flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition bg-purple-600 text-white shadow-md cursor-pointer";
            btnSosmed.className = "flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition text-slate-400 hover:text-white cursor-pointer";
            renderChart(datasetAkumulasi);
        } else if (type === 'sosmed') {
            btnSosmed.className = "flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition bg-purple-600 text-white shadow-md cursor-pointer";
            btnAkumulasi.className = "flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition text-slate-400 hover:text-white cursor-pointer";
            renderChart(datasetSosmed);
        }
    }

    // Fungsi Switcher Tombol Tab & Kirim Update Mode ke Server via AJAX
    function switchChart(type) {
        // 1. Eksekusi perpindahan grafik secara lokal tanpa menunggu server response
        updateButtonUI(type);

        // 2. Kirim update status ke server secara asynchronous di background
        const formData = new FormData();
        formData.append('mode', type);

        fetch('<?= base_url('admin/grafik/set-mode') ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .catch(err => {
                console.warn('Gagal sinkronisasi ke server, tetapi grafik lokal berhasil diubah:', err);
            });
    }

    // Render Awal saat Halaman Selesai Load Sesuai Active Mode
    document.addEventListener("DOMContentLoaded", function() {
        updateButtonUI(activeMode);
    });
</script>
<?= $this->endSection() ?>