<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ekstrakurikuler;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@sekolah.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'AIDHIL FAHIM MUBARRAQ',
            'kelas' => 'XII RPL ',
            'email' => '14145@smkn20.com',
            'password' => Hash::make('14145'),
            'role' => 'siswa',
        ]);

        // 3. Data Asli Ekskul SMKN 20 Jakarta
        $dataEkskul = [
            // Olahraga
            ['nama' => 'Badminton (PB Melaju)', 'kat' => 'Olahraga', 'hari' => 'Selasa', 'jam' => '15:30 - 17:30'],
            ['nama' => 'Futsal', 'kat' => 'Olahraga', 'hari' => 'Rabu', 'jam' => '15:30 - 17:30'],
            ['nama' => 'Basket', 'kat' => 'Olahraga', 'hari' => 'Kamis', 'jam' => '15:30 - 17:30'],
            ['nama' => 'Voli', 'kat' => 'Olahraga', 'hari' => 'Jumat', 'jam' => '15:00 - 17:00'],
            
            // Seni & Budaya
            ['nama' => 'Karawitan Jawa', 'kat' => 'Seni & Budaya', 'hari' => 'Rabu', 'jam' => '15:30 - 17:00'],
            ['nama' => 'Seni Tari (Tatra)', 'kat' => 'Seni & Budaya', 'hari' => 'Kamis', 'jam' => '15:30 - 17:00'],
            ['nama' => 'Band & Seni Musik', 'kat' => 'Seni & Budaya', 'hari' => 'Jumat', 'jam' => '15:00 - 17:00'],
            
            // Bela Diri
            ['nama' => 'Pencak Silat', 'kat' => 'Bela Diri', 'hari' => 'Selasa', 'jam' => '15:30 - 17:00'],
            ['nama' => 'Taekwondo', 'kat' => 'Bela Diri', 'hari' => 'Kamis', 'jam' => '15:30 - 17:00'],
            
            // Akademik & Organisasi
            ['nama' => 'Paskibra (Cakra Ferociter)', 'kat' => 'Akademik & Organisasi', 'hari' => 'Rabu', 'jam' => '15:30 - 17:30'],
            ['nama' => 'Pramuka', 'kat' => 'Akademik & Organisasi', 'hari' => 'Jumat', 'jam' => '13:30 - 15:30'],
            ['nama' => 'KIR', 'kat' => 'Akademik & Organisasi', 'hari' => 'Senin', 'jam' => '15:30 - 17:00'],
            ['nama' => 'English Club', 'kat' => 'Akademik & Organisasi', 'hari' => 'Selasa', 'jam' => '15:30 - 17:00'],
            ['nama' => 'Japanese Club', 'kat' => 'Akademik & Organisasi', 'hari' => 'Rabu', 'jam' => '15:30 - 17:00'],
            
            // Kerohanian & Sosial
            ['nama' => 'Rohis (Rohani Islam)', 'kat' => 'Kerohanian & Sosial', 'hari' => 'Jumat', 'jam' => '11:30 - 13:30'],
            ['nama' => 'Rohkris (Rohani Kristen)', 'kat' => 'Kerohanian & Sosial', 'hari' => 'Jumat', 'jam' => '11:30 - 13:30'],
            ['nama' => 'PMR (Palang Merah Remaja)', 'kat' => 'Kerohanian & Sosial', 'hari' => 'Kamis', 'jam' => '15:30 - 17:30'],
        ];

        // Looping untuk memasukkan data ke database
        foreach ($dataEkskul as $ekskul) {
            Ekstrakurikuler::create([
                'nama_ekskul' => $ekskul['nama'],
                'kategori' => $ekskul['kat'],
                'hari' => $ekskul['hari'],
                'jam' => $ekskul['jam'],
                'deskripsi' => 'Kegiatan ekstrakurikuler ' . $ekskul['nama'] . ' SMKN 20 Jakarta.',
                'pembina' => 'Pembina ' . $ekskul['nama'],
                'kuota' => 30,
            ]);
        }
    }
}