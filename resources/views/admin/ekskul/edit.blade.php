<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Ekstrakurikuler</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.ekskul.update', $ekskul->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Nama Ekskul</label>
                        <input type="text" name="nama_ekskul" value="{{ $ekskul->nama_ekskul }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Kategori</label>
                        <input type="text" name="kategori" value="{{ $ekskul->kategori }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Kuota</label>
                        <input type="number" name="kuota" value="{{ $ekskul->kuota }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Pembina</label>
                        <input type="text" name="pembina" value="{{ $ekskul->pembina }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Jadwal</label>
                        <input type="text" name="jadwal" value="{{ $ekskul->jadwal }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-bold">Perbarui</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>