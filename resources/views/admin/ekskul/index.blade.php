<x-app-layout>
    <!-- Memuat SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- BACKGROUND FULL SCREEN (Tetap diam saat di-scroll) -->
    <div class="fixed inset-0 z-0">
        <!-- Foto Sekolah Full Layar -->
        <img src="{{ asset('fotosekolah.jpg') }}" alt="Background Sekolah" class="w-full h-full object-cover">
        
        <!-- Overlay Estetik: Gradien Gelap Biru dan Efek Blur Tipis -->
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900/95 via-slate-800/85 to-blue-900/80 backdrop-blur-[2px]"></div>
    </div>

    <!-- WRAPPER KONTEN UTAMA -->
    <div class="relative z-10 min-h-screen pb-12">
        
        <!-- HEADER HALAMAN -->
        <div class="pt-10 pb-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight drop-shadow-lg">Kelola Ekstrakurikuler</h1>
                <p class="mt-1 text-blue-200 text-sm font-medium drop-shadow-md">Tambah, ubah, atau hapus data kegiatan ekstrakurikuler SMKN 20 Jakarta.</p>
            </div>
            <div class="flex items-center gap-3">
                <!-- TOMBOL EXPORT TO WORD -->
                <a href="{{ route('admin.export.word') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-xl transform hover:scale-105 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Export to Word
                </a>

                <!-- Tombol Tambah Ekskul Baru -->
                <a href="{{ route('admin.ekskul.create') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-xl transform hover:scale-105 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Ekstrakurikuler
                </a>
            </div>
        </div>

        <!-- AREA KONTEN UTAMA -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-2">
            
            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="mb-6 bg-green-500/90 backdrop-blur-md border border-green-400 p-4 rounded-xl shadow-lg flex items-center">
                    <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p class="text-sm font-bold text-white">{{ session('success') }}</p>
                </div>
            @endif

            <!-- TABEL DATA EKSTRAKURIKULER (Efek Kaca) -->
            <div class="bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/50 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200/60 bg-white/50 flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-extrabold text-slate-900">Daftar Seluruh Ekstrakurikuler</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200/60">
                        <thead class="bg-slate-50/50">
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
                                <tr class="hover:bg-blue-50/50 transition-colors duration-200">
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
                                            <a href="{{ route('admin.ekskul.edit', $ekskul->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-2 rounded-lg font-bold text-xs shadow-md transition-all">
                                                Edit
                                            </a>

                                            <!-- Form Hapus dengan SweetAlert -->
                                            <form id="form-hapus-{{ $ekskul->id }}" action="{{ route('admin.ekskul.destroy', $ekskul->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="konfirmasiHapus({{ $ekskul->id }}, '{{ $ekskul->nama_ekskul }}')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg font-bold text-xs shadow-md transition-all">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-500 font-medium bg-white/50">
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
        function konfirmasiHapus(id, namaEkskul) {
            Swal.fire({
                title: 'Hapus Ekstrakurikuler?',
                html: "Kamu yakin ingin menghapus ekskul <b>" + namaEkskul + "</b>?<br><span class='text-sm text-red-500'>Data yang dihapus tidak dapat dikembalikan.</span>",
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-hapus-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>