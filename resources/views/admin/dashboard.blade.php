<x-app-layout>
    <!-- Memuat SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- BACKGROUND FULL SCREEN (Tetap diam saat di-scroll) -->
    <div class="fixed inset-0 z-0">
        <!-- Foto Sekolah Full Layar -->
        <img src="{{ asset('fotosekolah.jpg') }}" alt="Background Sekolah" class="w-full h-full object-cover">
        
        <!-- Overlay Estetik: Gradien Gelap Biru dan Efek Blur Tipis agar teks bisa dibaca -->
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900/95 via-slate-800/85 to-blue-900/80 backdrop-blur-[2px]"></div>
    </div>

    <!-- WRAPPER KONTEN UTAMA (Berada di atas background) -->
    <div class="relative z-10 min-h-screen pb-12">
        
        <!-- HEADER PANEL ADMIN -->
        <div class="pt-10 pb-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight drop-shadow-lg">Panel Administrator</h1>
                <p class="mt-1 text-blue-200 text-sm font-medium drop-shadow-md">Kelola dan validasi pendaftaran ekstrakurikuler siswa SMKN 20 Jakarta.</p>
            </div>
            <div>
                <span class="bg-white/10 text-white px-5 py-2.5 rounded-full text-sm font-bold backdrop-blur-md border border-white/20 shadow-xl flex items-center">
                    <span class="w-2.5 h-2.5 rounded-full bg-green-400 mr-2.5 animate-pulse shadow-[0_0_8px_rgba(74,222,128,0.8)]"></span> Mode Admin
                </span>
            </div>
        </div>

        <!-- AREA KONTEN (Statistik & Tabel) -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-2">
            
            <!-- KARTU STATISTIK -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-xl border border-white/40 p-5 hover:bg-white transition-all transform hover:-translate-y-1">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Pendaftar</p>
                    <p class="text-3xl font-black text-slate-800 mt-1">{{ $pendaftarans->count() }}</p>
                </div>
                <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-xl border border-white/40 p-5 hover:bg-white transition-all transform hover:-translate-y-1">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Menunggu (Pending)</p>
                    <p class="text-3xl font-black text-yellow-600 mt-1">{{ $pendaftarans->where('status', 'pending')->count() }}</p>
                </div>
                <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-xl border border-white/40 p-5 hover:bg-white transition-all transform hover:-translate-y-1">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Disetujui</p>
                    <p class="text-3xl font-black text-green-600 mt-1">{{ $pendaftarans->where('status', 'diterima')->count() }}</p>
                </div>
                <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-xl border border-white/40 p-5 hover:bg-white transition-all transform hover:-translate-y-1">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Ditolak</p>
                    <p class="text-3xl font-black text-red-600 mt-1">{{ $pendaftarans->where('status', 'ditolak')->count() }}</p>
                </div>
            </div>

            <!-- Notifikasi Sistem -->
            @if(session('success'))
                <div class="mb-6 bg-green-500/90 backdrop-blur-md border border-green-400 p-4 rounded-xl shadow-lg flex items-center">
                    <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p class="text-sm font-bold text-white">{{ session('success') }}</p>
                </div>
            @endif

            <!-- TABEL DATA PENDAFTAR -->
            <div class="bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/50 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200/60 bg-white/50 flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-extrabold text-slate-900">Daftar Antrean Validasi</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200/60">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Info Siswa</th>
                                <th class="px-6 py-4 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Ekskul Pilihan</th>
                                <th class="px-6 py-4 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-extrabold text-slate-500 uppercase tracking-wider">Aksi Validasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($pendaftarans as $pendaftar)
                                <tr class="hover:bg-blue-50/50 transition-colors duration-200">
                                    <!-- Info Siswa -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full border-2 border-white shadow-sm" src="https://ui-avatars.com/api/?name={{ urlencode($pendaftar->user->name ?? 'User') }}&background=e2e8f0&color=1e293b&bold=true" alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-slate-900 uppercase">{{ $pendaftar->user->name ?? 'Tanpa Nama' }}</div>
                                                <div class="text-xs font-medium text-slate-500">{{ $pendaftar->user->email ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <!-- Ekskul Pilihan -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-blue-700">{{ $pendaftar->ekstrakurikuler->nama_ekskul ?? 'Ekskul Dihapus' }}</div>
                                        <div class="text-xs font-medium text-slate-500">Sisa Kuota: <span class="font-bold text-slate-700">{{ $pendaftar->ekstrakurikuler->kuota ?? 0 }}</span></div>
                                    </td>
                                    
                                    <!-- Status Badge -->
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($pendaftar->status == 'diterima')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800 shadow-sm border border-green-200">Diterima</span>
                                        @elseif($pendaftar->status == 'ditolak')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800 shadow-sm border border-red-200">Ditolak</span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-800 shadow-sm border border-yellow-300 animate-pulse">Menunggu</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Aksi Validasi -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if($pendaftar->status == 'pending')
                                            <div class="flex justify-end space-x-2">
                                                <form id="form-acc-{{ $pendaftar->id }}" action="{{ route('admin.pendaftaran.status', $pendaftar->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="diterima">
                                                    <button type="button" onclick="konfirmasiValidasi({{ $pendaftar->id }}, 'diterima', '{{ $pendaftar->user->name ?? 'Siswa' }}', '{{ $pendaftar->ekstrakurikuler->nama_ekskul ?? 'Ekskul' }}')" class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-4 py-2 rounded-lg font-bold text-xs shadow-md transform hover:scale-105 transition-all">
                                                        Terima
                                                    </button>
                                                </form>

                                                <form id="form-tolak-{{ $pendaftar->id }}" action="{{ route('admin.pendaftaran.status', $pendaftar->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="ditolak">
                                                    <button type="button" onclick="konfirmasiValidasi({{ $pendaftar->id }}, 'ditolak', '{{ $pendaftar->user->name ?? 'Siswa' }}', '{{ $pendaftar->ekstrakurikuler->nama_ekskul ?? 'Ekskul' }}')" class="bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white px-4 py-2 rounded-lg font-bold text-xs shadow-md transform hover:scale-105 transition-all">
                                                        Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-slate-400 italic text-xs font-semibold">Tervalidasi</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-500 font-medium bg-white/50">
                                        Belum ada antrean pendaftaran yang masuk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Script SweetAlert2 -->
    <script>
        function konfirmasiValidasi(id, aksi, namaSiswa, namaEkskul) {
            let configAlert = {
                title: 'Konfirmasi Validasi',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                reverseButtons: true
            };

            if (aksi === 'diterima') {
                configAlert.html = "Terima pendaftaran <b>" + namaSiswa + "</b> untuk ekskul <b>" + namaEkskul + "</b>?<br><br><span class='text-sm text-gray-500'>Kuota ekskul akan otomatis berkurang 1.</span>";
                configAlert.confirmButtonColor = '#059669'; 
                configAlert.confirmButtonText = 'Ya, Terima Siswa!';
            } else {
                configAlert.html = "Tolak pendaftaran <b>" + namaSiswa + "</b> untuk ekskul <b>" + namaEkskul + "</b>?";
                configAlert.confirmButtonColor = '#e11d48'; 
                configAlert.confirmButtonText = 'Ya, Tolak!';
            }

            Swal.fire(configAlert).then((result) => {
                if (result.isConfirmed) {
                    if(aksi === 'diterima') {
                        document.getElementById('form-acc-' + id).submit();
                    } else {
                        document.getElementById('form-tolak-' + id).submit();
                    }
                }
            });
        }
    </script>
</x-app-layout>