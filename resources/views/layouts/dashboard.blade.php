<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="#">
    <meta name="author" content="#">
    <meta name="generator" content="Laravel">

    <title>Dashboard - Stockify</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="canonical" href="{{ request()->fullUrl() }}">

    @if(isset($page->params['robots']))
        <meta name="robots" content="{{ $page->params['robots'] }}">
    @endif

    <!-- THEME AUTO LOAD -->
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
</head>

@php
    $whiteBg = isset($params['white_bg']) && $params['white_bg'];
@endphp

<body class="{{ $whiteBg ? 'bg-white' : 'bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white' }} transition">

    <!-- NAVBAR -->
    <x-navbar-dashboard/>

    <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">

        <!-- SIDEBAR -->
        <x-sidebar.admin-sidebar/>

        <!-- MAIN CONTENT -->
        <div id="main-content"
             class="relative w-full h-full overflow-y-auto bg-gray-50 dark:bg-gray-900 lg:ml-64">

            <!-- HEADER -->
            <div class="flex justify-end items-center px-6 py-4 border-b border-gray-200 dark:border-gray-700">

                <!-- THEME TOGGLE -->
                <button
                    onclick="toggleTheme()"
                    id="theme-toggle"
                    class="w-11 h-11 flex items-center justify-center
                           rounded-full
                           bg-white shadow-sm
                           hover:scale-110
                           hover:bg-gray-100
                           dark:bg-gray-800
                           dark:hover:bg-gray-700
                           text-yellow-400
                           transition duration-300">

                    <span id="theme-icon"></span>
                </button>
            </div>

            <!-- PAGE CONTENT -->
            <main class="p-6">
                @yield('content')
            </main>

            <!-- FOOTER -->
            <x-footer-dashboard/>
        </div>
    </div>

    <!-- THEME SCRIPT -->
    <script>
        function updateThemeIcon() {
            const icon = document.getElementById('theme-icon');

            if (!icon) return;

            if (document.documentElement.classList.contains('dark')) {
                icon.innerHTML = '☀️';
            } else {
                icon.innerHTML = '🌙';
            }
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

    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.2/datepicker.min.js"></script>

</body>
</html>