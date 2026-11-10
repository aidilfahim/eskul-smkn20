<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Ekstrakurikuler;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Menampilkan halaman dashboard admin
    public function index()
    {
        // Ambil semua data pendaftaran beserta nama siswa dan ekskulnya
        $pendaftarans = Pendaftaran::with(['user', 'ekstrakurikuler'])->latest()->get();
        return view('admin.dashboard', compact('pendaftarans'));
    }

    public function students(Request $request)
    {
        abort_unless($request->user()->role === 'admin', 403);

        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
        ]);
        $search = $validated['search'] ?? null;

        $students = User::query()
            ->where('role', 'siswa')
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('kelas', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.siswa.index', compact('students', 'search'));
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

    public function resetPassword(Request $request, $id)
    {
        abort_unless($request->user()->role === 'admin', 403);

        $user = User::where('role', 'siswa')->findOrFail($id);
        $user->password = bcrypt('12345');
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil direset menjadi 12345.');
    }

    public function destroyStudent(Request $request, $id)
    {
        abort_unless($request->user()->role === 'admin', 403);

        DB::transaction(function () use ($id) {
            $student = User::where('role', 'siswa')->lockForUpdate()->findOrFail($id);
            $registrations = Pendaftaran::where('user_id', $student->id)
                ->with('ekstrakurikuler')
                ->get();

            foreach ($registrations as $registration) {
                $registration->ekstrakurikuler->increment('kuota');
            }

            $student->delete();
        });

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa dan seluruh riwayat pendaftarannya berhasil dihapus.');
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