<nav class="fixed top-0 z-50 w-full bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 shadow-sm">
    <div class="px-4 py-3 lg:px-6">
        <div class="flex items-center justify-between">

            <!-- LEFT -->
            <div class="flex items-center gap-4">

                <!-- MOBILE SIDEBAR BUTTON -->
                <button
                    id="toggleSidebarMobile"
                    aria-expanded="true"
                    aria-controls="sidebar"
                    class="p-2 text-gray-600 rounded-lg lg:hidden hover:bg-gray-100 dark:text-white dark:hover:bg-gray-800">

                    <svg id="toggleSidebarMobileHamburger"
                        class="w-6 h-6"
                        fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd">
                        </path>
                    </svg>
                </button>

                <!-- LOGO -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                        Stockify
                    </span>
                </a>
            </div>

            <!-- RIGHT -->
            <div class="flex items-center gap-3">

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

                <!-- PROFILE AVATAR DROPDOWN -->
                <div class="relative" id="profileDropdownWrapper">

                    <!-- TRIGGER -->
                    <button
                        id="profileDropdownBtn"
                        onclick="toggleProfileDropdown()"
                        class="flex items-center gap-3 px-3 py-2 rounded-2xl
                               hover:bg-gray-100 dark:hover:bg-gray-800
                               transition duration-200 focus:outline-none group">

                        <!-- Info (hidden on mobile) -->
                        <div class="text-right hidden sm:block">
                            <div class="text-sm font-semibold text-gray-800 dark:text-white leading-tight">
                                {{ Auth::user()->name }}
                            </div>
                            <div class="text-xs text-gray-400 dark:text-gray-500">
                                {{ Auth::user()->roles->first()->name ?? 'User' }}
                            </div>
                        </div>

                        <!-- Avatar circle -->
                        <div class="relative">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600
                                        text-white flex items-center justify-center
                                        font-bold text-sm shadow-lg
                                        ring-2 ring-transparent group-hover:ring-blue-400
                                        transition duration-300">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <!-- Online dot -->
                            <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 rounded-full
                                         border-2 border-white dark:border-gray-900"></span>
                        </div>

                        <!-- Chevron -->
                        <svg id="profileChevron"
                             class="w-4 h-4 text-gray-400 transition-transform duration-300 hidden sm:block"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>

                    </button>

                    <!-- DROPDOWN MENU -->
                    <div id="profileDropdown"
                         class="absolute right-0 mt-2 w-64 origin-top-right
                                bg-white dark:bg-gray-800
                                rounded-2xl shadow-2xl
                                border border-gray-100 dark:border-gray-700
                                opacity-0 scale-95 pointer-events-none
                                transition-all duration-200 ease-out z-50">

                        <!-- HEADER -->
                        <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-3">

                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600
                                            text-white flex items-center justify-center font-bold text-lg shadow">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>

                                <div>
                                    <div class="font-bold text-gray-800 dark:text-white text-sm">
                                        {{ Auth::user()->name }}
                                    </div>
                                    <div class="text-xs text-gray-400 dark:text-gray-400 truncate max-w-[140px]">
                                        {{ Auth::user()->email }}
                                    </div>
                                    <span class="inline-block mt-1 px-2 py-0.5 text-xs rounded-full
                                                 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 font-semibold">
                                        {{ Auth::user()->roles->first()->name ?? 'User' }}
                                    </span>
                                </div>

                            </div>
                        </div>

                        <!-- MENU ITEMS -->
                        <div class="py-2">

                            <a href="{{ route('profile.edit') }}"
                               class="flex items-center gap-3 px-5 py-3
                                      text-sm text-gray-700 dark:text-gray-200
                                      hover:bg-gray-50 dark:hover:bg-gray-700
                                      transition duration-150">
                                <span class="text-lg">👤</span>
                                <span class="font-medium">Edit Profile</span>
                            </a>

                            <a href="{{ route('dashboard') }}"
                               class="flex items-center gap-3 px-5 py-3
                                      text-sm text-gray-700 dark:text-gray-200
                                      hover:bg-gray-50 dark:hover:bg-gray-700
                                      transition duration-150">
                                <span class="text-lg">📊</span>
                                <span class="font-medium">Dashboard</span>
                            </a>

                        </div>

                        <!-- DIVIDER -->
                        <div class="border-t border-gray-100 dark:border-gray-700"></div>

                        <!-- LOGOUT -->
                        <div class="py-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="w-full flex items-center gap-3 px-5 py-3
                                               text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20
                                               transition duration-150">
                                    <span class="text-lg">🚪</span>
                                    <span class="font-medium">Logout</span>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
                <!-- END PROFILE DROPDOWN -->

            </div>
        </div>
    </div>
</nav>

<!-- THEME + DROPDOWN SCRIPT -->
<script>
    function updateThemeIcon() {
        const icon = document.getElementById('theme-icon');
        if (!icon) return;
        icon.innerHTML = document.documentElement.classList.contains('dark') ? '☀️' : '🌙';
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

    function toggleProfileDropdown() {
        const dropdown = document.getElementById('profileDropdown');
        const chevron  = document.getElementById('profileChevron');
        const isOpen   = !dropdown.classList.contains('pointer-events-none');

        if (isOpen) {
            dropdown.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
            chevron?.classList.remove('rotate-180');
        } else {
            dropdown.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
            chevron?.classList.add('rotate-180');
        }
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function (e) {
        const wrapper  = document.getElementById('profileDropdownWrapper');
        const dropdown = document.getElementById('profileDropdown');
        const chevron  = document.getElementById('profileChevron');

        if (wrapper && !wrapper.contains(e.target)) {
            dropdown?.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
            chevron?.classList.remove('rotate-180');
        }
    });

    document.addEventListener('DOMContentLoaded', updateThemeIcon);
</script>