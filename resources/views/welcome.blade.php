<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Ekstrakurikuler - SMKN 20 Jakarta</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('logosekolah.png') }}?v=4">
</head>
<body class="antialiased bg-gray-50 text-gray-800 font-sans flex flex-col min-h-screen">
    
    <!-- Navbar / Header -->
    <header class="bg-white border-b border-gray-200 w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between h-16 items-center">
            
            <!-- Sisi Kiri: Nama Teks -->
            <div class="flex items-center">
                <span class="text-lg font-bold text-slate-900 tracking-tight">
                    EKSKUL<span class="text-blue-700">SMKN20</span>
                </span>
            </div>

            <!-- Sisi Kanan: Logo Sekolah (Diperbesar) -->
            <div class="flex items-center">
                <img src="{{ asset('logosekolah.png') }}" alt="Logo SMKN 20" class="h-11 w-auto">
            </div>
            
        </div>
    </header>

    <!-- Konten Utama (Hero Section) -->
    <main class="flex-grow flex items-center py-12 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center w-full">
            
            <!-- Sisi Kiri: Teks & Tombol Utama -->
            <div class="text-center lg:text-left z-10">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight mb-6 tracking-tight">
                    Sistem Pendaftaran <br class="hidden sm:block lg:hidden xl:block"> 
                    <span class="text-blue-700">Ekstrakurikuler</span>
                </h1>
                
                <p class="text-lg sm:text-xl text-gray-600 mb-10 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    Selamat datang di portal resmi Ekstrakurikuler SMKN 20 Jakarta. Temukan minat dan bakatmu, kembangkan potensimu, dan jadilah bagian dari siswa berprestasi!
                </p>
                
                <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 px-6 rounded-lg transition">
                            Buka Dashboard Saya
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 px-6 rounded-lg transition">
                            Log in (Masuk)
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold py-3 px-6 rounded-lg transition">
                                Buat Akun Baru
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Sisi Kanan: Foto Sekolah -->
            <div class="relative mx-auto w-full max-w-lg lg:max-w-full lg:pl-10">
                <div class="rounded-xl overflow-hidden border border-gray-200 bg-gray-200">
                    <img src="{{ asset('fotosekolah.jpg') }}" alt="Lapangan SMKN 20 Jakarta" class="w-full h-[300px] sm:h-[400px] lg:h-[440px] object-cover">
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-6 text-center z-10 mt-auto">
        <p class="text-sm text-gray-500 font-medium">
            &copy; {{ date('Y') }} SMKN 20 Jakarta. Hak Cipta Dilindungi.
        </p>
    </footer>

</body>
</html>