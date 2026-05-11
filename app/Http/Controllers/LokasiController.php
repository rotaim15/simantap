<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lokasi;

class LokasiController extends Controller
{
    public function index(Request $request)
    {

        $lokasis = Lokasi::latest()->get();
        return view('layouts.dashboard', [
            'slot' => view('lokasi.index', compact('lokasis'))
        ]);
    }
    public function apiIndex()
    {
        $lokasis = Lokasi::all();
        return response()->json($lokasis);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lokasi' => 'required|max:60',
            'alamat' => 'nullable|max:100',
            'koordinat' => 'nullable|max:200',
            'kapasitas' => 'nullable|integer',
            'keterangan' => 'nullable',
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        $validated['created_by'] = auth()->id();

        $lokasi = Lokasi::create($validated);

        return response()->json([
            'message' => 'Berhasil ditambahkan',
            'data' => $lokasi
        ]);
    }

    public function update(Request $request, Lokasi $lokasi)
    {
        $validated = $request->validate([
            'nama_lokasi' => 'required|max:60',
            'alamat' => 'nullable|max:100',
            'koordinat' => 'nullable|max:200',
            'kapasitas' => 'nullable|integer',
            'keterangan' => 'nullable',
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        $validated['updated_by'] = auth()->id();

        $lokasi->update($validated);

        return response()->json([
            'message' => 'Berhasil diperbarui',
            'data' => $lokasi
        ]);
    }

    public function destroy(Lokasi $lokasi)
    {
        $lokasi->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
