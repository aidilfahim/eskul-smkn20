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
        $kategori_pilihan = $request->query('kategori');

        if ($kategori_pilihan) {
            $ekskuls = Ekstrakurikuler::where('kategori', $kategori_pilihan)->get();
        } else {
            $ekskuls = Ekstrakurikuler::all();
        }

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

        // Cek Kuota (Mencegah daftar jika kuota habis)
        if ($ekskulTujuan->kuota <= 0) {
            return back()->with('error', 'Maaf, kuota untuk ekstrakurikuler ini sudah penuh!');
        }

        // 1. Cek apakah sudah pernah daftar ekskul ini (Anti-Spam)
        $sudahDaftar = Pendaftaran::where('user_id', $user_id)
            ->where('ekstrakurikuler_id', $ekskulTujuan->id)
            ->exists();

        if ($sudahDaftar) {
            return back()->with('error', 'Kamu sudah mendaftar di ekstrakurikuler ini!');
        }

        // 2. LOGIKA BENTROK JADWAL (REVISI GURU: OTOMATIS DITOLAK)
        $ekskulBentrok = Pendaftaran::where('user_id', $user_id)
            ->whereIn('status', ['pending', 'diterima'])
            ->whereHas('ekstrakurikuler', function ($query) use ($ekskulTujuan) {
                // Diubah kembali menjadi 'hari'
                $query->where('hari', $ekskulTujuan->hari);
            })->first();

        if ($ekskulBentrok) {
            return back()->with('error', 'Gagal mendaftar! Jadwal bentrok dengan ekskul ' . $ekskulBentrok->ekstrakurikuler->nama_ekskul . ' (' . $ekskulTujuan->hari . ').');
        }

        // 3. Simpan Pendaftaran
        Pendaftaran::create([
            'user_id' => $user_id,
            'ekstrakurikuler_id' => $ekskulTujuan->id,
            'status' => 'pending',
        ]);

        // 4. Potong Kuota (-1) karena ada yang mendaftar
        $ekskulTujuan->decrement('kuota');

        return back()->with('success', 'Pendaftaran berhasil dikirim!');
    }

    // FUNGSI BARU: Untuk Batal / Keluar Ekskul
    public function keluar($id)
    {
        // 1. Cari data pendaftaran (pastikan milik user yang sedang login)
        $pendaftaran = Pendaftaran::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // 2. Cari data ekstrakurikuler terkait
        $ekskul = Ekstrakurikuler::findOrFail($pendaftaran->ekstrakurikuler_id);

        // 3. Kembalikan kuota (+1) karena kursi kembali kosong
        $ekskul->increment('kuota');

        // 4. Hapus riwayat pendaftaran
        $pendaftaran->delete();

        // 5. Kembali ke dashboard dengan pesan sukses
        return back()->with('success', 'Berhasil! Pendaftaran dibatalkan dan kuota telah dikembalikan. Kamu bebas memilih ekskul lain.');
    }
}