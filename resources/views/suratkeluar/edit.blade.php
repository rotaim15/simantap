@extends('layouts.app')

@section('title', 'Edit Surat Keluar — ' . $suratKeluar->no_agenda)
@section('page-title', 'Surat Keluar')

@section('breadcrumb')
<a href="{{ route('surat-keluar.index') }}" class="hover:text-slate-600">Surat Keluar</a>
/ <a href="{{ route('surat-keluar.show', $suratKeluar) }}" class="hover:text-slate-600">{{ $suratKeluar->no_agenda
    }}</a>
/ <span class="text-slate-600">Edit</span>
@endsection

@section('content')
<div class="max-w-4xl">

    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-bold text-slate-800">Edit Surat Keluar</h2>
            <p class="text-sm text-slate-500 mt-0.5">
                Nomor Agenda:
                <span class="font-mono font-semibold text-emerald-700">{{ $suratKeluar->no_agenda }}</span>
            </p>
        </div>
        <a href="{{ route('surat-keluar.show', $suratKeluar) }}"
            class="flex items-center gap-2 text-sm text-slate-600 hover:text-slate-800 font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Detail
        </a>
    </div>

    <form method="POST" action="{{ route('surat-keluar.update', $suratKeluar) }}" enctype="multipart/form-data" x-data="{
              loading: false,
              sifat: '{{ old('sifat', $suratKeluar->sifat) }}',
              fileName: null,
              removeFile: false,
              charCount: {{ strlen(old('perihal', $suratKeluar->perihal)) }},
          }" @submit="loading = true">
        @csrf
        @method('PUT')

        <div class="grid gap-6">

            {{-- ── Informasi Surat ── --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        Informasi Surat
                    </h3>
                </div>
                <div class="card-body grid sm:grid-cols-2 gap-5">

                    {{-- No. Agenda (readonly) --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">No. Agenda</label>
                        <div class="relative">
                            <input type="text" value="{{ $suratKeluar->no_agenda }}" readonly
                                class="w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-sm font-mono text-slate-500 cursor-not-allowed pr-10">
                            <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-slate-400">Nomor agenda tidak dapat diubah</p>
                    </div>

                    {{-- No. Surat --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            No. Surat
                            <span class="text-xs font-normal text-slate-400 ml-1">(opsional)</span>
                        </label>
                        <input type="text" name="no_surat" value="{{ old('no_surat', $suratKeluar->no_surat) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input
                                      @error('no_surat') border-red-400 bg-red-50 @enderror"
                            placeholder="Contoh: 045/DINAS/V/2025">
                        @error('no_surat')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    {{-- Tanggal Surat --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Tanggal Surat <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_surat"
                            value="{{ old('tanggal_surat', $suratKeluar->tanggal_surat->format('Y-m-d')) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input
                                      @error('tanggal_surat') border-red-400 bg-red-50 @enderror" required>
                        @error('tanggal_surat')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    {{-- tgl_kirim --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Tanggal Kirim <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggalkirim"
                            value="{{ old('tanggalkirim', $suratKeluar->tanggal_kirim ? $suratKeluar->tanggal_kirim->format('Y-m-d') : null) }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input
                                      @error('tanggalkirim') border-red-400 bg-red-50 @enderror" required>
                        @error('tanggalkirim')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    {{-- time --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Waktu Mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="time" name="waktumulai"
                            value="{{ old('waktumulai', $suratKeluar->waktumulai ? \Carbon\Carbon::parse($suratKeluar->waktumulai)->format('H:i') : null) }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input
                                      @error('waktumulai') border-red-400 bg-red-50 @enderror" required>
                        @error('waktumulai')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Waktu Selesai <span class="text-red-500">*</span>
                        </label>
                        <input type="time" name="waktuselesai"
                            value="{{ old('waktuselesai', $suratKeluar->waktuselesai ? \Carbon\Carbon::parse($suratKeluar->waktuselesai)->format('H:i') : null) }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input
                                      @error('waktuselesai') border-red-400 bg-red-50 @enderror" required>
                        @error('waktuselesai')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    {{-- Tujuan Surat --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Tujuan Surat <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <input type="text" name="tujuan_surat"
                                value="{{ old('tujuan_surat', $suratKeluar->tujuan_surat) }}" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input
                                          @error('tujuan_surat') border-red-400 bg-red-50 @enderror"
                                placeholder="Nama instansi / pejabat tujuan" required>
                        </div>
                        @error('tujuan_surat')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    {{-- disposisikan --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            disposisikan ke <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <input type="text" name="disposisikan"
                                value="{{ old('disposisikan', $suratKeluar->disposisikan) }}" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input
                                          @error('disposisikan') border-red-400 bg-red-50 @enderror"
                                placeholder="Nama instansi / pejabat disposisi" required>
                        </div>
                        @error('disposisikan')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    {{-- lokasi --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Lokasi Agenda <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <input type="text" name="lokasi" value="{{ old('lokasi', $suratKeluar->lokasi) }}" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input
                                          @error('lokasi') border-red-400 bg-red-50 @enderror"
                                placeholder="Lokasi agenda" required>
                        </div>
                        @error('lokasi')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    {{-- Perihal --}}
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Perihal <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="perihal" value="{{ old('perihal', $suratKeluar->perihal) }}"
                                maxlength="500" @input="charCount = $event.target.value.length" class="w-full px-4 py-2.5 pr-16 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input
                                          @error('perihal') border-red-400 bg-red-50 @enderror"
                                placeholder="Perihal / pokok isi surat" required>
                            <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none">
                                <span class="text-xs text-slate-400" x-text="charCount + '/500'"></span>
                            </div>
                        </div>
                        @error('perihal')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- ── Klasifikasi & Status ── --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        Klasifikasi & Status
                    </h3>
                </div>
                <div class="card-body space-y-5">

                    {{-- Sifat as radio cards --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Sifat Surat <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                            @foreach([
                            'biasa' => ['label' => 'Biasa', 'desc' => 'Surat umum biasa'],
                            'penting' => ['label' => 'Penting', 'desc' => 'Perlu perhatian'],
                            'rahasia' => ['label' => 'Rahasia', 'desc' => 'Terbatas'],
                            'sangat_rahasia' => ['label' => 'Sangat Rahasia', 'desc' => 'Sangat terbatas'],
                            ] as $val => $cfg)
                            <label :class="sifat === '{{ $val }}'
                                       ? 'ring-2 ring-primary-500 bg-primary-50'
                                       : 'ring-1 ring-slate-200 bg-slate-50 hover:bg-slate-100'"
                                class="relative flex items-start gap-2.5 p-3 rounded-xl cursor-pointer transition-all">
                                <input type="radio" name="sifat" value="{{ $val }}" class="sr-only"
                                    @change="sifat = '{{ $val }}'" {{ old('sifat', $suratKeluar->sifat) === $val ?
                                'checked' : '' }}>
                                <div class="w-4 h-4 rounded-full border-2 mt-0.5 flex items-center justify-center shrink-0 transition-all"
                                    :class="sifat === '{{ $val }}' ? 'border-primary-600 bg-primary-600' : 'border-slate-300'">
                                    <div class="w-1.5 h-1.5 rounded-full bg-white" x-show="sifat === '{{ $val }}'">
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-slate-700">{{ $cfg['label'] }}</p>
                                    <p class="text-[10px] text-slate-400 mt-0.5">{{ $cfg['desc'] }}</p>
                                </div>
                            </label>
                            @endforeach
                        </div>
                        @error('sifat')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status + Lampiran --}}
                    <div class="grid sm:grid-cols-2 gap-5">

                        {{-- Status --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Status Pengiriman <span class="text-red-500">*</span>
                            </label>
                            <select name="status" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input
                                           @error('status') border-red-400 @enderror" required>
                                @foreach([
                                'draft' => 'Draft',
                                'terkirim' => 'Terkirim',
                                'diterima' => 'Diterima',
                                ] as $val => $label)
                                <option value="{{ $val }}" {{ old('status', $suratKeluar->status) === $val ? 'selected'
                                    : '' }}>
                                    {{ $label }}
                                </option>
                                @endforeach
                            </select>
                            @error('status')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-slate-400">
                                Alur: Draft → Terkirim → Diterima
                            </p>
                        </div>

                        {{-- Lampiran --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Lampiran</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                </div>
                                <input type="text" name="lampiran" value="{{ old('lampiran', $suratKeluar->lampiran) }}"
                                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input"
                                    placeholder="Contoh: 2 berkas, 1 dokumen">
                            </div>
                        </div>

                    </div>

                    {{-- Keterangan --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Keterangan</label>
                        <textarea name="keterangan" rows="3"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input resize-none"
                            placeholder="Keterangan atau catatan tambahan (opsional)">{{ old('keterangan', $suratKeluar->keterangan) }}</textarea>
                    </div>

                </div>
            </div>

            {{-- ── File Surat ── --}}
            <div class="card">
                <div class="card-header flex items-center justify-between">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                        </div>
                        File Surat
                    </h3>
                    <span class="text-xs text-slate-400 font-medium">Opsional</span>
                </div>
                <div class="card-body space-y-4">

                    {{-- File lama (jika ada) --}}
                    @if($suratKeluar->file_surat)
                    <div x-show="!removeFile"
                        class="flex items-center gap-4 p-4 bg-slate-50 rounded-xl border border-slate-200">
                        {{-- Icon file --}}
                        @php
                        $ext = strtolower(pathinfo($suratKeluar->file_surat, PATHINFO_EXTENSION));
                        $iconColor = match($ext) {
                        'pdf' => 'bg-red-100 text-red-600',
                        'doc', 'docx' => 'bg-blue-100 text-blue-600',
                        default => 'bg-slate-100 text-slate-500',
                        };
                        @endphp
                        <div class="w-10 h-10 rounded-xl {{ $iconColor }} flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-800 truncate">
                                {{ basename($suratKeluar->file_surat) }}
                            </p>
                            <p class="text-xs text-slate-400 mt-0.5 uppercase">
                                {{ strtoupper($ext) }} · File surat saat ini
                            </p>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <a href="{{ asset('storage/' . $suratKeluar->file_surat) }}" target="_blank"
                                class="flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-semibold text-slate-600 hover:text-emerald-600 hover:border-emerald-300 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Lihat
                            </a>
                            <button type="button" @click="removeFile = true"
                                class="flex items-center gap-1.5 px-3 py-1.5 bg-red-50 border border-red-200 rounded-lg text-xs font-semibold text-red-600 hover:bg-red-100 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4l16 16M4 20L20 4" />
                                </svg>
                                Ganti File
                            </button>
                        </div>
                    </div>

                    {{-- Info ganti file --}}
                    <div x-show="removeFile" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="flex items-center gap-3 p-3 bg-amber-50 border border-amber-200 rounded-xl text-sm">
                        <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span class="text-amber-800 flex-1 text-xs">File lama akan diganti. Unggah file baru di
                            bawah.</span>
                        <button type="button" @click="removeFile = false; fileName = null; $refs.fileInput.value = ''"
                            class="text-amber-700 hover:text-amber-900 text-xs font-semibold underline shrink-0">
                            Batalkan
                        </button>
                    </div>
                    @endif

                    {{-- Upload area --}}
                    <div :class="{
                            'opacity-40 pointer-events-none': {{ $suratKeluar->file_surat ? 'true' : 'false' }} && !removeFile
                         }"
                        class="relative border-2 border-dashed rounded-xl p-8 text-center transition-all cursor-pointer"
                        :class="fileName
                             ? 'border-emerald-300 bg-emerald-50'
                             : 'border-slate-200 hover:border-emerald-300 hover:bg-emerald-50/30'"
                        @click="{{ $suratKeluar->file_surat ? '' : '' }} $refs.fileInput.click()" @dragover.prevent
                        @drop.prevent="
                             const f = $event.dataTransfer.files[0];
                             if(f) { fileName = f.name; $refs.fileInput.files = $event.dataTransfer.files; }
                         ">
                        <input type="file" name="file_surat" x-ref="fileInput" class="hidden" accept=".pdf,.doc,.docx"
                            @change="fileName = $event.target.files[0]?.name">

                        <div class="flex flex-col items-center gap-3 pointer-events-none">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center transition-colors"
                                :class="fileName ? 'bg-emerald-100' : 'bg-slate-100'">
                                <svg x-show="!fileName" class="w-6 h-6 text-slate-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <svg x-show="fileName" class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p x-show="!fileName" class="text-sm font-semibold text-slate-600">
                                    @if($suratKeluar->file_surat)
                                    Klik untuk mengganti file
                                    @else
                                    Klik atau seret file ke sini
                                    @endif
                                </p>
                                <p x-show="fileName" x-text="fileName" class="text-sm font-semibold text-emerald-700">
                                </p>
                                <p class="text-xs text-slate-400 mt-1">PDF, DOC, DOCX — Maks. <strong>10 MB</strong></p>
                            </div>
                            <button type="button" x-show="fileName"
                                @click.stop="fileName = null; $refs.fileInput.value = ''"
                                class="pointer-events-auto flex items-center gap-1.5 text-xs text-red-500 hover:text-red-700 font-semibold transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Hapus pilihan
                            </button>
                        </div>
                    </div>

                    @error('file_surat')
                    <p class="text-xs text-red-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror

                </div>
            </div>

            {{-- ── Info Perubahan ── --}}
            <div class="flex items-start gap-3 p-4 bg-blue-50 border border-blue-200 rounded-xl text-sm">
                <svg class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-blue-800">
                    <p class="font-semibold">Informasi Perubahan</p>
                    <p class="mt-0.5 text-blue-600 text-xs leading-relaxed">
                        Terakhir diperbarui pada
                        <span class="font-semibold">{{ $suratKeluar->updated_at->isoFormat('dddd, D MMMM YYYY [pukul]
                            HH:mm') }}</span>.
                        Setiap perubahan akan tercatat di riwayat aktivitas sistem.
                    </p>
                </div>
            </div>

            {{-- ── Action Buttons ── --}}
            <div class="flex flex-wrap items-center justify-between gap-3">
                <a href="{{ route('surat-keluar.show', $suratKeluar) }}"
                    class="flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Batal
                </a>

                <div class="flex items-center gap-3">
                    {{-- Reset --}}
                    <button type="reset"
                        @click="sifat = '{{ $suratKeluar->sifat }}'; fileName = null; removeFile = false; charCount = {{ strlen($suratKeluar->perihal) }}"
                        class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                        Reset
                    </button>

                    {{-- Submit --}}
                    <button type="submit" :disabled="loading"
                        class="flex items-center gap-2 px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 disabled:opacity-70 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm shadow-emerald-500/20">
                        <svg x-show="loading" class="animate-spin w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        <svg x-show="!loading" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span x-text="loading ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection
