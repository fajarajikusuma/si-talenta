<!DOCTYPE html>
<html lang="id" class="scroll-smooth dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'SI-TALENTA | Dashboard' ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts: Space Grotesk for a Futuristic vibe -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = {
            darkMode: 'class', // Enable class-based dark mode
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Space Grotesk', 'sans-serif'],
                    },
                    colors: {
                        dark: '#080C16', // Slightly deep navy/black
                        darker: '#03050A',
                        primary: {
                            400: '#38bdf8', // Neon Sky Blue
                            500: '#0ea5e9',
                            600: '#0284c7',
                        },
                        accent: {
                            400: '#818cf8', // Neon Indigo
                            500: '#6366f1',
                        },
                        gold: '#fbbf24', // Luxury Gold Touch
                    },
                    animation: {
                        'blob': 'blob 10s infinite',
                        'float': 'float 6s ease-in-out infinite',
                        'float-delayed': 'float 6s ease-in-out 3s infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'scan': 'scan 3s linear infinite',
                    },
                    keyframes: {
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        scan: {
                            '0%': { transform: 'translateY(-100%)', opacity: 0 },
                            '50%': { opacity: 1 },
                            '100%': { transform: 'translateY(200%)', opacity: 0 },
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            transition: background-color 0.5s ease, color 0.5s ease;
            overflow-x: hidden;
        }
        
        /* Glassmorphism Utilities - Adaptive */
        .glass-nav {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            transition: background-color 0.5s ease, border-color 0.5s ease;
        }
        
        .glass-card {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            transition: all 0.4s ease;
        }
        
        .glass-card:hover {
            transform: translateY(-5px);
        }

        /* Gradient Texts */
        .text-gradient-primary {
            background: linear-gradient(135deg, #0ea5e9 0%, #6366f1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .dark .text-gradient-primary {
            background: linear-gradient(135deg, #38bdf8 0%, #818cf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .dark ::-webkit-scrollbar-track {
            background: #080C16;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .dark ::-webkit-scrollbar-thumb {
            background: #1e293b;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .dark ::-webkit-scrollbar-thumb:hover {
            background: #38bdf8;
        }
    </style>
</head>
<body class="antialiased selection:bg-primary-500 selection:text-white bg-slate-50 dark:bg-darker text-slate-800 dark:text-slate-200">

    <!-- Animated Background Blobs -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none transition-opacity duration-700 opacity-60 dark:opacity-100">
        <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-primary-400/30 dark:bg-primary-600/20 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-[100px] animate-blob"></div>
        <div class="absolute top-[20%] right-[-10%] w-96 h-96 bg-accent-400/30 dark:bg-accent-600/20 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-[100px] animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-[-20%] left-[20%] w-96 h-96 bg-teal-400/20 dark:bg-primary-400/10 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-[100px] animate-blob animation-delay-4000"></div>
    </div>
    
    <!-- Navbar (Glassmorphism) -->
    <nav class="fixed top-0 w-full z-50 glass-nav bg-white/70 dark:bg-white/5 border-b border-slate-200 dark:border-white/5" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center space-x-3 cursor-pointer" onclick="window.scrollTo(0,0)">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-primary-500 to-accent-500 flex items-center justify-center shadow-lg dark:shadow-[0_0_15px_rgba(56,189,248,0.5)]">
                        <i class="fas fa-fingerprint text-xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold tracking-widest text-slate-900 dark:text-white">SI<span class="text-primary-600 dark:text-primary-400">-TALENTA</span></h1>
                    </div>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors font-semibold text-sm tracking-wide">BERANDA</a>
                    <a href="#tentang" class="text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors font-semibold text-sm tracking-wide">TENTANG</a>
                    <a href="#statistik" class="text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors font-semibold text-sm tracking-wide">STATISTIK</a>
                    <a href="#kontak" class="text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors font-semibold text-sm tracking-wide">KONTAK</a>
                    
                    <!-- Theme Toggle -->
                    <button id="themeToggleBtn" class="text-slate-500 dark:text-slate-300 hover:text-primary-500 dark:hover:text-primary-400 transition-colors p-2 rounded-full bg-slate-200/50 dark:bg-white/5 border border-slate-300 dark:border-white/10">
                        <i class="fas fa-moon dark:hidden text-lg"></i>
                        <i class="fas fa-sun hidden dark:block text-lg"></i>
                    </button>

                    <a href="<?= base_url('login') ?>" class="px-6 py-2.5 rounded-full bg-white dark:bg-white/5 border border-slate-300 dark:border-white/10 text-slate-800 dark:text-white font-semibold text-sm shadow-md hover:bg-primary-50 dark:hover:bg-primary-500 hover:border-primary-400 dark:hover:shadow-[0_0_20px_rgba(56,189,248,0.4)] transition-all duration-300 group">
                        <i class="fas fa-lock mr-2 text-primary-500 dark:text-primary-400 group-hover:text-primary-600 dark:group-hover:text-white"></i>Login
                    </a>
                </div>

                <!-- Mobile Button -->
                <div class="md:hidden flex items-center space-x-4">
                    <button id="themeToggleBtnMobile" class="text-slate-500 dark:text-slate-300 p-2">
                        <i class="fas fa-moon dark:hidden text-xl"></i>
                        <i class="fas fa-sun hidden dark:block text-xl"></i>
                    </button>
                    <button @click="open = !open" class="text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white p-2">
                        <i class="fas fa-bars text-2xl" x-show="!open"></i>
                        <i class="fas fa-times text-2xl" x-show="open"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="open" x-transition class="md:hidden pb-4 flex flex-col space-y-3 glass-nav bg-white/90 dark:bg-dark/90 mt-2 p-4 rounded-b-xl border border-slate-200 dark:border-white/10 shadow-xl">
                <a href="#home" class="text-slate-700 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 py-2 font-medium">Beranda</a>
                <a href="#tentang" class="text-slate-700 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 py-2 font-medium">Tentang</a>
                <a href="#statistik" class="text-slate-700 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 py-2 font-medium">Statistik</a>
                <a href="#kontak" class="text-slate-700 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 py-2 font-medium">Kontak</a>
                <a href="<?= base_url('login') ?>" class="px-6 py-2.5 bg-primary-600 text-white rounded-lg font-medium text-center shadow-lg dark:shadow-[0_0_15px_rgba(56,189,248,0.3)]">
                    Login Sistem
                </a>
            </div>
        </div>
    </nav>

    <!-- 1. Hero Section -->
    <section id="home" class="relative min-h-screen flex items-center pt-20 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10 w-full">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                
                <!-- Left Text Content -->
                <div data-aos="fade-right" data-aos-duration="1000">
                    <div class="inline-block px-5 py-2 glass-nav bg-white/60 dark:bg-white/5 rounded-full mb-6 border border-primary-300 dark:border-primary-500/30 shadow-sm dark:shadow-[0_0_15px_rgba(56,189,248,0.2)]">
                        <span class="text-primary-700 dark:text-primary-400 text-sm font-bold flex items-center tracking-wider">
                            <i class="fas fa-bolt mr-2 text-amber-500 dark:text-gold animate-pulse"></i> DASHBOARD EKSEKUTIF v2.0
                        </span>
                    </div>
                    
                    <h1 class="text-5xl lg:text-6xl font-extrabold mb-6 leading-tight text-slate-900 dark:text-white tracking-tight">
                        Sistem Informasi <br>
                        <span class="text-gradient-primary">Manajemen Talenta</span>
                    </h1>
                    
                    <p class="text-lg text-slate-600 dark:text-slate-400 mb-8 leading-relaxed font-medium dark:font-light">
                        Platform digital masa depan yang terintegrasi untuk pengelolaan data tenaga kerja Dinas Lingkungan Hidup secara cerdas, akurat, dan transparan.
                    </p>
                    
                    <!-- REVISED: The 3 Hero Cards -->
                    <div class="grid grid-cols-3 gap-4 mb-10">
                        <!-- Card: Aktif -->
                        <div class="relative p-5 rounded-2xl glass-card bg-white/60 dark:bg-white/5 border border-slate-200 dark:border-white/10 hover:border-primary-400 dark:hover:border-primary-500/50 transition-all overflow-hidden group shadow-lg dark:shadow-none text-center">
                            <div class="absolute inset-0 bg-gradient-to-br from-primary-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div class="relative z-10">
                                <div class="text-4xl font-extrabold text-slate-900 dark:text-white mb-1 drop-shadow-md">
                                    <?= number_format($statistik['aktif'] ?? 60) ?>
                                </div>
                                <div class="text-xs text-primary-600 dark:text-primary-400 font-bold tracking-[0.2em] uppercase">Aktif</div>
                            </div>
                        </div>
                        
                        <!-- Card: Total -->
                        <div class="relative p-5 rounded-2xl glass-card bg-white/60 dark:bg-white/5 border border-slate-200 dark:border-white/10 hover:border-accent-400 dark:hover:border-accent-500/50 transition-all overflow-hidden group shadow-lg dark:shadow-none text-center">
                            <div class="absolute inset-0 bg-gradient-to-br from-accent-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div class="relative z-10">
                                <div class="text-4xl font-extrabold text-slate-900 dark:text-white mb-1 drop-shadow-md">
                                    <?= number_format($statistik['total'] ?? 67) ?>
                                </div>
                                <div class="text-xs text-accent-600 dark:text-accent-400 font-bold tracking-[0.2em] uppercase">Total</div>
                            </div>
                        </div>
                        
                        <!-- Card: Akurasi -->
                        <div class="relative p-5 rounded-2xl glass-card bg-white/60 dark:bg-white/5 border border-slate-200 dark:border-white/10 hover:border-amber-400 dark:hover:border-gold/50 transition-all overflow-hidden group shadow-lg dark:shadow-none text-center">
                            <div class="absolute inset-0 bg-gradient-to-br from-amber-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div class="relative z-10">
                                <div class="text-4xl font-extrabold text-slate-900 dark:text-white mb-1 drop-shadow-md">
                                    99<span class="text-xl">%</span>
                                </div>
                                <div class="text-xs text-amber-600 dark:text-gold font-bold tracking-[0.2em] uppercase">Akurasi</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#statistik" class="px-8 py-4 bg-slate-900 dark:bg-white text-white dark:text-darker rounded-full font-bold shadow-xl dark:shadow-none hover:scale-105 hover:shadow-2xl dark:hover:shadow-[0_0_25px_rgba(255,255,255,0.4)] transition-all duration-300 text-center flex items-center justify-center">
                            <span>Eksplorasi Data</span>
                            <i class="fas fa-arrow-right ml-3"></i>
                        </a>
                    </div>
                </div>

                <!-- Right: Futuristic Dashboard Mockup -->
                <div class="relative hidden lg:block animate-float" data-aos="fade-left" data-aos-duration="1200" data-aos-delay="200">
                    <div class="absolute inset-0 bg-gradient-to-tr from-primary-400/20 to-accent-400/20 dark:from-primary-500/20 dark:to-accent-500/20 rounded-3xl filter blur-2xl transform scale-105"></div>
                    <div class="relative glass-nav bg-white/50 dark:bg-[#0c1220]/80 rounded-3xl p-2 shadow-2xl border border-slate-300 dark:border-white/10">
                        <div class="bg-slate-50 dark:bg-[#111827] rounded-2xl overflow-hidden border border-slate-200 dark:border-white/5 relative">
                            <!-- Header -->
                            <div class="h-12 border-b border-slate-200 dark:border-white/5 bg-white/80 dark:bg-transparent flex items-center px-4 justify-between backdrop-blur-md">
                                <div class="flex space-x-2">
                                    <div class="w-3 h-3 rounded-full bg-red-400 dark:bg-red-500 dark:shadow-[0_0_5px_#ef4444]"></div>
                                    <div class="w-3 h-3 rounded-full bg-amber-400 dark:bg-yellow-500 dark:shadow-[0_0_5px_#eab308]"></div>
                                    <div class="w-3 h-3 rounded-full bg-green-400 dark:bg-green-500 dark:shadow-[0_0_5px_#22c55e]"></div>
                                </div>
                                <div class="text-xs text-slate-500 dark:text-slate-400 tracking-widest font-mono font-medium">portaldlh.web.id/si-talenta</div>
                                <div><i class="fas fa-wifi text-primary-500 dark:text-primary-400 text-xs"></i></div>
                            </div>
                            <!-- Body -->
                            <div class="p-6 relative overflow-hidden">
                                <!-- Glowing Background inside mockup -->
                                <div class="absolute top-0 right-0 w-32 h-32 bg-primary-400/20 dark:bg-primary-500/10 rounded-full filter blur-xl"></div>
                                
                                <div class="flex items-center justify-between mb-6 relative z-10">
                                    <h3 class="font-bold text-slate-800 dark:text-white flex items-center tracking-wide"><i class="fas fa-microchip mr-2 text-primary-500 dark:text-primary-400"></i> AI Analysis Overview</h3>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4 mb-4 relative z-10">
                                    <div class="glass-card bg-white/70 dark:bg-white/5 p-4 rounded-xl border border-slate-200 dark:border-white/5 shadow-sm">
                                        <div class="text-[10px] text-slate-500 dark:text-slate-400 mb-1 uppercase tracking-wider font-bold">Sync Status</div>
                                        <div class="text-base font-bold text-green-600 dark:text-green-400 flex items-center"><i class="fas fa-check-circle mr-2"></i> Real-time</div>
                                    </div>
                                    <div class="glass-card bg-white/70 dark:bg-white/5 p-4 rounded-xl border border-slate-200 dark:border-white/5 shadow-sm">
                                        <div class="text-[10px] text-slate-500 dark:text-slate-400 mb-1 uppercase tracking-wider font-bold">Security</div>
                                        <div class="text-base font-bold text-slate-800 dark:text-white flex items-center"><i class="fas fa-shield-alt text-amber-500 dark:text-gold mr-2"></i> Encrypted</div>
                                    </div>
                                </div>
                                
                                <!-- REVISED: Mini Live Chart inside the empty box -->
                                <div class="glass-card bg-white/70 dark:bg-white/5 p-4 rounded-xl h-40 border border-slate-200 dark:border-white/5 shadow-sm relative z-10 flex flex-col overflow-hidden group">
                                    <!-- Scanning animation line -->
                                    <div class="absolute left-0 right-0 h-1 bg-primary-400/50 dark:bg-primary-500/50 shadow-[0_0_10px_rgba(56,189,248,0.8)] z-0 animate-scan hidden dark:block"></div>
                                    
                                    <div class="flex justify-between items-center mb-2 z-10 relative">
                                        <span class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider">Live Activity</span>
                                        <span class="flex h-2.5 w-2.5 relative">
                                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                                          <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-primary-500"></span>
                                        </span>
                                    </div>
                                    <!-- Canvas for mini chart -->
                                    <div class="relative w-full flex-grow z-10">
                                        <canvas id="miniAiChart"></canvas>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Tentang Section -->
    <section id="tentang" class="relative py-24 bg-white dark:bg-dark border-t border-slate-200 dark:border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
                <h2 class="text-sm font-extrabold text-primary-600 dark:text-primary-400 tracking-[0.2em] uppercase mb-3">Tentang Sistem</h2>
                <h3 class="text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white mb-6">Masa Depan <span class="text-gradient-primary">Manajemen Data</span></h3>
                <p class="text-slate-600 dark:text-slate-400 leading-relaxed text-lg font-medium dark:font-light">
                    SI-TALENTA dirancang dengan teknologi mutakhir untuk memberikan pengalaman manajemen tenaga kerja yang cepat, aman, dan tanpa batas.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="glass-card bg-slate-50 dark:bg-slate-800/40 p-8 rounded-2xl text-center border border-slate-200 dark:border-white/10 shadow-lg dark:shadow-[0_8px_32px_rgba(0,0,0,0.3)] hover:border-primary-300 dark:hover:border-primary-500/50 group" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 mx-auto bg-primary-100 dark:bg-primary-500/10 rounded-2xl flex items-center justify-center mb-6 border border-primary-200 dark:border-primary-500/20 group-hover:scale-110 transition-transform duration-300 shadow-sm">
                        <i class="fas fa-database text-3xl text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Database Terpusat</h4>
                    <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
                        Seluruh informasi demografi dan profil talenta terenkripsi dan disimpan dalam satu basis data cloud berkecepatan tinggi.
                    </p>
                </div>
                
                <!-- Feature 2 -->
                <div class="glass-card bg-slate-50 dark:bg-slate-800/40 p-8 rounded-2xl text-center border border-slate-200 dark:border-white/10 shadow-lg dark:shadow-[0_8px_32px_rgba(0,0,0,0.3)] hover:border-accent-300 dark:hover:border-accent-500/50 group relative overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                    <div class="absolute inset-0 bg-gradient-to-b from-accent-100/50 dark:from-accent-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 mx-auto bg-accent-100 dark:bg-accent-500/10 rounded-2xl flex items-center justify-center mb-6 border border-accent-200 dark:border-accent-500/20 group-hover:scale-110 transition-transform duration-300 shadow-sm">
                            <i class="fas fa-microchip text-3xl text-accent-600 dark:text-accent-400"></i>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Pemrosesan Cerdas</h4>
                        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
                            Dilengkapi algoritma pintar yang mampu menyajikan analitik data dan ringkasan statistik secara real-time.
                        </p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="glass-card bg-slate-50 dark:bg-slate-800/40 p-8 rounded-2xl text-center border border-slate-200 dark:border-white/10 shadow-lg dark:shadow-[0_8px_32px_rgba(0,0,0,0.3)] hover:border-amber-300 dark:hover:border-gold/50 group" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-16 h-16 mx-auto bg-amber-100 dark:bg-gold/10 rounded-2xl flex items-center justify-center mb-6 border border-amber-200 dark:border-gold/20 group-hover:scale-110 transition-transform duration-300 shadow-sm">
                        <i class="fas fa-shield-halved text-3xl text-amber-600 dark:text-gold"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Keamanan Berlapis</h4>
                    <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
                        Akses berbasis peran dan enkripsi end-to-end menjamin kerahasiaan setiap entitas data pekerja instansi.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Statistik Section -->
    <section id="statistik" class="relative py-24 bg-slate-50 dark:bg-[#060913] border-t border-slate-200 dark:border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12" data-aos="fade-right">
                <div>
                    <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white flex items-center tracking-tight">
                        <i class="fas fa-chart-pie mr-4 text-primary-600 dark:text-primary-400"></i> Pusat Statistik
                    </h2>
                    <p class="text-slate-600 dark:text-slate-400 mt-2 text-lg font-medium dark:font-light">Visualisasi data demografi real-time instansi</p>
                </div>
                <div class="mt-4 md:mt-0 px-5 py-2 glass-nav bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-500/30 text-green-700 dark:text-green-400 text-sm font-bold dark:font-medium rounded-full inline-flex items-center w-max shadow-sm dark:shadow-[0_0_15px_rgba(34,197,94,0.15)]">
                    <i class="fas fa-circle text-[8px] animate-pulse mr-2 text-green-500"></i> Live Update: <?= date('d M Y') ?>
                </div>
            </div>

            <!-- Cards Model Dashboard -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Aktif -->
                <div class="glass-card bg-white dark:bg-slate-800/40 border border-slate-200 dark:border-white/10 border-t-4 border-t-primary-500 p-6 flex flex-col justify-between rounded-xl shadow-md dark:shadow-none group" data-aos="zoom-in" data-aos-delay="100">
                    <div>
                        <div class="text-slate-600 dark:text-slate-400 font-bold dark:font-medium mb-2 text-sm uppercase tracking-wider flex items-center justify-between">
                            Pekerja Aktif
                            <i class="fas fa-user-check text-primary-500/50 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors"></i>
                        </div>
                        <div class="text-4xl font-extrabold text-slate-900 dark:text-white mb-1"><?= number_format($statistik['aktif'] ?? 1250) ?></div>
                    </div>
                </div>

                <!-- Pensiun -->
                <div class="glass-card bg-white dark:bg-slate-800/40 border border-slate-200 dark:border-white/10 border-t-4 border-t-accent-500 p-6 flex flex-col justify-between rounded-xl shadow-md dark:shadow-none group" data-aos="zoom-in" data-aos-delay="200">
                    <div>
                        <div class="text-slate-600 dark:text-slate-400 font-bold dark:font-medium mb-2 text-sm uppercase tracking-wider flex items-center justify-between">
                            Pensiun
                            <i class="fas fa-user-clock text-accent-500/50 group-hover:text-accent-600 dark:group-hover:text-accent-400 transition-colors"></i>
                        </div>
                        <div class="text-4xl font-extrabold text-slate-900 dark:text-white mb-1"><?= number_format($statistik['pensiun'] ?? 120) ?></div>
                    </div>
                </div>

                <!-- Tidak Aktif -->
                <div class="glass-card bg-white dark:bg-slate-800/40 border border-slate-200 dark:border-white/10 border-t-4 border-t-red-500 p-6 flex flex-col justify-between rounded-xl shadow-md dark:shadow-none group" data-aos="zoom-in" data-aos-delay="300">
                    <div>
                        <div class="text-slate-600 dark:text-slate-400 font-bold dark:font-medium mb-2 text-sm uppercase tracking-wider flex items-center justify-between">
                            Tidak Aktif
                            <i class="fas fa-user-times text-red-500/50 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors"></i>
                        </div>
                        <div class="text-4xl font-extrabold text-slate-900 dark:text-white mb-1"><?= number_format($statistik['tidak_aktif'] ?? 30) ?></div>
                    </div>
                </div>

                <!-- Total -->
                <div class="glass-card bg-white dark:bg-slate-800/40 border border-slate-200 dark:border-white/10 border-t-4 border-t-amber-500 p-6 flex flex-col justify-between rounded-xl shadow-md dark:shadow-none group" data-aos="zoom-in" data-aos-delay="400">
                    <div>
                        <div class="text-slate-600 dark:text-slate-400 font-bold dark:font-medium mb-2 text-sm uppercase tracking-wider flex items-center justify-between">
                            Total Pekerja
                            <i class="fas fa-users text-amber-500/50 group-hover:text-amber-600 dark:group-hover:text-gold transition-colors"></i>
                        </div>
                        <div class="text-4xl font-extrabold text-slate-900 dark:text-white mb-1"><?= number_format($statistik['total'] ?? 1400) ?></div>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Statistik -->
            <div class="glass-card bg-blue-50/80 dark:bg-slate-800/50 rounded-2xl p-6 mb-12 border border-blue-100 dark:border-white/5 border-l-4 border-l-primary-600 dark:border-l-primary-500 shadow-md dark:shadow-none" data-aos="fade-up">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 rounded-full bg-white dark:bg-primary-500/10 flex items-center justify-center mr-4 shadow-sm dark:shadow-none">
                        <i class="fas fa-robot text-primary-600 dark:text-primary-400 text-lg"></i>
                    </div>
                    <h3 class="text-xl font-extrabold text-slate-900 dark:text-white tracking-wide">Ringkasan Analitik AI</h3>
                </div>
                <p class="text-slate-700 dark:text-slate-300 leading-relaxed font-medium dark:font-light text-md">
                    <?= isset($statistik) && function_exists('generateRingkasanStatistik') ? generateRingkasanStatistik($statistik) : 'Sistem mendeteksi pertumbuhan pekerja aktif sebesar 5% pada kuartal ini. Distribusi pendidikan didominasi oleh lulusan Sarjana (S1). Keseimbangan rasio gender berada pada rentang ideal. Silakan periksa grafik di bawah untuk rincian persebaran demografi.' ?>
                </p>
            </div>

            <!-- Visualisasi Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Card Chart Umur -->
                <div class="glass-card bg-white dark:bg-slate-800/40 border border-slate-200 dark:border-white/10 rounded-2xl p-6 shadow-md dark:shadow-none" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-lg font-extrabold text-slate-900 dark:text-white mb-6 flex items-center pb-4 border-b border-slate-100 dark:border-white/10 tracking-wide">
                        <i class="fas fa-wave-square text-primary-600 dark:text-primary-400 mr-3"></i> Rentang Umur
                    </h3>
                    <div class="relative w-full h-[300px]">
                        <canvas id="chartUmur"></canvas>
                    </div>
                </div>

                <!-- Card Chart Jenis Kelamin -->
                <div class="glass-card bg-white dark:bg-slate-800/40 border border-slate-200 dark:border-white/10 rounded-2xl p-6 shadow-md dark:shadow-none" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="text-lg font-extrabold text-slate-900 dark:text-white mb-6 flex items-center pb-4 border-b border-slate-100 dark:border-white/10 tracking-wide">
                        <i class="fas fa-venus-mars text-accent-600 dark:text-accent-400 mr-3"></i> Demografi Gender
                    </h3>
                    <div class="relative w-full h-[300px]">
                        <canvas id="chartJenisKelamin"></canvas>
                    </div>
                </div>

                <!-- Card Chart Pendidikan -->
                <div class="glass-card bg-white dark:bg-slate-800/40 border border-slate-200 dark:border-white/10 rounded-2xl p-6 shadow-md dark:shadow-none" data-aos="fade-up" data-aos-delay="300">
                    <h3 class="text-lg font-extrabold text-slate-900 dark:text-white mb-6 flex items-center pb-4 border-b border-slate-100 dark:border-white/10 tracking-wide">
                        <i class="fas fa-graduation-cap text-amber-500 dark:text-gold mr-3"></i> Profil Pendidikan
                    </h3>
                    <div class="relative w-full h-[300px]">
                        <canvas id="chartPendidikan"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Kontak / Footer -->
    <footer id="kontak" class="relative bg-white dark:bg-darker border-t border-slate-200 dark:border-white/10 pt-20 pb-10 overflow-hidden">
        <!-- Glow effect in footer (Dark Mode only) -->
        <div class="hidden dark:block absolute bottom-0 left-1/2 -translate-x-1/2 w-full max-w-3xl h-32 bg-primary-600/20 filter blur-[100px] rounded-full pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-12 mb-16">
                <div class="md:col-span-5">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-primary-500 to-accent-500 flex items-center justify-center shadow-md">
                            <i class="fas fa-fingerprint text-white"></i>
                        </div>
                        <span class="text-2xl font-bold tracking-widest text-slate-900 dark:text-white">SI<span class="text-primary-600 dark:text-primary-400">-TALENTA</span></span>
                    </div>
                    <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed mb-6 font-medium dark:font-light max-w-sm">
                        Menghadirkan ekosistem digital cerdas untuk pengelolaan manajemen talenta terpadu pada Dinas Lingkungan Hidup. Efisien, presisi, masa depan.
                    </p>
                </div>

                <div class="md:col-span-3">
                    <h4 class="font-bold text-slate-900 dark:text-white mb-6 text-sm uppercase tracking-[0.15em]">Navigasi Sistem</h4>
                    <div class="space-y-3">
                        <a href="#home" class="block text-sm text-slate-600 dark:text-slate-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors flex items-center font-medium dark:font-light"><i class="fas fa-chevron-right text-[10px] mr-2 text-primary-500/50"></i> Beranda</a>
                        <a href="#tentang" class="block text-sm text-slate-600 dark:text-slate-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors flex items-center font-medium dark:font-light"><i class="fas fa-chevron-right text-[10px] mr-2 text-primary-500/50"></i> Tentang Platform</a>
                        <a href="#statistik" class="block text-sm text-slate-600 dark:text-slate-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors flex items-center font-medium dark:font-light"><i class="fas fa-chevron-right text-[10px] mr-2 text-primary-500/50"></i> Data & Statistik</a>
                    </div>
                </div>

                <div class="md:col-span-4">
                    <h4 class="font-bold text-slate-900 dark:text-white mb-6 text-sm uppercase tracking-[0.15em]">Hubungi Kami</h4>
                    <div class="space-y-4 text-slate-600 dark:text-slate-400 text-sm font-medium dark:font-light">
                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-white/5 flex items-center justify-center shrink-0 border border-slate-200 dark:border-white/5 mt-1">
                                <i class="fas fa-map-marker-alt text-primary-600 dark:text-primary-400"></i>
                            </div>
                            <span class="m-0 p-0">Dinas Lingkungan Hidup<br>Jl. Tentara Pelajar No.1, Kota Pekalongan</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-white/5 flex items-center justify-center shrink-0 border border-slate-200 dark:border-white/5">
                                <i class="fas fa-envelope text-accent-600 dark:text-accent-400"></i>
                            </div>
                            <span>dlhkotapekalongan@gmail.com</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-white/5 flex items-center justify-center shrink-0 border border-slate-200 dark:border-white/5">
                                <i class="fas fa-phone text-amber-500 dark:text-gold"></i>
                            </div>
                            <span>0895-4144-61165</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-200 dark:border-white/10 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <p class="text-slate-500 text-xs tracking-wider uppercase text-center md:text-left font-semibold dark:font-normal">&copy; <?= date('Y') ?> Dinas Lingkungan Hidup. Hak Cipta Dilindungi.<br>Crafted with ❤️ by <span><a href="https://fajarajikusuma.vercel.app" target="_blank">Fajar Aji Kusuma S.Kom.</a></span></p>
                <div class="flex space-x-3">
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/5 flex items-center justify-center text-slate-500 dark:text-slate-400 hover:text-white hover:border-primary-500/50 hover:bg-primary-500 dark:hover:bg-primary-500/10 transition-all duration-300">
                        <i class="fab fa-twitter text-sm"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/5 flex items-center justify-center text-slate-500 dark:text-slate-400 hover:text-white hover:border-accent-500/50 hover:bg-accent-500 dark:hover:bg-accent-500/10 transition-all duration-300">
                        <i class="fab fa-instagram text-sm"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/5 flex items-center justify-center text-slate-500 dark:text-slate-400 hover:text-white hover:border-blue-500/50 hover:bg-blue-600 dark:hover:bg-blue-500/10 transition-all duration-300">
                        <i class="fab fa-linkedin-in text-sm"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Script Libraries Initialization -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // --- THEME TOGGLE LOGIC ---
        const themeToggleBtns = document.querySelectorAll('#themeToggleBtn, #themeToggleBtnMobile');
        const htmlElement = document.documentElement;
        
        let isDark = true;
        if (localStorage.getItem('theme') === 'light' || (!('theme' in localStorage) && !window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            isDark = false;
            htmlElement.classList.remove('dark');
        }

        themeToggleBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                isDark = !isDark;
                if (isDark) {
                    htmlElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    htmlElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                }
                updateChartsTheme();
            });
        });

        // Initialize Animate On Scroll
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
        });

        // --- CHART JS DATA & CONFIG ---
        const dataUmur = <?= isset($statistikUmur) && function_exists('formatStatistikChart') ? json_encode(formatStatistikChart($statistikUmur, 'rentang_umur', 'jumlah')) : json_encode(['labels'=>['20-30','31-40','41-50','>50'], 'values'=>[300, 500, 450, 150]]) ?>;
        const dataJenisKelamin = <?= isset($statistikJenisKelamin) && function_exists('formatStatistikChart') ? json_encode(formatStatistikChart($statistikJenisKelamin, 'jenis_kelamin', 'jumlah')) : json_encode(['labels'=>['Laki-laki','Perempuan'], 'values'=>[850, 550]]) ?>;
        const dataPendidikan = <?= isset($statistikPendidikan) && function_exists('formatStatistikChart') ? json_encode(formatStatistikChart($statistikPendidikan, 'tingkat_pendidikan', 'jumlah')) : json_encode(['labels'=>['SMA','D3','S1','S2'], 'values'=>[200, 300, 700, 200]]) ?>;
        
        Chart.defaults.font.family = "'Space Grotesk', sans-serif";
        Chart.defaults.plugins.tooltip.padding = 12;
        Chart.defaults.plugins.tooltip.cornerRadius = 8;
        
        let chartUmurInst, chartJenisKelaminInst, chartPendidikanInst, miniAiChartInst;

        // Function to init/update charts based on current theme
        function updateChartsTheme() {
            const textColor = isDark ? '#94a3b8' : '#475569'; 
            const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';
            const tooltipBg = isDark ? 'rgba(15, 23, 42, 0.95)' : 'rgba(255, 255, 255, 0.95)';
            const tooltipTitleColor = isDark ? '#ffffff' : '#0f172a';
            const tooltipBodyColor = isDark ? '#e2e8f0' : '#334155';
            const tooltipBorderColor = isDark ? 'rgba(56, 189, 248, 0.3)' : 'rgba(14, 165, 233, 0.2)';
            
            Chart.defaults.color = textColor;
            Chart.defaults.plugins.tooltip.backgroundColor = tooltipBg;
            Chart.defaults.plugins.tooltip.titleColor = tooltipTitleColor;
            Chart.defaults.plugins.tooltip.bodyColor = tooltipBodyColor;
            Chart.defaults.plugins.tooltip.borderColor = tooltipBorderColor;
            Chart.defaults.plugins.tooltip.borderWidth = 1;

            // Update Main Charts (Umur, Jenis Kelamin, Pendidikan)
            if(chartUmurInst) chartUmurInst.destroy();
            chartUmurInst = new Chart(document.getElementById('chartUmur'), {
                type: 'doughnut',
                data: {
                    labels: dataUmur.labels,
                    datasets: [{
                        data: dataUmur.values,
                        backgroundColor: ['#38bdf8', '#818cf8', '#fbbf24', '#f472b6', '#34d399'],
                        borderWidth: 3,
                        borderColor: isDark ? '#060913' : '#ffffff',
                        hoverOffset: 8,
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false, cutout: '75%',
                    plugins: { legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true, pointStyle: 'circle', font: { size: 12, weight: '500' } } } }
                }
            });

            if(chartJenisKelaminInst) chartJenisKelaminInst.destroy();
            chartJenisKelaminInst = new Chart(document.getElementById('chartJenisKelamin'), {
                type: 'pie',
                data: {
                    labels: dataJenisKelamin.labels,
                    datasets: [{
                        data: dataJenisKelamin.values,
                        backgroundColor: ['#0ea5e9', '#c084fc'],
                        borderWidth: 3,
                        borderColor: isDark ? '#060913' : '#ffffff',
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true, pointStyle: 'circle', font: { size: 12, weight: '500' } } } }
                }
            });
            
            if(chartPendidikanInst) chartPendidikanInst.destroy();
            chartPendidikanInst = new Chart(document.getElementById('chartPendidikan'), {
                type: 'bar',
                data: {
                    labels: dataPendidikan.labels,
                    datasets: [{
                        label: 'Jumlah Pegawai',
                        data: dataPendidikan.values,
                        backgroundColor: 'rgba(14, 165, 233, 0.8)',
                        borderColor: '#0ea5e9',
                        borderWidth: 1,
                        borderRadius: 6,
                        barThickness: 24,
                        hoverBackgroundColor: '#0284c7',
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { size: 12 } } },
                        y: { beginAtZero: true, grid: { color: gridColor, drawBorder: false }, ticks: { stepSize: 200, font: { size: 12 } } }
                    }
                }
            });

            // NEW: Mini Line Chart for AI Mockup
            if(miniAiChartInst) miniAiChartInst.destroy();
            const ctxMini = document.getElementById('miniAiChart').getContext('2d');
            
            // Create nice gradient fill under the line
            let gradientFill = ctxMini.createLinearGradient(0, 0, 0, 150);
            gradientFill.addColorStop(0, isDark ? 'rgba(56, 189, 248, 0.4)' : 'rgba(14, 165, 233, 0.3)');
            gradientFill.addColorStop(1, 'rgba(56, 189, 248, 0)');

            miniAiChartInst = new Chart(ctxMini, {
                type: 'line',
                data: {
                    labels: ['1', '2', '3', '4', '5', '6', '7', '8'],
                    datasets: [{
                        label: 'Traffic',
                        data: [12, 19, 15, 25, 22, 30, 28, 35],
                        borderColor: isDark ? '#38bdf8' : '#0ea5e9',
                        borderWidth: 2,
                        backgroundColor: gradientFill,
                        fill: true,
                        tension: 0.4, // Smooth curved lines
                        pointRadius: 0, // Hide points for cleaner look
                        pointHoverRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false }, tooltip: { enabled: false } },
                    scales: {
                        x: { display: false }, // Hide axes entirely
                        y: { display: false, min: 0, max: 40 }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeInOutQuart'
                    }
                }
            });
            
            // Optional: simulate live data update on the mini chart
            setInterval(() => {
                if(miniAiChartInst) {
                    const dataArr = miniAiChartInst.data.datasets[0].data;
                    dataArr.shift(); // remove first
                    dataArr.push(Math.floor(Math.random() * (38 - 15 + 1) + 15)); // add random
                    miniAiChartInst.update('none'); // update without full animation
                }
            }, 3000);
        }

        // Initialize Charts on First Load
        updateChartsTheme();

        // Smooth scroll untuk navigasi
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>

    <!-- Floating Button: Back to Portal -->
    <a href="https://portaldlh.web.id" 
       class="fixed bottom-8 right-8 z-50 group flex items-center"
       title="Kembali ke Portal Utama">
        <!-- Main Button -->
        <div class="glass-nav bg-white/70 dark:bg-white/10 backdrop-blur-md border-2 border-primary-400 dark:border-primary-500 rounded-full w-14 h-14 flex items-center justify-center shadow-xl dark:shadow-[0_0_25px_rgba(56,189,248,0.4)] hover:scale-110 hover:rotate-12 transition-all duration-300 hover:border-primary-500 dark:hover:border-primary-400">
            <i class="fas fa-home text-2xl text-primary-600 dark:text-primary-400 group-hover:text-primary-700 dark:group-hover:text-primary-300"></i>
        </div>
        
        <!-- Hover Text -->
        <div class="absolute right-16 opacity-0 group-hover:opacity-100 translate-x-2 group-hover:translate-x-0 transition-all duration-300 pointer-events-none">
            <div class="glass-nav bg-white/90 dark:bg-slate-800/90 backdrop-blur-md px-4 py-2 rounded-lg border border-slate-200 dark:border-white/20 shadow-lg dark:shadow-[0_0_15px_rgba(0,0,0,0.3)] whitespace-nowrap">
                <span class="text-sm font-semibold text-slate-700 dark:text-slate-200 flex items-center">
                    <i class="fas fa-arrow-left mr-2 text-primary-500 dark:text-primary-400"></i>
                    Portal Utama
                </span>
            </div>
        </div>
    </a>
</body>
</html>