<x-app-layout>

    <div class="max-w-3xl mx-auto space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-black text-gray-800 dark:text-white">Tambah Produk</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Isi data produk baru di bawah ini</p>
            </div>
            <a href="{{ route('products.index') }}"
               class="px-4 py-2 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300
                      hover:bg-gray-200 dark:hover:bg-gray-600 transition text-sm font-medium">
                ← Kembali
            </a>
        </div>

        {{-- SERVER ERROR --}}
        @if(session('error'))
            <div class="flex items-start gap-3 px-5 py-4 rounded-2xl
                        bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800
                        text-red-700 dark:text-red-400 font-medium">
                <span class="text-xl">🚫</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8">
            <form action="{{ route('products.store') }}" method="POST"
                  enctype="multipart/form-data" class="space-y-5" id="productForm">
                @csrf

                {{-- CATEGORY --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Kategori</label>
                    <select name="category_id"
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                   bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                   p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="">— Pilih Kategori —</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- SUPPLIER --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Supplier</label>
                    <select name="supplier_id"
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                   bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                   p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="">— Pilih Supplier —</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('supplier_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- NAME + SKU --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Nama Produk</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               placeholder="cth: Laptop Asus VivoBook"
                               class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                      bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                      placeholder-gray-400 dark:placeholder-gray-500
                                      p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">SKU</label>
                        <input type="text" name="sku" value="{{ old('sku') }}"
                               placeholder="cth: ASUS-VB-001"
                               class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                      bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                      placeholder-gray-400 dark:placeholder-gray-500
                                      p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        @error('sku')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- HARGA --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Harga Beli (Rp)</label>
                        <input type="number" name="buy_price" id="buy_price"
                               value="{{ old('buy_price') }}" placeholder="0" min="0"
                               oninput="checkHarga()"
                               class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                      bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                      placeholder-gray-400 dark:placeholder-gray-500
                                      p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        @error('buy_price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Harga Jual (Rp)</label>
                        <input type="number" name="sell_price" id="sell_price"
                               value="{{ old('sell_price') }}" placeholder="0" min="0"
                               oninput="checkHarga()"
                               class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                      bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                      placeholder-gray-400 dark:placeholder-gray-500
                                      p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        @error('sell_price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- WARNING HARGA --}}
                <div id="warningHarga" class="hidden flex items-start gap-3 px-4 py-3 rounded-xl
                                               bg-yellow-50 dark:bg-yellow-900/20
                                               border border-yellow-300 dark:border-yellow-700
                                               text-yellow-800 dark:text-yellow-300 text-sm">
                    <span class="text-lg">⚠️</span>
                    <div>
                        <p class="font-bold">Harga jual lebih kecil dari harga beli!</p>
                        <p class="text-xs mt-0.5 text-yellow-600 dark:text-yellow-400">
                            Kamu akan <span class="font-bold text-red-500">rugi</span> setiap kali menjual produk ini.
                            Pastikan harga jual lebih besar dari harga beli.
                        </p>
                    </div>
                </div>

                {{-- STOK + MIN STOK --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Stok Awal</label>
                        <input type="number" name="stock" id="stock"
                               value="{{ old('stock', 0) }}" min="0"
                               oninput="checkStok()"
                               class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                      bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                      p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                            Min Stok ⚠️
                            <span class="text-gray-400 font-normal text-xs">(batas peringatan)</span>
                        </label>
                        <input type="number" name="min_stock" id="min_stock"
                               value="{{ old('min_stock', 5) }}" min="0"
                               oninput="checkStok()"
                               class="w-full rounded-xl border border-orange-200 dark:border-orange-600
                                      bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                      p-3 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                        @error('min_stock')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- WARNING MIN STOK --}}
                <div id="warningStok" class="hidden flex items-start gap-3 px-4 py-3 rounded-xl
                                              bg-orange-50 dark:bg-orange-900/20
                                              border border-orange-300 dark:border-orange-700
                                              text-orange-800 dark:text-orange-300 text-sm">
                    <span class="text-lg">📦</span>
                    <div>
                        <p class="font-bold">Stok awal di bawah batas minimum!</p>
                        <p class="text-xs mt-0.5 text-orange-600 dark:text-orange-400">
                            Produk ini akan langsung muncul sebagai <span class="font-bold">stok menipis</span> di dashboard dan notifikasi.
                        </p>
                    </div>
                </div>

                {{-- DESCRIPTION --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Deskripsi</label>
                    <textarea name="description" rows="3"
                              placeholder="Deskripsi produk (opsional)"
                              class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                     bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                     placeholder-gray-400 dark:placeholder-gray-500
                                     p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">{{ old('description') }}</textarea>
                </div>

                {{-- IMAGE --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Foto Produk (opsional)</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                  bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                  p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition
                                  file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0
                                  file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900 dark:file:text-blue-300
                                  file:font-medium file:text-sm cursor-pointer">
                </div>

                {{-- SUBMIT --}}
                <div class="pt-2">
                    <button type="submit"
                            class="px-8 py-3 rounded-xl bg-blue-600 hover:bg-blue-700
                                   text-white font-bold text-sm shadow-lg transition-all duration-200">
                        💾 Simpan Produk
                    </button>
                </div>

            </form>
        </div>

    </div>

<script>
function checkHarga() {
    const beli = parseFloat(document.getElementById('buy_price').value) || 0;
    const jual = parseFloat(document.getElementById('sell_price').value) || 0;
    const warn = document.getElementById('warningHarga');

    if (beli > 0 && jual > 0 && jual < beli) {
        warn.classList.remove('hidden');
    } else {
        warn.classList.add('hidden');
    }
}

function checkStok() {
    const stok = parseInt(document.getElementById('stock').value) || 0;
    const min  = parseInt(document.getElementById('min_stock').value) || 0;
    const warn = document.getElementById('warningStok');

    if (min > 0 && stok < min) {
        warn.classList.remove('hidden');
    } else {
        warn.classList.add('hidden');
    }
}
</script>

</x-app-layout>