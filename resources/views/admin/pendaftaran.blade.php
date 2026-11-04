<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Pendaftaran Ekstrakurikuler (Admin)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Daftar Pendaftar Masuk</h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-100">
                                <th class="p-3">Nama Siswa</th>
                                <th class="p-3">Email</th>
                                <th class="p-3">Ekstrakurikuler</th>
                                <th class="p-3">Tanggal Daftar</th>
                                <th class="p-3">Status Saat Ini</th>
                                <th class="p-3 text-center">Aksi (Persetujuan)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pendaftarans as $item)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3 font-semibold">{{ $item->user->name }}</td>
                                    <td class="p-3 text-gray-600">{{ $item->user->email }}</td>
                                    <td class="p-3 font-semibold text-blue-600">{{ $item->ekstrakurikuler->nama_ekskul }}</td>
                                    <td class="p-3 text-sm">{{ $item->created_at->format('d M Y, H:i') }}</td>
                                    <td class="p-3">
                                        @if($item->status == 'pending')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2.5 py-1 rounded">Pending</span>
                                        @elseif($item->status == 'diterima')
                                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">Diterima</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-1 rounded">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-center">
                                        <div class="flex justify-center gap-2">
                                            <!-- Tombol ACC / Diterima -->
                                            <form action="{{ route('admin.pendaftaran.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="diterima">
                                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold py-1 px-3 rounded">
                                                    ACC
                                                </button>
                                            </form>

                                            <!-- Tombol Tolak -->
                                            <form action="{{ route('admin.pendaftaran.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="ditolak">
                                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-1 px-3 rounded">
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-4 text-center text-gray-500">Belum ada siswa yang mendaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>