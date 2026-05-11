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
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Disposisi::with(['suratMasuk', 'suratKeluar', 'dariUser', 'penerima'])->latest();

        // Staff hanya lihat disposisi yang ditujukan ke mereka
        if ($user->role === 'staff') {
            $query->whereHas('penerima', fn($q) => $q->where('user_id', $user->id));
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_disposisi', 'like', "%{$request->search}%")
                    ->orWhere('instruksi', 'like', "%{$request->search}%")
                    ->orWhereHas('suratMasuk', fn($sq) => $sq->where('perihal', 'like', "%{$request->search}%"))
                    ->orWhereHas('suratKeluar', fn($sq) => $sq->where('perihal', 'like', "%{$request->search}%"));
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

    public function create(Request $request)
    {
        $suratMasukId = $request->surat_masuk_id;
        $suratMasuk = $suratMasukId ? SuratMasuk::findOrFail($suratMasukId) : null;

        $suratKeluarId = $request->surat_keluar_id;
        $suratKeluar = $suratKeluarId ? SuratKeluar::findOrFail($suratKeluarId) : null;

        // Tentukan jenis surat berdasarkan parameter atau old input
        $jenis = old('jenis', $request->jenis);
        if ($suratMasuk) $jenis = 'masuk';
        if ($suratKeluar) $jenis = 'keluar';
        if (!$jenis) $jenis = 'masuk'; // default

        $suratMasukList = SuratMasuk::whereIn('status', ['pending', 'diproses'])
            ->orderBy('tanggal_terima', 'desc')
            ->get();

        $suratKeluarList = SuratKeluar::whereIn('status', ['draft', 'terkirim'])
            ->orderBy('tanggal_surat', 'desc')
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
            'suratKeluar',
            'suratMasukList',
            'suratKeluarList',
            'users',
            'tindakanDefault',
            'kodeDisposisi',
            'jenis'
        ));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'jenis' => 'required|in:masuk,keluar',
            'surat_masuk_id' => 'nullable|required_if:jenis,masuk|exists:surat_masuks,id',
            'surat_keluar_id' => 'nullable|required_if:jenis,keluar|exists:surat_keluars,id',
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

        DB::transaction(function () use ($validated) {
            $disposisi = Disposisi::create([
                'jenis' => $validated['jenis'],
                'kode_disposisi' => Disposisi::generateKode(),
                'surat_masuk_id' => $validated['jenis'] === 'masuk' ? $validated['surat_masuk_id'] : null,
                'surat_keluar_id' => $validated['jenis'] === 'keluar' ? $validated['surat_keluar_id'] : null,
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

            // Update status surat terkait
            if ($validated['jenis'] === 'masuk') {
                SuratMasuk::where('id', $validated['surat_masuk_id'])
                    ->update(['status' => 'diproses']);
            } else {
                SuratKeluar::where('id', $validated['surat_keluar_id'])
                    ->update(['status' => 'terkirim']);
            }

            Aktivitas::catat(
                'tambah_disposisi',
                $disposisi,
                "Membuat disposisi: {$disposisi->kode_disposisi}"
            );
        });

        return redirect()->route('disposisi.index')
            ->with('success', 'Disposisi berhasil dibuat dan dikirim kepada penerima.');
    }

    public function show(Disposisi $disposisi)
    {
        $user = auth()->user();
        $disposisi->load(['suratMasuk', 'suratKeluar', 'dariUser', 'penerima', 'tindakan']);

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

    public function edit(Disposisi $disposisi)
    {
        $this->authorize('update', $disposisi);

        $users = User::where('is_active', true)
            ->where('id', '!=', auth()->id())
            ->orderBy('name')
            ->get();

        $suratMasukList = SuratMasuk::whereIn('status', ['pending', 'diproses'])->get();
        $suratKeluarList = SuratKeluar::whereIn('status', ['pending', 'diproses'])->get();

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

        return view('disposisi.edit', compact('disposisi', 'users', 'suratMasukList', 'suratKeluarList', 'tindakanDefault'));
    }

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

            // Update status surat terkait (masuk atau keluar)
            if ($disposisi->surat_masuk_id) {
                SuratMasuk::where('id', $disposisi->surat_masuk_id)->update(['status' => 'selesai']);
            } elseif ($disposisi->surat_keluar_id) {
                SuratKeluar::where('id', $disposisi->surat_keluar_id)->update(['status' => 'selesai']);
            }
        }

        Aktivitas::catat('tanggapi_disposisi', $disposisi, "Menanggapi disposisi: {$disposisi->kode_disposisi}");

        return back()->with('success', 'Tanggapan berhasil disimpan.');
    }

    public function inbox()
    {
        $user = auth()->user();

        // Pastikan method disposisiDiterima ada di model User
        $disposisi = $user->disposisiDiterima()
            ->with(['suratMasuk', 'suratKeluar', 'dariUser'])
            ->latest('disposisi.created_at')
            ->paginate(10);

        return view('disposisi.inbox', compact('disposisi'));
    }
}
