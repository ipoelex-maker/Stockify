<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register — Stockify</title>
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
        .blob  { animation: blob 7s ease-in-out infinite; }
    </style>
</head>

<body class="min-h-screen font-sans
             bg-gradient-to-br from-slate-100 via-blue-50 to-indigo-100
             dark:from-gray-950 dark:via-gray-900 dark:to-slate-900
             flex items-center justify-center p-4">

    {{-- BG BLOBS --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-indigo-400/20 dark:bg-indigo-600/10 blur-3xl blob"></div>
        <div class="absolute bottom-0 -left-40 w-80 h-80 bg-blue-400/20 dark:bg-blue-600/10 blur-3xl blob" style="animation-delay:2s"></div>
        <div class="absolute top-1/3 right-1/4 w-64 h-64 bg-cyan-400/20 dark:bg-cyan-600/10 blur-3xl blob" style="animation-delay:4s"></div>
    </div>

    <div class="relative z-10 w-full max-w-md">

        {{-- LOGO --}}
        <div class="text-center mb-8">
            <div class="float inline-block text-6xl mb-3">🏭</div>
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

            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-1">Buat Akun Baru ✨</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mb-8">Daftarkan diri kamu untuk mulai menggunakan Stockify</p>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- NAME --}}
                <div>
                    <label for="name" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                        Nama Lengkap
                    </label>
                    <input id="name" type="text" name="name"
                           value="{{ old('name') }}"
                           required autofocus autocomplete="name"
                           placeholder="cth: Budi Santoso"
                           class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                  bg-white/80 dark:bg-gray-800/80
                                  text-gray-800 dark:text-white
                                  placeholder-gray-400 dark:placeholder-gray-500
                                  px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- EMAIL --}}
                <div>
                    <label for="email" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                        Email
                    </label>
                    <input id="email" type="email" name="email"
                           value="{{ old('email') }}"
                           required autocomplete="username"
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

                {{-- PASSWORD --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                            Password
                        </label>
                        <input id="password" type="password" name="password"
                               required autocomplete="new-password"
                               placeholder="Min. 8 karakter"
                               class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                      bg-white/80 dark:bg-gray-800/80
                                      text-gray-800 dark:text-white
                                      placeholder-gray-400 dark:placeholder-gray-500
                                      px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                            Konfirmasi
                        </label>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                               required autocomplete="new-password"
                               placeholder="Ulangi password"
                               class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                      bg-white/80 dark:bg-gray-800/80
                                      text-gray-800 dark:text-white
                                      placeholder-gray-400 dark:placeholder-gray-500
                                      px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        @error('password_confirmation')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- REGISTER BUTTON --}}
                <button type="submit"
                        class="w-full py-3 rounded-xl font-bold text-white text-sm
                               bg-gradient-to-r from-blue-600 to-indigo-600
                               hover:from-blue-700 hover:to-indigo-700
                               shadow-lg hover:shadow-blue-200 dark:hover:shadow-blue-900/40
                               transition-all duration-200">
                    ✨ Daftar Sekarang
                </button>

            </form>

        </div>

        {{-- LOGIN LINK --}}
        <p class="text-center mt-6 text-sm text-gray-500 dark:text-gray-400">
            Sudah punya akun?
            <a href="{{ route('login') }}"
               class="text-blue-600 dark:text-blue-400 font-semibold hover:underline">
                Masuk di sini
            </a>
        </p>

    </div>

    {{-- DARK MODE TOGGLE --}}
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