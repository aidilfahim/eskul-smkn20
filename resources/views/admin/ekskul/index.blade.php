<x-app-layout>
    <!-- Memuat SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="school-photo-backdrop">
        <img src="{{ asset('fotosekolah.jpg') }}" alt="">
        <div class="school-photo-overlay"></div>
    </div>

    <div class="relative z-10 min-h-screen pb-12">
        
        <!-- HEADER HALAMAN -->
        <div class="pt-10 pb-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Kelola Ekstrakurikuler</h1>
                <p class="mt-1 text-slate-200 text-sm">Tambah, ubah, atau hapus data kegiatan ekstrakurikuler SMKN 20 Jakarta.</p>
            </div>
            <div class="flex items-center gap-3">
                <!-- Tombol Tambah Ekskul Baru -->
                <a href="{{ route('admin.ekskul.create') }}" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2.5 rounded-lg font-semibold text-sm transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Ekstrakurikuler
                </a>
            </div>
        </div>

        <!-- AREA KONTEN UTAMA -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-2">
            
            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 p-4 rounded-lg flex items-center">
                    <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p class="text-sm font-semibold text-green-900">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200 bg-white flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-bold text-slate-900">Daftar Seluruh Ekstrakurikuler</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200/60">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Nama Ekstrakurikuler</th>
                                <th class="px-6 py-4 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Jadwal (Hari)</th>
                                <th class="px-6 py-4 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Pembina</th>
                                <th class="px-6 py-4 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">Kuota</th>
                                <th class="px-6 py-4 text-right text-xs font-extrabold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($ekskuls as $ekskul)
                                <tr class="hover:bg-slate-50">
                                    <!-- Nama Ekskul -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-slate-900">{{ $ekskul->nama_ekskul }}</div>
                                    </td>
                                    
                                    <!-- Hari -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-blue-100 text-blue-800 shadow-sm border border-blue-200">
                                            {{ $ekskul->hari }}
                                        </span>
                                    </td>

                                    <!-- Pembina -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-slate-700">{{ $ekskul->pembina }}</div>
                                    </td>

                                    <!-- Kuota -->
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="text-sm font-bold text-slate-800 bg-slate-100 px-3 py-1 rounded-lg border border-slate-200">
                                            {{ $ekskul->kuota }}
                                        </span>
                                    </td>
                                    
                                    <!-- Aksi (Edit & Hapus) -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('admin.ekskul.edit', $ekskul->id) }}" class="bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 px-3 py-2 rounded-lg font-semibold text-xs transition">
                                                Edit
                                            </a>

                                            <!-- Form Hapus dengan SweetAlert -->
                                            <form id="form-hapus-{{ $ekskul->id }}" action="{{ route('admin.ekskul.destroy', $ekskul->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" data-form="form-hapus-{{ $ekskul->id }}" data-activity="{{ $ekskul->nama_ekskul }}" onclick="konfirmasiHapus(this)" class="bg-red-700 hover:bg-red-800 text-white px-3 py-2 rounded-lg font-semibold text-xs transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-500 font-medium bg-white">
                                        Belum ada data ekstrakurikuler yang terdaftar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Script SweetAlert2 untuk Konfirmasi Hapus -->
    <script>
        function konfirmasiHapus(button) {
            Swal.fire({
                title: 'Hapus Ekstrakurikuler?',
                text: `Kamu yakin ingin menghapus ekskul "${button.dataset.activity}"? Data yang dihapus tidak dapat dikembalikan.`,
                icon: 'error',
                iconColor: '#b91c1c',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Kembali',
                reverseButtons: true,
                buttonsStyling: false,
                customClass: {
                    popup: 'eskul-alert-popup',
                    confirmButton: 'eskul-alert-confirm eskul-alert-danger',
                    cancelButton: 'eskul-alert-cancel',
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(button.dataset.form).submit();
                }
            });
        }
    </script>
</x-app-layout>