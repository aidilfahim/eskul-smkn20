<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">Edit Ekstrakurikuler</h2>
            <p class="mt-1 text-sm text-gray-600">Perbarui informasi kegiatan ekstrakurikuler.</p>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-6 sm:p-8 border border-gray-200 rounded-xl">
                <form action="{{ route('admin.ekskul.update', $ekskul->id) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="nama_ekskul" class="block font-semibold text-sm text-gray-700 mb-1">Nama Ekskul</label>
                        <input id="nama_ekskul" type="text" name="nama_ekskul" value="{{ old('nama_ekskul', $ekskul->nama_ekskul) }}" class="w-full" required>
                    </div>
                    <div>
                        <label for="kategori" class="block font-semibold text-sm text-gray-700 mb-1">Kategori</label>
                        <input id="kategori" type="text" name="kategori" value="{{ old('kategori', $ekskul->kategori) }}" class="w-full" required>
                    </div>
                    <div>
                        <label for="kuota" class="block font-semibold text-sm text-gray-700 mb-1">Kuota</label>
                        <input id="kuota" type="number" name="kuota" value="{{ old('kuota', $ekskul->kuota) }}" class="w-full" required>
                    </div>
                    <div>
                        <label for="pembina" class="block font-semibold text-sm text-gray-700 mb-1">Pembina</label>
                        <input id="pembina" type="text" name="pembina" value="{{ old('pembina', $ekskul->pembina) }}" class="w-full" required>
                    </div>
                    <div>
                        <label for="jadwal" class="block font-semibold text-sm text-gray-700 mb-1">Jadwal</label>
                        <input id="jadwal" type="text" name="jadwal" value="{{ old('jadwal', $ekskul->jadwal) }}" class="w-full" required>
                    </div>
                    <div class="flex justify-end gap-3 border-t border-gray-100 pt-5">
                        <a href="{{ route('admin.ekskul.index') }}" class="inline-flex items-center rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">Batal</a>
                        <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-2 rounded-lg font-semibold text-sm">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>