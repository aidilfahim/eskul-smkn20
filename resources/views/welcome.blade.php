<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Ekstrakurikuler - SMKN 20 Jakarta</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Memuat Tailwind CSS -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="antialiased bg-gray-50 text-gray-800 font-figtree selection:bg-blue-500 selection:text-white flex flex-col min-h-screen">
    
    <!-- Navbar / Header -->
    <header class="bg-white border-b border-gray-200 shadow-sm w-full absolute top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between h-20 items-center">
            
            <!-- Sisi Kiri: Nama Teks -->
            <div class="flex items-center">
                <span class="text-2xl font-extrabold text-blue-700 tracking-wider">
                    EKSKUL<span class="text-gray-800">SMKN20</span>
                </span>
            </div>

            <!-- Sisi Kanan: Logo Sekolah (Diperbesar) -->
            <div class="flex items-center">
                <img src="{{ asset('logosekolah.png') }}" alt="Logo SMKN 20" class="h-14 w-auto hover:scale-105 transition-transform">
            </div>
            
        </div>
    </header>

    <!-- Konten Utama (Hero Section) -->
    <main class="flex-grow flex items-center pt-28 pb-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full relative overflow-hidden">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center w-full">
            
            <!-- Sisi Kiri: Teks & Tombol Utama -->
            <div class="text-center lg:text-left z-10">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6 tracking-tight">
                    Sistem Pendaftaran <br class="hidden sm:block lg:hidden xl:block"> 
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Ekstrakurikuler</span>
                </h1>
                
                <p class="text-lg sm:text-xl text-gray-600 mb-10 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    Selamat datang di portal resmi Ekstrakurikuler SMKN 20 Jakarta. Temukan minat dan bakatmu, kembangkan potensimu, dan jadilah bagian dari siswa berprestasi!
                </p>
                
                <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-8 rounded-xl shadow-lg transition transform hover:-translate-y-1">
                            Buka Dashboard Saya
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-8 rounded-xl shadow-lg transition transform hover:-translate-y-1">
                            Log in (Masuk)
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-white border-2 border-gray-200 text-gray-700 hover:border-gray-300 hover:bg-gray-50 font-bold py-3.5 px-8 rounded-xl shadow-sm transition transform hover:-translate-y-1">
                                Buat Akun Baru
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Sisi Kanan: Foto Sekolah -->
            <div class="relative mx-auto w-full max-w-lg lg:max-w-full lg:pl-10">
                <div class="absolute -inset-4 bg-gradient-to-tr from-blue-300 to-indigo-200 rounded-[2.5rem] blur-2xl opacity-50"></div>
                <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white bg-gray-200 group">
                    <img src="{{ asset('fotosekolah.jpg') }}" alt="Lapangan SMKN 20 Jakarta" class="w-full h-[350px] sm:h-[450px] lg:h-[500px] object-cover transform group-hover:scale-105 transition-transform duration-700 ease-in-out">
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