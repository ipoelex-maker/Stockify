@php
    $url = explode('/', request()->url());
    $page_slug = $url[count($url) - 2];
@endphp

<aside id="sidebar"
    class="fixed top-0 left-0 z-20 flex flex-col flex-shrink-0 hidden w-64 h-full pt-16 font-normal duration-75 lg:flex transition-width"
    aria-label="Sidebar">

    <div class="relative flex flex-col flex-1 min-h-0 pt-0 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700">

        <!-- MENU -->
        <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
            <div class="flex-1 px-3 space-y-1 bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                <ul class="pb-2 space-y-2">
                    {{ $slot }}
                </ul>
            </div>
        </div>

        <!-- BOTTOM USER + THEME -->
        <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">

            <!-- USER -->
            <div class="mb-3">
                <div class="font-semibold text-gray-800 dark:text-white">
                    {{ Auth::user()->name }}
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    {{ Auth::user()->email }}
                </div>

                <span class="inline-block mt-2 px-3 py-1 text-xs rounded-full bg-blue-600 text-white">
                    {{ Auth::user()->roles->first()->name ?? 'User' }}
                </span>
            </div>

            <!-- THEME TOGGLE -->
            <button
                onclick="toggleTheme()"
                id="theme-toggle"
                class="w-10 h-10 flex items-center justify-center
                       rounded-full
                       bg-gray-100 hover:bg-gray-200
                       dark:bg-gray-800 dark:hover:bg-gray-700
                       text-yellow-500
                       transition duration-300">

                <span id="theme-icon" class="text-lg"></span>
            </button>

        </div>
    </div>
</aside>

<div class="fixed inset-0 z-10 hidden bg-gray-900/50" id="sidebarBackdrop"></div>