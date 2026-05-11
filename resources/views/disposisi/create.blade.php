@extends('layouts.app')

@section('title', 'Buat Disposisi')
@section('page-title', 'Disposisi')

@section('breadcrumb')
<a href="{{ route('disposisi.index') }}" class="hover:text-slate-600">Disposisi</a>
/ <span class="text-slate-600">Buat Baru</span>
@endsection

@section('content')
<div class="max-w-4xl">

    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-bold text-slate-800">Buat Disposisi Baru</h2>
            <p class="text-sm text-slate-500 mt-0.5">
                Kode: <span class="font-mono font-semibold text-amber-700">{{ $kodeDisposisi }}</span>
            </p>
        </div>
        <a href="{{ route('disposisi.index') }}"
            class="flex items-center gap-2 text-sm text-slate-600 hover:text-slate-800 font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
    <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl">
        <p class="text-sm font-semibold text-red-700 flex items-center gap-2 mb-2">
            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Terdapat {{ $errors->count() }} kesalahan:
        </p>
        <ul class="space-y-1 pl-6 list-disc text-xs text-red-600">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @php
    $oldPenerima = collect(old('penerima', []))
    ->map(function ($id) {
    return \App\Models\User::find($id);
    })
    ->filter()
    ->map(function ($u) {
    return [
    'id' => $u->id,
    'name' => $u->name,
    'role' => $u->role,
    'avatar' => $u->getAvatarUrl(),
    ];
    })
    ->values()
    ->toArray();
    @endphp
    <form method="POST" action="{{ route('disposisi.store') }}" x-data="{
    loading: false,
    jenis: '{{ old('jenis', $jenis) }}',
    penerima: @json($oldPenerima),

    tindakanList: @json(array_values(array_filter(old('tindakan', [])))),
    tindakanBaru: '',
    addTindakan(val) {
        const t = (val || this.tindakanBaru).trim();
        if (t && !this.tindakanList.includes(t)) { this.tindakanList.push(t); }
        this.tindakanBaru = '';
    },
    removeTindakan(i) { this.tindakanList.splice(i, 1); },
    addPenerima(id, name, jabatan, avatar) {
        if (!this.penerima.find(p => p.id == id)) {
            this.penerima.push({ id, name, jabatan, avatar });
        }
    },
    removePenerima(id) { this.penerima = this.penerima.filter(p => p.id != id); },
}" @submit="loading = true">

        @csrf

        {{-- PENTING: field jenis dikirim ke controller --}}
        <input type="hidden" name="jenis" :value="jenis">

        <div class="grid gap-6">

            {{-- ══ 1. Pilih Jenis & Surat ══ --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        Pilih Surat
                    </h3>
                </div>
                <div class="card-body space-y-5">

                    {{-- Toggle Jenis --}}
                    {{-- <div class="flex flex-wrap items-center gap-3">
                        <span class="text-sm font-semibold text-slate-700 shrink-0">Jenis Surat:</span>
                        <div class="flex bg-slate-100 rounded-xl p-1 gap-1">
                            <button type="button" @click="jenis = 'masuk'"
                                :class="jenis === 'masuk' ? 'bg-white text-blue-700 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                                class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                Surat Masuk
                            </button>
                            <button type="button" @click="jenis = 'keluar'"
                                :class="jenis === 'keluar' ? 'bg-white text-emerald-700 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                                class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Surat Keluar
                            </button>
                        </div>
                    </div> --}}
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="text-sm font-semibold text-slate-700 shrink-0">Jenis Surat:</span>
                        <div class="flex bg-slate-100 rounded-xl p-1 gap-1">
                            {{-- Tombol Surat Masuk --}}
                            <button type="button" {{--
                                @click="jenis = 'masuk'; $el.closest('form').querySelector('[name=surat_keluar_id]').value = ''"
                                --}}
                                @click="jenis = 'masuk'; document.getElementsByName('surat_keluar_id')[0].value = ''"
                                :class="jenis === 'masuk' ? 'bg-white text-blue-700 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                                class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                Surat Masuk
                            </button>

                            {{-- Tombol Surat Keluar --}}
                            <button type="button" {{--
                                @click="jenis = 'keluar'; $el.closest('form').querySelector('[name=surat_masuk_id]').value = ''"
                                --}}
                                @click="jenis = 'keluar'; document.getElementsByName('surat_masuk_id')[0].value = ''"
                                :class="jenis === 'keluar' ? 'bg-white text-emerald-700 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                                class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Surat Keluar
                            </button>
                        </div>
                    </div>

                    {{-- Panel Surat Masuk --}}
                    <div x-show="jenis === 'masuk'" x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Surat Masuk <span class="text-red-500">*</span>
                        </label>
                        <select name="surat_masuk_id" :disabled="
                            jenis !=='masuk'" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input
                                       @error('surat_masuk_id') border-red-400 bg-red-50 @enderror">
                            <option value="">— Pilih Surat Masuk —</option>
                            @foreach($suratMasukList as $sm)
                            <option value="{{ $sm->id }}" {{ old('surat_masuk_id', $suratMasuk?->id) == $sm->id ?
                                'selected' : '' }}>
                                [{{ $sm->no_agenda }}] {{ Str::limit($sm->perihal, 55) }} — {{ $sm->asal_surat }}
                            </option>
                            @endforeach
                        </select>
                        @error('surat_masuk_id')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror

                        @if($suratMasuk)
                        <div
                            class="mt-3 flex items-start gap-3 p-3 bg-blue-50 border border-blue-200 rounded-xl text-xs text-blue-800">
                            <svg class="w-4 h-4 text-blue-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="font-bold">{{ $suratMasuk->no_agenda }}</p>
                                <p class="mt-0.5">{{ $suratMasuk->perihal }}</p>
                                <p class="text-blue-500 mt-0.5">Dari: {{ $suratMasuk->asal_surat }} · {{
                                    $suratMasuk->tanggal_terima->isoFormat('D MMM Y') }}</p>
                            </div>
                        </div>
                        @endif

                        @if($suratMasukList->isEmpty())
                        <p class="mt-2 text-xs text-amber-600 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Tidak ada surat masuk dengan status pending/diproses.
                        </p>
                        @endif
                    </div>

                    {{-- Panel Surat Keluar --}}
                    <div x-show="jenis === 'keluar'" x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Surat Keluar <span class="text-red-500">*</span>
                        </label>
                        <select name="surat_keluar_id"
                        :disabled="
                            jenis !=='keluar'"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input
                                       @error('surat_keluar_id') border-red-400 bg-red-50 @enderror">
                            <option value="">— Pilih Surat Keluar —</option>
                            @foreach($suratKeluarList as $sk)
                            <option value="{{ $sk->id }}" {{ old('surat_keluar_id', $suratKeluar?->id) == $sk->id ?
                                'selected' : '' }}>
                                [{{ $sk->no_agenda }}] {{ Str::limit($sk->perihal, 55) }} — {{ $sk->tujuan_surat }}
                            </option>
                            @endforeach
                        </select>
                        @error('surat_keluar_id')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror

                        @if($suratKeluar)
                        <div
                            class="mt-3 flex items-start gap-3 p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-xs text-emerald-800">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="font-bold">{{ $suratKeluar->no_agenda }}</p>
                                <p class="mt-0.5">{{ $suratKeluar->perihal }}</p>
                                <p class="text-emerald-500 mt-0.5">Tujuan: {{ $suratKeluar->tujuan_surat }} · {{
                                    $suratKeluar->tanggal_surat->isoFormat('D MMM Y') }}</p>
                            </div>
                        </div>
                        @endif

                        @if($suratKeluarList->isEmpty())
                        <p class="mt-2 text-xs text-amber-600 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Tidak ada surat keluar dengan status pending/diproses.
                        </p>
                        @endif
                    </div>

                </div>
            </div>

            {{-- ══ 2. Detail Disposisi ══ --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        Detail Disposisi
                    </h3>
                </div>
                <div class="card-body grid sm:grid-cols-2 gap-5">

                    {{-- Tanggal Disposisi --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Tanggal Disposisi <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_disposisi"
                            value="{{ old('tanggal_disposisi', date('Y-m-d')) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input
                                      @error('tanggal_disposisi') border-red-400 bg-red-50 @enderror" required>
                        @error('tanggal_disposisi')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    {{-- Batas Waktu --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Batas Waktu
                            <span class="text-xs font-normal text-slate-400 ml-1">(opsional)</span>
                        </label>
                        <input type="date" name="batas_waktu" value="{{ old('batas_waktu') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input
                                      @error('batas_waktu') border-red-400 bg-red-50 @enderror">
                        @error('batas_waktu')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    {{-- Prioritas --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Prioritas <span class="text-red-500">*</span>
                        </label>
                        <select name="prioritas" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input
                                       @error('prioritas') border-red-400 @enderror" required>
                            @foreach([
                            'rendah' => 'Rendah',
                            'normal' => 'Normal',
                            'tinggi' => 'Tinggi',
                            'segera' => 'Segera / Urgent',
                            ] as $v => $l)
                            <option value="{{ $v }}" {{ old('prioritas', 'normal' )===$v ? 'selected' : '' }}>
                                {{ $l }}
                            </option>
                            @endforeach
                        </select>
                        @error('prioritas')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    {{-- Instruksi --}}
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Instruksi / Perintah <span class="text-red-500">*</span>
                        </label>
                        <textarea name="instruksi" rows="3" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input resize-none
                                         @error('instruksi') border-red-400 bg-red-50 @enderror"
                            placeholder="Tuliskan instruksi atau arahan yang harus dilaksanakan...">{{ old('instruksi') }}</textarea>
                        @error('instruksi')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    {{-- Catatan --}}
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Catatan
                            <span class="text-xs font-normal text-slate-400 ml-1">(opsional)</span>
                        </label>
                        <textarea name="catatan" rows="2"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input resize-none"
                            placeholder="Catatan atau informasi tambahan...">{{ old('catatan') }}</textarea>
                    </div>

                </div>
            </div>

            {{-- ══ 3. Daftar Tindakan ══ --}}
            <div class="card">
                <div class="card-header flex items-center justify-between">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        Daftar Tindakan
                    </h3>
                    <span class="text-xs text-slate-400 font-medium">Opsional</span>
                </div>
                <div class="card-body space-y-4">

                    {{-- Template --}}
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Pilih dari
                            template:</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tindakanDefault as $td)
                            <button type="button" @click="addTindakan('{{ $td }}')"
                                class="text-xs px-3 py-1.5 bg-slate-100 hover:bg-purple-100 hover:text-purple-700 text-slate-600 rounded-lg transition-colors font-medium">
                                + {{ $td }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Input manual --}}
                    <div class="flex gap-2">
                        <input type="text" x-model="tindakanBaru" @keydown.enter.prevent="addTindakan()"
                            class="flex-1 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input"
                            placeholder="Atau ketik tindakan kustom lalu tekan Enter...">
                        <button type="button" @click="addTindakan()"
                            class="px-4 py-2.5 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-sm font-semibold transition-colors shrink-0">
                            Tambah
                        </button>
                    </div>

                    {{-- Hidden inputs untuk tindakan --}}
                    <template x-for="(t, i) in tindakanList" :key="i">
                        <input type="hidden" :name="'tindakan[' + i + ']'" :value="t">
                    </template>

                    {{-- List tindakan --}}
                    <div x-show="tindakanList.length > 0" class="space-y-2">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                            Ditambahkan (<span x-text="tindakanList.length"></span>):
                        </p>
                        <template x-for="(t, i) in tindakanList" :key="i">
                            <div
                                class="flex items-center gap-3 p-3 bg-purple-50 border border-purple-100 rounded-xl group">
                                <div class="w-6 h-6 rounded-lg bg-purple-200 flex items-center justify-center shrink-0">
                                    <span class="text-xs font-bold text-purple-700" x-text="i + 1"></span>
                                </div>
                                <span class="flex-1 text-sm text-slate-700" x-text="t"></span>
                                <button type="button" @click="removeTindakan(i)"
                                    class="text-slate-400 hover:text-red-500 transition-colors shrink-0 opacity-0 group-hover:opacity-100">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                    <p x-show="tindakanList.length === 0" class="text-xs text-slate-400 italic text-center py-2">
                        Belum ada tindakan
                    </p>

                </div>
            </div>

            {{-- ══ 4. Penerima Disposisi ══ --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        Penerima Disposisi <span class="text-red-500 font-normal text-sm ml-0.5">*</span>
                    </h3>
                </div>
                <div class="card-body space-y-4">

                    @error('penerima')
                    <div
                        class="flex items-center gap-2 p-3 bg-red-50 border border-red-200 rounded-xl text-xs text-red-600">
                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </div>
                    @enderror

                    {{-- Hidden inputs penerima — name="penerima[]" sesuai controller --}}
                    <template x-for="p in penerima" :key="p.id">
                        <input type="hidden" name="penerima[]" :value="p.id">
                    </template>

                    {{-- Chip penerima terpilih --}}
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">
                            Dipilih (<span x-text="penerima.length"></span>):
                        </p>
                        <div x-show="penerima.length > 0" class="flex flex-wrap gap-2">
                            <template x-for="p in penerima" :key="p.id">
                                <div
                                    class="flex items-center gap-2 bg-blue-50 border border-blue-200 rounded-xl px-3 py-2">
                                    <img :src="p.avatar" class="w-6 h-6 rounded-lg object-cover shrink-0" alt="">
                                    <div>
                                        <p class="text-xs font-semibold text-slate-800 leading-tight" x-text="p.name">
                                        </p>
                                        <p class="text-[10px] text-slate-400 leading-tight" x-text="p.jabatan"></p>
                                    </div>
                                    <button type="button" @click="removePenerima(p.id)"
                                        class="ml-1 text-slate-400 hover:text-red-500 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                        <p x-show="penerima.length === 0" class="text-xs text-slate-400 italic">
                            Belum ada penerima. Klik nama pegawai di bawah untuk menambahkan.
                        </p>
                    </div>

                    {{-- Daftar pengguna --}}
                    <div class="border border-slate-200 rounded-xl overflow-hidden" x-data="{ cari: '' }">
                        <div class="p-3 bg-slate-50 border-b border-slate-200">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" x-model="cari" placeholder="Cari nama, jabatan, atau unit kerja..."
                                    class="w-full pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-sm form-input">
                            </div>
                        </div>
                        <div class="max-h-56 overflow-y-auto divide-y divide-slate-50">
                            @forelse($users as $u)
                            <button type="button" x-show="cari === '' ||
                                        '{{ strtolower($u->name) }}'.includes(cari.toLowerCase()) ||
                                        '{{ strtolower($u->jabatan ?? '') }}'.includes(cari.toLowerCase()) ||
                                        '{{ strtolower($u->unit_kerja ?? '') }}'.includes(cari.toLowerCase())" @click="addPenerima(
                                        {{ $u->id }},
                                        '{{ addslashes($u->name) }}',
                                        '{{ addslashes($u->jabatan ?? $u->role) }}',
                                        '{{ $u->getAvatarUrl() }}'
                                    )" :class="penerima.find(p => p.id == {{ $u->id }})
                                        ? 'bg-blue-50 cursor-default'
                                        : 'hover:bg-slate-50'"
                                class="w-full flex items-center gap-3 px-4 py-3 text-left transition-colors">
                                <img src="{{ $u->getAvatarUrl() }}" class="w-9 h-9 rounded-xl object-cover shrink-0"
                                    alt="">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-slate-800 truncate">{{ $u->name }}</p>
                                    <p class="text-xs text-slate-400 truncate">
                                        {{ $u->jabatan ?? ucfirst($u->role) }}
                                        @if($u->unit_kerja) · {{ $u->unit_kerja }} @endif
                                    </p>
                                </div>
                                <div x-show="penerima.find(p => p.id == {{ $u->id }})"
                                    class="w-6 h-6 rounded-full bg-blue-500 flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div x-show="!penerima.find(p => p.id == {{ $u->id }})"
                                    class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center shrink-0">
                                    <svg class="w-3 h-3 text-slate-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                            </button>
                            @empty
                            <div class="px-4 py-8 text-center text-sm text-slate-400">
                                Tidak ada pengguna aktif tersedia
                            </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>

            {{-- ══ Action Buttons ══ --}}
            <div class="flex flex-wrap items-center justify-between gap-3">
                <a href="{{ route('disposisi.index') }}"
                    class="flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Batal
                </a>
                <button type="submit" :disabled="loading || penerima.length === 0"
                    class="flex items-center gap-2 px-6 py-2.5 bg-amber-500 hover:bg-amber-600 disabled:opacity-60 disabled:cursor-not-allowed text-white text-sm font-semibold rounded-xl transition-colors shadow-sm shadow-amber-500/20">
                    <svg x-show="loading" class="animate-spin w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z">
                        </path>
                    </svg>
                    <svg x-show="!loading" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    <span x-text="loading
                        ? 'Mengirim...'
                        : (penerima.length === 0 ? 'Pilih penerima dulu' : 'Kirim Disposisi')">
                    </span>
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
    Alpine.data('disposisiForm', () => ({
        addTindakan(val) {
            const t = (val || this.tindakanBaru).trim();

            if (t && !this.tindakanList.includes(t)) {
                this.tindakanList.push(t);
            }

            this.tindakanBaru = '';
        },

        removeTindakan(i) {
            this.tindakanList.splice(i, 1);
        },

        addPenerima(id, name, jabatan, avatar) {
            if (!this.penerima.find(p => p.id == id)) {
                this.penerima.push({
                    id,
                    name,
                    jabatan,
                    avatar
                });
            }
        },

        removePenerima(id) {
            this.penerima = this.penerima.filter(p => p.id != id);
        }
    }))
})
</script>
@endpush
