@extends('layouts.app')

@section('title', 'Tambah Surat Masuk')
@section('page-title', 'Surat Masuk')

@section('breadcrumb')
<a href="{{ route('surat-masuk.index') }}">Surat Masuk</a> / <span class="text-slate-600">Tambah Baru</span>
@endsection

@section('content')
<div class="max-w-4xl">
    <form method="POST" action="{{ route('surat-masuk.store') }}" enctype="multipart/form-data"
        x-data="{ loading: false }" @submit="loading = true">
        @csrf

        <div class="grid gap-6">
            {{-- Info Surat --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        Informasi Surat
                    </h3>
                </div>
                <div class="card-body grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">No. Agenda</label>
                        <input type="text" value="{{ $noAgenda }}" readonly
                            class="w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-sm font-mono text-slate-600 cursor-not-allowed"
                            name="no_agenda">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">No. Surat <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="no_surat" value="{{ old('no_surat') }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input @error('no_surat') border-red-400 @enderror"
                            placeholder="Contoh: 001/DIR/I/2025" required>
                        @error('no_surat')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tanggal Surat <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat') }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input @error('tanggal_surat') border-red-400 @enderror"
                            required>
                        @error('tanggal_surat')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tanggal Diterima <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_terima" value="{{ old('tanggal_terima', date('Y-m-d')) }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input @error('tanggal_terima') border-red-400 @enderror"
                            required>
                        @error('tanggal_terima')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <!-- Waktu -->

                    {{-- Waktu Mulai & Selesai --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Waktu Mulai
                            <span class="text-xs font-normal text-slate-400 ml-1">(opsional)</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <input type="time" name="waktumulai" value="{{ old('waktumulai') }}"
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input @error('waktumulai') border-red-400 @enderror">
                        </div>
                        @error('waktumulai')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Waktu Selesai
                            <span class="text-xs font-normal text-slate-400 ml-1">(opsional)</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <input type="time" name="waktuselesai" value="{{ old('waktuselesai') }}" x-data
                                x-bind:min="$el.closest('form').querySelector('[name=waktumulai]').value || ''"
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input @error('waktuselesai') border-red-400 @enderror">
                        </div>
                        @error('waktuselesai')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Asal Surat <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="asal_surat" value="{{ old('asal_surat') }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input @error('asal_surat') border-red-400 @enderror"
                            placeholder="Nama instansi/pengirim surat" required>
                        @error('asal_surat')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    {{-- disposisikan --}}

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Disposisikan Ke
                        </label>

                        <input type="text" name="disposisikan" value="{{ old('disposisikan') }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input @error('disposisikan') border-red-400 @enderror"
                            placeholder="Contoh: Sekretaris, Kabid Umum, Kabid Hukum">

                        <p class="mt-1 text-xs text-slate-500">
                            Pisahkan dengan tanda koma (,)
                        </p>

                        @error('disposisikan')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Perihal <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="perihal" value="{{ old('perihal') }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input @error('perihal') border-red-400 @enderror"
                            placeholder="Perihal / isi pokok surat" required>
                        @error('perihal')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Lokasi<span
                                class="text-red-500">*</span></label>
                        <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input @error('lokasi') border-red-400 @enderror"
                            placeholder="Lokasi Agenda" required>
                        @error('lokasi')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                </div>
            </div>

            {{-- Klasifikasi --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        Klasifikasi
                    </h3>
                </div>
                <div class="card-body grid sm:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Sifat Surat <span
                                class="text-red-500">*</span></label>
                        <select name="sifat"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input"
                            required>
                            <option value="biasa" {{ old('sifat')=='biasa' ? 'selected' : '' }}>Biasa</option>
                            <option value="penting" {{ old('sifat')=='penting' ? 'selected' : '' }}>Penting</option>
                            <option value="rahasia" {{ old('sifat')=='rahasia' ? 'selected' : '' }}>Rahasia</option>
                            <option value="sangat_rahasia" {{ old('sifat')=='sangat_rahasia' ? 'selected' : '' }}>Sangat
                                Rahasia</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Klasifikasi <span
                                class="text-red-500">*</span></label>
                        <select name="klasifikasi"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input"
                            required>
                            <option value="umum" {{ old('klasifikasi')=='umum' ? 'selected' : '' }}>Umum</option>
                            <option value="internal" {{ old('klasifikasi')=='internal' ? 'selected' : '' }}>Internal
                            </option>
                            <option value="eksternal" {{ old('klasifikasi')=='eksternal' ? 'selected' : '' }}>Eksternal
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Lampiran</label>
                        <input type="text" name="lampiran" value="{{ old('lampiran') }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input"
                            placeholder="Contoh: 1 berkas">
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Keterangan</label>
                        <textarea name="keterangan" rows="3"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input resize-none"
                            placeholder="Keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- File Upload --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                        </div>
                        File Surat
                    </h3>
                </div>
                <div class="card-body">
                    <div x-data="{ fileName: null }"
                        class="border-2 border-dashed border-slate-200 rounded-xl p-8 text-center hover:border-primary-300 transition-colors">
                        <input type="file" name="file_surat" id="file_surat" class="hidden" accept=".pdf,.doc,.docx"
                            @change="fileName = $event.target.files[0]?.name">
                        <label for="file_surat" class="cursor-pointer flex flex-col items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-slate-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                            </div>
                            <div>
                                <p x-show="!fileName" class="text-sm text-slate-600 font-medium">Klik untuk unggah file
                                    atau drag & drop</p>
                                <p x-show="fileName" x-text="fileName" class="text-sm text-primary-600 font-medium"></p>
                                <p class="text-xs text-slate-400 mt-1">PDF, DOC, DOCX — Maks. 10MB</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('surat-masuk.index') }}"
                    class="px-5 py-2.5 text-sm font-semibold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" :disabled="loading"
                    class="flex items-center gap-2 px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm disabled:opacity-70">
                    <svg x-show="loading" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z">
                        </path>
                    </svg>
                    <span x-text="loading ? 'Menyimpan...' : 'Simpan Surat Masuk'"></span>
                </button>
            </div>
        </div>
    </form>
</div>
@endsection