<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="icon" type="image/png" href="{{ asset('logosekolah.png') }}?v=4">
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="relative min-h-screen flex flex-col justify-center items-center px-4 py-10">
            <div class="school-photo-backdrop">
                <img src="{{ asset('fotosekolah.jpg') }}" alt="">
                <div class="school-photo-overlay"></div>
            </div>

            <div class="relative z-10 mb-6">
                <a href="/">
                    <span class="text-xl font-bold tracking-tight text-white">EKSKUL<span class="text-blue-200">SMKN20</span></span>
                </a>
            </div>

            <div class="relative z-10 w-full sm:max-w-md px-6 py-8 bg-white border border-gray-200 shadow-sm overflow-hidden rounded-xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>