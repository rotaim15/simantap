<?php

namespace App\Http\Controllers;

use App\Models\Aktivitas;
use App\Models\SuratMasuk;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SuratMasuk::with('creator')->latest();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('no_surat', 'like', "%{$request->search}%")
                    ->orWhere('perihal', 'like', "%{$request->search}%")
                    ->orWhere('asal_surat', 'like', "%{$request->search}%")
                    ->orWhere('no_agenda', 'like', "%{$request->search}%");
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->sifat) {
            $query->where('sifat', $request->sifat);
        }

        if ($request->tanggal_dari) {
            $query->where('tanggal_terima', '>=', $request->tanggal_dari);
        }

        if ($request->tanggal_sampai) {
            $query->where('tanggal_terima', '<=', $request->tanggal_sampai);
        }

        $suratMasuk = $query->paginate(10)->withQueryString();

        return view('suratmasuk.index', compact('suratMasuk'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $noAgenda = SuratMasuk::generateNoAgenda();
        return view('suratmasuk.create', compact('noAgenda'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_agenda' => 'required|string|max:100',
            'no_surat' => 'required|string|max:100',
            'tanggal_surat' => 'required|date',
            'tanggal_terima' => 'required|date',
            'waktumulai'   => 'nullable|date_format:H:i',
            'waktuselesai' => 'nullable|date_format:H:i|after_or_equal:waktumulai',
            'asal_surat' => 'required|string|max:200',
            'disposisikan' => 'nullable|string',
            'lokasi' => 'nullable|string|max:200',
            'perihal' => 'required|string|max:500',
            'sifat' => 'required|in:biasa,penting,rahasia,sangat_rahasia',
            'klasifikasi' => 'required|in:umum,internal,eksternal',
            'lampiran' => 'nullable|string|max:200',
            'keterangan' => 'nullable|string',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $validated['no_agenda'] = SuratMasuk::generateNoAgenda();
        $validated['created_by'] = auth()->id();
        $validated['status'] = 'pending';

        if ($request->hasFile('file_surat')) {
            $validated['file_surat'] = $request->file('file_surat')
                ->store('surat/masuk', 'public');
        }

        $surat = SuratMasuk::create($validated);
        Aktivitas::catat('tambah_surat_masuk', $surat, "Menambahkan surat masuk: {$surat->perihal}");

        return redirect()->route('surat-masuk.show', $surat)
            ->with('success', 'Surat masuk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratMasuk $suratMasuk)
    {
        $suratMasuk->load(['creator', 'disposisi.dariUser', 'disposisi.penerima', 'disposisi.tindakan']);
        return view('suratmasuk.show', compact('suratMasuk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratMasuk $suratMasuk)
    {
        return view('suratmasuk.edit', compact('suratMasuk'));
    }

    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        // dd($request->all());

        // dd($request->all());
        $validated = $request->validate([
            'no_surat'        => 'required|string|max:100',
            'tanggal_surat'   => 'required|date',
            'tanggal_terima'  => 'required|date',
            'waktu_mulai'     => 'nullable|date_format:H:i',
            'waktu_selesai'   => 'nullable|date_format:H:i|after_or_equal:waktu_mulai',
            'asal_surat'      => 'required|string|max:200',
            'disposisikan'    => 'nullable|string|max:500',
            'perihal'         => 'required|string|max:500',
            'sifat'           => 'required|in:biasa,penting,rahasia,sangat_rahasia',
            'klasifikasi'     => 'required|in:umum,internal,eksternal',
            'lokasi'          => 'nullable|string|max:300',
            'lampiran'        => 'nullable|string|max:200',
            'keterangan'      => 'nullable|string',
            'file_surat'      => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'status'          => 'required|in:pending,diproses,selesai,ditolak',
        ]);


        if ($request->hasFile('file_surat')) {
            if ($suratMasuk->file_surat) {
                Storage::disk('public')->delete($suratMasuk->file_surat);
            }
            $validated['file_surat'] = $request->file('file_surat')
                ->store('surat/masuk', 'public');
        }

        $suratMasuk->update($validated);
        Aktivitas::catat('edit_surat_masuk', $suratMasuk, "Mengedit surat masuk: {$suratMasuk->perihal}");

        return redirect()->route('surat-masuk.show', $suratMasuk)
            ->with('success', 'Surat masuk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $suratMasuk = SuratMasuk::findOrFail($id);
        if ($suratMasuk->file_surat) {
            Storage::disk('public')->delete($suratMasuk->file_surat);
        }
        $suratMasuk->delete();
        Aktivitas::catat('hapus_surat_masuk', $suratMasuk, "Menghapus surat masuk: {$suratMasuk->perihal}");
        return redirect()->route('surat-masuk.index')
            ->with('success', 'Surat masuk berhasil dihapus.');
    }
}
