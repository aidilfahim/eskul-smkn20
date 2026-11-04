<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil kategori dari URL (jika tombol filter diklik)
        $kategori_pilihan = $request->query('kategori');

        // 2. Logika filter: Jika ada kategori, filter data. Jika tidak, tampilkan semua.
        if ($kategori_pilihan) {
            $ekskuls = Ekstrakurikuler::where('kategori', $kategori_pilihan)->get();
        } else {
            $ekskuls = Ekstrakurikuler::all();
        }

        // 3. Ambil data riwayat pendaftaran siswa
        $pendaftarans = Pendaftaran::with('ekstrakurikuler')
            ->where('user_id', Auth::id())
            ->get();

        return view('dashboard', compact('ekskuls', 'pendaftarans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ekstrakurikuler_id' => 'required|exists:ekstrakurikulers,id',
        ]);

        $user_id = Auth::id();
        $ekskulTujuan = Ekstrakurikuler::find($request->ekstrakurikuler_id);

        
        $sudahDaftar = Pendaftaran::where('user_id', $user_id)
            ->where('ekstrakurikuler_id', $ekskulTujuan->id)
            ->exists();

        if ($sudahDaftar) {
            return back()->with('error', 'Kamu sudah mendaftar di ekstrakurikuler ini!');
        }

        
        $ekskulBentrok = Pendaftaran::where('user_id', $user_id)
            ->whereIn('status', ['pending', 'diterima'])
            ->whereHas('ekstrakurikuler', function ($query) use ($ekskulTujuan) {
                // Menggunakan kolom 'jadwal' sesuai struktur tabel CRUD kamu
                $query->where('jadwal', $ekskulTujuan->jadwal);
            })->first();

        // Jika bentrok, langsung gagalkan dan lempar notifikasi error
        if ($ekskulBentrok) {
            return back()->with('error', 'Gagal mendaftar! Jadwal bentrok dengan ekskul ' . $ekskulBentrok->ekstrakurikuler->nama_ekskul . ' (' . $ekskulTujuan->jadwal . ').');
        }

        // 3. Simpan Pendaftaran jika lolos pengecekan
        Pendaftaran::create([
            'user_id' => $user_id,
            'ekstrakurikuler_id' => $ekskulTujuan->id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Pendaftaran berhasil dikirim!');
    }
}