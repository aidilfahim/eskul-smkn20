<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;

class AdminEkskulController extends Controller
{
    // Menampilkan daftar ekstrakurikuler untuk dikelola admin
    public function index()
    {
        $ekskuls = Ekstrakurikuler::all();
        return view('admin.ekskul.index', compact('ekskuls'));
    }

    // Menampilkan form tambah ekskul
    public function create()
    {
        return view('admin.ekskul.create');
    }

    // Menyimpan data ekskul baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_ekskul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'kuota' => 'required|integer|min:1',
            'pembina' => 'required|string|max:255',
            'jadwal' => 'required|string|max:255',
        ]);

        Ekstrakurikuler::create($request->all());

        return redirect()->route('admin.ekskul.index')->with('success', 'Ekstrakurikuler berhasil ditambahkan!');
    }

    // Menampilkan form edit ekskul
    public function edit(Ekstrakurikuler $ekskul)
    {
        return view('admin.ekskul.edit', compact('ekskul'));
    }

    // Memperbarui data ekskul
    public function update(Request $request, Ekstrakurikuler $ekskul)
    {
        $request->validate([
            'nama_ekskul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'kuota' => 'required|integer|min:1',
            'pembina' => 'required|string|max:255',
            'jadwal' => 'required|string|max:255',
        ]);

        $ekskul->update($request->all());

        return redirect()->route('admin.ekskul.index')->with('success', 'Ekstrakurikuler berhasil diperbarui!');
    }

    // Menghapus data ekskul
    public function destroy(Ekstrakurikuler $ekskul)
    {
        $ekskul->delete();
        return redirect()->route('admin.ekskul.index')->with('success', 'Ekstrakurikuler berhasil dihapus!');
    }
}