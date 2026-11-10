<nav class="bg-white border-b border-gray-200 relative z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- BAGIAN KIRI: Logo & Menu (Jarak Sudah Dirapatkan) -->
            <div class="flex items-center gap-6">
                <!-- Logo Aplikasi -->
                <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="text-lg font-bold text-slate-900 tracking-tight">
                    EKSKUL<span class="text-blue-700">SMKN20</span>
                </a>

                <!-- Link Menu Utama -->
                <div class="hidden sm:flex h-16 items-center gap-6">
                    @if(Auth::user()->role === 'admin')
                        <!-- Menu Khusus Admin -->
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'text-blue-700 border-b-2 border-blue-700 py-5' : 'text-gray-500 hover:text-gray-900 py-5' }}">
                            Validasi Pendaftaran
                        </a>
                        <a href="{{ route('admin.siswa.index') }}" class="text-sm font-medium {{ request()->routeIs('admin.siswa.*') ? 'text-blue-700 border-b-2 border-blue-700 py-5' : 'text-gray-500 hover:text-gray-900 py-5' }}">
                            Data Siswa
                        </a>
                        <a href="{{ route('admin.ekskul.index') }}" class="text-sm font-medium {{ request()->routeIs('admin.ekskul.*') ? 'text-blue-700 border-b-2 border-blue-700 py-5' : 'text-gray-500 hover:text-gray-900 py-5' }}">
                            Data Ekstrakurikuler
                        </a>
                    @else
                        <!-- Menu Khusus Siswa -->
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-blue-700 border-b-2 border-blue-700 py-5' : 'text-gray-500 hover:text-gray-900 py-5' }}">
                            Dashboard
                        </a>
                    @endif
                </div>
            </div>

            <!-- BAGIAN KANAN: Nama Akun & Dropdown Logout -->
            <div class="relative">
                <!-- Tombol Nama (Pas diklik akan memunculkan menu di bawahnya) -->
                <button type="button" aria-expanded="false" aria-controls="menu-logout" onclick="const menu = document.getElementById('menu-logout'); menu.classList.toggle('hidden'); this.setAttribute('aria-expanded', String(!menu.classList.contains('hidden')))" class="flex items-center gap-2 px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-700 hover:bg-gray-50 transition focus:outline-none cursor-pointer">
                    <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                    <!-- Ikon Panah Bawah -->
                    <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Kotak Dropdown Logout (Awalnya tersembunyi) -->
                <div id="menu-logout" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg py-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 font-bold hover:bg-red-50 transition cursor-pointer">
                            Log Out / Keluar
                        </button>
                    </form>
                </div>
            </div>

        </div>
        <div class="flex sm:hidden gap-5 overflow-x-auto border-t border-gray-100 py-3">
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="whitespace-nowrap text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'text-blue-700' : 'text-gray-600' }}">Validasi Pendaftaran</a>
                <a href="{{ route('admin.siswa.index') }}" class="whitespace-nowrap text-sm font-medium {{ request()->routeIs('admin.siswa.*') ? 'text-blue-700' : 'text-gray-600' }}">Data Siswa</a>
                <a href="{{ route('admin.ekskul.index') }}" class="whitespace-nowrap text-sm font-medium {{ request()->routeIs('admin.ekskul.*') ? 'text-blue-700' : 'text-gray-600' }}">Data Ekstrakurikuler</a>
            @else
                <a href="{{ route('dashboard') }}" class="whitespace-nowrap text-sm font-medium text-blue-700">Dashboard</a>
            @endif
            <a href="{{ route('profile.edit') }}" class="whitespace-nowrap text-sm font-medium text-gray-600">Profil</a>
        </div>
    </div>
</nav>