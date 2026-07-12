<!DOCTYPE html>
<html lang="en">

<head>
    <base href="<?= base_url() ?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23059669' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M12 2a10 10 0 0 1 10 10c0 5.523-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2z'%3E%3C/path%3E%3Cpath d='M12 22c-4.418 0-8-3.582-8-8 0-4.42 3.582-8 8-8s8 3.58 8 8c0 4.418-3.582 8-8 8z' opacity='0.3'%3E%3C/path%3E%3Ccircle cx='12' cy='10' r='3' fill='%23059669'%3E%3C/circle%3E%3Cpath d='M9 18c0-1.657 1.343-3 3-3s3 1.343 3 3'%3E%3C/path%3E%3C/svg%3E">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .bg-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#cbd5e1 0.5px, transparent 0.5px);
            background-size: 24px 24px;
        }
    </style>
</head>

<body class="bg-pattern text-slate-900">
    <div class="min-h-screen flex flex-col items-center justify-center p-6">

        <div class="w-full max-w-[450px]">

            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-emerald-500 to-blue-600 rounded-2xl shadow-xl shadow-blue-200 mb-4 transition-transform hover:scale-105 overflow-hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-12 h-12">
                        <path d="M12 2a10 10 0 0 1 10 10c0 5.523-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2z"></path>
                        <path d="M12 22c-4.418 0-8-3.582-8-8 0-4.42 3.582-8 8-8s8 3.58 8 8c0 4.418-3.582 8-8 8z" opacity="0.3"></path>
                        <path d="M7 10c0-1.657 2.239-3 5-3s5 1.343 5 3c0 .828-1.119 1.5-2.5 1.5S12 10.828 12 10s-1.119-1.5-2.5-1.5S7 9.172 7 10z" fill="white"></path>
                        <path d="M12 12v3"></path>
                        <path d="M9 18c0-1.657 1.343-3 3-3s3 1.343 3 3"></path>
                        <path d="M17 5l-2.5 2.5" opacity="0.8"></path>
                        <path d="M19 7l-2 2" opacity="0.8"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-extrabold tracking-tight">
                    <span class="text-slate-800">Si</span><span class="text-emerald-600">-Talenta</span>
                </h2>
                <p class="text-slate-500 mt-2 font-medium text-sm leading-relaxed">
                    Sistem Informasi Tata Kelola Tenaga Kerja <br>
                    <span class="text-slate-400">DLH Kota Pekalongan</span>
                </p>
            </div>

            <div class="bg-white rounded-3xl shadow-2xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
                <div class="p-8 md:p-10">
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-slate-800">Hello! let's get started</h3>
                        <p class="text-slate-500 text-sm mt-1">Sign in to continue to your dashboard.</p>
                    </div>

                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-lg flex items-center gap-3">
                            <i class="bi bi-check-circle-fill text-emerald-500"></i>
                            <p class="text-emerald-700 text-sm font-medium"><?= session()->getFlashdata('success') ?></p>
                        </div>
                    <?php elseif (session()->getFlashdata('error')) : ?>
                        <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-lg flex items-center gap-3">
                            <i class="bi bi-exclamation-circle-fill text-rose-500"></i>
                            <p class="text-rose-700 text-sm font-medium"><?= session()->getFlashdata('error') ?></p>
                        </div>
                    <?php endif; ?>

                    <form action="<?= site_url('login_load') ?>" method="POST" class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Username</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                    <i class="ti-user"></i>
                                </div>
                                <input type="text" name="username" required
                                    class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all placeholder:text-slate-400"
                                    placeholder="Enter your username">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                    <i class="ti-lock"></i>
                                </div>
                                <input type="password" name="password" required
                                    class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all placeholder:text-slate-400"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <div class="relative py-2">
                            <div class="absolute inset-0 flex items-center"><span class="w-full border-t border-slate-100"></span></div>
                        </div>

                        <div class="flex flex-row gap-3">
                            <a id="back-home-btn" href="<?= base_url() ?>"
                                class="flex items-center justify-center w-14 h-14 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl transition-all active:scale-90">
                                <i class="ti-arrow-left text-lg"></i>
                            </a>
                            <button type="submit"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-6 rounded-xl shadow-lg shadow-blue-200 transition-all transform hover:-translate-y-0.5 active:scale-95 uppercase tracking-wider text-sm">
                                Login Now
                            </button>
                        </div>
                    </form>
                </div>

                <div class="px-8 py-6 bg-slate-50 border-t border-slate-100 text-center">
                    <p class="text-xs text-slate-400 font-medium uppercase tracking-widest">
                        &copy; <?= date('Y') ?> SI-TALENTA &bull; Powered by Management
                    </p>
                </div>
            </div>

            <div class="text-center mt-8">
                <p class="text-sm text-slate-400">
                    Created with <i class="bi bi-heart-fill text-rose-500 text-xs mx-1"></i> by
                    <a href="https://fajarajikusuma.vercel.app" class="text-slate-600 font-semibold hover:text-blue-600 transition-colors">Fajar Aji Kusuma, S.Kom</a>
                </p>
            </div>
        </div>
    </div>

    <!-- <script>
        const backBtn = document.getElementById('back-home-btn');
        const baseUrl = window.location.origin;
        backBtn.href = baseUrl;
    </script> -->
</body>

</html>