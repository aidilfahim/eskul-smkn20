<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPendaftaranController extends Controller
{
    public function index()
    {
        // Proteksi sederhana agar hanya role 'admin' yang bisa masuk
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Ambil semua data pendaftaran beserta relasi user & ekskulnya
        $pendaftarans = Pendaftaran::with(['user', 'ekstrakurikuler'])->latest()->get();

        return view('admin.pendaftaran', compact('pendaftarans'));
    }

    public function updateStatus(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:diterima,ditolak',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update(['status' => $request->status]);

        return back()->with('success', 'Status pendaftaran berhasil diubah!');
    }
}