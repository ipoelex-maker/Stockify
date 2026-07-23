<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — Stockify</title>
    <script>
        if (localStorage.theme === 'dark' ||
            (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(-2deg); }
            50% { transform: translateY(-16px) rotate(2deg); }
        }
        @keyframes blob {
            0%, 100% { border-radius: 60% 40% 70% 30% / 50% 60% 40% 50%; }
            50% { border-radius: 40% 60% 30% 70% / 60% 40% 60% 40%; }
        }
        .float { animation: float 5s ease-in-out infinite; }
        .blob { animation: blob 7s ease-in-out infinite; }
        /* OLED TRUE BLACK */
        .dark body { background: #000000 !important; }
        .dark .bg-gradient-to-br { background: #000000 !important; }
        .dark [class*="bg-gray-950"],
        .dark [class*="bg-gray-900"] { background-color: #1a1a1a !important; }
        .dark [class*="bg-gray-800\/80"],
        .dark [class*="bg-gray-800"] { background-color: #222222 !important; }
        .dark input, .dark select, .dark textarea {
            background-color: #111111 !important;
            border-color: #3a3a3a !important;
            color: #f5f5f5 !important;
        }
        /* Glass card kontras dari background hitam */
        .dark .backdrop-blur-xl {
            background-color: rgba(28, 28, 28, 0.95) !important;
            border-color: rgba(255,255,255,0.12) !important;
            box-shadow: 0 8px 40px rgba(0,0,0,0.8), inset 0 1px 0 rgba(255,255,255,0.06) !important;
        }
        .dark .fixed.inset-0 > div { opacity: 0.25 !important; }
        .dark [class*="border-gray-700"] { border-color: #333333 !important; }
    </style>
</head>

<body class="min-h-screen font-sans
             bg-gradient-to-br from-slate-100 via-blue-50 to-indigo-100
             dark:from-gray-950 dark:via-gray-900 dark:to-slate-900
             flex items-center justify-center p-4">

    {{-- BG BLOBS --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-blue-400/20 dark:bg-blue-600/10 blur-3xl blob"></div>
        <div class="absolute top-1/2 -right-40 w-80 h-80 bg-indigo-400/20 dark:bg-indigo-600/10 blur-3xl blob" style="animation-delay:2s"></div>
        <div class="absolute -bottom-40 left-1/3 w-72 h-72 bg-cyan-400/20 dark:bg-cyan-600/10 blur-3xl blob" style="animation-delay:4s"></div>
    </div>

    <div class="relative z-10 w-full max-w-md">

        {{-- LOGO --}}
        <div class="text-center mb-8">
            <div class="float inline-block text-6xl mb-3">📦</div>
            <h1 class="text-4xl font-black bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                Stockify
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">
                Sistem Manajemen Inventori
            </p>
        </div>

        {{-- CARD --}}
        <div class="bg-white/70 dark:bg-gray-900/60
                    backdrop-blur-xl rounded-3xl
                    border border-white/40 dark:border-gray-700/50
                    shadow-2xl shadow-black/10
                    px-8 py-10">

            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-1">Selamat Datang! 👋</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mb-8">Masuk ke akun kamu untuk melanjutkan</p>

            @if(session('status'))
                <div class="mb-4 px-4 py-3 rounded-xl bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 text-sm font-medium">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Email</label>
                    <input id="email" type="email" name="email"
                           value="{{ old('email') }}"
                           required autofocus autocomplete="username"
                           placeholder="nama@email.com"
                           class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                  bg-white/80 dark:bg-gray-800/80
                                  text-gray-800 dark:text-white
                                  placeholder-gray-400 dark:placeholder-gray-500
                                  px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Password</label>
                    <input id="password" type="password" name="password"
                           required autocomplete="current-password"
                           placeholder="••••••••"
                           class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                  bg-white/80 dark:bg-gray-800/80
                                  text-gray-800 dark:text-white
                                  placeholder-gray-400 dark:placeholder-gray-500
                                  px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember"
                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Ingat saya</span>
                    </label>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-sm text-blue-600 dark:text-blue-400 hover:underline font-medium">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <button type="submit"
                        class="w-full py-3 rounded-xl font-bold text-white text-sm
                               bg-gradient-to-r from-blue-600 to-indigo-600
                               hover:from-blue-700 hover:to-indigo-700
                               shadow-lg hover:shadow-blue-200 dark:hover:shadow-blue-900/40
                               transition-all duration-200">
                    🚀 Masuk Sekarang
                </button>

            </form>

        </div>

        @if(Route::has('register'))
            <p class="text-center mt-6 text-sm text-gray-500 dark:text-gray-400">
                Belum punya akun?
                <a href="{{ route('register') }}"
                   class="text-blue-600 dark:text-blue-400 font-semibold hover:underline">
                    Daftar sekarang
                </a>
            </p>
        @endif

    </div>

    <div class="fixed bottom-6 right-6 z-50">
        <button onclick="toggleTheme()"
                class="w-11 h-11 flex items-center justify-center rounded-full shadow-xl
                       bg-white/80 dark:bg-gray-800/80 backdrop-blur
                       border border-gray-200 dark:border-gray-700
                       hover:scale-110 transition-all duration-300">
            <span id="theme-icon" class="text-lg">🌙</span>
        </button>
    </div>

    <script>
        function updateThemeIcon() {
            const el = document.getElementById('theme-icon');
            if (el) el.innerHTML = document.documentElement.classList.contains('dark') ? '☀️' : '🌙';
        }
        function toggleTheme() {
            document.documentElement.classList.toggle('dark');
            localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
            updateThemeIcon();
        }
        document.addEventListener('DOMContentLoaded', updateThemeIcon);
    </script>

</body>
</html>