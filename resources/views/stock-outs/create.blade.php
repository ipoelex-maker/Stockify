<x-app-layout>

    <div class="max-w-2xl mx-auto space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-black text-gray-800 dark:text-white">📤 Tambah Barang Keluar</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Catat pengeluaran barang</p>
            </div>
            <a href="{{ route('stock-outs.index') }}"
               class="px-4 py-2 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300
                      hover:bg-gray-200 dark:hover:bg-gray-600 transition text-sm font-medium">
                ← Kembali
            </a>
        </div>

        {{-- ERROR ALERT --}}
        @if(session('error'))
            <div class="flex items-start gap-3 px-5 py-4 rounded-2xl
                        bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800
                        text-red-700 dark:text-red-400 font-medium">
                <span class="text-xl mt-0.5">🚫</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- SUCCESS ALERT --}}
        @if(session('success'))
            <div class="flex items-start gap-3 px-5 py-4 rounded-2xl
                        bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800
                        text-green-700 dark:text-green-400 font-medium">
                <span class="text-xl mt-0.5">✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- FORM --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8">
            <form action="{{ route('stock-outs.store') }}" method="POST" class="space-y-5">
                @csrf

                {{-- PRODUCT --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                        Produk
                    </label>
                    <select name="product_id" id="productSelect" onchange="updateMinInfo(this)"
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                   bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                   p-3 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                        <option value="">— Pilih Produk —</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}"
                                    data-stock="{{ $product->stock }}"
                                    data-min="{{ $product->min_stock ?? 0 }}"
                                    {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} (Stok: {{ $product->stock }})
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    {{-- INFO STOK & MIN STOK --}}
                    <div id="stockInfo" class="hidden mt-2 flex items-center gap-4 text-xs">
                        <span class="px-3 py-1 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold">
                            Stok saat ini: <span id="currentStock">0</span> unit
                        </span>
                        <span class="px-3 py-1 rounded-full bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 font-semibold">
                            Min stok: <span id="minStock">0</span> unit
                        </span>
                        <span class="px-3 py-1 rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 font-semibold">
                            Maks keluar: <span id="maxOut">0</span> unit
                        </span>
                    </div>
                </div>

                {{-- QTY + DATE --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                            Jumlah (Qty)
                        </label>
                        <input type="number" name="qty" id="qtyInput"
                               value="{{ old('qty') }}" min="1"
                               placeholder="cth: 5"
                               oninput="validateQty(this)"
                               class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                      bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                      placeholder-gray-400 dark:placeholder-gray-500
                                      p-3 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                        @error('qty')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p id="qtyWarning" class="hidden text-red-500 text-xs mt-1"></p>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                            Tanggal
                        </label>
                        <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}"
                               class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                      bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                      p-3 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                        @error('date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- NOTE --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                        Catatan (opsional)
                    </label>
                    <textarea name="note" rows="3"
                              placeholder="cth: Pengiriman ke pelanggan A"
                              class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                     bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                     placeholder-gray-400 dark:placeholder-gray-500
                                     p-3 focus:outline-none focus:ring-2 focus:ring-red-500 transition">{{ old('note') }}</textarea>
                </div>

                {{-- SUBMIT --}}
                <div class="pt-2">
                    <button type="submit" id="submitBtn"
                            class="px-8 py-3 rounded-xl bg-red-500 hover:bg-red-600
                                   text-white font-bold text-sm shadow-lg transition-all duration-200">
                        💾 Simpan Barang Keluar
                    </button>
                </div>

            </form>
        </div>

    </div>

<script>
    let currentStock = 0;
    let minStock     = 0;

    function updateMinInfo(select) {
        const option = select.options[select.selectedIndex];
        if (!option.value) {
            document.getElementById('stockInfo').classList.add('hidden');
            return;
        }

        currentStock = parseInt(option.dataset.stock) || 0;
        minStock     = parseInt(option.dataset.min)   || 0;
        const maxOut = currentStock - minStock;

        document.getElementById('currentStock').textContent = currentStock;
        document.getElementById('minStock').textContent     = minStock;
        document.getElementById('maxOut').textContent       = Math.max(0, maxOut);
        document.getElementById('stockInfo').classList.remove('hidden');

        validateQty(document.getElementById('qtyInput'));
    }

    function validateQty(input) {
        const qty     = parseInt(input.value) || 0;
        const maxOut  = currentStock - minStock;
        const warning = document.getElementById('qtyWarning');
        const btn     = document.getElementById('submitBtn');

        if (qty > maxOut && currentStock > 0) {
            warning.textContent = `⚠️ Melebihi batas! Maksimal ${Math.max(0, maxOut)} unit (stok min: ${minStock}).`;
            warning.classList.remove('hidden');
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            warning.classList.add('hidden');
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }
</script>

</x-app-layout>