<x-app-layout>

<div class="space-y-6">

    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-black text-gray-800 dark:text-white">🚚 Suppliers</h1>
            <p class="text-gray-500 dark:text-gray-400">Kelola data supplier</p>
        </div>
        <a href="{{ route('suppliers.create') }}"
           class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-lg transition">
            + Tambah Supplier
        </a>
    </div>

    @if(session('success'))
        <div class="flex items-center gap-3 px-5 py-4 rounded-2xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 font-medium">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">#</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Nama</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Telepon</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Email</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Alamat</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                @forelse($suppliers as $supplier)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                    <td class="px-6 py-4 text-gray-400 dark:text-gray-500">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 font-semibold text-gray-800 dark:text-white">{{ $supplier->name }}</td>
                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $supplier->phone ?? '-' }}</td>
                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $supplier->email ?? '-' }}</td>
                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $supplier->address ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('suppliers.edit', $supplier->id) }}"
                               class="px-3 py-1.5 rounded-lg text-xs font-semibold
                                      bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400
                                      hover:bg-yellow-200 transition">
                                Edit
                            </a>
                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST"
                                  onsubmit="return confirm('Hapus supplier {{ $supplier->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-3 py-1.5 rounded-lg text-xs font-semibold
                                               bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400
                                               hover:bg-red-200 transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center text-gray-400 dark:text-gray-500">
                        <div class="text-4xl mb-3">🚚</div>
                        <div class="font-medium">Belum ada supplier</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

</x-app-layout>