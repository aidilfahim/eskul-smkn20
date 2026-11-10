<x-app-layout>
    <!-- Memuat SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="school-photo-backdrop">
        <img src="{{ asset('fotosekolah.jpg') }}" alt="">
        <div class="school-photo-overlay"></div>
    </div>

    <div class="relative z-10 min-h-screen pb-12">
        
        <!-- HEADER / BANNER SELAMAT DATANG -->
        <div class="pt-10 pb-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto flex items-center gap-5">
            <div class="w-14 h-14 rounded-full bg-blue-700 text-white flex items-center justify-center text-xl font-semibold" aria-hidden="true">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">
                    Halo, {{ Auth::user()->name }}
                </h1>
                <p class="mt-1 text-slate-200 text-sm sm:text-base">
                    Portal Pendaftaran Ekstrakurikuler SMKN 20 Jakarta
                </p>
            </div>
        </div>

        <!-- KONTEN UTAMA SISWA -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-2">
            
            <!-- Notifikasi Sistem (Flash Message) -->
            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 p-4 rounded-lg flex items-center">
                    <svg class="w-6 h-6 text-white mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <p class="text-sm font-semibold text-red-900">{{ session('error') }}</p>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 p-4 rounded-lg flex items-center">
                    <svg class="w-6 h-6 text-white mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p class="text-sm font-semibold text-green-900">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- KOLOM KIRI: Status Pendaftaran & Panduan (Sticky) -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 space-y-6">
                        
                        <!-- Box Status Riwayat -->
                        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                            <div class="bg-slate-50 px-5 py-4 border-b border-slate-200 flex items-center">
                                <svg class="w-5 h-5 text-slate-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                <h3 class="text-md font-bold text-slate-800">Status Pendaftaran Saya</h3>
                            </div>
                            <div class="p-0">
                                @if($pendaftarans->isEmpty())
                                    <p class="text-slate-500 text-sm text-center py-6 italic">Belum ada ekskul yang diikuti.</p>
                                @else
                                    <ul class="divide-y divide-slate-100">
                                        @foreach($pendaftarans as $riwayat)
                                            <li class="p-4 hover:bg-slate-50 transition">
                                                <div class="flex justify-between items-start mb-1">
                                                    <p class="font-bold text-slate-900 text-sm">{{ $riwayat->ekstrakurikuler->nama_ekskul }}</p>
                                                    @if($riwayat->status == 'diterima')
                                                        <span class="bg-green-100 text-green-800 px-2.5 py-0.5 rounded-full text-xs font-bold border border-green-200">Diterima</span>
                                                    @elseif($riwayat->status == 'ditolak')
                                                        <span class="bg-red-100 text-red-800 px-2.5 py-0.5 rounded-full text-xs font-bold border border-red-200">Ditolak</span>
                                                    @else
                                                        <span class="bg-yellow-100 text-yellow-800 px-2.5 py-0.5 rounded-full text-xs font-semibold border border-yellow-200">Pending</span>
                                                    @endif
                                                </div>
                                                <p class="text-xs text-slate-500">Jadwal: <span class="font-semibold text-slate-700">{{ $riwayat->ekstrakurikuler->hari }}</span></p>

                                                <!-- TOMBOL DINAMIS: BATALKAN / KELUAR EKSKUL -->
                                                <form id="form-keluar-{{ $riwayat->id }}" action="{{ route('ekskul.keluar', $riwayat->id) }}" method="POST" class="mt-3">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        data-exit-form="form-keluar-{{ $riwayat->id }}"
                                                        data-activity="{{ $riwayat->ekstrakurikuler->nama_ekskul }}"
                                                        data-status="{{ $riwayat->status }}"
                                                        onclick="konfirmasiKeluar(this)"
                                                        class="w-full bg-white hover:bg-red-50 text-red-700 text-xs font-semibold py-2 rounded-lg transition-colors border border-red-200">
                                                        {{ $riwayat->status == 'diterima' ? 'Keluar dari Ekskul' : 'Batalkan Pendaftaran' }}
                                                    </button>
                                                </form>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>

                        <!-- Box Informasi Panduan -->
                        <div class="bg-slate-100 rounded-xl border border-slate-200 p-5 text-slate-800">
                            <h3 class="text-sm font-semibold text-slate-900 mb-3 border-b border-slate-300 pb-2">Panduan Pendaftaran</h3>
                            <div class="space-y-3 text-xs text-slate-600">
                                <div class="flex items-start">
                                    <span class="bg-blue-700 text-white rounded-full w-5 h-5 flex items-center justify-center font-semibold mr-2 flex-shrink-0 mt-0.5">1</span>
                                    <p>Pilih ekskul dan pastikan hari kegiatannya tidak bentrok.</p>
                                </div>
                                <div class="flex items-start">
                                    <span class="bg-blue-700 text-white rounded-full w-5 h-5 flex items-center justify-center font-semibold mr-2 flex-shrink-0 mt-0.5">2</span>
                                    <p>Klik tombol <b>Daftar</b>, status akan menjadi "Pending".</p>
                                </div>
                                <div class="flex items-start">
                                    <span class="bg-blue-700 text-white rounded-full w-5 h-5 flex items-center justify-center font-semibold mr-2 flex-shrink-0 mt-0.5">3</span>
                                    <p>Tunggu persetujuan admin sekolah.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- KOLOM KANAN: Daftar Ekskul (Kartu Efek Kaca) -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl border border-slate-200 p-6">
                        <h2 class="text-lg font-bold text-slate-900 mb-5 border-b border-slate-200 pb-3 flex justify-between items-center">
                            <span>Pilihan Ekstrakurikuler</span>
                            <span class="text-xs font-bold bg-blue-100 text-blue-800 px-3 py-1 rounded-full">{{ $ekskuls->count() }} Tersedia</span>
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse($ekskuls as $ekskul)
                                <div class="border border-slate-200 rounded-lg p-4 hover:border-blue-700 transition-colors bg-white flex flex-col justify-between">
                                    <div>
                                        <h3 class="font-semibold text-slate-900 text-base mb-3">{{ $ekskul->nama_ekskul }}</h3>
                                        <div class="space-y-1.5 mb-5 text-xs text-slate-600">
                                            <p class="flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
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
                                        <button type="button" data-form="form-daftar-{{ $ekskul->id }}" data-activity="{{ $ekskul->nama_ekskul }}" data-day="{{ $ekskul->hari }}" onclick="konfirmasiDaftar(this)" class="w-full bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold py-2.5 rounded-lg transition">
                                            Daftar Ekskul
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <div class="col-span-full py-12 text-center text-slate-500 font-medium bg-white rounded-xl border border-dashed border-slate-300">
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
        function konfirmasiKeluar(button) {
            const isAccepted = button.dataset.status === 'diterima';
            const actionLabel = isAccepted ? 'keluar dari ekskul' : 'membatalkan pendaftaran';

            Swal.fire({
                title: isAccepted ? 'Keluar dari ekskul?' : 'Batalkan pendaftaran?',
                text: `Kamu yakin ingin ${actionLabel} "${button.dataset.activity}"? Kuota akan dikembalikan dan kamu bisa mendaftar ekskul lain.`,
                icon: 'warning',
                iconColor: '#d97706',
                showCancelButton: true,
                confirmButtonText: isAccepted ? 'Ya, keluar' : 'Ya, batalkan',
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
                    document.getElementById(button.dataset.exitForm).submit();
                }
            });
        }

        function konfirmasiDaftar(button) {
            Swal.fire({
                title: 'Konfirmasi Pendaftaran',
                text: `Apakah kamu yakin ingin mendaftar ekskul "${button.dataset.activity}"? Jadwal latihan: ${button.dataset.day}.`,
                icon: 'question',
                iconColor: '#1d4ed8',
                showCancelButton: true,
                confirmButtonText: 'Ya, Daftar Sekarang!',
                cancelButtonText: 'Kembali',
                reverseButtons: true,
                buttonsStyling: false,
                customClass: {
                    popup: 'eskul-alert-popup',
                    confirmButton: 'eskul-alert-confirm',
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