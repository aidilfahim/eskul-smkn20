<x-app-layout>
    <x-slot name="header">
     
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Alert Notifikasi (Sukses / Error) -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm" role="alert">
                    <span class="block sm:inline font-medium">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative shadow-sm" role="alert">
                    <span class="block sm:inline font-medium">{{ session('error') }}</span>
                </div>
            @endif

            <!-- BAGIAN 1: RIWAYAT PENDAFTARAN SAYA -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 text-blue-800">Riwayat Pendaftaran Saya</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 border">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                <tr>
                                    <th class="px-6 py-3">Nama Ekskul</th>
                                    <th class="px-6 py-3">Jadwal</th>
                                    <th class="px-6 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- MENGGUNAKAN FORELSE (Lebih aman dari error) -->
                                @forelse ($pendaftarans as $pendaftaran)
                                <tr class="bg-white border-b">
                                    <td class="px-6 py-4 font-bold text-gray-900">{{ $pendaftaran->ekstrakurikuler->nama_ekskul }}</td>
                                    <td class="px-6 py-4">{{ $pendaftaran->ekstrakurikuler->hari }}, {{ $pendaftaran->ekstrakurikuler->jam }}</td>
                                    <td class="px-6 py-4">
                                        @if ($pendaftaran->status == 'pending')
                                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold">Menunggu</span>
                                        @elseif ($pendaftaran->status == 'diterima')
                                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold">Diterima</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500 italic">Kamu belum mendaftar ekstrakurikuler apapun.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- BAGIAN 2: KATALOG & FILTER EKSKUL -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 text-blue-800">Pilihan Ekstrakurikuler</h3>

                    <!-- Tombol Filter Kategori -->
                    <div class="mb-6 flex flex-wrap gap-2">
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-full text-sm font-semibold {{ !request('kategori') ? 'bg-blue-600 text-white shadow' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Semua</a>
                        <a href="{{ route('dashboard', ['kategori' => 'Olahraga']) }}" class="px-4 py-2 rounded-full text-sm font-semibold {{ request('kategori') == 'Olahraga' ? 'bg-blue-600 text-white shadow' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Olahraga</a>
                        <a href="{{ route('dashboard', ['kategori' => 'Seni & Budaya']) }}" class="px-4 py-2 rounded-full text-sm font-semibold {{ request('kategori') == 'Seni & Budaya' ? 'bg-blue-600 text-white shadow' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Seni & Budaya</a>
                        <a href="{{ route('dashboard', ['kategori' => 'Bela Diri']) }}" class="px-4 py-2 rounded-full text-sm font-semibold {{ request('kategori') == 'Bela Diri' ? 'bg-blue-600 text-white shadow' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Bela Diri</a>
                        <a href="{{ route('dashboard', ['kategori' => 'Akademik & Organisasi']) }}" class="px-4 py-2 rounded-full text-sm font-semibold {{ request('kategori') == 'Akademik & Organisasi' ? 'bg-blue-600 text-white shadow' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Akademik & Organisasi</a>
                        <a href="{{ route('dashboard', ['kategori' => 'Kerohanian & Sosial']) }}" class="px-4 py-2 rounded-full text-sm font-semibold {{ request('kategori') == 'Kerohanian & Sosial' ? 'bg-blue-600 text-white shadow' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Kerohanian & Sosial</a>
                    </div>

                    <!-- Grid Daftar Ekskul -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($ekskuls as $ekskul)
                            <div class="border border-gray-200 rounded-xl p-5 flex flex-col justify-between hover:shadow-lg transition-shadow bg-slate-50">
                                <div>
                                    <h4 class="font-extrabold text-xl text-blue-700">{{ $ekskul->nama_ekskul }}</h4>
                                    
                                    <!-- Label Kategori & Jadwal -->
                                    <div class="mt-2 mb-3 flex flex-wrap gap-2">
                                        <span class="inline-block bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded font-semibold">{{ $ekskul->kategori }}</span>
                                        <span class="inline-block bg-amber-100 text-amber-800 text-xs px-2 py-1 rounded font-semibold flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $ekskul->hari }}, {{ $ekskul->jam }}
                                        </span>
                                    </div>

                                    <p class="text-sm text-gray-600 mb-3 leading-relaxed">{{ $ekskul->deskripsi }}</p>
                                    
                                    <div class="text-sm bg-white p-3 rounded-lg border border-gray-100">
                                        <p><span class="font-semibold text-gray-700">Pembina:</span> {{ $ekskul->pembina }}</p>
                                        <p><span class="font-semibold text-gray-700">Sisa Kuota:</span> <span class="font-bold text-blue-600">{{ $ekskul->kuota }} Siswa</span></p>
                                    </div>
                                </div>

                                <!-- Form Pendaftaran -->
                                <form action="{{ route('pendaftaran.store') }}" method="POST" class="mt-4" id="form-daftar-{{ $ekskul->id }}">
                                    @csrf
                                    <input type="hidden" name="ekstrakurikuler_id" value="{{ $ekskul->id }}">
                                    <!-- Input rahasia untuk konfirmasi pop-up -->
                                    <input type="hidden" name="konfirmasi_bentrok" id="konfirmasi-{{ $ekskul->id }}" value="0">
                                    
                                    @if ($ekskul->kuota > 0)
                                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-lg transition-colors shadow-sm">
                                            Daftar Sekarang
                                        </button>
                                    @else
                                        <button type="button" disabled class="w-full bg-gray-400 text-white font-bold py-2.5 px-4 rounded-lg cursor-not-allowed">
                                            Kuota Penuh
                                        </button>
                                    @endif
                                </form>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-10 bg-gray-50 rounded-lg mt-4 border border-dashed border-gray-300">
                                <p class="text-gray-500 font-medium">Tidak ada ekstrakurikuler di kategori ini.</p>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- MODAL POP-UP PERINGATAN BENTROK JADWAL -->
    @if (session('bentrok_warning'))
        @php $dataBentrok = session('bentrok_warning'); @endphp
        
        <div id="modal-bentrok" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full mx-4 border-t-4 border-yellow-500 transform transition-all">
                <div class="flex items-center gap-3 mb-4">
                    <div class="bg-yellow-100 p-2 rounded-full text-yellow-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Jadwal Bentrok!</h3>
                </div>
                
                <p class="text-gray-600 mb-6 leading-relaxed text-sm">
                    Kamu akan mendaftar ke <strong>{{ $dataBentrok['nama_tujuan'] }}</strong> di hari <strong class="text-blue-600">{{ $dataBentrok['hari'] }}</strong>, tetapi kamu sudah memiliki kegiatan <strong class="text-red-600">{{ $dataBentrok['nama_bentrok'] }}</strong> di hari yang sama.
                    <br><br>
                    Apakah kamu yakin sanggup mengikuti keduanya dan ingin tetap mendaftar?
                </p>
                
                <div class="flex flex-col sm:flex-row gap-3">
                    <button onclick="document.getElementById('modal-bentrok').style.display='none'" class="w-full px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition-colors">
                        Batal
                    </button>
                    
                    <button onclick="lanjutDaftar({{ $dataBentrok['id_tujuan'] }})" class="w-full px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-lg transition-colors shadow-sm">
                        Ya, Tetap Daftar
                    </button>
                </div>
            </div>
        </div>

        <script>
            function lanjutDaftar(id) {
                document.getElementById('konfirmasi-' + id).value = '1';
                document.getElementById('modal-bentrok').style.display = 'none';
                document.getElementById('form-daftar-' + id).submit();
            }
        </script>
    @endif
    <!-- AKHIR MODAL -->

</x-app-layout>