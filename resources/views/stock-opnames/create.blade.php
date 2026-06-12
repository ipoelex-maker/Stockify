<x-app-layout>
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-gray-800 dark:text-white">📦 Mulai Stock Opname</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Input stok fisik untuk setiap produk</p>
        </div>
        <a href="{{ route('stock-opnames.index') }}"
           class="px-4 py-2 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300
                  hover:bg-gray-200 dark:hover:bg-gray-600 transition text-sm font-medium">
            ← Kembali
        </a>
    </div>

    <form action="{{ route('stock-opnames.store') }}" method="POST">
        @csrf

        {{-- INFO OPNAME --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 mb-6">
            <h2 class="font-bold text-gray-800 dark:text-white mb-4">Informasi Opname</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Tanggal Opname</label>
                    <input type="date" name="date" value="{{ date('Y-m-d') }}"
                           class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                  bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                  p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Catatan (opsional)</label>
                    <input type="text" name="notes" placeholder="cth: Opname akhir bulan"
                           class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                  bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                  placeholder-gray-400 dark:placeholder-gray-500
                                  p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
            </div>

            {{-- APPLY ADJUSTMENT --}}
            <div class="mt-4 flex items-start gap-3 p-4 rounded-xl bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800">
                <input type="checkbox" name="apply_adjustment" id="apply_adjustment" value="1"
                       class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <div>
                    <label for="apply_adjustment" class="font-semibold text-yellow-800 dark:text-yellow-300 cursor-pointer text-sm">
                        ⚠️ Terapkan penyesuaian stok otomatis
                    </label>
                    <p class="text-xs text-yellow-600 dark:text-yellow-400 mt-0.5">
                        Jika dicentang, stok sistem akan diupdate mengikuti stok fisik yang kamu input.
                    </p>
                </div>
            </div>
        </div>

        {{-- PRODUCT TABLE --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                <h2 class="font-bold text-gray-800 dark:text-white">Daftar Produk</h2>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Input jumlah stok fisik yang kamu hitung</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                            <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Produk</th>
                            <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Kategori</th>
                            <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Stok Sistem</th>
                            <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Stok Fisik</th>
                            <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Selisih</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                        @foreach($products as $product)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition" id="row-{{ $product->id }}">
                            <td class="px-6 py-4 font-semibold text-gray-800 dark:text-white">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $product->category->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-bold
                                    {{ $product->stock <= 5
                                        ? 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400'
                                        : 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400' }}">
                                    {{ $product->stock }} unit
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <input type="number"
                                       name="physical_stock[{{ $product->id }}]"
                                       value="{{ $product->stock }}"
                                       min="0"
                                       onchange="calcDiff({{ $product->id }}, {{ $product->stock }}, this.value)"
                                       class="w-24 text-center rounded-xl border border-gray-200 dark:border-gray-600
                                              bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                              p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span id="diff-{{ $product->id }}"
                                      class="px-3 py-1 rounded-full text-xs font-bold
                                             bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400">
                                    0
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- SUBMIT --}}
        <div class="flex justify-end">
            <button type="submit"
                    class="px-10 py-3 rounded-xl bg-blue-600 hover:bg-blue-700
                           text-white font-bold text-sm shadow-lg transition-all duration-200">
                💾 Simpan Hasil Opname
            </button>
        </div>

    </form>
</div>

<script>
function calcDiff(productId, systemStock, physicalStock) {
    const diff    = parseInt(physicalStock) - parseInt(systemStock);
    const el      = document.getElementById('diff-' + productId);
    el.textContent = (diff > 0 ? '+' : '') + diff;

    el.className = 'px-3 py-1 rounded-full text-xs font-bold ';
    if (diff > 0) {
        el.className += 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400';
    } else if (diff < 0) {
        el.className += 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400';
    } else {
        el.className += 'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400';
    }
}
</script>
</x-app-layout>