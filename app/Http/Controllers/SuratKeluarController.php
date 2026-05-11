<?php

namespace App\Http\Controllers;

use App\Models\Aktivitas;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = SuratKeluar::with('creator')->latest();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('no_surat', 'like', "%{$request->search}%")
                    ->orWhere('perihal', 'like', "%{$request->search}%")
                    ->orWhere('tujuan_surat', 'like', "%{$request->search}%")
                    ->orWhere('no_agenda', 'like', "%{$request->search}%");
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $suratKeluar = $query->paginate(10)->withQueryString();

        return view('suratkeluar.index', compact('suratKeluar'));
    }

    public function create()
    {
        $noAgenda = SuratKeluar::generateNoAgenda();
        return view('suratkeluar.create', compact('noAgenda'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'no_surat' => 'nullable|string|max:100',
            'tanggal_surat' => 'required|date',
            'tanggal_kirim' => 'nullable|date',
            'tujuan_surat' => 'required|string|max:200',
            'disposisikan' => 'nullable|string|max:500',
            'lokasi' => 'nullable|string|max:200',
            'perihal' => 'required|string|max:500',
            'sifat' => 'required|in:biasa,penting,rahasia,sangat_rahasia',
            'lampiran' => 'nullable|string|max:200',
            'keterangan' => 'nullable|string',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $validated['no_agenda'] = SuratKeluar::generateNoAgenda();
        $validated['created_by'] = auth()->id();
        $validated['status'] = 'draft';

        if ($request->hasFile('file_surat')) {
            $validated['file_surat'] = $request->file('file_surat')
                ->store('surat/keluar', 'public');
        }
        // if ($request->filled('disposisikan')) {

        //     $validated['disposisikan'] = array_values(
        //         array_filter(
        //             array_map('trim', explode(',', $request->disposisikan))
        //         )
        //     );
        // } else {

        //     $validated['disposisikan'] = [];
        // }

        $surat = SuratKeluar::create($validated);
        Aktivitas::catat('tambah_surat_keluar', $surat, "Menambahkan surat keluar: {$surat->perihal}");

        return redirect()->route('surat-keluar.show', $surat)
            ->with('success', 'Surat keluar berhasil ditambahkan.');
    }

    public function show(SuratKeluar $suratKeluar)
    {
        $suratKeluar->load('creator');
        return view('suratkeluar.show', compact('suratKeluar'));
    }

    public function edit(SuratKeluar $suratKeluar)
    {
        return view('suratkeluar.edit', compact('suratKeluar'));
    }

    public function update(Request $request, SuratKeluar $suratKeluar)
    {
        $validated = $request->validate([
            'no_surat' => 'nullable|string|max:100',
            'tanggal_surat' => 'required|date',
            'tanggal_kirim' => 'nullable|date',
            'waktumulai' => 'nullable|date_format:H:i',
            'waktuselesai' => 'nullable|date_format:H:i',
            'tujuan_surat' => 'required|string|max:200',
            'disposisikan' => 'nullable|string|max:500',
            'lokasi' => 'nullable|string|max:200',
            'perihal' => 'required|string|max:500',
            'sifat' => 'required|in:biasa,penting,rahasia,sangat_rahasia',
            'lampiran' => 'nullable|string|max:200',
            'keterangan' => 'nullable|string',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'status' => 'required|in:draft,terkirim,diterima',
        ]);

        if ($request->hasFile('file_surat')) {
            if ($suratKeluar->file_surat) {
                Storage::disk('public')->delete($suratKeluar->file_surat);
            }
            $validated['file_surat'] = $request->file('file_surat')
                ->store('surat/keluar', 'public');
        }

        $suratKeluar->update($validated);
        Aktivitas::catat('edit_surat_keluar', $suratKeluar, "Mengedit surat keluar: {$suratKeluar->perihal}");

        return redirect()->route('surat-keluar.show', $suratKeluar)
            ->with('success', 'Surat keluar berhasil diperbarui.');
    }

    public function destroy(SuratKeluar $suratKeluar)
    {
        if ($suratKeluar->file_surat) {
            Storage::disk('public')->delete($suratKeluar->file_surat);
        }

        Aktivitas::catat('hapus_surat_keluar', $suratKeluar, "Menghapus surat keluar: {$suratKeluar->perihal}");
        $suratKeluar->delete();

        return redirect()->route('surat-keluar.index')
            ->with('success', 'Surat keluar berhasil dihapus.');
    }
}
