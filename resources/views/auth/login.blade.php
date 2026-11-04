<x-guest-layout>
    <!-- Background Foto Sekolah dengan Overlay Gelap & Blur Tipis -->
    <div class="fixed inset-0 z-0">
        <img src="{{ asset('fotosekolah.jpg') }}" alt="Background SMKN 20 Jakarta" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
    </div>

    <!-- Konten Form Login di Tengah -->
    <div class="relative z-10 sm:max-w-md w-full bg-white/95 backdrop-blur-md p-8 rounded-2xl shadow-2xl border border-white/20 my-auto">
        
        <!-- Header Judul -->
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Selamat Datang</h2>
            <p class="text-sm text-gray-500 mt-2">Sistem Informasi Ekstrakurikuler SMKN 20 Jakarta</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input id="email" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2.5 border" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <div class="flex justify-between items-center mb-1">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    @if (Route::has('password.request'))
                        <a class="text-xs font-medium text-blue-600 hover:text-blue-500" href="{{ route('password.request') }}">
                            Lupa password?
                        </a>
                    @endif
                </div>
                <input id="password" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2.5 border" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" name="remember">
                <label for="remember_me" class="ml-2 block text-sm text-gray-700">Ingat Saya</label>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:-translate-y-0.5">
                    Masuk ke Sistem
                </button>
            </div>
        </form>
        
        <!-- Tombol Kembali ke Beranda -->
        <div class="mt-6 text-center">
            <a href="/" class="text-xs font-semibold text-gray-500 hover:text-blue-600 transition">
                &larr; Kembali ke Beranda Utama
            </a>
        </div>
    </div>
</x-guest-layout>