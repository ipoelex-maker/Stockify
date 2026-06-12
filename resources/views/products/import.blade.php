<x-app-layout>

<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-gray-800 dark:text-white">📥 Import Produk</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Upload file CSV untuk import produk massal</p>
        </div>
        <a href="{{ route('products.index') }}"
           class="px-4 py-2 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300
                  hover:bg-gray-200 dark:hover:bg-gray-600 transition text-sm font-medium">
            ← Kembali
        </a>
    </div>

    {{-- DOWNLOAD TEMPLATE --}}
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-2xl p-5">
        <div class="flex items-start gap-4">
            <span class="text-3xl">📋</span>
            <div class="flex-1">
                <p class="font-bold text-blue-800 dark:text-blue-300">Download Template CSV dulu!</p>
                <p class="text-sm text-blue-600 dark:text-blue-400 mt-1">
                    Gunakan template ini agar format file sesuai. Isi data produk di template, lalu upload.
                </p>
                <a href="{{ route('products.template') }}"
                   class="inline-flex items-center gap-2 mt-3 px-4 py-2 rounded-xl
                          bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm transition">
                    ⬇️ Download Template CSV
                </a>
            </div>
        </div>
    </div>

    {{-- FORMAT INFO --}}
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6">
        <h2 class="font-bold text-gray-800 dark:text-white mb-3">Format Kolom CSV</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700">
                        <th class="text-left py-2 px-3 text-gray-500 dark:text-gray-400">#</th>
                        <th class="text-left py-2 px-3 text-gray-500 dark:text-gray-400">Kolom</th>
                        <th class="text-left py-2 px-3 text-gray-500 dark:text-gray-400">Contoh</th>
                        <th class="text-left py-2 px-3 text-gray-500 dark:text-gray-400">Wajib</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                    @foreach([
                        ['1','Nama Produk','Laptop Asus VivoBook','✅'],
                        ['2','SKU','ASUS-VB-001','✅'],
                        ['3','Kategori','Elektronik','✅ (auto dibuat)'],
                        ['4','Supplier','PT Sumber Makmur','✅ (auto dibuat)'],
                        ['5','Harga Beli','5000000','✅'],
                        ['6','Harga Jual','6500000','✅'],
                        ['7','Stok Minimum','5','✅'],
                        ['8','Stok Awal','10','Opsional (default 0)'],
                    ] as $col)
                    <tr>
                        <td class="py-2 px-3 text-gray-400 dark:text-gray-500">{{ $col[0] }}</td>
                        <td class="py-2 px-3 font-semibold text-gray-800 dark:text-white">{{ $col[1] }}</td>
                        <td class="py-2 px-3 text-gray-500 dark:text-gray-400">{{ $col[2] }}</td>
                        <td class="py-2 px-3 text-gray-500 dark:text-gray-400">{{ $col[3] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- UPLOAD FORM --}}
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8">
        <h2 class="font-bold text-gray-800 dark:text-white mb-5">Upload File CSV</h2>

        @if(session('import_errors'))
            <div class="mb-4 p-4 rounded-xl bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800">
                <p class="font-semibold text-yellow-800 dark:text-yellow-300 mb-2">⚠️ Beberapa baris dilewati:</p>
                <ul class="text-xs text-yellow-700 dark:text-yellow-400 space-y-1">
                    @foreach(session('import_errors') as $err)
                        <li>• {{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                    Pilih File CSV
                </label>
                <input type="file" name="file" accept=".csv,.txt"
                       class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                              bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                              p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition
                              file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0
                              file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900 dark:file:text-blue-300
                              file:font-medium file:text-sm cursor-pointer">
                @error('file')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Format: .csv — Maks 2MB</p>
            </div>

            <button type="submit"
                    class="px-8 py-3 rounded-xl bg-blue-600 hover:bg-blue-700
                           text-white font-bold text-sm shadow-lg transition-all duration-200">
                📥 Import Sekarang
            </button>

        </form>
    </div>

</div>

</x-app-layout>