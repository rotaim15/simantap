<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LokasiController extends Controller
{
    public function index()
    {
        $lokasis = Lokasi::orderBy('nama_lokasi', 'asc')->get();
        return view('lokasi.index', compact('lokasis'));
    }

    public function store(Request $request)
    {
        dd($request->kapasitas);
        $validated = $request->validate([
            'nama_lokasi' => 'required|string|max:60',
            'alamat'      => 'nullable|string|max:100',
            'koordinat'   => 'nullable|string|max:200',
            'kapasitas'   => 'nullable|numeric|min:0',
            'status'      => 'required|in:aktif,tidak aktif',
        ]);

        try {
            $validated['created_by'] = Auth::id();
            $lokasi = Lokasi::create($validated);

            return response()->json([
                'status'  => 'success',
                'message' => 'Lokasi baru berhasil ditambahkan.',
                'data'    => $lokasi
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data.'
            ], 500);
        }
    }

    public function update(Request $request, Lokasi $lokasi)
    {
        $validated = $request->validate([
            'nama_lokasi' => 'required|string|max:60',
            'alamat'      => 'nullable|string|max:100',
            'koordinat'   => 'nullable|string|max:200',
            'kapasitas'   => 'nullable|integer|min:1',
            'status'      => 'required|in:aktif,tidak aktif',
        ]);

        try {
            $validated['updated_by'] = Auth::id();
            $lokasi->update($validated);

            return response()->json([
                'status'  => 'success',
                'message' => 'Data lokasi berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal memperbarui data.'
            ], 500);
        }
    }

    public function destroy(Lokasi $lokasi)
    {
        try {
            $lokasi->delete();
            return response()->json([
                'status'  => 'success',
                'message' => 'Lokasi telah dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data tidak bisa dihapus karena sedang digunakan.'
            ], 500);
        }
    }
}
