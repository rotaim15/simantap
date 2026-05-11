@extends('layouts.app')

@section('title', 'Detail Surat Keluar — ' . $suratKeluar->no_agenda)
@section('page-title', 'Surat Keluar')

@section('breadcrumb')
<a href="{{ route('surat-keluar.index') }}" class="hover:text-slate-600">Surat Keluar</a>
/ <span class="text-slate-600">Detail</span>
@endsection

@section('content')
<div class="space-y-6 animate-fade-in-up">

    {{-- ── Action Bar ── --}}
    <div class="flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('surat-keluar.index') }}"
            class="flex items-center gap-2 text-sm text-slate-600 hover:text-slate-800 font-medium transition-colors no-print">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar
        </a>

        <div class="flex items-center gap-2 flex-wrap">

            {{-- Cetak --}}
            <button onclick="window.print()"
                class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 rounded-xl text-sm font-medium transition-colors no-print">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak
            </button>

            @if($suratKeluar->file_surat)
            {{-- Unduh File --}}
            <a href="{{ asset('storage/' . $suratKeluar->file_surat) }}" target="_blank"
                class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 rounded-xl text-sm font-medium transition-colors no-print">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Unduh File
            </a>
            @endif

            @if(auth()->user()->isAdmin())
            {{-- Edit --}}
            <a href="{{ route('surat-keluar.edit', $suratKeluar) }}"
                class="flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-sm font-semibold transition-colors shadow-sm no-print">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>

            {{-- Hapus --}}
            <form method="POST" action="{{ route('surat-keluar.destroy', $suratKeluar) }}" x-data
                @submit.prevent="if(confirm('Yakin ingin menghapus surat keluar ini? Tindakan ini tidak dapat dibatalkan.')) $el.submit()">
                @csrf @method('DELETE')
                <button type="submit"
                    class="flex items-center gap-2 px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 rounded-xl text-sm font-semibold transition-colors no-print">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus
                </button>
            </form>
            @endif
        </div>
    </div>

    {{-- ── Print Header ── --}}
    <div class="hidden print-only text-center mb-6 border-b-2 border-slate-800 pb-4">
        <h1 class="text-xl font-bold uppercase tracking-widest">SURAT KELUAR</h1>
        <p class="text-sm text-slate-600 mt-1">Sistem Manajemen Tata Naskah & Disposisi (SIMANTAP)</p>
        <p class="text-xs text-slate-400 mt-0.5">Dicetak pada: {{ now()->isoFormat('dddd, D MMMM YYYY [pukul] HH:mm') }}
        </p>
    </div>

    {{-- ── Main Grid ── --}}
    <div id="print-grid" class="grid lg:grid-cols-3 gap-6">

        {{-- ══ Kolom Kiri (2/3) ══ --}}
        <div id="print-col-left" class="lg:col-span-2 space-y-6">

            {{-- Header Card --}}
            <div class="card overflow-hidden">
                {{-- Top strip warna emerald untuk surat keluar --}}
                <div class="h-1.5 bg-gradient-to-r from-emerald-500 to-teal-600"></div>

                <div class="p-6">
                    {{-- Badges row --}}
                    @php
                    $statusConfig = match($suratKeluar->status) {
                    'draft' => ['bg-slate-100 text-slate-600 ring-slate-200', 'Draft', 'bg-slate-400'],
                    'terkirim' => ['bg-blue-100 text-blue-700 ring-blue-200', 'Terkirim', 'bg-blue-500'],
                    'diterima' => ['bg-emerald-100 text-emerald-700 ring-emerald-200', 'Diterima', 'bg-emerald-500'],
                    default => ['bg-slate-100 text-slate-600 ring-slate-200', $suratKeluar->status, 'bg-slate-400'],
                    };
                    $sifatConfig = match($suratKeluar->sifat) {
                    'penting' => ['bg-orange-100 text-orange-700', 'Penting'],
                    'rahasia' => ['bg-red-100 text-red-800', 'Rahasia'],
                    'sangat_rahasia' => ['bg-red-200 text-red-900', 'Sangat Rahasia'],
                    default => ['bg-slate-100 text-slate-600', 'Biasa'],
                    };
                    @endphp

                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        {{-- Status badge --}}
                        <span
                            class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1 rounded-full ring-1 {{ $statusConfig[0] }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig[2] }}"></span>
                            {{ $statusConfig[1] }}
                        </span>

                        {{-- Sifat badge --}}
                        <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $sifatConfig[0] }}">
                            {{ $sifatConfig[1] }}
                        </span>

                        {{-- No Agenda badge --}}
                        <span
                            class="text-xs font-mono font-bold px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">
                            {{ $suratKeluar->no_agenda }}
                        </span>

                        @if(!$suratKeluar->no_surat)
                        <span
                            class="text-xs font-medium px-3 py-1 rounded-full bg-amber-50 text-amber-600 ring-1 ring-amber-200">
                            Belum bernomor
                        </span>
                        @endif
                    </div>

                    {{-- Perihal --}}
                    <h2 class="text-xl font-bold text-slate-800 leading-snug mb-1">
                        {{ $suratKeluar->perihal }}
                    </h2>
                    <p class="text-sm text-slate-500">
                        Kepada
                        <span class="font-semibold text-slate-700">{{ $suratKeluar->tujuan_surat }}</span>
                    </p>
                </div>
            </div>

            {{-- Detail Informasi --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-emerald-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        Informasi Surat
                    </h3>
                </div>
                <div class="card-body">
                    <dl class="grid sm:grid-cols-2 gap-x-8 gap-y-5">

                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nomor Agenda</dt>
                            <dd class="text-sm font-mono font-bold text-emerald-700">{{ $suratKeluar->no_agenda }}</dd>
                        </div>

                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nomor Surat</dt>
                            <dd class="text-sm font-semibold text-slate-800">
                                @if($suratKeluar->no_surat)
                                {{ $suratKeluar->no_surat }}
                                @else
                                <span class="text-slate-400 italic font-normal">Belum diisi</span>
                                @if(auth()->user()->isAdmin())
                                <a href="{{ route('surat-keluar.edit', $suratKeluar) }}"
                                    class="ml-2 text-xs text-primary-600 hover:underline font-semibold no-print">
                                    + Isi sekarang
                                </a>
                                @endif
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal Surat
                            </dt>
                            <dd class="text-sm text-slate-800">{{ $suratKeluar->tanggal_surat->isoFormat('dddd, D MMMM
                                YYYY') }}</dd>
                        </div>

                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tujuan Surat</dt>
                            <dd class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-lg bg-slate-100 flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold text-slate-800">{{ $suratKeluar->tujuan_surat
                                    }}</span>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Sifat Surat</dt>
                            <dd>
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $sifatConfig[0] }}">
                                    {{ $sifatConfig[1] }}
                                </span>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Status Pengiriman
                            </dt>
                            <dd>
                                <span
                                    class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full ring-1 {{ $statusConfig[0] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig[2] }}"></span>
                                    {{ $statusConfig[1] }}
                                </span>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Lampiran</dt>
                            <dd class="text-sm text-slate-800">
                                @if($suratKeluar->lampiran)
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                    {{ $suratKeluar->lampiran }}
                                </span>
                                @else
                                <span class="text-slate-400">—</span>
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Dibuat Oleh</dt>
                            <dd class="flex items-center gap-2 mt-0.5">
                                <img src="{{ $suratKeluar->creator->getAvatarUrl() }}"
                                    class="w-6 h-6 rounded-lg object-cover" alt="">
                                <span class="text-sm text-slate-800">{{ $suratKeluar->creator->name ?? '—' }}</span>
                            </dd>
                        </div>

                        @if($suratKeluar->keterangan)
                        <div class="sm:col-span-2">
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Keterangan</dt>
                            <dd
                                class="text-sm text-slate-700 bg-slate-50 rounded-xl p-3 leading-relaxed border border-slate-100">
                                {{ $suratKeluar->keterangan }}
                            </dd>
                        </div>
                        @endif

                    </dl>
                </div>
            </div>

            {{-- Update Status (Admin only) --}}
            @if(auth()->user()->isAdmin() && $suratKeluar->status !== 'diterima')
            <div class="card no-print" x-data="{ open: false }">
                <div class="card-header flex items-center justify-between cursor-pointer" @click="open = !open">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </div>
                        Perbarui Status Pengiriman
                    </h3>
                    <svg class="w-4 h-4 text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>

                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="card-body">
                        <form method="POST" action="{{ route('surat-keluar.update', $suratKeluar) }}"
                            x-data="{ loading: false }" @submit="loading = true">
                            @csrf @method('PUT')

                            {{-- Hidden fields to keep existing data --}}
                            <input type="hidden" name="tanggal_surat"
                                value="{{ $suratKeluar->tanggal_surat->format('Y-m-d') }}">
                            <input type="hidden" name="tujuan_surat" value="{{ $suratKeluar->tujuan_surat }}">
                            <input type="hidden" name="perihal" value="{{ $suratKeluar->perihal }}">
                            <input type="hidden" name="sifat" value="{{ $suratKeluar->sifat }}">
                            <input type="hidden" name="lampiran" value="{{ $suratKeluar->lampiran }}">
                            <input type="hidden" name="keterangan" value="{{ $suratKeluar->keterangan }}">
                            <input type="hidden" name="no_surat" value="{{ $suratKeluar->no_surat }}">

                            <div class="flex flex-wrap items-end gap-4">
                                <div class="flex-1 min-w-48">
                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status Baru</label>
                                    <select name="status"
                                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input">
                                        @if($suratKeluar->status === 'draft')
                                        <option value="draft" selected>Draft (saat ini)</option>
                                        <option value="terkirim">→ Terkirim</option>
                                        @elseif($suratKeluar->status === 'terkirim')
                                        <option value="terkirim" selected>Terkirim (saat ini)</option>
                                        <option value="diterima">→ Diterima</option>
                                        @endif
                                    </select>
                                </div>
                                <button type="submit" :disabled="loading"
                                    class="flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 disabled:opacity-70 text-white text-sm font-semibold rounded-xl transition-colors">
                                    <svg x-show="loading" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                    <span x-text="loading ? 'Menyimpan...' : 'Perbarui Status'"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            {{-- File Surat --}}
            @if($suratKeluar->file_surat)
            <div class="card no-print">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-purple-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                        </div>
                        Berkas Surat
                    </h3>
                </div>
                <div class="card-body">
                    <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-xl border border-slate-200">
                        {{-- File icon --}}
                        @php
                        $ext = strtolower(pathinfo($suratKeluar->file_surat, PATHINFO_EXTENSION));
                        $iconColor = match($ext) {
                        'pdf' => 'bg-red-100 text-red-600',
                        'doc', 'docx' => 'bg-blue-100 text-blue-600',
                        default => 'bg-slate-100 text-slate-500',
                        };
                        @endphp
                        <div class="w-12 h-12 rounded-xl {{ $iconColor }} flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-800 truncate">
                                {{ basename($suratKeluar->file_surat) }}
                            </p>
                            <p class="text-xs text-slate-400 mt-0.5 uppercase">
                                {{ strtoupper($ext) }} · Berkas Surat Keluar
                            </p>
                        </div>
                        <a href="{{ asset('storage/' . $suratKeluar->file_surat) }}" target="_blank"
                            class="flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition-colors shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Unduh
                        </a>
                    </div>
                </div>
            </div>
            @endif

            {{-- Riwayat Waktu --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        Riwayat Waktu
                    </h3>
                </div>
                <div class="card-body">
                    <div class="space-y-4">
                        {{-- Dibuat --}}
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div
                                    class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                                <div class="w-px flex-1 bg-slate-200 my-1"></div>
                            </div>
                            <div class="pb-4">
                                <p class="text-sm font-semibold text-slate-800">Surat Dibuat</p>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    {{ $suratKeluar->created_at->isoFormat('dddd, D MMMM YYYY [pukul] HH:mm') }}
                                </p>
                                <p class="text-xs text-slate-400 mt-0.5">
                                    oleh <span class="font-semibold text-slate-600">{{ $suratKeluar->creator->name ??
                                        '—' }}</span>
                                </p>
                            </div>
                        </div>

                        {{-- Terkirim --}}
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div
                                    class="w-8 h-8 rounded-full flex items-center justify-center shrink-0
                                    {{ in_array($suratKeluar->status, ['terkirim','diterima']) ? 'bg-blue-100' : 'bg-slate-100' }}">
                                    <svg class="w-4 h-4 {{ in_array($suratKeluar->status, ['terkirim','diterima']) ? 'text-blue-600' : 'text-slate-300' }}"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                </div>
                                <div class="w-px flex-1 bg-slate-200 my-1"></div>
                            </div>
                            <div class="pb-4">
                                <p
                                    class="text-sm font-semibold {{ in_array($suratKeluar->status, ['terkirim','diterima']) ? 'text-slate-800' : 'text-slate-400' }}">
                                    Surat Terkirim
                                </p>
                                @if(in_array($suratKeluar->status, ['terkirim','diterima']))
                                <p class="text-xs text-slate-500 mt-0.5">
                                    {{ $suratKeluar->updated_at->isoFormat('dddd, D MMMM YYYY [pukul] HH:mm') }}
                                </p>
                                @else
                                <p class="text-xs text-slate-400 mt-0.5 italic">Belum terkirim</p>
                                @endif
                            </div>
                        </div>

                        {{-- Diterima --}}
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0
                                    {{ $suratKeluar->status === 'diterima' ? 'bg-emerald-100' : 'bg-slate-100' }}">
                                    <svg class="w-4 h-4 {{ $suratKeluar->status === 'diterima' ? 'text-emerald-600' : 'text-slate-300' }}"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p
                                    class="text-sm font-semibold {{ $suratKeluar->status === 'diterima' ? 'text-slate-800' : 'text-slate-400' }}">
                                    Surat Diterima
                                </p>
                                @if($suratKeluar->status === 'diterima')
                                <p class="text-xs text-slate-500 mt-0.5">
                                    {{ $suratKeluar->updated_at->isoFormat('dddd, D MMMM YYYY [pukul] HH:mm') }}
                                </p>
                                <p class="text-xs text-emerald-600 font-semibold mt-0.5">✓ Selesai</p>
                                @else
                                <p class="text-xs text-slate-400 mt-0.5 italic">Menunggu konfirmasi</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ══ Kolom Kanan (1/3) ══ --}}
        <div id="print-col-right" class="space-y-5">

            {{-- Status Card --}}
            <div class="card overflow-hidden">
                <div class="h-1 bg-gradient-to-r
                    {{ $suratKeluar->status === 'draft'    ? 'from-slate-300 to-slate-400' : '' }}
                    {{ $suratKeluar->status === 'terkirim' ? 'from-blue-400 to-blue-600'   : '' }}
                    {{ $suratKeluar->status === 'diterima' ? 'from-emerald-400 to-teal-500': '' }}
                "></div>
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 text-sm">Status Pengiriman</h3>
                </div>
                <div class="card-body space-y-4">
                    @php
                    $steps = [
                    ['key' => 'draft', 'label' => 'Draft', 'desc' => 'Surat dibuat'],
                    ['key' => 'terkirim', 'label' => 'Terkirim', 'desc' => 'Sudah dikirim'],
                    ['key' => 'diterima', 'label' => 'Diterima', 'desc' => 'Dikonfirmasi'],
                    ];
                    $currentIdx = match($suratKeluar->status) {
                    'draft' => 0,
                    'terkirim' => 1,
                    'diterima' => 2,
                    default => 0,
                    };
                    @endphp

                    <div class="space-y-3">
                        @foreach($steps as $i => $step)
                        <div class="flex items-center gap-3">
                            {{-- Step indicator --}}
                            <div class="w-7 h-7 rounded-full flex items-center justify-center shrink-0
                                {{ $i < $currentIdx  ? 'bg-emerald-500'  : '' }}
                                {{ $i === $currentIdx ? 'bg-primary-600'  : '' }}
                                {{ $i > $currentIdx  ? 'bg-slate-200'    : '' }}">
                                @if($i < $currentIdx) <svg class="w-3.5 h-3.5 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                    </svg>
                                    @elseif($i === $currentIdx)
                                    <div class="w-2.5 h-2.5 rounded-full bg-white"></div>
                                    @else
                                    <div class="w-2 h-2 rounded-full bg-slate-400"></div>
                                    @endif
                            </div>

                            <div class="flex-1">
                                <p
                                    class="text-sm {{ $i <= $currentIdx ? 'font-semibold text-slate-800' : 'text-slate-400' }}">
                                    {{ $step['label'] }}
                                </p>
                                <p class="text-xs text-slate-400">{{ $step['desc'] }}</p>
                            </div>

                            @if($i === $currentIdx)
                            <span
                                class="text-[10px] font-bold text-primary-600 bg-primary-50 px-2 py-0.5 rounded-full shrink-0">
                                Saat ini
                            </span>
                            @endif
                        </div>

                        @if(!$loop->last)
                        <div class="ml-3.5 w-px h-3 {{ $i < $currentIdx ? 'bg-emerald-300' : 'bg-slate-200' }}"></div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Ringkasan --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 text-sm">Ringkasan</h3>
                </div>
                <div class="card-body space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">No. Agenda</span>
                        <span class="font-mono font-bold text-emerald-700 text-xs">{{ $suratKeluar->no_agenda }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Tanggal</span>
                        <span class="font-semibold text-slate-700">{{ $suratKeluar->tanggal_surat->isoFormat('D MMM Y')
                            }}</span>
                    </div>
                    <div class="flex items-start justify-between gap-2">
                        <span class="text-slate-500 shrink-0">Tujuan</span>
                        <span class="font-semibold text-slate-700 text-right text-xs leading-relaxed">{{
                            $suratKeluar->tujuan_surat }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Sifat</span>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $sifatConfig[0] }}">
                            {{ $sifatConfig[1] }}
                        </span>
                    </div>
                    @if($suratKeluar->lampiran)
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Lampiran</span>
                        <span class="font-semibold text-slate-700 text-xs">{{ $suratKeluar->lampiran }}</span>
                    </div>
                    @endif
                    <div class="pt-2 border-t border-slate-100">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Dibuat</span>
                            <span class="text-xs text-slate-600">{{ $suratKeluar->created_at->isoFormat('D MMM Y,
                                HH:mm') }}</span>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-slate-500">Diperbarui</span>
                            <span class="text-xs text-slate-600">{{ $suratKeluar->updated_at->isoFormat('D MMM Y,
                                HH:mm') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pembuat Surat --}}
            <div class="card no-print">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 text-sm">Dibuat Oleh</h3>
                </div>
                <div class="card-body">
                    <div class="flex items-center gap-3">
                        <img src="{{ $suratKeluar->creator->getAvatarUrl() }}"
                            class="w-11 h-11 rounded-xl object-cover ring-2 ring-slate-100 shrink-0" alt="">
                        <div>
                            <p class="text-sm font-bold text-slate-800">{{ $suratKeluar->creator->name ?? '—' }}</p>
                            <p class="text-xs text-slate-500">{{ $suratKeluar->creator->jabatan ??
                                $suratKeluar->creator->role ?? '' }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $suratKeluar->creator->unit_kerja ?? '' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            @if(auth()->user()->isAdmin())
            <div class="card no-print">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 text-sm">Aksi Cepat</h3>
                </div>
                <div class="card-body space-y-2">
                    <a href="{{ route('surat-keluar.edit', $suratKeluar) }}"
                        class="w-full flex items-center gap-3 px-4 py-3 bg-slate-50 hover:bg-slate-100 text-slate-700 rounded-xl text-sm font-semibold transition-colors">
                        <svg class="w-4 h-4 shrink-0 text-slate-500" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Surat Keluar
                    </a>

                    @if($suratKeluar->file_surat)
                    <a href="{{ asset('storage/' . $suratKeluar->file_surat) }}" target="_blank"
                        class="w-full flex items-center gap-3 px-4 py-3 bg-slate-50 hover:bg-slate-100 text-slate-700 rounded-xl text-sm font-semibold transition-colors">
                        <svg class="w-4 h-4 shrink-0 text-slate-500" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Unduh Berkas Surat
                    </a>
                    @endif

                    <button onclick="window.print()"
                        class="w-full flex items-center gap-3 px-4 py-3 bg-slate-50 hover:bg-slate-100 text-slate-700 rounded-xl text-sm font-semibold transition-colors">
                        <svg class="w-4 h-4 shrink-0 text-slate-500" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Cetak / Export PDF
                    </button>
                </div>
            </div>
            @endif

        </div>
    </div>

</div>
@endsection

@section('styles')
<style>
    @media print {

        /* Sembunyikan sidebar, topbar, breadcrumb, footer */
        aside,
        header,
        footer,
        nav[aria-label="breadcrumb"],
        .no-print {
            display: none !important;
        }

        /* Tampilkan elemen print-only */
        .print-only {
            display: block !important;
        }

        /* Reset margin main content */
        main {
            margin-left: 0 !important;
            padding: 0 !important;
        }

        /* Grid 1 kolom penuh */
        #print-grid {
            display: block !important;
            grid-template-columns: none !important;
        }

        #print-col-left,
        #print-col-right {
            width: 100% !important;
            max-width: 100% !important;
            grid-column: auto !important;
        }

        #print-col-right {
            margin-top: 1.5rem;
        }

        /* Card reset */
        .card {
            break-inside: avoid;
            page-break-inside: avoid;
            box-shadow: none !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 8px !important;
            margin-bottom: 1rem;
        }

        /* Hilangkan animasi */
        * {
            animation: none !important;
            transition: none !important;
        }

        body {
            font-size: 12px;
            color: #1e293b;
        }
    }
</style>
@endsection