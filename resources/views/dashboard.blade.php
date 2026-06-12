<x-app-layout>

    {{-- SESSION ALERT --}}
    @if(session('error'))
        <div class="mb-6 flex items-center gap-3 px-6 py-4 rounded-2xl
                    bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800
                    text-red-700 dark:text-red-400 font-medium shadow">
            <span class="text-xl">🚫</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 px-6 py-4 rounded-2xl
                    bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800
                    text-green-700 dark:text-green-400 font-medium shadow">
            <span class="text-xl">✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="space-y-8">

        {{-- ROLE BANNER --}}
        @if($role === 'staff')
        <div class="flex items-center gap-4 px-6 py-4 rounded-2xl
                    bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700">
            <span class="text-3xl">👷</span>
            <div>
                <p class="font-bold text-green-800 dark:text-green-300">Mode Staff Gudang</p>
                <p class="text-sm text-green-600 dark:text-green-400">Kamu hanya bisa mencatat barang masuk & keluar. Hubungi manager untuk akses lainnya.</p>
            </div>
        </div>
        @elseif($role === 'manager')
        <div class="flex items-center gap-4 px-6 py-4 rounded-2xl
                    bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700">
            <span class="text-3xl">📋</span>
            <div>
                <p class="font-bold text-yellow-800 dark:text-yellow-300">Mode Manajer Gudang</p>
                <p class="text-sm text-yellow-600 dark:text-yellow-400">Kamu bisa kelola produk, stok, dan melihat laporan.</p>
            </div>
        </div>
        @endif


        {{-- ROLE BANNER --}}
        @if($role === 'staff')
        <div class="flex items-center gap-4 px-6 py-4 rounded-2xl
                    bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700">
            <span class="text-3xl">👷</span>
            <div>
                <p class="font-bold text-green-800 dark:text-green-300">Mode Staff Gudang</p>
                <p class="text-sm text-green-600 dark:text-green-400">Kamu bisa mencatat barang masuk & keluar. Hubungi manager untuk akses lainnya.</p>
            </div>
        </div>
        @elseif($role === 'manager')
        <div class="flex items-center gap-4 px-6 py-4 rounded-2xl
                    bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700">
            <span class="text-3xl">📋</span>
            <div>
                <p class="font-bold text-yellow-800 dark:text-yellow-300">Mode Manajer Gudang</p>
                <p class="text-sm text-yellow-600 dark:text-yellow-400">Kamu bisa kelola produk, stok, dan melihat laporan.</p>
            </div>
        </div>
        @endif

        {{-- HEADER --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

            <div>

                <h1 class="text-4xl font-black text-gray-800 dark:text-white leading-tight">
                    Dashboard Inventory
                </h1>

                <p class="mt-2 text-gray-500 dark:text-gray-400 text-lg">
                    Welcome back 👋 Monitor your inventory activity here.
                </p>

            </div>

            {{-- QUICK ACTION --}}
            <div class="flex flex-wrap gap-3">

                <a href="{{ route('products.create') }}"
                   class="px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700
                          text-white font-semibold shadow-lg hover:scale-105
                          transition duration-300">

                    + Add Product

                </a>

                @role('admin|manager')
                <a href="{{ route('reports.index') }}"
                   class="px-6 py-3 rounded-2xl bg-gray-900 hover:bg-black
                          text-white font-semibold shadow-lg hover:scale-105
                          transition duration-300">

                    📊 Export Report

                </a>
                @endrole

            </div>

        </div>

        {{-- STATS CARD --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

            {{-- PRODUCT --}}
            <div class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-500 to-blue-700 p-7 text-white shadow-2xl hover:-translate-y-2 transition duration-500">

                <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full"></div>

                <div class="relative z-10">

                    <div class="flex items-center justify-between">

                        <p class="text-sm font-medium opacity-80">
                            Total Product
                        </p>

                        <div class="text-3xl">
                            📦
                        </div>

                    </div>

                    <h2 class="mt-8 text-5xl font-black">
                        {{ $totalProducts }}
                    </h2>

                </div>

            </div>

            {{-- CATEGORY --}}
            <div class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-green-500 to-emerald-700 p-7 text-white shadow-2xl hover:-translate-y-2 transition duration-500">

                <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full"></div>

                <div class="relative z-10">

                    <div class="flex items-center justify-between">

                        <p class="text-sm font-medium opacity-80">
                            Total Category
                        </p>

                        <div class="text-3xl">
                            🗂
                        </div>

                    </div>

                    <h2 class="mt-8 text-5xl font-black">
                        {{ $totalCategories }}
                    </h2>

                </div>

            </div>

            {{-- SUPPLIER --}}
            <div class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-yellow-400 to-orange-600 p-7 text-white shadow-2xl hover:-translate-y-2 transition duration-500">

                <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full"></div>

                <div class="relative z-10">

                    <div class="flex items-center justify-between">

                        <p class="text-sm font-medium opacity-80">
                            Total Supplier
                        </p>

                        <div class="text-3xl">
                            🚚
                        </div>

                    </div>

                    <h2 class="mt-8 text-5xl font-black">
                        {{ $totalSuppliers }}
                    </h2>

                </div>

            </div>

            {{-- STOCK --}}
            <div class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-red-500 to-pink-700 p-7 text-white shadow-2xl hover:-translate-y-2 transition duration-500">

                <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full"></div>

                <div class="relative z-10">

                    <div class="flex items-center justify-between">

                        <p class="text-sm font-medium opacity-80">
                            Total Stock
                        </p>

                        <div class="text-3xl">
                            📊
                        </div>

                    </div>

                    <h2 class="mt-8 text-5xl font-black">
                        {{ $totalStock }}
                    </h2>

                </div>

            </div>

        </div>

        {{-- TODAY SUMMARY --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- STOCK IN --}}
            <div class="relative overflow-hidden rounded-3xl bg-white dark:bg-gray-800 p-8 shadow-2xl border border-gray-100 dark:border-gray-700">

                <div class="absolute top-0 right-0 w-40 h-40 bg-green-100 dark:bg-green-900 rounded-full blur-3xl opacity-40"></div>

                <div class="relative z-10 flex items-center justify-between">

                    <div>

                        <p class="text-gray-500 dark:text-gray-400 text-lg">
                            Barang Masuk Hari Ini
                        </p>

                        <h2 class="mt-4 text-6xl font-black text-green-600">
                            {{ $todayStockIn }}
                        </h2>

                    </div>

                    <div class="w-24 h-24 rounded-3xl bg-green-100 dark:bg-green-900 flex items-center justify-center text-5xl shadow-lg">
                        📥
                    </div>

                </div>

            </div>

            {{-- STOCK OUT --}}
            <div class="relative overflow-hidden rounded-3xl bg-white dark:bg-gray-800 p-8 shadow-2xl border border-gray-100 dark:border-gray-700">

                <div class="absolute top-0 right-0 w-40 h-40 bg-red-100 dark:bg-red-900 rounded-full blur-3xl opacity-40"></div>

                <div class="relative z-10 flex items-center justify-between">

                    <div>

                        <p class="text-gray-500 dark:text-gray-400 text-lg">
                            Barang Keluar Hari Ini
                        </p>

                        <h2 class="mt-4 text-6xl font-black text-red-600">
                            {{ $todayStockOut }}
                        </h2>

                    </div>

                    <div class="w-24 h-24 rounded-3xl bg-red-100 dark:bg-red-900 flex items-center justify-center text-5xl shadow-lg">
                        📤
                    </div>

                </div>

            </div>

        </div>

        {{-- QUICK STATS PREMIUM --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- STOCK IN BULAN INI --}}
            <div class="relative overflow-hidden rounded-3xl p-8
                        bg-white/70 dark:bg-gray-800/70
                        backdrop-blur-xl border border-white/20
                        shadow-2xl">

                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/20 rounded-full blur-3xl"></div>

                <div class="relative z-10">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-gray-500 dark:text-gray-400">
                                Stock In Bulan Ini
                            </p>

                            <h2 class="mt-3 text-4xl font-black text-gray-800 dark:text-white">
                                {{ $monthlyStockIn }} unit
                            </h2>

                        </div>

                        <div class="w-16 h-16 rounded-2xl bg-blue-100 dark:bg-blue-900
                                    flex items-center justify-center text-3xl">
                            📥
                        </div>

                    </div>

                    <div class="mt-6">

                        <div class="flex justify-between mb-2">

                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                vs rata-rata 3 bulan
                            </span>

                            <span class="text-sm font-bold text-blue-600">
                                {{ $monthlyStockInPct }}%
                            </span>

                        </div>

                        <div class="w-full h-3 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">

                            <div class="h-full bg-gradient-to-r from-blue-500 to-cyan-400 rounded-full transition-all duration-700"
                                 style="width: {{ $monthlyStockInPct }}%"></div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- BEST SELLER --}}
            <div class="relative overflow-hidden rounded-3xl p-8
                        bg-white/70 dark:bg-gray-800/70
                        backdrop-blur-xl border border-white/20
                        shadow-2xl">

                <div class="absolute top-0 right-0 w-32 h-32 bg-pink-500/20 rounded-full blur-3xl"></div>

                <div class="relative z-10">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-gray-500 dark:text-gray-400">
                                Best Seller
                            </p>

                            <h2 class="mt-3 text-2xl font-black text-gray-800 dark:text-white truncate max-w-[160px]">
                                {{ $bestSellerName }}
                            </h2>

                        </div>

                        <div class="w-16 h-16 rounded-2xl bg-pink-100 dark:bg-pink-900
                                    flex items-center justify-center text-3xl">
                            🔥
                        </div>

                    </div>

                    <div class="mt-6">

                        <div class="flex justify-between mb-2">

                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                Dominasi Stock Out
                            </span>

                            <span class="text-sm font-bold text-pink-600">
                                {{ $bestSellerPct }}%
                            </span>

                        </div>

                        <div class="w-full h-3 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">

                            <div class="h-full bg-gradient-to-r from-pink-500 to-rose-400 rounded-full transition-all duration-700"
                                 style="width: {{ $bestSellerPct }}%"></div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- PERFORMANCE --}}
            <div class="relative overflow-hidden rounded-3xl p-8
                        bg-white/70 dark:bg-gray-800/70
                        backdrop-blur-xl border border-white/20
                        shadow-2xl">

                <div class="absolute top-0 right-0 w-32 h-32 bg-green-500/20 rounded-full blur-3xl"></div>

                <div class="relative z-10">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-gray-500 dark:text-gray-400">
                                Stock Health
                            </p>

                            <h2 class="mt-3 text-4xl font-black text-gray-800 dark:text-white">
                                {{ $performanceLabel }}
                            </h2>

                        </div>

                        <div class="w-16 h-16 rounded-2xl bg-green-100 dark:bg-green-900
                                    flex items-center justify-center text-3xl">
                            🚀
                        </div>

                    </div>

                    <div class="mt-6">

                        <div class="flex justify-between mb-2">

                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                Produk aman (stok > 5)
                            </span>

                            <span class="text-sm font-bold text-green-600">
                                {{ $healthPct }}%
                            </span>

                        </div>

                        <div class="w-full h-3 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">

                            <div class="h-full bg-gradient-to-r from-green-500 to-emerald-400 rounded-full transition-all duration-700"
                                 style="width: {{ $healthPct }}%"></div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- REAL CHART.JS --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden">

            {{-- HEADER --}}
            <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                <div>
                    <h2 class="text-2xl font-black text-gray-800 dark:text-white">
                        📊 Inventory Analytics
                    </h2>
                    <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">
                        Stock In vs Stock Out — {{ now()->year }}
                    </p>
                </div>

                {{-- LEGEND --}}
                <div class="flex items-center gap-5 text-sm font-semibold">
                    <span class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-blue-500 inline-block"></span>
                        <span class="text-gray-600 dark:text-gray-300">Stock In</span>
                    </span>
                    <span class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-red-400 inline-block"></span>
                        <span class="text-gray-600 dark:text-gray-300">Stock Out</span>
                    </span>
                </div>

            </div>

            {{-- CANVAS --}}
            <div class="p-8">
                <div class="relative h-80">
                    <canvas id="stockChart"></canvas>
                </div>
            </div>

        </div>

        {{-- LOW STOCK --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden">

            <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700">

                <h2 class="text-3xl font-black text-red-600">
                    ⚠ Stock Menipis
                </h2>

                <p class="text-gray-500 dark:text-gray-400 mt-1">
                    Products that need immediate restock
                </p>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-50 dark:bg-gray-700">

                        <tr>

                            <th class="px-8 py-5 text-left text-sm font-bold text-gray-600 dark:text-gray-300">
                                Product
                            </th>

                            <th class="px-8 py-5 text-left text-sm font-bold text-gray-600 dark:text-gray-300">
                                Stock
                            </th>

                            <th class="px-8 py-5 text-left text-sm font-bold text-gray-600 dark:text-gray-300">
                                Status
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($lowStocks as $product)

                            <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-300">

                                <td class="px-8 py-6 font-semibold text-gray-800 dark:text-white">

                                    {{ $product->name }}

                                </td>

                                <td class="px-8 py-6">

                                    <span class="px-5 py-2 rounded-full bg-red-100 dark:bg-red-900 text-red-600 font-bold">

                                        {{ $product->stock }}

                                    </span>

                                </td>

                                <td class="px-8 py-6">

                                    <span class="px-5 py-2 rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-600 font-bold">

                                        Low Stock

                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="3"
                                    class="px-8 py-12 text-center text-gray-500 dark:text-gray-400 text-lg">

                                    No low stock items 🎉

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


{{-- CHART.JS SCRIPT --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function () {
    const labels  = @json($chartLabels);
    const dataIn  = @json($chartStockIn);
    const dataOut = @json($chartStockOut);

    const isDark = () => document.documentElement.classList.contains('dark');
    const gridColor  = () => isDark() ? 'rgba(255,255,255,0.07)' : 'rgba(0,0,0,0.06)';
    const labelColor = () => isDark() ? '#9ca3af' : '#6b7280';

    const ctx = document.getElementById('stockChart').getContext('2d');

    const gradIn = ctx.createLinearGradient(0, 0, 0, 300);
    gradIn.addColorStop(0, 'rgba(59,130,246,0.35)');
    gradIn.addColorStop(1, 'rgba(59,130,246,0)');

    const gradOut = ctx.createLinearGradient(0, 0, 0, 300);
    gradOut.addColorStop(0, 'rgba(248,113,113,0.35)');
    gradOut.addColorStop(1, 'rgba(248,113,113,0)');

    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels,
            datasets: [
                {
                    type: 'line',
                    label: 'Stock In',
                    data: dataIn,
                    borderColor: '#3b82f6',
                    backgroundColor: gradIn,
                    borderWidth: 3,
                    pointBackgroundColor: '#3b82f6',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.4,
                    fill: true,
                    order: 1,
                },
                {
                    type: 'bar',
                    label: 'Stock Out',
                    data: dataOut,
                    backgroundColor: 'rgba(248,113,113,0.75)',
                    borderRadius: 8,
                    borderSkipped: false,
                    order: 2,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: isDark() ? '#1f2937' : '#fff',
                    titleColor:      isDark() ? '#f9fafb' : '#111827',
                    bodyColor:       isDark() ? '#d1d5db' : '#374151',
                    borderColor:     isDark() ? '#374151' : '#e5e7eb',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 12,
                    callbacks: {
                        label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y} unit`,
                    },
                },
            },
            scales: {
                x: {
                    grid:  { color: gridColor() },
                    ticks: { color: labelColor(), font: { size: 12, weight: '600' } },
                },
                y: {
                    grid:  { color: gridColor() },
                    ticks: { color: labelColor(), font: { size: 12 }, callback: v => v + ' unit' },
                    beginAtZero: true,
                },
            },
        },
    });

    // Update chart colors on dark mode toggle
    const observer = new MutationObserver(() => {
        chart.options.scales.x.grid.color  = gridColor();
        chart.options.scales.x.ticks.color = labelColor();
        chart.options.scales.y.grid.color  = gridColor();
        chart.options.scales.y.ticks.color = labelColor();
        chart.update();
    });
    observer.observe(document.documentElement, { attributeFilter: ['class'] });
})();
</script>

</x-app-layout>