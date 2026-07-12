<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.05)',
                        'hover': '0 10px 40px -5px rgba(0, 0, 0, 0.08)',
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .gradient-text {
            background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .card-stats {
            transition: all 0.3s ease;
        }
        .card-stats:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 40px -5px rgba(0, 0, 0, 0.08);
        }
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .stat-card-icon {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(37, 99, 235, 0.05) 100%);
        }
    </style>
</head>
<body class="text-slate-800">
    
    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-50 bg-white shadow-sm border-b border-slate-100" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-primary-50 rounded-lg flex items-center justify-center border border-primary-100">
                        <i class="fas fa-user text-xl text-primary-600"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-primary-700 tracking-tight">Si-Talenta</h1>
                    </div>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-slate-500 hover:text-primary-600 transition-colors font-medium text-sm">Beranda</a>
                    <a href="#statistik" class="text-slate-500 hover:text-primary-600 transition-colors font-medium text-sm">Statistik</a>
                    <a href="#kontak" class="text-slate-500 hover:text-primary-600 transition-colors font-medium text-sm">Hubungi Kami</a>
                    <a href="<?= base_url('login') ?>" class="px-5 py-2.5 bg-primary-600 text-white rounded-lg font-medium text-sm hover:bg-primary-700 hover:shadow-md transition-all duration-300">
                        <i class="fas fa-user mr-2"></i>Login
                    </a>
                </div>

                <button @click="open = !open" class="md:hidden text-slate-600 p-2">
                    <i class="fas fa-bars text-2xl" x-show="!open"></i>
                    <i class="fas fa-times text-2xl" x-show="open"></i>
                </button>
            </div>

            <div x-show="open" x-transition class="md:hidden pb-4 flex flex-col space-y-3 bg-white border-t border-slate-100 mt-2 p-4 rounded-b-xl shadow-lg">
                <a href="#home" class="text-slate-600 hover:text-primary-600 py-2 font-medium">Beranda</a>
                <a href="#statistik" class="text-slate-600 hover:text-primary-600 py-2 font-medium">Statistik</a>
                <a href="#kontak" class="text-slate-600 hover:text-primary-600 py-2 font-medium">Hubungi Kami</a>
                <a href="<?= base_url('login') ?>" class="px-6 py-2.5 bg-primary-600 text-white rounded-lg font-medium text-center">
                    <i class="fas fa-user mr-2"></i>Login
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="relative min-h-screen flex items-center pt-20 bg-slate-50">
        <!-- Soft background pattern/gradient -->
        <div class="absolute inset-0 z-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-blue-100/50 via-slate-50 to-slate-50"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10 w-full">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-block px-4 py-2 bg-white border border-slate-200 shadow-sm rounded-full mb-6">
                        <span class="text-primary-600 text-sm font-semibold flex items-center">
                            <i class="fas fa-chart-pie mr-2"></i> Dashboard Eksekutif
                        </span>
                    </div>
                    
                    <h1 class="text-4xl lg:text-5xl font-extrabold mb-6 leading-tight text-slate-900 tracking-tight">
                        Sistem Informasi
                        <span class="text-primary-600 block mt-1">Manajemen Talenta</span>
                    </h1>
                    
                    <p class="text-lg text-slate-500 mb-8 leading-relaxed">
                        Platform digital terintegrasi untuk pengelolaan data tenaga kerja Dinas Lingkungan Hidup secara profesional, akurat, dan transparan.
                    </p>
                    
                    <div class="grid grid-cols-3 gap-4 mb-8">
                        <div class="text-center p-4 bg-white rounded-xl shadow-sm border border-slate-100">
                            <div class="text-2xl font-bold text-slate-800"><?= number_format($statistik['aktif']) ?>+</div>
                            <div class="text-xs text-slate-500 mt-1 font-medium">Aktif</div>
                        </div>
                        <div class="text-center p-4 bg-white rounded-xl shadow-sm border border-slate-100">
                            <div class="text-2xl font-bold text-slate-800"><?= number_format($statistik['total']) ?>+</div>
                            <div class="text-xs text-slate-500 mt-1 font-medium">Total</div>
                        </div>
                        <div class="text-center p-4 bg-white rounded-xl shadow-sm border border-slate-100">
                            <div class="text-2xl font-bold text-slate-800">24/7</div>
                            <div class="text-xs text-slate-500 mt-1 font-medium">Online</div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#statistik" class="px-6 py-3.5 bg-primary-600 text-white rounded-lg font-medium hover:bg-primary-700 hover:shadow-lg transition-all text-center flex items-center justify-center">
                            <span>Lihat Statistik</span>
                            <i class="fas fa-arrow-down ml-2"></i>
                        </a>
                    </div>
                </div>

                <div class="relative hidden lg:block">
                    <!-- Dashboard Preview Mockup -->
                    <div class="relative bg-white rounded-2xl p-2 shadow-2xl border border-slate-200 transform rotate-1 hover:rotate-0 transition-transform duration-500">
                        <div class="bg-slate-50 rounded-xl overflow-hidden border border-slate-100">
                            <!-- Mockup Header -->
                            <div class="h-12 border-b border-slate-200 bg-white flex items-center px-4 justify-between">
                                <div class="flex space-x-2">
                                    <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                    <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                    <div class="w-3 h-3 rounded-full bg-green-400"></div>
                                </div>
                                <div class="text-xs text-slate-400 font-medium">portal.dlh.go.id/si-talenta</div>
                                <div></div>
                            </div>
                            <!-- Mockup Body -->
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="font-bold text-slate-800 flex items-center"><i class="fas fa-tachometer-alt mr-2 text-primary-500"></i> Dashboard Overview</h3>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-100 border-l-4 border-l-primary-500">
                                        <div class="text-xs text-slate-500 mb-1">Total Pegawai</div>
                                        <div class="text-xl font-bold text-slate-800"><?= number_format($statistik['total']) ?></div>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-100 border-l-4 border-l-teal-500">
                                        <div class="text-xs text-slate-500 mb-1">Pegawai Aktif</div>
                                        <div class="text-xl font-bold text-slate-800"><?= number_format($statistik['aktif']) ?></div>
                                    </div>
                                </div>
                                <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-100 h-32 flex items-end space-x-2">
                                    <!-- Bar chart mockups -->
                                    <div class="w-full bg-primary-100 rounded-t flex flex-col justify-end"><div class="w-full bg-primary-500 rounded-t" style="height: 60%"></div></div>
                                    <div class="w-full bg-primary-100 rounded-t flex flex-col justify-end"><div class="w-full bg-teal-400 rounded-t" style="height: 80%"></div></div>
                                    <div class="w-full bg-primary-100 rounded-t flex flex-col justify-end"><div class="w-full bg-primary-400 rounded-t" style="height: 45%"></div></div>
                                    <div class="w-full bg-primary-100 rounded-t flex flex-col justify-end"><div class="w-full bg-teal-500 rounded-t" style="height: 90%"></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistik Section -->
    <section id="statistik" class="relative py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800 flex items-center">
                        <i class="fas fa-users mr-3 text-primary-600"></i> Statistik Demografi
                    </h2>
                    <p class="text-slate-500 text-sm mt-1">Ringkasan data real-time manajemen talenta</p>
                </div>
                <div class="mt-4 md:mt-0 px-4 py-1.5 bg-green-100 text-green-700 text-xs font-semibold rounded-full border border-green-200 inline-block w-max">
                    Terakhir Update: <?= date('d M Y') ?>
                </div>
            </div>

            <!-- Cards Model Dashboard -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <!-- Aktif -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 border-l-4 border-l-blue-600 p-5 flex flex-col justify-between card-stats">
                    <div>
                        <div class="text-slate-800 font-semibold mb-1 text-base">Pekerja Aktif</div>
                        <div class="text-3xl font-bold text-slate-800 mb-1"><?= number_format($statistik['aktif']) ?> <span class="text-sm font-normal text-slate-500">Orang</span></div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <a href="#" class="text-xs font-medium text-blue-600 hover:text-blue-800 flex items-center justify-center border border-slate-200 rounded-lg py-1.5 transition-colors">Lihat Detail</a>
                    </div>
                </div>

                <!-- Pensiun -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 border-l-4 border-l-teal-500 p-5 flex flex-col justify-between card-stats">
                    <div>
                        <div class="text-slate-800 font-semibold mb-1 text-base">Pekerja Pensiun</div>
                        <div class="text-3xl font-bold text-slate-800 mb-1"><?= number_format($statistik['pensiun']) ?> <span class="text-sm font-normal text-slate-500">Orang</span></div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <a href="#" class="text-xs font-medium text-teal-600 hover:text-teal-800 flex items-center justify-center border border-slate-200 rounded-lg py-1.5 transition-colors">Lihat Detail</a>
                    </div>
                </div>

                <!-- Tidak Aktif -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 border-l-4 border-l-yellow-500 p-5 flex flex-col justify-between card-stats">
                    <div>
                        <div class="text-slate-800 font-semibold mb-1 text-base">Tidak Aktif</div>
                        <div class="text-3xl font-bold text-slate-800 mb-1"><?= number_format($statistik['tidak_aktif']) ?> <span class="text-sm font-normal text-slate-500">Orang</span></div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <a href="#" class="text-xs font-medium text-yellow-600 hover:text-yellow-800 flex items-center justify-center border border-slate-200 rounded-lg py-1.5 transition-colors">Lihat Detail</a>
                    </div>
                </div>

                <!-- Total -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 border-l-4 border-l-sky-500 p-5 flex flex-col justify-between card-stats">
                    <div>
                        <div class="text-slate-800 font-semibold mb-1 text-base">Total Pekerja</div>
                        <div class="text-3xl font-bold text-slate-800 mb-1"><?= number_format($statistik['total']) ?> <span class="text-sm font-normal text-slate-500">Orang</span></div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <a href="#" class="text-xs font-medium text-sky-600 hover:text-sky-800 flex items-center justify-center border border-slate-200 rounded-lg py-1.5 transition-colors">Lihat Detail</a>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Statistik -->
            <div class="bg-gradient-to-r from-blue-50 to-teal-50 rounded-xl p-6 mb-10 border border-blue-100">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 rounded-lg bg-white shadow-sm flex items-center justify-center mr-3 shrink-0">
                        <i class="fas fa-info-circle text-blue-600"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Ringkasan Data</h3>
                </div>
                <p class="text-slate-600 leading-relaxed text-sm md:text-base">
                    <?= generateRingkasanStatistik($statistik) ?>
                </p>
            </div>

            <!-- Visualisasi Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Card Chart Umur -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 hover:shadow-md transition-shadow">
                    <h3 class="text-base font-bold text-slate-800 mb-6 flex items-center pb-3 border-b border-slate-100">
                        <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                        Distribusi Rentang Umur
                    </h3>
                    <div class="relative w-full h-64 md:h-[300px]">
                        <canvas id="chartUmur"></canvas>
                    </div>
                </div>

                <!-- Card Chart Jenis Kelamin -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 hover:shadow-md transition-shadow">
                    <h3 class="text-base font-bold text-slate-800 mb-6 flex items-center pb-3 border-b border-slate-100">
                        <i class="fas fa-venus-mars text-purple-500 mr-2"></i>
                        Distribusi Jenis Kelamin
                    </h3>
                    <div class="relative w-full h-64 md:h-[300px]">
                        <canvas id="chartJenisKelamin"></canvas>
                    </div>
                </div>

                <!-- Card Chart Pendidikan -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 hover:shadow-md transition-shadow">
                    <h3 class="text-base font-bold text-slate-800 mb-6 flex items-center pb-3 border-b border-slate-100">
                        <i class="fas fa-graduation-cap text-teal-500 mr-2"></i>
                        Distribusi Pendidikan
                    </h3>
                    <div class="relative w-full h-64 md:h-[300px]">
                        <canvas id="chartPendidikan"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="bg-white border-t border-slate-200 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-8 h-8 bg-primary-50 border border-primary-100 rounded flex items-center justify-center">
                            <i class="fas fa-user text-primary-600 text-sm"></i>
                        </div>
                        <span class="text-lg font-bold text-primary-700">SI-TALENTA</span>
                    </div>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        Sistem Informasi Manajemen Talenta Dinas Lingkungan Hidup. Platform digital cerdas untuk pengelolaan data tenaga kerja.
                    </p>
                </div>

                <div>
                    <h4 class="font-semibold text-slate-800 mb-4 text-sm uppercase tracking-wider">Tautan Pintas</h4>
                    <div class="space-y-2">
                        <a href="#home" class="block text-sm text-slate-500 hover:text-primary-600 transition-colors">Beranda Utama</a>
                        <a href="#statistik" class="block text-sm text-slate-500 hover:text-primary-600 transition-colors">Pusat Statistik</a>
                        <a href="#kontak" class="block text-sm text-slate-500 hover:text-primary-600 transition-colors">Hubungi Kami</a>
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold text-slate-800 mb-4 text-sm uppercase tracking-wider">Hubungi Kami</h4>
                    <div class="space-y-3 text-slate-500 text-sm">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-map-marker-alt text-primary-500 mt-1 w-4 text-center shrink-0"></i>
                            <span>Kantor Dinas Lingkungan Hidup<br>Kota/Kabupaten</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-envelope text-primary-500 w-4 text-center shrink-0"></i>
                            <span>info@dlh.go.id</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-phone text-primary-500 w-4 text-center shrink-0"></i>
                            <span>(021) 1234-5678</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-200 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <p class="text-slate-400 text-sm text-center md:text-left">&copy; <?= date('Y') ?> Dinas Lingkungan Hidup. All rights reserved.</p>
                <div class="flex space-x-4">
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-400 hover:text-primary-600 hover:border-primary-200 transition-all">
                        <i class="fab fa-facebook-f text-sm"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-400 hover:text-primary-600 hover:border-primary-200 transition-all">
                        <i class="fab fa-twitter text-sm"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-400 hover:text-primary-600 hover:border-primary-200 transition-all">
                        <i class="fab fa-instagram text-sm"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Set default font for Chart.js to Inter
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = '#64748b'; // Tailwind slate-500

        // Data dari helper
        const dataUmur = <?= json_encode(formatStatistikChart($statistikUmur, 'rentang_umur', 'jumlah')) ?>;
        const dataJenisKelamin = <?= json_encode(formatStatistikChart($statistikJenisKelamin, 'jenis_kelamin', 'jumlah')) ?>;
        const dataPendidikan = <?= json_encode(formatStatistikChart($statistikPendidikan, 'tingkat_pendidikan', 'jumlah')) ?>;
        
        // Chart Umur (Doughnut)
        new Chart(document.getElementById('chartUmur'), {
            type: 'doughnut',
            data: {
                labels: dataUmur.labels,
                datasets: [{
                    data: dataUmur.values,
                    backgroundColor: [
                        '#3b82f6', // blue-500
                        '#0ea5e9', // sky-500
                        '#14b8a6', // teal-500
                        '#f59e0b', // amber-500
                        '#f43f5e'  // rose-500
                    ],
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverOffset: 8,
                    hoverBorderWidth: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: {
                                size: 11,
                                weight: '500'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: {
                            size: 13,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 12
                        },
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return ' ' + context.parsed + ' Orang (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Chart Jenis Kelamin (Pie)
        new Chart(document.getElementById('chartJenisKelamin'), {
            type: 'pie',
            data: {
                labels: dataJenisKelamin.labels,
                datasets: [{
                    data: dataJenisKelamin.values,
                    backgroundColor: [
                        '#3b82f6', // blue-500 untuk Laki-laki
                        '#ec4899'  // pink-500 untuk Perempuan
                    ],
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverOffset: 8,
                    hoverBorderWidth: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: {
                            size: 13,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 12
                        },
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return ' ' + context.parsed + ' Orang (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
        
        // Chart Pendidikan (Bar)
        new Chart(document.getElementById('chartPendidikan'), {
            type: 'bar',
            data: {
                labels: dataPendidikan.labels,
                datasets: [{
                    label: 'Jumlah Pegawai',
                    data: dataPendidikan.values,
                    backgroundColor: '#14b8a6', // teal-500
                    borderRadius: 6,
                    barThickness: 28,
                    hoverBackgroundColor: '#0d9488' // teal-600
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8,
                            font: {
                                size: 11,
                                weight: '500'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: {
                            size: 13,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 12
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                        },
                        ticks: {
                            font: { 
                                size: 11,
                                weight: '500'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9',
                            drawBorder: false,
                        },
                        ticks: {
                            stepSize: 2,
                            font: { 
                                size: 11 
                            }
                        }
                    }
                }
            }
        });

        // Smooth scroll implementation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>