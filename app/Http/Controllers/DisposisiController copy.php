<?php

namespace App\Http\Controllers;

use App\Models\Aktivitas;
use App\Models\Disposisi;
use App\Models\DisposisiTindakan;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DisposisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Disposisi::with(['suratMasuk', 'dariUser', 'penerima'])->latest();

        // Staff hanya lihat disposisi yang ditujukan ke mereka
        if ($user->role === 'staff') {
            $query->whereHas('penerima', fn($q) => $q->where('user_id', $user->id));
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_disposisi', 'like', "%{$request->search}%")
                    ->orWhere('instruksi', 'like', "%{$request->search}%")
                    ->orWhereHas(
                        'suratMasuk',
                        fn($sq) =>
                        $sq->where('perihal', 'like', "%{$request->search}%")
                    );
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->prioritas) {
            $query->where('prioritas', $request->prioritas);
        }

        $disposisi = $query->paginate(10)->withQueryString();

        return view('disposisi.index', compact('disposisi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $suratMasukId = $request->surat_masuk_id;
        $suratMasuk = $suratMasukId ? SuratMasuk::findOrFail($suratMasukId) : null;

        $suratMasukList = SuratMasuk::whereIn('status', ['pending', 'diproses'])
            ->orderBy('tanggal_terima', 'desc')
            ->get();

        $users = User::where('is_active', true)
            ->where('id', '!=', auth()->id())
            ->orderBy('name')
            ->get();

        $tindakanDefault = [
            'Untuk diketahui',
            'Untuk ditindaklanjuti',
            'Untuk diproses',
            'Untuk diteruskan',
            'Untuk koordinasi',
            'Untuk dibuat surat balasan',
            'Untuk diarsipkan',
            'Harap dijawab',
            'Selesaikan dan laporkan',
        ];

        $kodeDisposisi = Disposisi::generateKode();

        return view('disposisi.create', compact(
            'suratMasuk',
            'suratMasukList',
            'users',
            'tindakanDefault',
            'kodeDisposisi'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'surat_masuk_id' => 'required|exists:surat_masuks,id',
            'tanggal_disposisi' => 'required|date',
            'batas_waktu' => 'nullable|date|after_or_equal:tanggal_disposisi',
            'instruksi' => 'required|string',
            'catatan' => 'nullable|string',
            'prioritas' => 'required|in:rendah,normal,tinggi,segera',
            'penerima' => 'required|array|min:1',
            'penerima.*' => 'exists:users,id',
            'tindakan' => 'nullable|array',
            'tindakan.*' => 'string|max:200',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $disposisi = Disposisi::create([
                'kode_disposisi' => Disposisi::generateKode(),
                'surat_masuk_id' => $validated['surat_masuk_id'],
                'user_id' => auth()->id(),
                'tanggal_disposisi' => $validated['tanggal_disposisi'],
                'batas_waktu' => $validated['batas_waktu'] ?? null,
                'instruksi' => $validated['instruksi'],
                'catatan' => $validated['catatan'] ?? null,
                'prioritas' => $validated['prioritas'],
                'status' => 'aktif',
            ]);

            // Attach penerima
            $penerimaData = [];
            foreach ($validated['penerima'] as $userId) {
                $penerimaData[$userId] = ['status' => 'belum_dibaca'];
            }
            $disposisi->penerima()->attach($penerimaData);

            // Save tindakan
            if (!empty($validated['tindakan'])) {
                foreach ($validated['tindakan'] as $i => $t) {
                    if (!empty(trim($t))) {
                        DisposisiTindakan::create([
                            'disposisi_id' => $disposisi->id,
                            'tindakan' => trim($t),
                            'urutan' => $i,
                        ]);
                    }
                }
            }

            // Update status surat masuk
            SuratMasuk::where('id', $validated['surat_masuk_id'])
                ->update(['status' => 'diproses']);

            Aktivitas::catat(
                'tambah_disposisi',
                $disposisi,
                "Membuat disposisi: {$disposisi->kode_disposisi}"
            );
        });

        return redirect()->route('disposisi.index')
            ->with('success', 'Disposisi berhasil dibuat dan dikirim kepada penerima.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Disposisi $disposisi)
    {
        $user = auth()->user();
        $disposisi->load(['suratMasuk', 'dariUser', 'penerima', 'tindakan']);

        // Mark as read if recipient
        $pivot = $disposisi->penerima->where('id', $user->id)->first();
        if ($pivot && $pivot->pivot->status === 'belum_dibaca') {
            $disposisi->penerima()->updateExistingPivot($user->id, [
                'status' => 'dibaca',
                'dibaca_at' => now(),
            ]);
        }

        return view('disposisi.show', compact('disposisi', 'pivot'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Disposisi $disposisi)
    { {
            $this->authorize('update', $disposisi);

            $users = User::where('is_active', true)->where('id', '!=', auth()->id())->orderBy('name')->get();
            $suratMasukList = SuratMasuk::whereIn('status', ['pending', 'diproses'])->get();
            $tindakanDefault = [
                'Untuk diketahui',
                'Untuk ditindaklanjuti',
                'Untuk diproses',
                'Untuk diteruskan',
                'Untuk koordinasi',
                'Untuk dibuat surat balasan',
                'Untuk diarsipkan',
                'Harap dijawab',
                'Selesaikan dan laporkan',
            ];

            $disposisi->load(['penerima', 'tindakan']);
            return view('disposisi.edit', compact('disposisi', 'users', 'suratMasukList', 'tindakanDefault'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Disposisi $disposisi)
    {
        $this->authorize('update', $disposisi);

        $validated = $request->validate([
            'batas_waktu' => 'nullable|date',
            'instruksi' => 'required|string',
            'catatan' => 'nullable|string',
            'prioritas' => 'required|in:rendah,normal,tinggi,segera',
            'status' => 'required|in:aktif,selesai,dibatalkan',
        ]);

        $disposisi->update($validated);
        Aktivitas::catat('edit_disposisi', $disposisi, "Mengedit disposisi: {$disposisi->kode_disposisi}");

        return redirect()->route('disposisi.show', $disposisi)
            ->with('success', 'Disposisi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disposisi $disposisi)
    {
        $this->authorize('delete', $disposisi);
        Aktivitas::catat('hapus_disposisi', $disposisi, "Menghapus disposisi: {$disposisi->kode_disposisi}");
        $disposisi->delete();

        return redirect()->route('disposisi.index')
            ->with('success', 'Disposisi berhasil dihapus.');
    }



    public function tanggapi(Request $request, Disposisi $disposisi)
    {
        $user = auth()->user();

        $request->validate([
            'tanggapan' => 'required|string|max:1000',
            'status' => 'required|in:diproses,selesai',
        ]);

        $disposisi->penerima()->updateExistingPivot($user->id, [
            'tanggapan' => $request->tanggapan,
            'status' => $request->status,
            'selesai_at' => $request->status === 'selesai' ? now() : null,
        ]);

        // Cek apakah semua penerima sudah selesai
        $allDone = $disposisi->penerima()
            ->wherePivotNotIn('status', ['selesai'])
            ->doesntExist();

        if ($allDone) {
            $disposisi->update(['status' => 'selesai']);
            SuratMasuk::where('id', $disposisi->surat_masuk_id)->update(['status' => 'selesai']);
        }

        Aktivitas::catat('tanggapi_disposisi', $disposisi, "Menanggapi disposisi: {$disposisi->kode_disposisi}");

        return back()->with('success', 'Tanggapan berhasil disimpan.');
    }

    public function inbox()
    {
        $user = auth()->user();
        $disposisi = $user->disposisiDiterima()
            ->with(['suratMasuk', 'dariUser'])
            ->latest('disposisi.created_at')
            ->paginate(10);

        return view('disposisi.inbox', compact('disposisi'));
    }
}
