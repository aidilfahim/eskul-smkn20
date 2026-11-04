<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Kelola Data Ekstrakurikuler') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg leading-6 font-semibold text-gray-900">Daftar Ekstrakurikuler</h3>
                        <p class="mt-1 text-sm text-gray-500">Kelola daftar ekskul, kuota, pembina, dan jadwal.</p>
                    </div>
                    <!-- Tombol Tambah Ekskul -->
                    <a href="{{ route('admin.ekskul.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-sm transition-all text-sm">
                        + Tambah Ekskul
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Nama Ekskul</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Kategori</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Pembina & Jadwal</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">Kuota</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($ekskuls as $ekskul)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">
                                        {{ $ekskul->nama_ekskul }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <span class="bg-gray-100 text-gray-700 px-2.5 py-0.5 rounded-full text-xs font-medium border border-gray-200">
                                            {{ $ekskul->kategori }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $ekskul->pembina }}</div>
                                        <div class="text-xs text-gray-500">{{ $ekskul->jadwal }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-blue-600">
                                        {{ $ekskul->kuota }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <!-- Edit -->
                                            <a href="{{ route('admin.ekskul.edit', $ekskul->id) }}" class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-3 py-1.5 rounded-md text-xs font-semibold transition">Edit</a>
                                            
                                            <!-- Hapus -->
                                            <form action="{{ route('admin.ekskul.destroy', $ekskul->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus ekskul ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1.5 rounded-md text-xs font-semibold transition">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                        Belum ada data ekstrakurikuler. Silakan tambah ekskul baru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>