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
        abort_unless($request->user()->role === 'admin', 403);

        $validated = $request->validate([
            'status' => ['required', 'in:diterima,ditolak'],
        ]);

        $result = DB::transaction(function () use ($id, $validated) {
            $pendaftaran = Pendaftaran::query()->lockForUpdate()->findOrFail($id);
            $ekskul = Ekstrakurikuler::query()
                ->lockForUpdate()
                ->findOrFail($pendaftaran->ekstrakurikuler_id);

            if ($pendaftaran->status === $validated['status']) {
                return ['error' => 'Status pendaftaran tidak berubah.'];
            }

            if ($validated['status'] === 'ditolak') {
                $ekskul->increment('kuota');
            } elseif ($pendaftaran->status === 'ditolak') {
                if ($ekskul->kuota < 1) {
                    return ['error' => 'Gagal menerima siswa: kuota ekstrakurikuler ini sudah penuh.'];
                }

                $ekskul->decrement('kuota');
            }

            $pendaftaran->update(['status' => $validated['status']]);

            return ['success' => 'Status pendaftaran berhasil diperbarui.'];
        });

        if (isset($result['error'])) {
            return back()->with('error', $result['error']);
        }

        return back()->with('success', $result['success']);
    }

    public function bulkUpdate(Request $request)
    {
        abort_unless($request->user()->role === 'admin', 403);

        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1', 'max:100'],
            'ids.*' => ['required', 'integer', 'distinct', 'exists:pendaftarans,id'],
            'status' => ['required', 'in:diterima,ditolak'],
        ]);

        $updatedCount = DB::transaction(function () use ($validated) {
            $pendaftarans = Pendaftaran::query()
                ->whereIn('id', $validated['ids'])
                ->where('status', 'pending')
                ->orderBy('id')
                ->lockForUpdate()
                ->get();

            if ($pendaftarans->isEmpty()) {
                return 0;
            }

            if ($validated['status'] === 'ditolak') {
                foreach ($pendaftarans->groupBy('ekstrakurikuler_id') as $ekskulId => $group) {
                    $ekskul = Ekstrakurikuler::query()
                        ->lockForUpdate()
                        ->findOrFail($ekskulId);
                    $ekskul->increment('kuota', $group->count());
                }
            }

            return Pendaftaran::query()
                ->whereIn('id', $pendaftarans->modelKeys())
                ->where('status', 'pending')
                ->update(['status' => $validated['status']]);
        });

        if ($updatedCount === 0) {
            return back()->with('error', 'Tidak ada pendaftaran berstatus menunggu yang dipilih.');
        }

        $statusLabel = $validated['status'] === 'diterima' ? 'diterima' : 'ditolak';

        return back()->with('success', "{$updatedCount} pendaftaran berhasil {$statusLabel}.");
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