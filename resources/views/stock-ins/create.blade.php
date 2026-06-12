<x-app-layout>

    <div class="max-w-2xl mx-auto space-y-6">

        {{-- HEADER --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-black text-gray-800 dark:text-white">📥 Tambah Barang Masuk</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Catat penerimaan barang baru</p>
            </div>
            <a href="{{ route('stock-ins.index') }}"
               class="px-4 py-2 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300
                      hover:bg-gray-200 dark:hover:bg-gray-600 transition text-sm font-medium">
                ← Kembali
            </a>
        </div>

        {{-- FORM --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8">
            <form action="{{ route('stock-ins.store') }}" method="POST" class="space-y-5">
                @csrf

                {{-- PRODUCT --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                        Produk
                    </label>
                    <select name="product_id"
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                   bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                   p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="">— Pilih Produk —</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} (Stok: {{ $product->stock }})
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- QTY + DATE --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                            Jumlah (Qty)
                        </label>
                        <input type="number" name="qty" value="{{ old('qty') }}" min="1"
                               placeholder="cth: 10"
                               class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                      bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                      placeholder-gray-400 dark:placeholder-gray-500
                                      p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        @error('qty')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                            Tanggal
                        </label>
                        <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}"
                               class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                      bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                      p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
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
                              placeholder="cth: Pengiriman dari supplier X"
                              class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                     bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                     placeholder-gray-400 dark:placeholder-gray-500
                                     p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">{{ old('note') }}</textarea>
                </div>

                {{-- SUBMIT --}}
                <div class="pt-2">
                    <button type="submit"
                            class="px-8 py-3 rounded-xl bg-blue-600 hover:bg-blue-700
                                   text-white font-bold text-sm shadow-lg transition-all duration-200">
                        💾 Simpan Barang Masuk
                    </button>
                </div>

            </form>
        </div>

    </div>

</x-app-layout>