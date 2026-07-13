<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kesalahan Sistem | SI-TALENTA</title>

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
                        mono: ['ui-monospace', 'SFMono-Regular', 'Menlo', 'Monaco', 'Consolas', 'monospace'],
                    },
                    colors: {
                        dark: '#080C16',
                        darker: '#03050A',
                        danger: { 400: '#f87171', 500: '#ef4444', 600: '#dc2626' },
                    },
                    animation: {
                        'spin-slow': 'spin 8s linear infinite',
                        'ping-slow': 'ping 3s cubic-bezier(0, 0, 0.2, 1) infinite',
                    }
                }
            }
        }
    </script>

    <style>
        body { background-color: #03050A; color: #e2e8f0; }
        
        .glass-container {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(239, 68, 68, 0.2); /* Red tinted border */
            box-shadow: 0 0 40px rgba(239, 68, 68, 0.1);
        }
        
        /* Cyberpunk styled scrollbar for code blocks */
        pre::-webkit-scrollbar { width: 6px; height: 6px; }
        pre::-webkit-scrollbar-track { background: #0f172a; }
        pre::-webkit-scrollbar-thumb { background: #ef4444; border-radius: 3px; }
        
        .code-glass {
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
    
    <!-- Embed original CodeIgniter debug CSS safely -->
    <style>
        <?= preg_replace('#[\r\n\t ]+#', ' ', file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'debug.css')) ?>
        
        /* Overriding some default CI styles to match our dark theme */
        .trace { background: transparent !important; color: #94a3b8 !important; }
        .trace a { color: #38bdf8 !important; }
        .trace-file { color: #f87171 !important; font-family: monospace; }
        .header { background: transparent !important; color: white !important; border-bottom: none !important; }
        .container { max-width: 100% !important; margin: 0 !important; padding: 0 !important; box-shadow: none !important; background: transparent !important;}
        h1.headline { display: none; /* Hidden because we use tailwind H1 */ }
    </style>
</head>
<body class="min-h-screen relative bg-darker p-4 md:p-8 flex items-start justify-center">
    
    <!-- Red glowing background element -->
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-danger-600/10 rounded-full filter blur-[120px] pointer-events-none z-0"></div>

    <div class="w-full max-w-5xl glass-container rounded-2xl overflow-hidden relative z-10 border-t-4 border-t-danger-500">
        
        <!-- Header Banner -->
        <div class="bg-danger-500/10 border-b border-danger-500/20 p-6 md:p-8 flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
            <!-- Warning Icon Animation -->
            <div class="absolute right-0 top-0 opacity-5 transform translate-x-1/4 -translate-y-1/4">
                <i class="fas fa-triangle-exclamation text-9xl"></i>
            </div>
            
            <div class="flex items-center gap-5 z-10">
                <div class="w-16 h-16 rounded-xl bg-danger-500/20 border border-danger-500/50 flex items-center justify-center text-danger-400 relative">
                    <span class="absolute inset-0 rounded-xl border border-danger-400 animate-ping-slow"></span>
                    <i class="fas fa-bug text-2xl"></i>
                </div>
                <div>
                    <div class="text-danger-400 text-xs font-bold tracking-[0.2em] uppercase mb-1">System Exception</div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white tracking-tight">
                        <?= lang('Errors.whoops') ?: 'Terjadi Kesalahan Kritis' ?>
                    </h1>
                    <p class="text-slate-400 mt-1 font-light text-sm">
                        <?= lang('Errors.weHitASnag') ?: 'Mesin AI mendeteksi adanya anomali pada kode.' ?>
                    </p>
                </div>
            </div>
            
            <div class="z-10 w-full md:w-auto flex justify-center">
                <a href="<?= base_url('/') ?>" class="px-6 py-2.5 rounded-full bg-white/5 border border-white/10 text-white text-sm font-medium hover:bg-white/10 transition-colors flex items-center w-full md:w-auto justify-center">
                    <i class="fas fa-home mr-2"></i> Ke Dasbor
                </a>
            </div>
        </div>

        <!-- Error Details (Only shown in non-production) -->
        <div class="p-6 md:p-8">
            <div class="bg-dark/80 rounded-xl border border-white/5 overflow-hidden code-glass">
                <!-- Mac-like Window Controls -->
                <div class="h-10 bg-white/5 border-b border-white/5 flex items-center px-4 gap-2">
                    <div class="w-3 h-3 rounded-full bg-danger-500"></div>
                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    <div class="ml-4 text-xs text-slate-500 font-mono tracking-widest">ERROR_LOG.TXT</div>
                </div>
                
                <div class="p-6 overflow-x-auto">
                    <!-- The original CodeIgniter output will render here securely -->
                    <div class="text-sm font-mono leading-relaxed text-slate-300">
                        <?php 
                            // Ini akan memuat tampilan error bawaan CI4 namun di dalam wadah modern kita
                            // Karena file asli Codeigniter memisahkan error_exception dengan view internal, 
                            // CSS override di atas akan menangani pewarnaan output asli.
                        ?>
                        
                        <!-- Fallback / Simulated output if direct CI dump fails to inject cleanly -->
                        <div class="mb-4">
                            <span class="text-danger-400 font-bold">Exception:</span> 
                            <span class="text-white"><?= isset($message) ? esc($message) : 'System encountered an unexpected exception.' ?></span>
                        </div>
                        
                        <?php if (isset($file) && isset($line)) : ?>
                        <div class="mb-4">
                            <span class="text-slate-500">File:</span> <span class="text-primary-400"><?= esc($file) ?></span><br>
                            <span class="text-slate-500">Line:</span> <span class="text-amber-400"><?= esc($line) ?></span>
                        </div>
                        <?php endif; ?>

                        <!-- Standard CodeIgniter Trace rendering container -->
                        <div class="ci-trace-container mt-6">
                             <!-- We leave this blank, CI's core will often append the trace below the body 
                                  or inside the container based on how it includes this file.
                                  The CSS overrides in the head will restyle it to match. -->
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 flex items-center justify-between text-xs text-slate-500 font-mono border-t border-white/5 pt-4">
                <div class="flex items-center">
                    <i class="fas fa-server mr-2 text-primary-500"></i> SI-TALENTA Core Engine
                </div>
                <div>
                    Waktu Log: <?= date('Y-m-d H:i:s') ?>
                </div>
            </div>
        </div>

    </div>
</body>
</html>