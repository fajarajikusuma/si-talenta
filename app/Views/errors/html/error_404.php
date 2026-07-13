<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | SI-TALENTA</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts: Space Grotesk -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Space Grotesk', 'sans-serif'],
                    },
                    colors: {
                        dark: '#080C16',
                        darker: '#03050A',
                        primary: { 400: '#38bdf8', 500: '#0ea5e9', 600: '#0284c7' },
                        accent: { 400: '#818cf8', 500: '#6366f1' },
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-glow': 'pulseGlow 2s infinite',
                        'glitch': 'glitch 1s linear infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        pulseGlow: {
                            '0%, 100%': { opacity: 1, filter: 'drop-shadow(0 0 10px rgba(56,189,248,0.5))' },
                            '50%': { opacity: 0.7, filter: 'drop-shadow(0 0 2px rgba(56,189,248,0.2))' },
                        },
                        glitch: {
                            '2%, 64%': { transform: 'translate(2px, 0) skew(0deg)' },
                            '4%, 60%': { transform: 'translate(-2px, 0) skew(0deg)' },
                            '62%': { transform: 'translate(0, 0) skew(5deg)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body { overflow: hidden; background-color: #03050A; color: #e2e8f0; }
        .glass-card {
            background: rgba(30, 41, 59, 0.4);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
        }
        .text-gradient {
            background: linear-gradient(135deg, #38bdf8 0%, #818cf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        /* Grid Background Pattern */
        .grid-bg {
            background-size: 40px 40px;
            background-image: linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            mask-image: radial-gradient(circle at center, black 40%, transparent 80%);
            -webkit-mask-image: radial-gradient(circle at center, black 40%, transparent 80%);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center relative bg-darker">
    
    <!-- Background Elements -->
    <div class="fixed inset-0 grid-bg z-0 pointer-events-none"></div>
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-600/20 rounded-full mix-blend-screen filter blur-[100px] animate-pulse"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-accent-600/20 rounded-full mix-blend-screen filter blur-[100px] animate-pulse" style="animation-delay: 1s;"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 w-full max-w-2xl px-6">
        <div class="glass-card rounded-3xl p-10 md:p-14 text-center border-t-4 border-t-primary-500 animate-float">
            
            <!-- Glitchy 404 Text -->
            <div class="relative mb-6">
                <h1 class="text-7xl md:text-9xl font-extrabold text-transparent bg-clip-text bg-gradient-to-br from-primary-400 to-accent-500 animate-pulse-glow tracking-tighter" style="line-height: 1.1;">
                    404
                </h1>
                <div class="absolute inset-0 flex items-center justify-center opacity-30 text-7xl md:text-9xl font-extrabold text-primary-300 animate-glitch tracking-tighter pointer-events-none">
                    404
                </div>
            </div>

            <!-- Error Message -->
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-4 tracking-wide">
                <i class="fas fa-satellite-dish mr-2 text-primary-400"></i> Signal Hilang
            </h2>
            
            <p class="text-slate-400 text-lg mb-10 font-light max-w-lg mx-auto">
                <?php if (ENVIRONMENT !== 'production') : ?>
                    <span class="block bg-slate-900/80 p-4 rounded-lg text-left text-sm text-red-400 border border-red-500/20 overflow-x-auto">
                        <i class="fas fa-bug mr-2"></i> <?= nl2br(esc($message)) ?>
                    </span>
                <?php else : ?>
                    <?= lang('Errors.sorryCannotFind') ?: 'Sistem tidak dapat menemukan halaman yang Anda cari. Entitas data mungkin telah dipindahkan atau tidak pernah ada.' ?>
                <?php endif; ?>
            </p>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <button onclick="window.history.back()" class="w-full sm:w-auto px-8 py-3 rounded-full bg-white/5 border border-white/10 text-white font-medium hover:bg-white/10 hover:border-white/20 transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </button>
                <a href="<?= base_url('/') ?>" class="w-full sm:w-auto px-8 py-3 rounded-full bg-primary-600 text-white font-bold hover:bg-primary-500 shadow-[0_0_20px_rgba(56,189,248,0.4)] transition-all duration-300 flex items-center justify-center group">
                    Ke Beranda <i class="fas fa-home ml-2 group-hover:scale-110 transition-transform"></i>
                </a>
            </div>
            
            <!-- Footer -->
            <div class="mt-12 pt-6 border-t border-white/5 flex items-center justify-center space-x-2 text-slate-500 text-xs tracking-widest font-mono">
                <div class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></div>
                <span>STATUS: KONEKSI TERPUTUS</span>
            </div>
        </div>
    </div>

</body>
</html>