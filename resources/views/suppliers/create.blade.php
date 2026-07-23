<x-app-layout>

    <div class="max-w-2xl mx-auto space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-black text-gray-800 dark:text-white">Tambah Supplier</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Daftarkan supplier baru</p>
            </div>
            <a href="{{ route('suppliers.index') }}"
               class="px-4 py-2 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300
                      hover:bg-gray-200 dark:hover:bg-gray-600 transition text-sm font-medium">
                ← Kembali
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8">
            <form action="{{ route('suppliers.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                        Nama Supplier
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           placeholder="cth: PT. Sumber Makmur"
                           class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                  bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                  placeholder-gray-400 dark:placeholder-gray-500
                                  p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                            No. Telepon
                        </label>
                        <input type="tel"
                               name="phone"
                               value="{{ old('phone') }}"
                               placeholder="cth: 08123456789"
                               pattern="[0-9+\-\s()]+"
                               title="Hanya boleh angka, +, -, atau spasi"
                               inputmode="tel"
                               class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                      bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                      placeholder-gray-400 dark:placeholder-gray-500
                                      p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                            Email
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               placeholder="cth: supplier@email.com"
                               class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                      bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                      placeholder-gray-400 dark:placeholder-gray-500
                                      p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                        Alamat
                    </label>
                    <textarea name="address" rows="3"
                              placeholder="Alamat lengkap supplier"
                              class="w-full rounded-xl border border-gray-200 dark:border-gray-600
                                     bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                     placeholder-gray-400 dark:placeholder-gray-500
                                     p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="px-8 py-3 rounded-xl bg-blue-600 hover:bg-blue-700
                                   text-white font-bold text-sm shadow-lg transition-all duration-200">
                        💾 Simpan Supplier
                    </button>
                </div>

            </form>
        </div>

    </div>

</x-app-layout>