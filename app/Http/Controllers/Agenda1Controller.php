<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Lokasi;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgendaController extends Controller
{

    public function index()
    {
        $agendas = Agenda::with(['lokasi', 'pesertas'])->latest()->get();
        $lokasis = Lokasi::all();
        $pesertas = Peserta::all();

        return view('agendas.index', compact('agendas', 'lokasis', 'pesertas'));
    }
    public function data()
    {
        return response()->json(
            Agenda::with(['lokasi', 'pesertas'])->latest()->get()
        );
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'nullable|date|after_or_equal:waktu_mulai',
            'lokasi_id' => 'required|exists:lokasis,id',
            'peserta_ids' => 'nullable|array',
            'peserta_ids.*' => 'exists:pesertas,id',
        ]);

        DB::transaction(function () use ($validated) {
            $agenda = Agenda::create([
                'judul' => $validated['judul'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'tanggal' => $validated['tanggal'],
                'waktu_mulai' => $validated['waktu_mulai'],
                'waktu_selesai' => $validated['waktu_selesai'] ?? null,
                'lokasi_id' => $validated['lokasi_id'],
            ]);

            if (!empty($validated['peserta_ids'])) {
                // Default status 'hadir' akan terisi otomatis berdasarkan schema DB
                $agenda->pesertas()->sync($validated['peserta_ids']);
            }
        });

        return redirect()->route('agendas.index')->with('success', 'Agenda berhasil ditambahkan!');
    }


    // public function store(Request $request)
    // {
    //     $agenda = Agenda::create([
    //         'judul' => $request->judul,
    //         'deskripsi' => $request->deskripsi,
    //         'tanggal' => $request->tanggal,
    //         'waktu_mulai' => $request->waktu_mulai,
    //         'waktu_selesai' => $request->waktu_selesai,
    //         'lokasi_id' => $request->lokasi_id,
    //     ]);

    //     $pesertaData = collect($request->pesertas)->mapWithKeys(fn($p) => [
    //         $p['id'] => [
    //             'status' => $p['status'] ?? 'hadir',
    //             'catatan' => $p['catatan'] ?? null
    //         ]
    //     ]);

    //     $agenda->pesertas()->sync($pesertaData);

    //     return response()->json(
    //         $agenda->load('lokasi', 'pesertas')
    //     );
    // }

    //    {
    // public function store(Request $request)
    // {
    //     $agenda = Agenda::create([
    //         'judul' => $request->judul,
    //         'deskripsi' => $request->deskripsi,
    //         'tanggal' => $request->tanggal,
    //         'waktu_mulai' => $request->waktu_mulai,
    //         'waktu_selesai' => $request->waktu_selesai,
    //         'lokasi_id' => $request->lokasi_id,
    //     ]);

    //     $pesertaData = collect($request->pesertas)->mapWithKeys(fn($p) => [
    //         $p['id'] => [
    //             'status' => $p['status'] ?? 'hadir',
    //             'catatan' => $p['catatan'] ?? null
    //         ]
    //     ]);

    //     $agenda->peserta()->sync($pesertaData);

    //     return response()->json(
    //         $agenda->load('lokasi', 'peserta')
    //     );
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'judul' => 'required|string|max:255',
    //         'tanggal' => 'required|date',
    //         'waktu_mulai' => 'required',
    //         'waktu_selesai' => 'required',
    //         'lokasi_id' => 'required|exists:lokasis,id',
    //         'pesertas' => 'array',
    //         'pesertas.*.id' => 'exists:pesertas,id'
    //     ]);

    //     DB::beginTransaction();

    //     try {
    //         $agenda = Agenda::create([
    //             'judul' => $request->judul,
    //             'deskripsi' => $request->deskripsi,
    //             'tanggal' => $request->tanggal,
    //             'waktu_mulai' => $request->waktu_mulai,
    //             'waktu_selesai' => $request->waktu_selesai,
    //             'lokasi_id' => $request->lokasi_id,
    //         ]);

    //         $pesertaData = collect($request->pesertas ?? [])
    //             ->mapWithKeys(fn($p) => [
    //                 $p['id'] => [
    //                     'status' => $p['status'] ?? 'hadir',
    //                     'catatan' => $p['catatan'] ?? null
    //                 ]
    //             ]);

    //         $agenda->pesertas()->sync($pesertaData);

    //         DB::commit();

    //         return response()->json(
    //             $agenda->load('lokasi', 'pesertas')
    //         );
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         return response()->json([
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function update(Request $request, $id)
    {
        $agenda = Agenda::findOrFail($id);

        $agenda->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'lokasi_id' => $request->lokasi_id,
        ]);

        $pesertaData = collect($request->pesertas)->mapWithKeys(fn($p) => [
            $p['id'] => [
                'status' => $p['status'],
                'catatan' => $p['catatan']
            ]
        ]);

        $agenda->pesertas()->sync($pesertaData);

        return response()->json(
            $agenda->load('lokasi', 'pesertas')
        );
    }

    public function destroy($id)
    {
        Agenda::destroy($id);
        return back()->with('success', 'Berhasil dihapus');
    }
}
