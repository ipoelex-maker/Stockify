@php
    $lowStockProducts = \App\Models\Product::where('stock', '<=', 5)->get();
    $todayStockIn     = \App\Models\StockIn::whereDate('date', today())->count();
    $todayStockOut    = \App\Models\StockOut::whereDate('date', today())->count();
    $notifCount       = $lowStockProducts->count() + ($todayStockIn > 0 ? 1 : 0) + ($todayStockOut > 0 ? 1 : 0);
@endphp

<!-- SIDEBAR -->
<aside id="sidebar"
       class="w-64 flex-shrink-0
              text-gray-800 dark:text-white
              flex flex-col justify-between
              fixed lg:relative
              top-0 left-0 h-full z-40
              transform -translate-x-full lg:translate-x-0
              transition-transform duration-300 ease-in-out
              lg:p-3 lg:bg-transparent">

    {{-- GLASS PANEL --}}
    <div class="flex flex-col h-full
                bg-white dark:bg-gray-900/80
                lg:bg-white/70 lg:dark:bg-gray-900/60
                lg:backdrop-blur-xl
                lg:rounded-3xl
                lg:shadow-2xl lg:shadow-black/10 dark:lg:shadow-black/40
                lg:border lg:border-white/40 dark:lg:border-gray-700/50
                overflow-hidden">

    <!-- TOP -->
    <div class="flex-1 overflow-y-auto min-h-0 scrollbar-thin">

        <!-- LOGO + CLOSE (mobile) -->
        <div class="p-5 border-b border-gray-100/50 dark:border-gray-700/50 flex items-center justify-between">
            <span class="text-2xl font-black bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Stockify</span>
            <button onclick="closeSidebar()"
                    class="lg:hidden p-1 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-200
                           hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- MENU -->
        <nav class="mt-3 space-y-0.5 px-3">

            <!-- DASHBOARD -->
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 py-2.5 px-4 rounded-2xl hover:bg-blue-50/80 dark:hover:bg-gray-700/60 transition {{ request()->routeIs('dashboard') ? 'bg-blue-100/80 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold shadow-sm' : '' }}">
                <span class="text-lg">🏠</span>
                <span>Dashboard</span>
            </a>

            <!-- ADMIN ONLY -->
            @role('admin')
                <a href="{{ route('categories.index') }}"
                   class="flex items-center gap-3 py-2.5 px-4 rounded-2xl hover:bg-blue-50/80 dark:hover:bg-gray-700/60 transition {{ request()->routeIs('categories.*') ? 'bg-blue-100/80 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold shadow-sm' : '' }}">
                    <span class="text-lg">🗂️</span>
                    <span>Categories</span>
                </a>

                <a href="{{ route('suppliers.index') }}"
                   class="flex items-center gap-3 py-2.5 px-4 rounded-2xl hover:bg-blue-50/80 dark:hover:bg-gray-700/60 transition {{ request()->routeIs('suppliers.*') ? 'bg-blue-100/80 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold shadow-sm' : '' }}">
                    <span class="text-lg">🚚</span>
                    <span>Suppliers</span>
                </a>

                <a href="{{ route('users.index') }}"
                   class="flex items-center gap-3 py-2.5 px-4 rounded-2xl hover:bg-blue-50/80 dark:hover:bg-gray-700/60 transition {{ request()->routeIs('users.*') ? 'bg-blue-100/80 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold shadow-sm' : '' }}">
                    <span class="text-lg">👥</span>
                    <span>Users</span>
                </a>
            @endrole

            <!-- ADMIN + MANAGER -->
            @role('admin|manager')
                <a href="{{ route('reports.index') }}"
                   class="flex items-center gap-3 py-2.5 px-4 rounded-2xl hover:bg-blue-50/80 dark:hover:bg-gray-700/60 transition {{ request()->routeIs('reports.*') ? 'bg-blue-100/80 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold shadow-sm' : '' }}">
                    <span class="text-lg">📊</span>
                    <span>Laporan</span>
                </a>

                <a href="{{ route('stock-opnames.index') }}"
                   class="flex items-center gap-3 py-2.5 px-4 rounded-2xl hover:bg-blue-50/80 dark:hover:bg-gray-700/60 transition {{ request()->routeIs('stock-opnames.*') ? 'bg-blue-100/80 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold shadow-sm' : '' }}">
                    <span class="text-lg">📦</span>
                    <span>Stock Opname</span>
                </a>

                <a href="{{ route('products.index') }}" 
                   class="flex items-center gap-3 py-2.5 px-4 rounded-2xl hover:bg-blue-50/80 dark:hover:bg-gray-700/60 transition {{ request()->routeIs('products.*') ? 'bg-blue-100/80 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold shadow-sm' : '' }}">
                    <span class="text-lg">📦</span>
                    <span>Products</span>
                </a>
            @endrole

            <!-- ALL ROLE -->
            @role('admin|manager|staff')
                <a href="{{ route('stock-ins.index') }}"
                   class="flex items-center gap-3 py-2.5 px-4 rounded-2xl hover:bg-blue-50/80 dark:hover:bg-gray-700/60 transition {{ request()->routeIs('stock-ins.*') ? 'bg-blue-100/80 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold shadow-sm' : '' }}">
                    <span class="text-lg">📥</span>
                    <span>Stock In</span>
                </a>

                <a href="{{ route('stock-outs.index') }}"
                   class="flex items-center gap-3 py-2.5 px-4 rounded-2xl hover:bg-blue-50/80 dark:hover:bg-gray-700/60 transition {{ request()->routeIs('stock-outs.*') ? 'bg-blue-100/80 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold shadow-sm' : '' }}">
                    <span class="text-lg">📤</span>
                    <span>Stock Out</span>
                </a>
            @endrole

        </nav>
    </div>

    <!-- USER -->
    <div class="flex-shrink-0 p-4 border-t border-gray-100/50 dark:border-gray-700/50">

        {{-- NOTIFICATION BELL --}}
        <div class="relative mb-4" id="notifWrapper">

            <button onclick="toggleNotif()"
                    class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl
                           bg-gray-100 dark:bg-gray-800
                           hover:bg-gray-200 dark:hover:bg-gray-700
                           transition duration-200">
                <div class="flex items-center gap-2">
                    <span class="text-lg">🔔</span>
                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">Notifikasi</span>
                </div>
                @if($notifCount > 0)
                    <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-red-500 text-white">
                        {{ $notifCount }}
                    </span>
                @endif
            </button>

            {{-- DROPDOWN --}}
            <div id="notifDropdown"
                 class="absolute bottom-full mb-2 left-0 right-0
                        bg-white dark:bg-gray-800
                        rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700
                        opacity-0 scale-95 pointer-events-none
                        transition-all duration-200 origin-bottom
                        max-h-80 overflow-y-auto z-50">

                <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                    <p class="font-bold text-sm text-gray-800 dark:text-white">Notifikasi</p>
                </div>

                <div class="py-2">

                    {{-- LOW STOCK --}}
                    @forelse($lowStockProducts as $p)
                        <div class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <span class="text-lg mt-0.5">⚠️</span>
                            <div>
                                <p class="text-sm font-semibold text-gray-800 dark:text-white">Stok Menipis</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $p->name }} — sisa {{ $p->stock }} unit
                                </p>
                            </div>
                        </div>
                    @empty
                    @endforelse

                    {{-- TODAY STOCK IN --}}
                    @if($todayStockIn > 0)
                        <div class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <span class="text-lg mt-0.5">📥</span>
                            <div>
                                <p class="text-sm font-semibold text-gray-800 dark:text-white">Barang Masuk Hari Ini</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $todayStockIn }} transaksi masuk hari ini
                                </p>
                            </div>
                        </div>
                    @endif

                    {{-- TODAY STOCK OUT --}}
                    @if($todayStockOut > 0)
                        <div class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <span class="text-lg mt-0.5">📤</span>
                            <div>
                                <p class="text-sm font-semibold text-gray-800 dark:text-white">Barang Keluar Hari Ini</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $todayStockOut }} transaksi keluar hari ini
                                </p>
                            </div>
                        </div>
                    @endif

                    {{-- EMPTY --}}
                    @if($notifCount === 0)
                        <div class="px-4 py-8 text-center text-gray-400 dark:text-gray-500">
                            <div class="text-3xl mb-2">✅</div>
                            <p class="text-sm">Semua aman, tidak ada notifikasi</p>
                        </div>
                    @endif

                </div>

            </div>

        </div>

        <div class="mb-4">
            <div class="font-bold">
                {{ Auth::user()->name }}
            </div>

            <div class="text-sm text-gray-500 dark:text-gray-400">
                {{ Auth::user()->email }}
            </div>

            <div class="mt-2 inline-block bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-200 text-xs px-3 py-1 rounded-full">
                {{ Auth::user()->roles->first()->name ?? 'User' }}
            </div>
        </div>

        <!-- LOGOUT -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full bg-gradient-to-r from-red-500 to-rose-600
                           hover:from-red-600 hover:to-rose-700
                           text-white py-2.5 rounded-2xl
                           font-semibold text-sm shadow-lg
                           transition-all duration-200">
                🚪 Logout
            </button>
        </form>
    </div>


<style>
.scrollbar-thin::-webkit-scrollbar {
    width: 4px;
}
.scrollbar-thin::-webkit-scrollbar-track {
    background: transparent;
}
.scrollbar-thin::-webkit-scrollbar-thumb {
    background: rgba(148, 163, 184, 0.3);
    border-radius: 99px;
}
.scrollbar-thin::-webkit-scrollbar-thumb:hover {
    background: rgba(148, 163, 184, 0.6);
}
/* Firefox */
.scrollbar-thin {
    scrollbar-width: thin;
    scrollbar-color: rgba(148, 163, 184, 0.3) transparent;
}
</style>

<script>
function toggleNotif() {
    const dropdown = document.getElementById('notifDropdown');
    const isOpen   = !dropdown.classList.contains('pointer-events-none');
    if (isOpen) {
        dropdown.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
    } else {
        dropdown.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
    }
}

document.addEventListener('click', function(e) {
    const wrapper  = document.getElementById('notifWrapper');
    const dropdown = document.getElementById('notifDropdown');
    if (wrapper && !wrapper.contains(e.target)) {
        dropdown?.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
    }
});
</script>
    </div>
</aside>
