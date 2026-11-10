<x-app-layout>
    <!-- Memuat SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="school-photo-backdrop">
        <img src="{{ asset('fotosekolah.jpg') }}" alt="">
        <div class="school-photo-overlay"></div>
    </div>

    <div class="relative z-10 min-h-screen pb-12">
        
        <!-- HEADER PANEL ADMIN -->
        <div class="pt-10 pb-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Panel Administrator</h1>
                <p class="mt-1 text-slate-200 text-sm">Kelola dan validasi pendaftaran ekstrakurikuler siswa SMKN 20 Jakarta.</p>
            </div>
            <div class="flex flex-wrap items-center justify-center gap-3">
                <a href="{{ route('admin.siswa.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-4 py-2.5 text-sm font-semibold text-white hover:bg-amber-600">
                    Data Siswa
                </a>
                <a href="{{ route('admin.export.word') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">
                    Export ke Word
                </a>
            </div>
        </div>

        <!-- AREA KONTEN (Statistik & Tabel) -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-2">
            
            <!-- KARTU STATISTIK -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl border border-slate-200 p-5">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Pendaftar</p>
                    <p class="text-3xl font-black text-slate-800 mt-1">{{ $pendaftarans->count() }}</p>
                </div>
                <div class="bg-white rounded-xl border border-slate-200 p-5">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Menunggu (Pending)</p>
                    <p class="text-3xl font-black text-yellow-600 mt-1">{{ $pendaftarans->where('status', 'pending')->count() }}</p>
                </div>
                <div class="bg-white rounded-xl border border-slate-200 p-5">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Disetujui</p>
                    <p class="text-3xl font-black text-green-600 mt-1">{{ $pendaftarans->where('status', 'diterima')->count() }}</p>
                </div>
                <div class="bg-white rounded-xl border border-slate-200 p-5">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Ditolak</p>
                    <p class="text-3xl font-black text-red-600 mt-1">{{ $pendaftarans->where('status', 'ditolak')->count() }}</p>
                </div>
            </div>

            <!-- Notifikasi Sistem -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 p-4 rounded-lg flex items-center">
                    <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p class="text-sm font-semibold text-green-900">{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm font-semibold text-red-900" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <!-- TABEL DATA PENDAFTAR -->
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200 bg-white flex flex-col gap-4 lg:flex-row lg:justify-between lg:items-center">
                    <h3 class="text-lg leading-6 font-bold text-slate-900">Daftar Antrean Validasi</h3>
                    <form id="bulk-update-form" action="{{ route('admin.pendaftaran.bulk-update') }}" method="POST" class="flex flex-wrap gap-2">
                        @csrf
                        <button
                            type="submit"
                            name="status"
                            value="diterima"
                            disabled
                            onclick="return confirm('Terima semua pendaftaran terpilih?')"
                            class="rounded-lg bg-green-700 px-4 py-2 text-xs font-semibold text-white hover:bg-green-800 disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            Terima Terpilih
                        </button>
                        <button
                            type="submit"
                            name="status"
                            value="ditolak"
                            disabled
                            onclick="return confirm('Tolak semua pendaftaran terpilih? Kuota ekskul akan dikembalikan.')"
                            class="rounded-lg bg-red-700 px-4 py-2 text-xs font-semibold text-white hover:bg-red-800 disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            Tolak Terpilih
                        </button>
                    </form>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200/60">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-4 text-left">
                                    <label class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600">
                                        <input id="select-all-pending" type="checkbox" class="rounded border-slate-300 text-blue-700 focus:ring-blue-500">
                                        <span>Pilih semua</span>
                                    </label>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Info Siswa</th>
                                <th class="px-6 py-4 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">Ekskul Pilihan</th>
                                <th class="px-6 py-4 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-extrabold text-slate-500 uppercase tracking-wider">Aksi Validasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($pendaftarans as $pendaftar)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-4 text-center">
                                        @if($pendaftar->status === 'pending')
                                            <input
                                                type="checkbox"
                                                name="ids[]"
                                                value="{{ $pendaftar->id }}"
                                                form="bulk-update-form"
                                                class="bulk-registration-checkbox rounded border-slate-300 text-blue-700 focus:ring-blue-500"
                                                aria-label="Pilih pendaftaran {{ $pendaftar->user->name ?? 'Siswa' }}"
                                            >
                                        @endif
                                    </td>
                                    <!-- Info Siswa -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-slate-100 text-slate-700 flex items-center justify-center font-semibold">
                                                {{ strtoupper(substr($pendaftar->user->name ?? 'S', 0, 1)) }}
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
                                                    <button type="button" data-form="form-acc-{{ $pendaftar->id }}" data-student="{{ $pendaftar->user->name ?? 'Siswa' }}" data-activity="{{ $pendaftar->ekstrakurikuler->nama_ekskul ?? 'Ekskul' }}" onclick="konfirmasiValidasi(this, 'diterima')" class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg font-semibold text-xs">
                                                        Terima
                                                    </button>
                                                </form>

                                                <form id="form-tolak-{{ $pendaftar->id }}" action="{{ route('admin.pendaftaran.status', $pendaftar->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="ditolak">
                                                    <button type="button" data-form="form-tolak-{{ $pendaftar->id }}" data-student="{{ $pendaftar->user->name ?? 'Siswa' }}" data-activity="{{ $pendaftar->ekstrakurikuler->nama_ekskul ?? 'Ekskul' }}" onclick="konfirmasiValidasi(this, 'ditolak')" class="bg-red-700 hover:bg-red-800 text-white px-4 py-2 rounded-lg font-semibold text-xs">
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
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-500 font-medium bg-white">
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
        const selectAllPending = document.getElementById('select-all-pending');
        const pendingRegistrationCheckboxes = Array.from(document.querySelectorAll('.bulk-registration-checkbox'));
        const bulkUpdateButtons = document.querySelectorAll('#bulk-update-form button[type="submit"]');

        function updateBulkSelection() {
            const selectedCount = pendingRegistrationCheckboxes.filter((checkbox) => checkbox.checked).length;

            bulkUpdateButtons.forEach((button) => {
                button.disabled = selectedCount === 0;
            });

            selectAllPending.checked = pendingRegistrationCheckboxes.length > 0
                && selectedCount === pendingRegistrationCheckboxes.length;
            selectAllPending.indeterminate = selectedCount > 0
                && selectedCount < pendingRegistrationCheckboxes.length;
        }

        selectAllPending.addEventListener('change', () => {
            pendingRegistrationCheckboxes.forEach((checkbox) => {
                checkbox.checked = selectAllPending.checked;
            });
            updateBulkSelection();
        });

        pendingRegistrationCheckboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', updateBulkSelection);
        });

        updateBulkSelection();

        function konfirmasiValidasi(button, aksi) {
            let configAlert = {
                title: 'Konfirmasi Validasi',
                icon: 'warning',
                iconColor: '#d97706',
                showCancelButton: true,
                cancelButtonText: 'Kembali',
                reverseButtons: true,
                buttonsStyling: false,
                customClass: {
                    popup: 'eskul-alert-popup',
                    confirmButton: 'eskul-alert-confirm',
                    cancelButton: 'eskul-alert-cancel',
                },
            };

            if (aksi === 'diterima') {
                configAlert.text = `Terima pendaftaran ${button.dataset.student} untuk ekskul ${button.dataset.activity}?`;
                configAlert.confirmButtonText = 'Ya, Terima Siswa!';
                configAlert.customClass.confirmButton = 'eskul-alert-confirm';
            } else {
                configAlert.text = `Tolak pendaftaran ${button.dataset.student} untuk ekskul ${button.dataset.activity}?`;
                configAlert.confirmButtonText = 'Ya, Tolak!';
                configAlert.customClass.confirmButton = 'eskul-alert-confirm eskul-alert-danger';
            }

            Swal.fire(configAlert).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(button.dataset.form).submit();
                }
            });
        }

    </script>
</x-app-layout>