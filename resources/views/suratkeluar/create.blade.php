@extends('layouts.app')

@section('title', 'Tambah Surat Keluar')
@section('page-title', 'Surat Keluar')

@section('breadcrumb')
    <a href="{{ route('surat-keluar.index') }}" class="hover:text-slate-600">Surat Keluar</a>
    / <span class="text-slate-600">Tambah Baru</span>
@endsection

@section('content')
<div class="max-w-4xl">

    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-bold text-slate-800">Tambah Surat Keluar</h2>
            <p class="text-sm text-slate-500 mt-0.5">Isi formulir berikut untuk mencatat surat keluar baru</p>
        </div>
        <a href="{{ route('surat-keluar.index') }}"
           class="flex items-center gap-2 text-sm text-slate-600 hover:text-slate-800 font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('surat-keluar.store') }}"
          enctype="multipart/form-data"
          x-data="{
              loading: false,
              sifat: '{{ old('sifat', 'biasa') }}',
              fileName: null,
              charCount: {{ strlen(old('perihal', '')) }},
          }"
          @submit="loading = true">
        @csrf

        <div class="grid gap-6">

            {{-- ── Informasi Surat ── --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        Informasi Surat
                    </h3>
                </div>

                <div class="card-body grid sm:grid-cols-2 gap-5">

                    {{-- No. Agenda (auto generate, readonly) --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">No. Agenda</label>
                        <div class="relative">
                            <input type="text" value="{{ $noAgenda }}" readonly
                                   class="w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-sm font-mono text-slate-500 cursor-not-allowed pr-10">
                            <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-slate-400">Dibuat otomatis oleh sistem</p>
                    </div>

                    {{-- No. Surat (opsional, bisa diisi setelah penomoran resmi) --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            No. Surat
                            <span class="text-xs font-normal text-slate-400 ml-1">(opsional)</span>
                        </label>
                        <input type="text" name="no_surat"
                               value="{{ old('no_surat') }}"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input
                                      @error('no_surat') border-red-400 bg-red-50 @enderror"
                               placeholder="Contoh: 045/DINAS/V/2025">
                        <p class="mt-1 text-xs text-slate-400">Bisa diisi setelah mendapat nomor resmi</p>
                        @error('no_surat')
                            <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
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
                               value="{{ old('tanggal_surat', date('Y-m-d')) }}"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input
                                      @error('tanggal_surat') border-red-400 bg-red-50 @enderror"
                               required>
                        @error('tanggal_surat')
                            <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                     <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Tanggal Kirim <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_kirim"
                               value="{{ old('tanggal_kirim', date('Y-m-d')) }}"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input
                                      @error('tanggal_kirim') border-red-400 bg-red-50 @enderror"
                               required>
                        @error('tanggal_surat')
                            <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    {{-- TIME --}}
                     <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Waktu Mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="time" name="waktumulai"
                            value="{{ old('waktumulai', null) }}"
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
                            value="{{ old('waktuselesai', null) }}"
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
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <input type="text" name="tujuan_surat"
                                   value="{{ old('tujuan_surat') }}"
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input
                                          @error('tujuan_surat') border-red-400 bg-red-50 @enderror"
                                   placeholder="Nama instansi / pejabat tujuan"
                                   required>
                        </div>
                        @error('tujuan_surat')
                            <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            disposisikan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="disposisikan"
                                   value="{{ old('disposisikan') }}"
                                   maxlength="500"
                                   @input="charCount = $event.target.value.length"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input
                                          @error('disposisikan') border-red-400 bg-red-50 @enderror"
                                   placeholder="Disposisikan"
                                   required>
                            <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none">
                                <span class="text-xs text-slate-400" x-text="charCount + '/500'">0/500</span>
                            </div>
                        </div>
                        @error('disposisikan')
                            <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                     <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            lokasi <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="lokasi"
                                   value="{{ old('lokasi') }}"
                                   maxlength="200"
                                   @input="charCount = $event.target.value.length"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input
                                          @error('lokasi') border-red-400 bg-red-50 @enderror"
                                   placeholder="Lokasi"
                                   required>
                            <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none">
                                <span class="text-xs text-slate-400" x-text="charCount + '/200'">0/200</span>
                            </div>
                        </div>
                        @error('lokasi')
                            <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Perihal --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Perihal <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="perihal"
                                   value="{{ old('perihal') }}"
                                   maxlength="500"
                                   @input="charCount = $event.target.value.length"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input
                                          @error('perihal') border-red-400 bg-red-50 @enderror"
                                   placeholder="Perihal / pokok isi surat"
                                   required>
                            <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none">
                                <span class="text-xs text-slate-400" x-text="charCount + '/500'">0/500</span>
                            </div>
                        </div>
                        @error('perihal')
                            <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- ── Klasifikasi ── --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        Klasifikasi Surat
                    </h3>
                </div>

                <div class="card-body grid sm:grid-cols-2 gap-5">

                    {{-- Sifat Surat --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Sifat Surat <span class="text-red-500">*</span>
                        </label>

                        {{-- Sifat as radio cards --}}
                        <div class="grid grid-cols-2 gap-2">
                            @foreach([
                                'biasa'          => ['label' => 'Biasa',         'color' => 'slate',  'desc' => 'Surat umum biasa'],
                                'penting'        => ['label' => 'Penting',        'color' => 'orange', 'desc' => 'Perlu perhatian'],
                                'rahasia'        => ['label' => 'Rahasia',        'color' => 'red',    'desc' => 'Terbatas'],
                                'sangat_rahasia' => ['label' => 'Sangat Rahasia', 'color' => 'red',    'desc' => 'Sangat terbatas'],
                            ] as $val => $cfg)
                            <label class="relative cursor-pointer"
                                   :class="sifat === '{{ $val }}'
                                       ? 'ring-2 ring-primary-500 bg-primary-50'
                                       : 'ring-1 ring-slate-200 bg-slate-50 hover:bg-slate-100'"
                                   class="flex items-start gap-2.5 p-3 rounded-xl transition-all">
                                <input type="radio" name="sifat" value="{{ $val }}"
                                       class="sr-only"
                                       @change="sifat = '{{ $val }}'"
                                       {{ old('sifat', 'biasa') === $val ? 'checked' : '' }}>
                                <div class="w-4 h-4 rounded-full border-2 mt-0.5 flex items-center justify-center shrink-0 transition-all"
                                     :class="sifat === '{{ $val }}' ? 'border-primary-600 bg-primary-600' : 'border-slate-300'">
                                    <div class="w-1.5 h-1.5 rounded-full bg-white"
                                         x-show="sifat === '{{ $val }}'"></div>
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

                    {{-- Lampiran + Keterangan --}}
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Lampiran</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                    </svg>
                                </div>
                                <input type="text" name="lampiran"
                                       value="{{ old('lampiran') }}"
                                       class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input"
                                       placeholder="Contoh: 2 berkas, 1 dokumen">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Keterangan</label>
                            <textarea name="keterangan" rows="3"
                                      class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input resize-none"
                                      placeholder="Keterangan atau catatan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ── File Surat ── --}}
            <div class="card">
                <div class="card-header flex items-center justify-between">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                            </svg>
                        </div>
                        Lampirkan File Surat
                    </h3>
                    <span class="text-xs text-slate-400 font-medium">Opsional</span>
                </div>

                <div class="card-body">
                    <div x-data
                         class="relative border-2 border-dashed rounded-xl p-8 text-center transition-all cursor-pointer"
                         :class="fileName
                             ? 'border-emerald-300 bg-emerald-50'
                             : 'border-slate-200 hover:border-emerald-300 hover:bg-emerald-50/30'"
                         @click="$refs.fileInput.click()"
                         @dragover.prevent
                         @drop.prevent="
                             const f = $event.dataTransfer.files[0];
                             if(f) { fileName = f.name; $refs.fileInput.files = $event.dataTransfer.files; }
                         ">
                        <input type="file" name="file_surat" id="file_surat"
                               x-ref="fileInput"
                               class="hidden"
                               accept=".pdf,.doc,.docx"
                               @change="fileName = $event.target.files[0]?.name">

                        <div class="flex flex-col items-center gap-3 pointer-events-none">
                            {{-- Icon --}}
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center transition-colors"
                                 :class="fileName ? 'bg-emerald-100' : 'bg-slate-100'">
                                <svg x-show="!fileName" class="w-7 h-7 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <svg x-show="fileName" class="w-7 h-7 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>

                            {{-- Text --}}
                            <div>
                                <p x-show="!fileName"
                                   class="text-sm font-semibold text-slate-600">
                                    Klik atau seret file ke sini
                                </p>
                                <p x-show="fileName"
                                   x-text="fileName"
                                   class="text-sm font-semibold text-emerald-700">
                                </p>
                                <p class="text-xs text-slate-400 mt-1">
                                    Format: PDF, DOC, DOCX — Ukuran maks. <strong>10 MB</strong>
                                </p>
                            </div>

                            {{-- Remove file button --}}
                            <button type="button"
                                    x-show="fileName"
                                    @click.stop="fileName = null; $refs.fileInput.value = ''"
                                    class="pointer-events-auto flex items-center gap-1.5 text-xs text-red-500 hover:text-red-700 font-semibold mt-1 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Hapus file
                            </button>
                        </div>
                    </div>

                    @error('file_surat')
                        <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            {{-- ── Info Box ── --}}
            <div class="flex items-start gap-3 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-sm">
                <svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="text-emerald-800">
                    <p class="font-semibold">Status Awal: Draft</p>
                    <p class="mt-0.5 text-emerald-700 text-xs leading-relaxed">
                        Surat keluar yang baru dibuat akan berstatus <strong>Draft</strong>.
                        Ubah status menjadi <strong>Terkirim</strong> setelah surat dikirimkan, dan <strong>Diterima</strong> setelah ada konfirmasi penerimaan.
                    </p>
                </div>
            </div>

            {{-- ── Action Buttons ── --}}
            <div class="flex flex-wrap items-center justify-between gap-3">
                <a href="{{ route('surat-keluar.index') }}"
                   class="flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Batal
                </a>

                <div class="flex items-center gap-3">
                    {{-- Reset --}}
                    <button type="reset"
                            @click="sifat = 'biasa'; fileName = null; charCount = 0"
                            class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                        Reset
                    </button>

                    {{-- Submit --}}
                    <button type="submit"
                            :disabled="loading"
                            class="flex items-center gap-2 px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 disabled:opacity-70 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm shadow-emerald-500/20">
                        <svg x-show="loading" class="animate-spin w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        <svg x-show="!loading" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        <span x-text="loading ? 'Menyimpan...' : 'Simpan Surat Keluar'"></span>
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection
