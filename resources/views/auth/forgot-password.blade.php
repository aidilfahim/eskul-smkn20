<x-guest-layout>
    <div class="w-full">
        
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Atur Ulang Password</h2>
            <p class="text-xs text-gray-500 mt-2 leading-relaxed">
                Lupa kata sandi Anda? Tidak masalah. Cukup masukkan alamat email Anda dan kami akan mengirimkan tautan pemulihan kata sandi melalui email.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Terdaftar</label>
                <input id="email" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2.5 border" type="email" name="email" value="{{ old('email') }}" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg text-sm font-semibold text-white bg-blue-700 hover:bg-blue-800 focus:outline-none transition">
                    Kirim Tautan Reset Password
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-xs font-semibold text-gray-500 hover:text-blue-600 transition">
                &larr; Kembali ke Halaman Login
            </a>
        </div>
    </div>
</x-guest-layout>