<nav class="bg-white border-b border-gray-200 shadow-sm relative z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- BAGIAN KIRI: Logo & Menu (Jarak Sudah Dirapatkan) -->
            <div class="flex items-center gap-6">
                <!-- Logo Aplikasi -->
                <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="text-xl font-bold text-blue-700 tracking-wider">
                    EKSKUL<span class="text-gray-800">SMKN20</span>
                </a>

                <!-- Link Menu Utama -->
                <div class="hidden sm:flex gap-6">
                    @if(Auth::user()->role === 'admin')
                        <!-- Menu Khusus Admin -->
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'text-blue-600 border-b-2 border-blue-600 py-5' : 'text-gray-500 hover:text-gray-700 py-5' }}">
                            Validasi Pendaftaran
                        </a>
                        <a href="{{ route('admin.ekskul.index') }}" class="text-sm font-medium {{ request()->routeIs('admin.ekskul.*') ? 'text-blue-600 border-b-2 border-blue-600 py-5' : 'text-gray-500 hover:text-gray-700 py-5' }}">
                            Data Ekstrakurikuler
                        </a>
                    @else
                        <!-- Menu Khusus Siswa -->
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-blue-600 border-b-2 border-blue-600 py-5' : 'text-gray-500 hover:text-gray-700 py-5' }}">
                            Dashboard
                        </a>
                    @endif
                </div>
            </div>

            <!-- BAGIAN KANAN: Nama Akun & Dropdown Logout -->
            <div class="relative">
                <!-- Tombol Nama (Pas diklik akan memunculkan menu di bawahnya) -->
                <button onclick="document.getElementById('menu-logout').classList.toggle('hidden')" class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-md bg-white text-gray-700 hover:bg-gray-50 transition focus:outline-none shadow-sm cursor-pointer">
                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
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
    </div>
</nav>