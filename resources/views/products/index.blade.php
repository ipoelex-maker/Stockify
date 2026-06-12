<x-app-layout>

<div class="space-y-6">

    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-black text-gray-800 dark:text-white">📦 Products</h1>
            <p class="text-gray-500 dark:text-gray-400">Kelola semua produk inventori</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('products.import.form') }}"
               class="px-4 py-2.5 rounded-xl bg-green-600 hover:bg-green-700 text-white font-bold text-sm shadow-lg transition">
                📥 Import CSV
            </a>
            <a href="{{ route('products.create') }}"
               class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-lg transition">
                + Tambah Produk
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="flex items-center gap-3 px-5 py-4 rounded-2xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 font-medium">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden">

        {{-- SEARCH --}}
        <div class="p-6 border-b border-gray-100 dark:border-gray-700">
            <input type="text" id="searchInput" placeholder="🔍 Cari produk..."
                   oninput="searchProducts()"
                   class="w-full md:w-1/3 rounded-xl border border-gray-200 dark:border-gray-600
                          bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                          placeholder-gray-400 dark:placeholder-gray-500
                          px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="productTable">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Produk</th>
                        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Kategori</th>
                        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Supplier</th>
                        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Stok</th>
                        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Min Stok</th>
                        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Harga Jual</th>
                        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700" id="productBody">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition product-row">

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         class="w-12 h-12 rounded-xl object-cover flex-shrink-0"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-100 to-indigo-200 dark:from-blue-900 dark:to-indigo-800 flex items-center justify-center text-xl flex-shrink-0" style="display:none">📦</div>
                                @else
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-100 to-indigo-200 dark:from-blue-900 dark:to-indigo-800 flex items-center justify-center text-xl flex-shrink-0">📦</div>
                                @endif
                                <div>
                                    <div class="font-semibold text-gray-800 dark:text-white product-name">{{ $product->name }}</div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500">{{ $product->sku }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $product->category->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $product->supplier->name ?? '-' }}</td>

                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold
                                {{ $product->stock <= ($product->min_stock ?? 5)
                                    ? 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400'
                                    : 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400' }}">
                                {{ $product->stock }} unit {{ $product->stock <= ($product->min_stock ?? 5) ? '⚠️' : '' }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-gray-500 dark:text-gray-400 text-sm">
                            {{ $product->min_stock ?? 5 }} unit
                        </td>

                        <td class="px-6 py-4 font-semibold text-gray-800 dark:text-white">
                            Rp {{ number_format($product->sell_price, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('products.edit', $product->id) }}"
                                   class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 hover:bg-yellow-200 transition">
                                    Edit
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus produk {{ addslashes($product->name) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 hover:bg-red-200 transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center text-gray-400 dark:text-gray-500">
                            <div class="text-4xl mb-3">📭</div>
                            <div class="font-medium">Belum ada produk</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div id="noResult" class="hidden px-6 py-16 text-center text-gray-400 dark:text-gray-500">
                <div class="text-4xl mb-3">🔍</div>
                <div class="font-medium">Produk tidak ditemukan</div>
            </div>
        </div>
    </div>
</div>

<script>
function searchProducts() {
    const input    = document.getElementById('searchInput').value.toLowerCase();
    const rows     = document.querySelectorAll('.product-row');
    const noResult = document.getElementById('noResult');
    let found = 0;
    rows.forEach(row => {
        const name = row.querySelector('.product-name')?.textContent.toLowerCase() || '';
        if (name.includes(input)) { row.style.display = ''; found++; }
        else row.style.display = 'none';
    });
    noResult.classList.toggle('hidden', found > 0);
}
</script>

</x-app-layout>