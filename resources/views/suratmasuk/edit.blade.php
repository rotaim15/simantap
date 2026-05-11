@extends('layouts.app')

@section('title', 'Edit Surat Masuk')

@section('content')

<div class="max-w-5xl mx-auto">

    <form method="POST" action="{{ route('surat-masuk.update', $suratMasuk) }}" enctype="multipart/form-data"
        class="bg-white rounded-xl shadow">

        @csrf
        @method('PUT')

        <!-- HEADER -->
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold">Edit Surat Masuk</h2>
        </div>

        <input type="text" name="id" value="{{ $suratMasuk->id }}" hidden>

        <!-- BODY -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">


            <!-- No Surat -->
            <div>
                <label class="text-sm">No Surat</label>
                <input type="text" name="no_surat" value="{{ old('no_surat', $suratMasuk->no_surat) }}"
                    class="w-full border rounded-lg p-2 mt-1">
            </div>

            <!-- No Agenda -->
            <div>
                <label class="text-sm">No Agenda</label>
                <input type="text" value="{{ $suratMasuk->no_agenda }}" name="no_agenda" disabled
                    class="w-full border bg-gray-100 rounded-lg p-2 mt-1">
            </div>

            <!-- Tanggal Surat -->
            <div>
                <label class="text-sm">Tanggal Surat</label>
                <input type="date" name="tanggal_surat"
                    value="{{ old('tanggal_surat', $suratMasuk->tanggal_surat) ? $suratMasuk->tanggal_surat->format('Y-m-d') : '' }}"
                    class="w-full border rounded-lg p-2 mt-1">
            </div>

            <!-- Tanggal Terima -->
            <div>
                <label class="text-sm">Tanggal Terima</label>
                <input type="date" name="tanggal_terima"
                    value="{{ old('tanggal_terima', $suratMasuk->tanggal_terima) ? $suratMasuk->tanggal_terima->format('Y-m-d') : '' }}"
                    class="w-full border rounded-lg p-2 mt-1">
            </div>

            <!-- Waktu -->
            <div>
                <label class="text-sm">Waktu Mulai</label>
                <input type="time" name="waktumulai" value="{{ old('waktumulai', $suratMasuk->waktumulai) }}"
                    class="w-full border rounded-lg p-2 mt-1">
            </div>

            <div>
                <label class="text-sm">Waktu Selesai</label>
                <input type="time" name="waktuselesai" value="{{ old('waktuselesai', $suratMasuk->waktuselesai) }}"
                    class="w-full border rounded-lg p-2 mt-1">
            </div>

            <!-- Asal Surat -->
            <div class="md:col-span-2">
                <label class="text-sm">Asal Surat</label>
                <input type="text" name="asal_surat" value="{{ old('asal_surat', $suratMasuk->asal_surat) }}"
                    class="w-full border rounded-lg p-2 mt-1">
            </div>
            <div class="sm:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Disposisikan Ke
                </label>
                <input type="text" name="disposisikan" value="{{ old('disposisikan',
            is_array($suratMasuk->disposisikan)
                ? implode(', ', $suratMasuk->disposisikan)
                : $suratMasuk->disposisikan
        ) }}" class="w-full rounded-xl border-slate-300 focus:border-sky-500 focus:ring-sky-500"
                    placeholder="Contoh: Kabid, Kasubid, Kepala Bidang">
                <p class="text-xs text-slate-500 mt-1">Pisahkan dengan koma (,) jika lebih dari satu</p>
            </div>


            <!-- Perihal -->
            <div>
                <label class="text-sm">Perihal</label>
                <input type="text" name="perihal" value="{{ old('perihal', $suratMasuk->perihal) }}"
                    class="w-full border rounded-lg p-2 mt-1">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Lokasi<span
                        class="text-red-500">*</span></label>
                <input type="text" name="lokasi" value="{{ old('lokasi', $suratMasuk->lokasi) }}"
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input @error('lokasi') border-red-400 @enderror"
                    placeholder="Lokasi Agenda" required>
                @error('lokasi')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>


            <!-- Sifat -->
            <div>
                <label class="text-sm">Sifat</label>
                <select name="sifat" class="w-full border rounded-lg p-2 mt-1">
                    @foreach(['biasa','penting','rahasia','sangat_rahasia'] as $s)
                    <option value="{{ $s }}" {{ old('sifat', $suratMasuk->sifat) == $s ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_',' ',$s)) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Klasifikasi -->
            <div>
                <label class="text-sm">Klasifikasi</label>
                <select name="klasifikasi" class="w-full border rounded-lg p-2 mt-1">
                    @foreach(['umum','internal','eksternal'] as $k)
                    <option value="{{ $k }}" {{ old('klasifikasi', $suratMasuk->klasifikasi) == $k ? 'selected' : '' }}>
                        {{ ucfirst($k) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Lampiran -->
            <div class="md:col-span-2">
                <label class="text-sm">Lampiran</label>
                <input type="text" name="lampiran" value="{{ old('lampiran', $suratMasuk->lampiran) }}"
                    class="w-full border rounded-lg p-2 mt-1">
            </div>

            <!-- Keterangan -->
            <div class="md:col-span-2">
                <label class="text-sm">Keterangan</label>
                <textarea name="keterangan" class="w-full border rounded-lg p-2 mt-1"
                    rows="3">{{ old('keterangan', $suratMasuk->keterangan) }}</textarea>
            </div>

            <!-- Status -->
            <div>
                <label class="text-sm">Status</label>
                <select name="status" class="w-full border rounded-lg p-2 mt-1">
                    @foreach(['pending','diproses','selesai','ditolak'] as $st)
                    <option value="{{ $st }}" {{ old('status', $suratMasuk->status) == $st ? 'selected' : '' }}>
                        {{ ucfirst($st) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- File -->
            <div class="md:col-span-2">
                <label class="text-sm">File Surat</label>

                @if($suratMasuk->file_surat)
                <div class="mb-2">
                    <a href="{{ asset('storage/'.$suratMasuk->file_surat) }}" target="_blank"
                        class="text-blue-600 underline text-sm">
                        Lihat file saat ini
                    </a>
                </div>
                @endif

                <input type="file" name="file_surat" class="w-full border rounded-lg p-2">
            </div>

        </div>

        <!-- FOOTER -->
        <div class="p-6 border-t flex justify-between">

            <a href="{{ route('surat-masuk.show', $suratMasuk) }}" class="px-4 py-2 bg-gray-700 rounded-lg text-white">
                Batal
            </a>

            <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg">
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

@endsection
