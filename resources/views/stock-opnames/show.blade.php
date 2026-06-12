<x-app-layout>
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-gray-800 dark:text-white">📦 Detail Opname</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">
                {{ \Carbon\Carbon::parse($stockOpname->date)->format('d M Y') }}
                — oleh {{ $stockOpname->creator->name ?? '-' }}
            </p>
        </div>
        <a href="{{ route('stock-opnames.index') }}"
           class="px-4 py-2 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300
                  hover:bg-gray-200 dark:hover:bg-gray-600 transition text-sm font-medium">
            ← Kembali
        </a>
    </div>

    {{-- SUMMARY --}}
    @php
        $totalItems  = $stockOpname->items->count();
        $totalPlus   = $stockOpname->items->where('difference', '>', 0)->count();
        $totalMinus  = $stockOpname->items->where('difference', '<', 0)->count();
        $totalMatch  = $stockOpname->items->where('difference', 0)->count();
    @endphp

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-5 text-center">
            <p class="text-3xl font-black text-gray-800 dark:text-white">{{ $totalItems }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Total Produk</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-5 text-center">
            <p class="text-3xl font-black text-green-600">{{ $totalMatch }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">✅ Sesuai</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-5 text-center">
            <p class="text-3xl font-black text-blue-600">{{ $totalPlus }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">📈 Lebih</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-5 text-center">
            <p class="text-3xl font-black text-red-500">{{ $totalMinus }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">📉 Kurang</p>
        </div>
    </div>

    {{-- NOTES --}}
    @if($stockOpname->notes)
        <div class="px-5 py-4 rounded-2xl bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 text-blue-700 dark:text-blue-300 text-sm">
            📝 {{ $stockOpname->notes }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">#</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Produk</th>
                    <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Stok Sistem</th>
                    <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Stok Fisik</th>
                    <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Selisih</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                @foreach($stockOpname->items as $item)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                    <td class="px-6 py-4 text-gray-400 dark:text-gray-500">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 font-semibold text-gray-800 dark:text-white">
                        {{ $item->product->name ?? '-' }}
                    </td>
                    <td class="px-6 py-4 text-center text-gray-600 dark:text-gray-300">{{ $item->system_stock }}</td>
                    <td class="px-6 py-4 text-center text-gray-600 dark:text-gray-300">{{ $item->physical_stock }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-bold
                            @if($item->difference > 0) bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400
                            @elseif($item->difference < 0) bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400
                            @else bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400
                            @endif">
                            {{ $item->difference > 0 ? '+' : '' }}{{ $item->difference }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
</x-app-layout>