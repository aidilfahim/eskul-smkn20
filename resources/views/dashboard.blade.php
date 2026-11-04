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
        
        <!-- HEADER / BANNER SELAMAT DATANG -->
        <div class="pt-10 pb-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto flex items-center gap-5">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=ffffff&color=1e40af&size=128&bold=true" 
                 alt="Foto Profil" 
                 class="w-20 h-20 rounded-full border-2 border-white shadow-xl">
            
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight drop-shadow-md">
                    Halo, {{ Auth::user()->name }}! 👋
                </h1>
                <p class="mt-1 text-blue-200 text-sm sm:text-base font-medium drop-shadow-sm">
                    Portal Pendaftaran Ekstrakurikuler SMKN 20 Jakarta
                </p>
            </div>
        </div>

        <!-- KONTEN UTAMA SISWA -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-2">
            
            <!-- Notifikasi Sistem (Flash Message) -->
            @if(session('error'))
                <div class="mb-6 bg-red-500/90 backdrop-blur-md border border-red-400 p-4 rounded-xl shadow-lg flex items-center">
                    <svg class="w-6 h-6 text-white mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <p class="text-sm font-bold text-white">{{ session('error') }}</p>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-6 bg-green-500/90 backdrop-blur-md border border-green-400 p-4 rounded-xl shadow-lg flex items-center">
                    <svg class="w-6 h-6 text-white mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p class="text-sm font-bold text-white">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- KOLOM KIRI: Status Pendaftaran & Panduan (Sticky) -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 space-y-6">
                        
                        <!-- Box Status Riwayat -->
                        <div class="bg-white/95 backdrop-blur-xl rounded-2xl shadow-xl border border-white/50 overflow-hidden">
                            <div class="bg-slate-50/80 px-5 py-4 border-b border-slate-200/60 flex items-center">
                                <svg class="w-5 h-5 text-slate-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                <h3 class="text-md font-bold text-slate-800">Status Pendaftaran Saya</h3>
                            </div>
                            <div class="p-0">
                                @if($pendaftarans->isEmpty())
                                    <p class="text-slate-500 text-sm text-center py-6 italic">Belum ada ekskul yang diikuti.</p>
                                @else
                                    <ul class="divide-y divide-slate-100">
                                        @foreach($pendaftarans as $riwayat)
                                            <li class="p-4 hover:bg-blue-50/50 transition">
                                                <div class="flex justify-between items-start mb-1">
                                                    <p class="font-bold text-slate-900 text-sm">{{ $riwayat->ekstrakurikuler->nama_ekskul }}</p>
                                                    @if($riwayat->status == 'diterima')
                                                        <span class="bg-green-100 text-green-800 px-2.5 py-0.5 rounded-full text-xs font-bold border border-green-200">Diterima</span>
                                                    @elseif($riwayat->status == 'ditolak')
                                                        <span class="bg-red-100 text-red-800 px-2.5 py-0.5 rounded-full text-xs font-bold border border-red-200">Ditolak</span>
                                                    @else
                                                        <span class="bg-yellow-100 text-yellow-800 px-2.5 py-0.5 rounded-full text-xs font-bold border border-yellow-200 animate-pulse">Pending</span>
                                                    @endif
                                                </div>
                                                <p class="text-xs text-slate-500">Jadwal: <span class="font-semibold text-slate-700">{{ $riwayat->ekstrakurikuler->hari }}</span></p>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>

                        <!-- Box Informasi Panduan -->
                        <div class="bg-blue-900/80 backdrop-blur-md rounded-2xl border border-white/20 p-5 shadow-xl text-white">
                            <h3 class="text-sm font-bold text-blue-200 mb-3 border-b border-blue-700 pb-2">Panduan Pendaftaran</h3>
                            <div class="space-y-3 text-xs text-blue-100">
                                <div class="flex items-start">
                                    <span class="bg-blue-500 text-white rounded-full w-4 h-4 flex items-center justify-center font-bold mr-2 flex-shrink-0 mt-0.5">1</span>
                                    <p>Pilih ekskul dan pastikan hari kegiatannya tidak bentrok.</p>
                                </div>
                                <div class="flex items-start">
                                    <span class="bg-blue-500 text-white rounded-full w-4 h-4 flex items-center justify-center font-bold mr-2 flex-shrink-0 mt-0.5">2</span>
                                    <p>Klik tombol <b>Daftar</b>, status akan menjadi "Pending".</p>
                                </div>
                                <div class="flex items-start">
                                    <span class="bg-blue-500 text-white rounded-full w-4 h-4 flex items-center justify-center font-bold mr-2 flex-shrink-0 mt-0.5">3</span>
                                    <p>Tunggu persetujuan admin sekolah.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- KOLOM KANAN: Daftar Ekskul (Kartu Efek Kaca) -->
                <div class="lg:col-span-2">
                    <div class="bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/50 p-6">
                        <h2 class="text-lg font-extrabold text-slate-900 mb-5 border-b border-slate-200/60 pb-3 flex justify-between items-center">
                            <span>Pilihan Ekstrakurikuler</span>
                            <span class="text-xs font-bold bg-blue-100 text-blue-800 px-3 py-1 rounded-full">{{ $ekskuls->count() }} Tersedia</span>
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse($ekskuls as $ekskul)
                                <div class="border border-slate-200/80 rounded-xl p-4 hover:border-blue-500 transition-all bg-white/90 shadow-sm hover:shadow-md flex flex-col justify-between">
                                    <div>
                                        <h3 class="font-extrabold text-slate-800 text-base mb-3">{{ $ekskul->nama_ekskul }}</h3>
                                        <div class="space-y-1.5 mb-5 text-xs text-slate-600">
                                            <p class="flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                Hari: <span class="font-bold text-slate-800 ml-1">{{ $ekskul->hari }}</span>
                                            </p>
                                            <p class="flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                Pembina: <span class="font-bold text-slate-800 ml-1">{{ $ekskul->pembina }}</span>
                                            </p>
                                            <p class="flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                Sisa Kuota: <span class="font-black text-blue-600 ml-1">{{ $ekskul->kuota }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <!-- Form Tombol Daftar dengan SweetAlert -->
                                    <form id="form-daftar-{{ $ekskul->id }}" action="{{ route('pendaftaran.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="ekstrakurikuler_id" value="{{ $ekskul->id }}">
                                        <button type="button" onclick="konfirmasiDaftar({{ $ekskul->id }}, '{{ $ekskul->nama_ekskul }}', '{{ $ekskul->hari }}')" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-xs font-bold py-2.5 rounded-xl transition-all shadow-md transform hover:scale-[1.02]">
                                            Daftar Ekskul
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <div class="col-span-full py-12 text-center text-slate-500 font-medium bg-white/50 rounded-xl border border-dashed border-slate-300">
                                    Belum ada data ekstrakurikuler yang dibuka.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- SCRIPT SWEETALERT2 -->
    <script>
        function konfirmasiDaftar(id, namaEkskul, hariEkskul) {
            Swal.fire({
                title: 'Konfirmasi Pendaftaran',
                html: "Apakah kamu yakin ingin mendaftar ekskul <b>" + namaEkskul + "</b>?<br><br><span class='text-sm text-slate-500'>Jadwal latihan: " + hariEkskul + "</span>",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb', 
                cancelButtonColor: '#ef4444', 
                confirmButtonText: 'Ya, Daftar Sekarang!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-daftar-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>