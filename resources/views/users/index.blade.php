<x-app-layout>

    <div class="space-y-6">

        {{-- HEADER --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-black text-gray-800 dark:text-white">Manajemen User</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Kelola akun dan role pengguna</p>
            </div>
            <a href="{{ route('users.create') }}"
               class="flex items-center gap-2 px-5 py-2.5 rounded-xl
                      bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm
                      shadow-lg transition-all duration-200">
                + Tambah User
            </a>
        </div>

        {{-- SESSION ALERT --}}
        @if(session('success'))
            <div class="flex items-center gap-3 px-5 py-4 rounded-2xl
                        bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800
                        text-green-700 dark:text-green-400 font-medium">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="flex items-center gap-3 px-5 py-4 rounded-2xl
                        bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800
                        text-red-700 dark:text-red-400 font-medium">
                {{ session('error') }}
            </div>
        @endif

        {{-- TABLE --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden">

            <table class="w-full text-sm">

                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700">
                        <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">#</th>
                        <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                        <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Role</th>
                        <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Bergabung</th>
                        <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">

                            <td class="px-6 py-4 text-gray-400 dark:text-gray-500">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    {{-- Avatar --}}
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600
                                                text-white flex items-center justify-center font-bold text-sm flex-shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-800 dark:text-white">
                                            {{ $user->name }}
                                            @if($user->id === auth()->id())
                                                <span class="ml-1 text-xs text-blue-500">(Kamu)</span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-400 dark:text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                @foreach($user->roles as $role)
                                    @php
                                        $color = match($role->name) {
                                            'admin'   => 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400',
                                            'manager' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400',
                                            'staff'   => 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400',
                                            default   => 'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400',
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $color }}">
                                        {{ ucfirst($role->name) }}
                                    </span>
                                @endforeach
                                @if($user->roles->isEmpty())
                                    <span class="px-3 py-1 rounded-full text-xs font-bold
                                                 bg-gray-100 dark:bg-gray-700 text-gray-400">
                                        Tanpa Role
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                {{ $user->created_at->format('d M Y') }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">

                                    <a href="{{ route('users.edit', $user->id) }}"
                                       class="px-3 py-1.5 rounded-lg text-xs font-semibold
                                              bg-yellow-100 dark:bg-yellow-900/30
                                              text-yellow-700 dark:text-yellow-400
                                              hover:bg-yellow-200 dark:hover:bg-yellow-800/40 transition">
                                        Edit
                                    </a>

                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                              onsubmit="return confirm('Hapus user {{ $user->name }}?')">
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
                                    @endif

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-gray-400 dark:text-gray-500">
                                <div class="text-4xl mb-3">👥</div>
                                <div class="font-medium">Belum ada user</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>