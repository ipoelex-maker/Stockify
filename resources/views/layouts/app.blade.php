<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- AUTO LOAD THEME --}}
    <script>
        if (localStorage.theme === 'dark' ||
            (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 dark:text-white">

    {{-- MOBILE TOP BAR --}}
    <div class="lg:hidden fixed top-0 left-0 right-0 z-40
                flex items-center justify-between
                px-4 py-3
                bg-white dark:bg-gray-900
                border-b border-gray-200 dark:border-gray-700 shadow-sm">

        {{-- HAMBURGER --}}
        <button onclick="toggleSidebar()"
                class="p-2 rounded-xl text-gray-600 dark:text-gray-300
                       hover:bg-gray-100 dark:hover:bg-gray-800 transition">
            <svg id="hamburgerIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        {{-- LOGO --}}
        <a href="{{ route('dashboard') }}"
           class="text-xl font-black text-blue-600 dark:text-blue-400">
            Stockify
        </a>

        {{-- DARK MODE (mobile) --}}
        <button onclick="toggleTheme()"
                class="p-2 rounded-xl text-gray-600 dark:text-gray-300
                       hover:bg-gray-100 dark:hover:bg-gray-800 transition">
            <span id="theme-icon-mobile" class="text-lg">🌙</span>
        </button>

    </div>

    {{-- OVERLAY (mobile, klik untuk tutup sidebar) --}}
    <div id="sidebarOverlay"
         onclick="closeSidebar()"
         class="fixed inset-0 z-30 bg-black/50 hidden lg:hidden"></div>

    {{-- WRAPPER --}}
    <div class="h-screen overflow-hidden flex bg-gradient-to-br from-slate-100 via-blue-50 to-indigo-100 dark:from-gray-950 dark:via-gray-900 dark:to-slate-900 transition-colors duration-300">

        {{-- SIDEBAR --}}
        @include('layouts.navigation')

        {{-- MAIN CONTENT --}}
        <main class="flex-1 relative overflow-y-auto h-full bg-gray-50/80 dark:bg-gray-900/50 backdrop-blur-sm transition-colors duration-300 scrollbar-main">
            <div class="p-4 lg:p-8 pt-20 lg:pt-8">
                {{ $slot }}
            </div>
        </main>

    </div>

    {{-- DARK MODE TOGGLE (desktop, pojok kanan bawah) --}}
    <div class="hidden lg:block fixed bottom-6 right-6 z-[9999]">
        <button onclick="toggleTheme()" id="theme-toggle"
                title="Toggle Dark Mode"
                class="w-12 h-12 flex items-center justify-center rounded-full shadow-2xl
                       bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700
                       hover:scale-110 transition-all duration-300">
            <span id="theme-icon" class="text-xl">🌙</span>
        </button>
    </div>

    <style>
        .scrollbar-main::-webkit-scrollbar {
            width: 6px;
        }
        .scrollbar-main::-webkit-scrollbar-track {
            background: transparent;
        }
        .scrollbar-main::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.25);
            border-radius: 99px;
        }
        .scrollbar-main::-webkit-scrollbar-thumb:hover {
            background: rgba(148, 163, 184, 0.5);
        }
        .scrollbar-main {
            scrollbar-width: thin;
            scrollbar-color: rgba(148, 163, 184, 0.25) transparent;
        }
    </style>

    <script>
        // ── SIDEBAR TOGGLE ──────────────────────────────────────
        function toggleSidebar() {
            const sidebar  = document.getElementById('sidebar');
            const overlay  = document.getElementById('sidebarOverlay');
            const isOpen   = !sidebar.classList.contains('-translate-x-full');

            if (isOpen) {
                closeSidebar();
            } else {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            }
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }

        // Close on Escape
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeSidebar();
        });

        // ── THEME ───────────────────────────────────────────────
        function updateThemeIcon() {
            const isDark = document.documentElement.classList.contains('dark');
            const icons  = ['theme-icon', 'theme-icon-mobile'];
            icons.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.innerHTML = isDark ? '☀️' : '🌙';
            });
        }

        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
            updateThemeIcon();
        }

        document.addEventListener('DOMContentLoaded', updateThemeIcon);
    </script>

</body>
</html>