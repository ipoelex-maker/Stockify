<x-app-layout>

    <div class="space-y-6">

        {{-- HEADER --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-black text-gray-800 dark:text-white">📊 Laporan</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">
                    Laporan transaksi barang masuk & keluar
                </p>
            </div>

            {{-- EXPORT BUTTONS --}}
            <div class="flex items-center gap-2 print:hidden">
                <a href="{{ route('reports.export', ['month' => $month, 'year' => $year, 'type' => $type]) }}"
                   class="flex items-center gap-2 px-4 py-2.5 rounded-xl
                          bg-green-600 hover:bg-green-700 text-white font-bold text-sm
                          shadow-lg transition-all duration-200">
                    📥 Export CSV
                </a>
                <button onclick="window.print()"
                        class="flex items-center gap-2 px-4 py-2.5 rounded-xl
                               bg-gray-700 hover:bg-gray-800 text-white font-bold text-sm
                               shadow-lg transition-all duration-200">
                    🖨️ Print / PDF
                </button>
            </div>
        </div>

        {{-- FILTER CARD --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 print:hidden">
            <form method="GET" action="{{ route('reports.index') }}"
                  class="flex flex-wrap items-end gap-4">

                {{-- TYPE --}}
                <div class="flex-1 min-w-[160px]">
                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                        Jenis Laporan
                    </label>
                    <select name="type"
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                   bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                   p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="stock-in"  {{ $type === 'stock-in'  ? 'selected' : '' }}>📥 Barang Masuk</option>
                        <option value="stock-out" {{ $type === 'stock-out' ? 'selected' : '' }}>📤 Barang Keluar</option>
                    </select>
                </div>

                {{-- MONTH --}}
                <div class="flex-1 min-w-[140px]">
                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                        Bulan
                    </label>
                    <select name="month"
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                   bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                   p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        @foreach($months as $num => $name)
                            <option value="{{ $num }}" {{ $month == $num ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- YEAR --}}
                <div class="flex-1 min-w-[100px]">
                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                        Tahun
                    </label>
                    <select name="year"
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                   bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                   p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        @foreach($years as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- SUBMIT --}}
                <button type="submit"
                        class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700
                               text-white font-bold text-sm shadow-lg transition-all duration-200">
                    🔍 Tampilkan
                </button>

            </form>
        </div>

        {{-- PRINT HEADER (hanya tampil saat print) --}}
        <div class="hidden print:block text-center mb-6">
            <h2 class="text-2xl font-bold">STOCKIFY</h2>
            <p class="text-lg font-semibold mt-1">
                Laporan {{ $type === 'stock-in' ? 'Barang Masuk' : 'Barang Keluar' }}
            </p>
            <p class="text-gray-600">
                Periode: {{ $months[$month] }} {{ $year }}
            </p>
            <hr class="mt-3">
        </div>

        {{-- SUMMARY CARDS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 print:gap-2">

            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 print:rounded-lg print:shadow-none print:border">
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Barang Masuk</p>
                <p class="text-4xl font-black text-blue-600 mt-2">{{ $totalQtyIn }} <span class="text-lg font-normal text-gray-400">unit</span></p>
                <p class="text-xs text-gray-400 mt-1">{{ $months[$month] }} {{ $year }}</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 print:rounded-lg print:shadow-none print:border">
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Barang Keluar</p>
                <p class="text-4xl font-black text-red-500 mt-2">{{ $totalQtyOut }} <span class="text-lg font-normal text-gray-400">unit</span></p>
                <p class="text-xs text-gray-400 mt-1">{{ $months[$month] }} {{ $year }}</p>
            </div>

        </div>

        {{-- TABLE --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden print:rounded-lg print:shadow-none print:border">

            {{-- TABLE TITLE --}}
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                <h2 class="font-bold text-gray-800 dark:text-white">
                    {{ $type === 'stock-in' ? '📥 Detail Barang Masuk' : '📤 Detail Barang Keluar' }}
                    — {{ $months[$month] }} {{ $year }}
                </h2>
            </div>

            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 print:bg-gray-100">
                        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">#</th>
                        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Produk</th>
                        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Qty</th>
                        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Tanggal</th>
                        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                    @php $data = $type === 'stock-in' ? $stockIns : $stockOuts; @endphp
                    @forelse($data as $row)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="px-6 py-4 text-gray-400 dark:text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-800 dark:text-white">
                                {{ $row->product->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold print:px-0 print:rounded-none
                                    {{ $type === 'stock-in'
                                        ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400'
                                        : 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400' }}">
                                    {{ $type === 'stock-in' ? '+' : '-' }}{{ $row->qty }} unit
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                {{ $row->note ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-gray-400 dark:text-gray-500">
                                <div class="text-4xl mb-3">📭</div>
                                <div class="font-medium">Tidak ada data untuk periode ini</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

                {{-- TOTAL ROW --}}
                @if($data->count() > 0)
                    <tfoot>
                        <tr class="border-t-2 border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50">
                            <td colspan="2" class="px-6 py-4 font-bold text-gray-800 dark:text-white text-right">
                                Total:
                            </td>
                            <td class="px-6 py-4 font-black text-lg
                                {{ $type === 'stock-in' ? 'text-blue-600' : 'text-red-500' }}">
                                {{ $data->sum('qty') }} unit
                            </td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                @endif

            </table>
        </div>

    </div>

    {{-- PRINT STYLE --}}
    <style>
        @media print {
            aside, .print\:hidden { display: none !important; }
            main { margin: 0 !important; padding: 0 !important; }
            body { background: white !important; }
            * { color: black !important; background: white !important; }
        }
    </style>

</x-app-layout>