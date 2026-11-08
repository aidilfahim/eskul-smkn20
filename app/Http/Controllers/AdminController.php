<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Menampilkan halaman dashboard admin
    public function index()
    {
        // Ambil semua data pendaftaran beserta nama siswa dan ekskulnya
        $pendaftarans = Pendaftaran::with(['user', 'ekstrakurikuler'])->latest()->get();
        return view('admin.dashboard', compact('pendaftarans'));
    }

    // Mengubah status pendaftaran & memotong kuota
    public function updateStatus(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $ekskul = $pendaftaran->ekstrakurikuler;

        // 1. JIKA ADMIN KLIK "TERIMA"
        if ($request->status == 'diterima' && $pendaftaran->status != 'diterima') {
            if ($ekskul->kuota > 0) {
                $ekskul->decrement('kuota'); // Kurangi kuota 1
                $pendaftaran->update(['status' => 'diterima']);
                return back()->with('success', 'Siswa DITERIMA. Kuota ' . $ekskul->nama_ekskul . ' berkurang 1!');
            } else {
                return back()->with('error', 'Gagal! Kuota ekstrakurikuler ini sudah penuh.');
            }
        } 
        // 2. JIKA ADMIN KLIK "TOLAK" / BATALKAN PENERIMAAN
        elseif ($request->status == 'ditolak' && $pendaftaran->status == 'diterima') {
            $ekskul->increment('kuota'); // Kembalikan kuota 1
            $pendaftaran->update(['status' => 'ditolak']);
            return back()->with('success', 'Siswa DITOLAK. Kuota dikembalikan.');
        } 
        // 3. JIKA HANYA MENGUBAH STATUS KE DITOLAK (DARI PENDING)
        else {
            $pendaftaran->update(['status' => $request->status]);
            return back()->with('success', 'Status pendaftaran berhasil diperbarui.');
        }
    }

public function exportWord()
{
    
    $pendaftarans = Pendaftaran::with(['user', 'ekstrakurikuler'])
        ->whereHas('user', function ($query) {
            $query->where('role', '!=', 'admin'); 
        })
        ->get();

    // Siapkan view khusus untuk dokumen Word
    $view = view('admin.export-word', compact('pendaftarans'))->render();

    // Berikan header HTTP agar browser mendownloadnya sebagai file Word (.doc)
    $filename = "Laporan_Pendaftaran_Ekskul_" . date('Y-m-d') . ".doc";
    
    return response($view, 200, [
        'Content-Type' => 'application/msword',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        'Cache-Control' => 'max-age=0',
    ]);
}

}