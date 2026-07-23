<x-app-layout>

    <div class="space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-black text-gray-800 dark:text-white">📤 Barang Keluar</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Riwayat semua transaksi barang keluar</p>
            </div>
            <a href="{{ route('stock-outs.create') }}"
               class="flex items-center gap-2 px-5 py-2.5 rounded-xl
                      bg-red-500 hover:bg-red-600 text-white font-bold text-sm
                      shadow-lg transition-all duration-200">
                + Tambah
            </a>
        </div>

        {{-- ALERT --}}
        @if(session('success'))
            <div class="flex items-start gap-3 px-5 py-4 rounded-2xl
                        bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800
                        text-green-700 dark:text-green-400 font-medium">
                <span class="text-xl mt-0.5">✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="flex items-start gap-3 px-5 py-4 rounded-2xl
                        bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800
                        text-red-700 dark:text-red-400 font-medium">
                <span class="text-xl mt-0.5">🚫</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- TABLE --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">#</th>
                        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Produk</th>
                        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Qty</th>
                        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Tanggal</th>
                        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Catatan</th>
                        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                    @forelse($stockOuts as $stock)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="px-6 py-4 text-gray-400 dark:text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-800 dark:text-white">
                                {{ $stock->product->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold
                                             bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400">
                                    -{{ $stock->qty }} unit
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($stock->date)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                {{ $stock->note ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('stock-outs.destroy', $stock->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus data barang keluar ini? Stok akan dikembalikan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1.5 rounded-lg text-xs font-semibold
                                                   bg-red-100 dark:bg-red-900/30
                                                   text-red-700 dark:text-red-400
                                                   hover:bg-red-200 dark:hover:bg-red-800/40 transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-gray-400 dark:text-gray-500">
                                <div class="text-4xl mb-3">📭</div>
                                <div class="font-medium">Belum ada data barang keluar</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</x-app-layout>