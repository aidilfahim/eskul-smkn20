<x-guest-layout>
    <div class="w-full">
        
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Buat Akun Baru</h2>
            <p class="text-sm text-gray-500 mt-1">Pendaftaran Akun Siswa Ekstrakurikuler</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input id="name" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2 border" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Sekolah / Siswa</label>
                <input id="email" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2 border" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password (Gunakan NIS)</label>
                <input id="password" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2 border" type="password" name="password" required autocomplete="new-password" />
                <p class="text-xs text-gray-400 mt-1">Minimal 5 karakter (masukkan NIS)</p>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <input id="password_confirmation" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2 border" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between pt-2">
                <a class="text-xs font-semibold text-blue-600 hover:text-blue-500" href="{{ route('login') }}">
                    Sudah terdaftar? Masuk di sini
                </a>

                <button type="submit" class="inline-flex justify-center py-2.5 px-6 border border-transparent rounded-lg text-sm font-semibold text-white bg-blue-700 hover:bg-blue-800 focus:outline-none transition">
                    Daftar
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>