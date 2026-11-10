<x-app-layout>
    <div class="school-photo-backdrop">
        <img src="{{ asset('fotosekolah.jpg') }}" alt="">
        <div class="school-photo-overlay"></div>
    </div>

    <main class="relative z-10 min-h-screen px-4 pb-12 pt-10 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-white">Data Siswa</h1>
                    <p class="mt-1 text-sm text-slate-200">Kelola akun seluruh siswa dan reset password, termasuk siswa yang belum mendaftar ekskul.</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center rounded-lg border border-white/40 bg-white/10 px-4 py-2.5 text-sm font-semibold text-white hover:bg-white/20">
                    Kembali ke Validasi
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-sm font-semibold text-green-900" role="status">
                    {{ session('success') }}
                </div>
            @endif

            <section class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                <div class="flex flex-col gap-4 border-b border-slate-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Daftar Akun Siswa</h2>
                        <p class="mt-1 text-sm text-slate-500">Total hasil: {{ $students->total() }}</p>
                    </div>

                    <form action="{{ route('admin.siswa.index') }}" method="GET" class="flex w-full gap-2 sm:max-w-md">
                        <label for="search" class="sr-only">Cari siswa</label>
                        <input
                            id="search"
                            name="search"
                            type="search"
                            value="{{ $search }}"
                            placeholder="Cari nama, email, atau kelas"
                            class="min-w-0 flex-1 rounded-lg border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                        <button type="submit" class="rounded-lg bg-blue-700 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-800">
                            Cari
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500 sm:px-6">Nama Siswa</th>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500 sm:px-6">Email</th>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500 sm:px-6">Kelas</th>
                                <th scope="col" class="px-5 py-3 text-right text-xs font-bold uppercase tracking-wider text-slate-500 sm:px-6">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($students as $student)
                                <tr class="hover:bg-slate-50">
                                    <td class="whitespace-nowrap px-5 py-4 text-sm font-semibold text-slate-900 sm:px-6">{{ $student->name }}</td>
                                    <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600 sm:px-6">{{ $student->email }}</td>
                                    <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600 sm:px-6">{{ $student->kelas ?: '-' }}</td>
                                    <td class="whitespace-nowrap px-5 py-4 text-right sm:px-6">
                                        <div class="flex justify-end gap-2">
                                            <form action="{{ route('admin.siswa.reset-password', $student->id) }}" method="POST">
                                                @csrf
                                                <button
                                                    type="submit"
                                                    onclick="return confirm('Yakin ingin mereset password siswa ini menjadi 12345?')"
                                                    class="rounded-md bg-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-800 hover:bg-amber-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2"
                                                >
                                                    Reset Password
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.siswa.destroy', $student->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    onclick="return confirm('Hapus permanen data siswa ini beserta seluruh riwayat pendaftaran ekskulnya? Kuota ekskul akan dikembalikan dan tindakan ini tidak dapat dibatalkan.')"
                                                    class="rounded-md bg-red-100 px-3 py-1.5 text-xs font-semibold text-red-800 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                                >
                                                    Hapus Siswa
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-10 text-center text-sm text-slate-500 sm:px-6">
                                        {{ $search ? 'Siswa tidak ditemukan.' : 'Belum ada data siswa.' }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($students->hasPages())
                    <div class="border-t border-slate-200 px-5 py-4 sm:px-6">
                        {{ $students->links() }}
                    </div>
                @endif
            </section>
        </div>
    </main>
</x-app-layout>
