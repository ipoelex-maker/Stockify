<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 — Halaman Tidak Ditemukan | Stockify</title>
    <script>
        if (localStorage.theme === 'dark' ||
            (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        @keyframes pulse-slow {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }
        .float { animation: float 4s ease-in-out infinite; }
        .pulse-slow { animation: pulse-slow 3s ease-in-out infinite; }
    </style>
</head>

<body class="min-h-screen font-sans
             bg-gradient-to-br from-slate-100 via-blue-50 to-indigo-100
             dark:from-gray-950 dark:via-gray-900 dark:to-slate-900
             text-gray-800 dark:text-white
             flex items-center justify-center p-6">

    {{-- BG BLOBS --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full
                    bg-blue-400/20 dark:bg-blue-600/10 blur-3xl pulse-slow"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full
                    bg-indigo-400/20 dark:bg-indigo-600/10 blur-3xl pulse-slow"
             style="animation-delay: 1.5s"></div>
    </div>

    {{-- CARD --}}
    <div class="relative z-10 max-w-lg w-full text-center">

        {{-- GLASS CARD --}}
        <div class="bg-white/70 dark:bg-gray-900/60
                    backdrop-blur-xl rounded-3xl
                    border border-white/40 dark:border-gray-700/50
                    shadow-2xl shadow-black/10
                    px-10 py-14">

            {{-- FLOATING EMOJI --}}
            <div class="float text-8xl mb-6 select-none">📦</div>

            {{-- 404 TEXT --}}
            <h1 class="text-8xl font-black tracking-tight
                       bg-gradient-to-r from-blue-600 to-indigo-600
                       bg-clip-text text-transparent mb-2">
                404
            </h1>

            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-3">
                Halaman Tidak Ditemukan
            </h2>

            <p class="text-gray-500 dark:text-white-400 mb-8 leading-relaxed">
                Get The F.. Out of Here
            </p>

            {{-- BUTTONS --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">

                <a href="{{ route('dashboard') }}"
                   class="w-full sm:w-auto px-8 py-3 rounded-2xl
                          bg-gradient-to-r from-blue-600 to-indigo-600
                          hover:from-blue-700 hover:to-indigo-700
                          text-white font-bold text-sm shadow-lg
                          hover:shadow-blue-200 dark:hover:shadow-blue-900/40
                          transition-all duration-200">
                    🏠 Kembali ke Dashboard
                </a>

                <button onclick="history.back()"
                        class="w-full sm:w-auto px-8 py-3 rounded-2xl
                               bg-gray-100 dark:bg-gray-800
                               hover:bg-gray-200 dark:hover:bg-gray-700
                               text-gray-700 dark:text-gray-300
                               font-bold text-sm transition-all duration-200">
                    ← Halaman Sebelumnya
                </button>

            </div>

        </div>

        {{-- FOOTER --}}
        <p class="mt-6 text-xs text-gray-400 dark:text-gray-600">
            Stockify — Sistem Manajemen Inventori
        </p>

    </div>

</body>
</html>