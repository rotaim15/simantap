<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function index(Request $request)
    {
        $pesertas = Peserta::query()
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('jabatan', 'like', "%{$search}%")
                        ->orWhere('instansi', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        if ($request->ajax()) {

            return view('peserta.index', compact('pesertas'));
        }
        return view('layouts.dashboard', [
            'slot' => view('peserta.index', compact('pesertas'))
        ]);
    }
    public function data()
    {
        $pesertas = Peserta::all();
        return response()->json($pesertas);
    }
    public function create(Request $request)
    {
        return view('peserta.create', [
            'nama' => $request->nama
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:60',
            'email' => 'nullable|email|unique:pesertas,email',
            'no_tlp' => 'nullable|string|max:15',
            'tipe' => 'nullable|in:internal,external',
            'jabatan' => 'nullable|string',
            'instansi' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $peserta = Peserta::create($validated);
        // $request->validate([
        //     'nama' => 'required'
        // ]);

        // $peserta = Peserta::create([
        //     'nama' => $request->nama
        // ]);
        return response()->json($peserta);

        return back()->with('success', 'Peserta berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $peserta = Peserta::findOrFail($id);
        // dd($request->all());
        $validated = $request->validate([
            'nama' => 'required|string|max:60',
            'email' => 'required|email|unique:pesertas,email,' . $peserta->id,
            'no_tlp' => 'required|string|max:15',
            'tipe' => 'nullable|in:internal,external',
            'jabatan' => 'nullable|string',
            'instansi' => 'nullable|string',
        ]);

        $peserta->update($validated);
        return back()->with('success', 'Peserta berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $peserta = Peserta::findOrFail($id);
        $peserta->delete();
        return back()->with('success', 'Peserta berhasil dihapus.');
    }
}
