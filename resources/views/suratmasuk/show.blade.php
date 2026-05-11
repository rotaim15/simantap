@extends('layouts.app')

@section('title', 'Detail Surat Masuk — ' . $suratMasuk->no_agenda)
@section('page-title', 'Surat Masuk')

@section('breadcrumb')
    <a href="{{ route('surat-masuk.index') }}" class="hover:text-slate-600">Surat Masuk</a>
    / <span class="text-slate-600">Detail</span>
@endsection

@section('content')
<div class="space-y-6 animate-fade-in-up">

    {{-- Action Bar --}}
    <div class="flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('surat-masuk.index') }}"
           class="flex items-center gap-2 text-sm text-slate-600 hover:text-slate-800 font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar
        </a>

        <div class="flex items-center gap-2">
            {{-- Print --}}
            <button onclick="window.print()"
                    class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 rounded-xl text-sm font-medium transition-colors no-print">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak
            </button>

            {{-- Buat Disposisi --}}
            @if(auth()->user()->isAdmin() || auth()->user()->isPimpinan())
            @if(in_array($suratMasuk->status, ['pending', 'diproses']))
            <a href="{{ route('disposisi.create', ['surat_masuk_id' => $suratMasuk->id]) }}"
               class="flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-sm font-semibold transition-colors shadow-sm no-print">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                Buat Disposisi
            </a>
            @endif
            @endif

            {{-- Edit --}}
            @if(auth()->user()->isAdmin())
            <a href="{{ route('surat-masuk.edit', $suratMasuk) }}"
               class="flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-sm font-semibold transition-colors shadow-sm no-print">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>

            {{-- Hapus --}}
            <form method="POST" action="{{ route('surat-masuk.destroy', $suratMasuk) }}"
                  x-data @submit.prevent="if(confirm('Yakin ingin menghapus surat masuk ini? Semua disposisi terkait juga akan terhapus.')) $el.submit()">
                @csrf @method('DELETE')
                <button type="submit"
                        class="flex items-center gap-2 px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 rounded-xl text-sm font-semibold transition-colors no-print">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus
                </button>
            </form>
            @endif
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- PRINT HEADER (hanya muncul saat print) --}}
    {{-- ============================================================ --}}
    <div class="hidden print-only text-center mb-6 border-b-2 border-slate-800 pb-4">
        <h1 class="text-xl font-bold uppercase tracking-widest">LEMBAR DISPOSISI SURAT MASUK</h1>
        <p class="text-sm text-slate-600 mt-1">Sistem Manajemen Tata Naskah & Disposisi</p>
    </div>

    {{-- ============================================================ --}}
    {{-- Main Grid --}}
    {{-- ============================================================ --}}
    <div class="grid lg:grid-cols-3 gap-6">

        {{-- ── Kolom Kiri: Detail Surat ── --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Header Card --}}
            <div class="card overflow-hidden">
                {{-- Top gradient strip --}}
                <div class="h-1.5 bg-gradient-to-r from-primary-500 to-navy-600"></div>

                <div class="p-6">
                    {{-- Badges Row --}}
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        {{-- Status --}}
                        @php
                            $statusConfig = match($suratMasuk->status) {
                                'pending'  => ['bg-amber-100 text-amber-700 ring-amber-200',  'Pending'],
                                'diproses' => ['bg-blue-100 text-blue-700 ring-blue-200',     'Diproses'],
                                'selesai'  => ['bg-emerald-100 text-emerald-700 ring-emerald-200', 'Selesai'],
                                'ditolak'  => ['bg-red-100 text-red-700 ring-red-200',        'Ditolak'],
                                default    => ['bg-slate-100 text-slate-600 ring-slate-200',  $suratMasuk->status],
                            };
                            $sifatConfig = match($suratMasuk->sifat) {
                                'penting'       => ['bg-orange-100 text-orange-700', 'Penting'],
                                'rahasia'       => ['bg-red-100 text-red-800',       'Rahasia'],
                                'sangat_rahasia'=> ['bg-red-200 text-red-900 font-bold', 'Sangat Rahasia'],
                                default         => ['bg-slate-100 text-slate-600',   'Biasa'],
                            };
                        @endphp

                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1 rounded-full ring-1 {{ $statusConfig[0] }}">
                            <span class="w-1.5 h-1.5 rounded-full
                                {{ $suratMasuk->status === 'pending' ? 'bg-amber-500' : '' }}
                                {{ $suratMasuk->status === 'diproses' ? 'bg-blue-500' : '' }}
                                {{ $suratMasuk->status === 'selesai' ? 'bg-emerald-500' : '' }}
                                {{ $suratMasuk->status === 'ditolak' ? 'bg-red-500' : '' }}
                            "></span>
                            {{ $statusConfig[1] }}
                        </span>

                        <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $sifatConfig[0] }}">
                            {{ $sifatConfig[1] }}
                        </span>

                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-slate-100 text-slate-600 capitalize">
                            {{ $suratMasuk->klasifikasi }}
                        </span>

                        <span class="text-xs font-mono font-bold px-3 py-1 rounded-full bg-primary-50 text-primary-700 ring-1 ring-primary-200">
                            {{ $suratMasuk->no_agenda }}
                        </span>
                    </div>

                    {{-- Perihal --}}
                    <h2 class="text-xl font-bold text-slate-800 leading-snug mb-1">
                        {{ $suratMasuk->perihal }}
                    </h2>
                    <p class="text-sm text-slate-500">dari <span class="font-semibold text-slate-700">{{ $suratMasuk->asal_surat }}</span></p>
                </div>
            </div>

            {{-- Detail Informasi --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        Informasi Surat
                    </h3>
                </div>
                <div class="card-body">
                    <dl class="grid sm:grid-cols-2 gap-x-8 gap-y-5">
                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nomor Surat</dt>
                            <dd class="text-sm font-semibold text-slate-800">{{ $suratMasuk->no_surat }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nomor Agenda</dt>
                            <dd class="text-sm font-mono font-semibold text-primary-700">{{ $suratMasuk->no_agenda }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal Surat</dt>
                            <dd class="text-sm text-slate-800">{{ $suratMasuk->tanggal_surat->isoFormat('dddd, D MMMM YYYY') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal Diterima</dt>
                            <dd class="text-sm text-slate-800">{{ $suratMasuk->tanggal_terima->isoFormat('dddd, D MMMM YYYY') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Asal Surat</dt>
                            <dd class="text-sm text-slate-800 font-semibold">{{ $suratMasuk->asal_surat }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Lampiran</dt>
                            <dd class="text-sm text-slate-800">{{ $suratMasuk->lampiran ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Sifat</dt>
                            <dd>
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $sifatConfig[0] }}">
                                    {{ $sifatConfig[1] }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Klasifikasi</dt>
                            <dd class="text-sm text-slate-800 capitalize">{{ $suratMasuk->klasifikasi }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Dicatat Oleh</dt>
                            <dd class="flex items-center gap-2 mt-0.5">
                                <img src="{{ $suratMasuk->creator->getAvatarUrl() }}"
                                     class="w-6 h-6 rounded-lg object-cover" alt="">
                                <span class="text-sm text-slate-800">{{ $suratMasuk->creator->name ?? '—' }}</span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Dicatat Pada</dt>
                            <dd class="text-sm text-slate-800">{{ $suratMasuk->created_at->isoFormat('D MMM YYYY, HH:mm') }}</dd>
                        </div>

                        @if($suratMasuk->keterangan)
                        <div class="sm:col-span-2">
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Keterangan</dt>
                            <dd class="text-sm text-slate-700 bg-slate-50 rounded-xl p-3 leading-relaxed">
                                {{ $suratMasuk->keterangan }}
                            </dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>

            {{-- File Surat --}}
            @if($suratMasuk->file_surat)
            <div class="card no-print">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-purple-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                            </svg>
                        </div>
                        Berkas Terlampir
                    </h3>
                </div>
                <div class="card-body">
                    <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-xl border border-slate-200">
                        <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-800 truncate">
                                {{ basename($suratMasuk->file_surat) }}
                            </p>
                            <p class="text-xs text-slate-400 mt-0.5 uppercase">
                                {{ strtoupper(pathinfo($suratMasuk->file_surat, PATHINFO_EXTENSION)) }} • File Surat
                            </p>
                        </div>
                        <a href="{{ asset('storage/' . $suratMasuk->file_surat) }}"
                           target="_blank"
                           class="flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-sm font-semibold transition-colors shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Unduh
                        </a>
                    </div>
                </div>
            </div>
            @endif

            {{-- Riwayat Disposisi --}}
            <div class="card">
                <div class="card-header flex items-center justify-between">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-amber-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        Riwayat Disposisi
                        <span class="text-xs font-bold bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full">
                            {{ $suratMasuk->disposisi->count() }}
                        </span>
                    </h3>

                    @if(auth()->user()->isAdmin() || auth()->user()->isPimpinan())
                    @if(in_array($suratMasuk->status, ['pending', 'diproses']))
                    <a href="{{ route('disposisi.create', ['surat_masuk_id' => $suratMasuk->id]) }}"
                       class="flex items-center gap-1.5 text-xs font-semibold text-amber-600 hover:text-amber-700 no-print">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Disposisi
                    </a>
                    @endif
                    @endif
                </div>

                @if($suratMasuk->disposisi->isEmpty())
                <div class="px-6 py-10 text-center">
                    <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <p class="text-sm text-slate-400 font-medium">Belum ada disposisi untuk surat ini</p>
                    @if(auth()->user()->isAdmin() || auth()->user()->isPimpinan())
                    <a href="{{ route('disposisi.create', ['surat_masuk_id' => $suratMasuk->id]) }}"
                       class="inline-flex items-center gap-1.5 mt-3 text-sm text-primary-600 hover:underline font-medium no-print">
                        Buat Disposisi Sekarang →
                    </a>
                    @endif
                </div>
                @else
                {{-- Timeline disposisi --}}
                <div class="p-6 space-y-0">
                    @foreach($suratMasuk->disposisi->sortByDesc('created_at') as $index => $disposisi)
                    <div class="relative flex gap-4 {{ !$loop->last ? 'pb-6' : '' }}">
                        {{-- Timeline line --}}
                        @if(!$loop->last)
                        <div class="absolute left-5 top-10 bottom-0 w-px bg-slate-200"></div>
                        @endif

                        {{-- Timeline dot --}}
                        <div class="w-10 h-10 rounded-xl shrink-0 flex items-center justify-center z-10
                            {{ $disposisi->status === 'selesai' ? 'bg-emerald-100' : ($disposisi->status === 'dibatalkan' ? 'bg-red-100' : 'bg-amber-100') }}">
                            @if($disposisi->status === 'selesai')
                            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            @elseif($disposisi->status === 'dibatalkan')
                            <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            @else
                            <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            @endif
                        </div>

                        {{-- Disposisi content --}}
                        <div class="flex-1 bg-slate-50 rounded-xl p-4 border border-slate-100">
                            <div class="flex flex-wrap items-start justify-between gap-2 mb-2">
                                <div>
                                    <a href="{{ route('disposisi.show', $disposisi) }}"
                                       class="text-sm font-bold text-slate-800 hover:text-primary-600 transition-colors">
                                        {{ $disposisi->kode_disposisi }}
                                    </a>
                                    <p class="text-xs text-slate-500 mt-0.5">
                                        Dari <span class="font-semibold">{{ $disposisi->dariUser->name ?? '—' }}</span>
                                        · {{ $disposisi->tanggal_disposisi->isoFormat('D MMM Y') }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-2">
                                    {{-- Prioritas --}}
                                    @php
                                        $priColor = match($disposisi->prioritas) {
                                            'segera'  => 'bg-red-100 text-red-700',
                                            'tinggi'  => 'bg-orange-100 text-orange-700',
                                            'rendah'  => 'bg-slate-100 text-slate-500',
                                            default   => 'bg-blue-100 text-blue-700',
                                        };
                                    @endphp
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full uppercase {{ $priColor }}">
                                        {{ $disposisi->prioritas }}
                                    </span>
                                    {{-- Status --}}
                                    @php
                                        $dspColor = match($disposisi->status) {
                                            'selesai'    => 'bg-emerald-100 text-emerald-700',
                                            'dibatalkan' => 'bg-red-100 text-red-700',
                                            default      => 'bg-amber-100 text-amber-700',
                                        };
                                    @endphp
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full capitalize {{ $dspColor }}">
                                        {{ $disposisi->status }}
                                    </span>
                                </div>
                            </div>

                            {{-- Instruksi --}}
                            <p class="text-sm text-slate-700 leading-relaxed mb-3">
                                {{ $disposisi->instruksi }}
                            </p>

                            {{-- Penerima --}}
                            @if($disposisi->penerima->isNotEmpty())
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-xs text-slate-400 font-medium">Kepada:</span>
                                @foreach($disposisi->penerima as $penerima)
                                <div class="flex items-center gap-1.5 bg-white border border-slate-200 rounded-lg px-2 py-1">
                                    <img src="{{ $penerima->getAvatarUrl() }}"
                                         class="w-4 h-4 rounded-md object-cover" alt="">
                                    <span class="text-xs font-medium text-slate-700">{{ $penerima->name }}</span>
                                    @php
                                        $pvColor = match($penerima->pivot->status) {
                                            'selesai'  => 'text-emerald-600',
                                            'diproses' => 'text-blue-600',
                                            'dibaca'   => 'text-slate-500',
                                            default    => 'text-amber-500',
                                        };
                                    @endphp
                                    <svg class="w-3 h-3 {{ $pvColor }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                @endforeach
                            </div>
                            @endif

                            {{-- Batas waktu --}}
                            @if($disposisi->batas_waktu)
                            <div class="flex items-center gap-1.5 mt-2">
                                <svg class="w-3.5 h-3.5 {{ $disposisi->isOverdue() ? 'text-red-500' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-xs {{ $disposisi->isOverdue() ? 'text-red-600 font-semibold' : 'text-slate-500' }}">
                                    Batas: {{ $disposisi->batas_waktu->isoFormat('D MMM Y') }}
                                    @if($disposisi->isOverdue()) <span class="font-bold">(Terlambat!)</span> @endif
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

        </div>

        {{-- ── Kolom Kanan: Sidebar Info ── --}}
        <div class="space-y-5">

            {{-- Status Card --}}
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 text-sm">Status Surat</h3>
                </div>
                <div class="card-body space-y-4">
                    {{-- Status progress --}}
                    @php
                        $steps = [
                            ['key' => 'pending',  'label' => 'Diterima'],
                            ['key' => 'diproses', 'label' => 'Disposisi'],
                            ['key' => 'selesai',  'label' => 'Selesai'],
                        ];
                        $currentStep = match($suratMasuk->status) {
                            'pending'  => 0,
                            'diproses' => 1,
                            'selesai'  => 2,
                            'ditolak'  => -1,
                            default    => 0,
                        };
                    @endphp

                    @if($suratMasuk->status === 'ditolak')
                    <div class="flex items-center gap-3 p-3 bg-red-50 rounded-xl border border-red-200">
                        <div class="w-9 h-9 rounded-xl bg-red-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-red-700">Ditolak</p>
                            <p class="text-xs text-red-500">Surat tidak diproses</p>
                        </div>
                    </div>
                    @else
                    <div class="space-y-3">
                        @foreach($steps as $i => $step)
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-full flex items-center justify-center shrink-0
                                {{ $i <= $currentStep ? 'bg-primary-600' : 'bg-slate-200' }}">
                                @if($i < $currentStep)
                                <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                @elseif($i === $currentStep)
                                <div class="w-2.5 h-2.5 rounded-full bg-white"></div>
                                @else
                                <div class="w-2 h-2 rounded-full bg-slate-400"></div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-sm {{ $i <= $currentStep ? 'font-semibold text-slate-800' : 'text-slate-400' }}">
                                    {{ $step['label'] }}
                                </p>
                            </div>
                            @if($i === $currentStep)
                            <span class="text-[10px] font-bold text-primary-600 bg-primary-50 px-2 py-0.5 rounded-full">Saat ini</span>
                            @endif
                        </div>
                        @if(!$loop->last)
                        <div class="ml-3.5 w-px h-3 {{ $i < $currentStep ? 'bg-primary-300' : 'bg-slate-200' }}"></div>
                        @endif
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            {{-- Ringkasan Disposisi --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 text-sm">Ringkasan Disposisi</h3>
                </div>
                <div class="card-body space-y-3">
                    @php
                        $totalDisposisi = $suratMasuk->disposisi->count();
                        $aktif    = $suratMasuk->disposisi->where('status', 'aktif')->count();
                        $selesai  = $suratMasuk->disposisi->where('status', 'selesai')->count();
                        $batal    = $suratMasuk->disposisi->where('status', 'dibatalkan')->count();
                    @endphp

                    <div class="grid grid-cols-3 gap-2 text-center">
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-xl font-bold text-slate-800">{{ $totalDisposisi }}</p>
                            <p class="text-[10px] text-slate-500 mt-0.5">Total</p>
                        </div>
                        <div class="bg-amber-50 rounded-xl p-3">
                            <p class="text-xl font-bold text-amber-700">{{ $aktif }}</p>
                            <p class="text-[10px] text-amber-600 mt-0.5">Aktif</p>
                        </div>
                        <div class="bg-emerald-50 rounded-xl p-3">
                            <p class="text-xl font-bold text-emerald-700">{{ $selesai }}</p>
                            <p class="text-[10px] text-emerald-600 mt-0.5">Selesai</p>
                        </div>
                    </div>

                    @if($totalDisposisi > 0)
                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                        <div class="bg-emerald-500 h-2 rounded-full transition-all"
                             style="width: {{ $totalDisposisi > 0 ? round(($selesai / $totalDisposisi) * 100) : 0 }}%">
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 text-center">
                        {{ $totalDisposisi > 0 ? round(($selesai / $totalDisposisi) * 100) : 0 }}% selesai
                    </p>
                    @else
                    <p class="text-xs text-slate-400 text-center">Belum ada disposisi</p>
                    @endif
                </div>
            </div>

            {{-- Info Pencatatan --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 text-sm">Info Pencatatan</h3>
                </div>
                <div class="card-body space-y-3">
                    <div class="flex items-center gap-3">
                        <img src="{{ $suratMasuk->creator->getAvatarUrl() }}"
                             class="w-10 h-10 rounded-xl object-cover shrink-0" alt="">
                        <div>
                            <p class="text-sm font-semibold text-slate-800">{{ $suratMasuk->creator->name ?? '—' }}</p>
                            <p class="text-xs text-slate-500">{{ $suratMasuk->creator->jabatan ?? 'Pencatat' }}</p>
                        </div>
                    </div>
                    <div class="border-t border-slate-100 pt-3 space-y-2">
                        <div class="flex justify-between text-xs">
                            <span class="text-slate-400">Dibuat</span>
                            <span class="text-slate-700 font-medium">{{ $suratMasuk->created_at->isoFormat('D MMM Y, HH:mm') }}</span>
                        </div>
                        <div class="flex justify-between text-xs">
                            <span class="text-slate-400">Diperbarui</span>
                            <span class="text-slate-700 font-medium">{{ $suratMasuk->updated_at->isoFormat('D MMM Y, HH:mm') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            @if(auth()->user()->isAdmin() || auth()->user()->isPimpinan())
            <div class="card no-print">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 text-sm">Aksi Cepat</h3>
                </div>
                <div class="card-body space-y-2">
                    @if(in_array($suratMasuk->status, ['pending', 'diproses']))
                    <a href="{{ route('disposisi.create', ['surat_masuk_id' => $suratMasuk->id]) }}"
                       class="w-full flex items-center gap-3 px-4 py-3 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-xl text-sm font-semibold transition-colors">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Buat Disposisi Baru
                    </a>
                    @endif

                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('surat-masuk.edit', $suratMasuk) }}"
                       class="w-full flex items-center gap-3 px-4 py-3 bg-slate-50 hover:bg-slate-100 text-slate-700 rounded-xl text-sm font-semibold transition-colors">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Surat Masuk
                    </a>
                    @endif

                    @if($suratMasuk->file_surat)
                    <a href="{{ asset('storage/' . $suratMasuk->file_surat) }}" target="_blank"
                       class="w-full flex items-center gap-3 px-4 py-3 bg-slate-50 hover:bg-slate-100 text-slate-700 rounded-xl text-sm font-semibold transition-colors">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Unduh Berkas Surat
                    </a>
                    @endif

                    <button onclick="window.print()"
                            class="w-full flex items-center gap-3 px-4 py-3 bg-slate-50 hover:bg-slate-100 text-slate-700 rounded-xl text-sm font-semibold transition-colors">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
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
