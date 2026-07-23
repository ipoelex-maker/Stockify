<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- AUTO LOAD THEME --}}
    <script>
        if (
            localStorage.theme === 'dark' ||
            (!('theme' in localStorage) &&
                window.matchMedia('(prefers-color-scheme: dark)').matches)
        ) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ============================================================
         OLED TRUE BLACK DARK MODE
         Override semua warna Tailwind dark: jadi near-black / pure black
         OLED pixel = mati saat hitam = hemat baterai 🔋
    ============================================================ --}}
    <style>
        /* ── OLED TRUE BLACK — Background utama saja ─────── */
        .dark body                          { background: #000000 !important; }
        .dark aside                         { background-color: #050505 !important; }
        .dark main                          { background-color: #000000 !important; }
        .dark .from-slate-100               { background: #000000 !important; }

        /* ── CARDS & PANELS — cukup terang biar kontras ──── */
        .dark [class*="bg-gray-900"]        { background-color: #1a1a1a !important; }
        .dark [class*="bg-gray-800"]        { background-color: #222222 !important; }
        .dark [class*="bg-gray-700"]        { background-color: #2a2a2a !important; }
        .dark [class*="bg-gray-600"]        { background-color: #333333 !important; }
        .dark [class*="bg-gray-50\/80"]    { background-color: #111111 !important; }

        /* ── GLASS SIDEBAR — sedikit lebih terang ────────── */
        .dark aside > div {
            background-color: rgba(20, 20, 20, 0.97) !important;
            border-color: rgba(255,255,255,0.10) !important;
        }

        /* ── BORDERS — visible ────────────────────────────── */
        .dark [class*="border-gray-700"]    { border-color: #333333 !important; }
        .dark [class*="border-gray-600"]    { border-color: #3a3a3a !important; }
        .dark [class*="border-gray-100"]    { border-color: #2a2a2a !important; }

        /* ── INPUTS — kontras dari card ───────────────────── */
        .dark input,
        .dark select,
        .dark textarea {
            background-color: #111111 !important;
            color: #f5f5f5 !important;
            border-color: #3a3a3a !important;
        }

        /* ── HOVER STATES ─────────────────────────────────── */
        .dark [class*="hover:bg-gray-800"]:hover  { background-color: #2a2a2a !important; }
        .dark [class*="hover:bg-gray-700"]:hover  { background-color: #333333 !important; }

        /* ── TABEL ────────────────────────────────────────── */
        .dark thead tr                      { background-color: #1e1e1e !important; }
        .dark [class*="divide-gray-700"] > * + * { border-color: #2e2e2e !important; }
        .dark [class*="divide-gray-50"]  > * + * { border-color: #222222 !important; }

        /* ── NOTIFICATION & DROPDOWN ──────────────────────── */
        .dark #notifDropdown,
        .dark #profileDropdown {
            background-color: #1a1a1a !important;
            border-color: #333333 !important;
        }

        /* ── MOBILE TOP BAR ───────────────────────────────── */
        .dark .fixed.top-0.left-0.right-0 {
            background-color: #0a0a0a !important;
            border-color: #2a2a2a !important;
        }

        /* ── SCROLLBAR ────────────────────────────────────── */
        .dark ::-webkit-scrollbar-thumb     { background: rgba(255,255,255,0.15) !important; }
        .dark ::-webkit-scrollbar-track     { background: #000000 !important; }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 dark:text-white overflow-hidden">

    {{-- MOBILE TOP BAR --}}
    <div class="lg:hidden fixed top-0 left-0 right-0 z-40
                flex items-center justify-between
                px-4 py-3
                bg-white dark:bg-gray-900
                border-b border-gray-200 dark:border-gray-700 shadow-sm">

        <button onclick="toggleSidebar()"
                class="p-2 rounded-xl text-gray-600 dark:text-gray-300
                       hover:bg-gray-100 dark:hover:bg-gray-800 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <a href="{{ route('dashboard') }}"
           class="text-xl font-black bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
            Stockify
        </a>

        <button onclick="toggleTheme()"
                class="p-2 rounded-xl text-gray-600 dark:text-gray-300
                       hover:bg-gray-100 dark:hover:bg-gray-800 transition">
            <span id="theme-icon-mobile" class="text-lg">🌙</span>
        </button>
    </div>

    {{-- OVERLAY --}}
    <div id="sidebarOverlay"
         onclick="closeSidebar()"
         class="fixed inset-0 z-30 bg-black/50 hidden lg:hidden"></div>

    {{-- WRAPPER --}}
    <div class="h-screen overflow-hidden flex bg-gradient-to-br from-slate-100 via-blue-50 to-indigo-100
                dark:from-black dark:via-black dark:to-black
                transition-colors duration-300">

        {{-- SIDEBAR --}}
        @include('layouts.navigation')

        {{-- MAIN CONTENT --}}
        <main class="flex-1 relative overflow-y-auto h-full
                     bg-gray-50/80 dark:bg-black
                     backdrop-blur-sm transition-colors duration-300
                     scrollbar-main pt-14 lg:pt-0">
            <div class="p-4 lg:p-8">
                {{ $slot }}
            </div>
        </main>

    </div>

    {{-- DARK MODE TOGGLE (desktop) --}}
    <div class="hidden lg:block fixed bottom-6 right-6 z-[9999]">
        <button onclick="toggleTheme()" id="theme-toggle"
                title="Toggle Dark Mode"
                class="w-12 h-12 flex items-center justify-center rounded-full shadow-2xl
                       bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
                       hover:scale-110 transition-all duration-300">
            <span id="theme-icon" class="text-xl">🌙</span>
        </button>
    </div>

    <style>
        .scrollbar-main::-webkit-scrollbar { width: 6px; }
        .scrollbar-main::-webkit-scrollbar-track { background: transparent; }
        .scrollbar-main::-webkit-scrollbar-thumb {
            background: rgba(148,163,184,0.25);
            border-radius: 99px;
        }
        .scrollbar-main::-webkit-scrollbar-thumb:hover {
            background: rgba(148,163,184,0.5);
        }
        .scrollbar-main { scrollbar-width: thin; scrollbar-color: rgba(148,163,184,0.25) transparent; }
    </style>

    <script>
        // ── SIDEBAR ──────────────────────────────────────
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                closeSidebar();
            }
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }

        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeSidebar(); });

        // ── THEME ─────────────────────────────────────────
        function updateThemeIcon() {
            const isDark = document.documentElement.classList.contains('dark');
            ['theme-icon', 'theme-icon-mobile'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.innerHTML = isDark ? '☀️' : '🌙';
            });
        }

        function toggleTheme() {
            const isDark = document.documentElement.classList.contains('dark');
            document.documentElement.classList.toggle('dark');
            localStorage.theme = isDark ? 'light' : 'dark';
            updateThemeIcon();
        }

        document.addEventListener('DOMContentLoaded', updateThemeIcon);
    </script>

</body>
</html>