<x-guest-layout>
    <div class="w-full">
        
        <!-- Header Judul -->
        <div class="mb-8 text-center">
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Selamat Datang</h2>
            <p class="text-sm text-gray-500 mt-2">Sistem Informasi Ekstrakurikuler SMKN 20 Jakarta</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Alamat email</label>
                <input id="email" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2.5 border" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <div class="flex justify-between items-center mb-1">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <span class="text-xs text-gray-500">
                        Lupa password?
                        <a
                            href="https://wa.me/6289509921469?text={{ urlencode('Halo Admin, saya ingin meminta reset password akun siswa.') }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="font-medium text-blue-600 hover:text-blue-500"
                        >
                            Hubungi admin sekolah
                        </a>
                    </span>
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
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg text-sm font-semibold text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-700 transition">
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