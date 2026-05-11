@extends('layouts.app')

@section('title', 'Detail Disposisi — ' . $disposisi->kode_disposisi)
@section('page-title', 'Disposisi')

@section('breadcrumb')
<a href="{{ route('disposisi.index') }}" class="hover:text-slate-600">Disposisi</a>
/ <span class="text-slate-600">{{ $disposisi->kode_disposisi }}</span>
@endsection

@section('content')
<div class="space-y-6 animate-fade-in-up">

    {{-- Action Bar --}}
    <div class="flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('disposisi.index') }}"
            class="flex items-center gap-2 text-sm text-slate-600 hover:text-slate-800 font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
        <div class="flex items-center gap-2">
            @can('update', $disposisi)
            <a href="{{ route('disposisi.edit', $disposisi) }}"
                class="flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-sm font-semibold transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            @endcan
            @can('delete', $disposisi)
            <form method="POST" action="{{ route('disposisi.destroy', $disposisi) }}" x-data
                @submit.prevent="if(confirm('Hapus disposisi ini?')) $el.submit()">
                @csrf @method('DELETE')
                <button type="submit"
                    class="flex items-center gap-2 px-4 py-2 bg-red-50 border border-red-200 text-red-600 hover:bg-red-100 rounded-xl text-sm font-semibold transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus
                </button>
            </form>
            @endcan
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- Kolom Kiri --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Header Card --}}
            <div class="card overflow-hidden">
                @php $jenis = $disposisi->getJenisSurat(); @endphp
                <div
                    class="h-1.5 bg-gradient-to-r {{ $jenis === 'masuk' ? 'from-blue-500 to-primary-600' : 'from-emerald-500 to-teal-600' }}">
                </div>
                <div class="p-6">
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        {{-- Kode --}}
                        <span
                            class="text-xs font-mono font-bold px-3 py-1 rounded-full bg-amber-50 text-amber-700 ring-1 ring-amber-200">
                            {{ $disposisi->kode_disposisi }}
                        </span>
                        {{-- Jenis --}}
                        @if($jenis === 'masuk')
                        <span
                            class="inline-flex items-center gap-1 text-xs font-semibold px-3 py-1 rounded-full bg-blue-100 text-blue-700">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            Surat Masuk
                        </span>
                        @else
                        <span
                            class="inline-flex items-center gap-1 text-xs font-semibold px-3 py-1 rounded-full bg-emerald-100 text-emerald-700">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Surat Keluar
                        </span>
                        @endif
                        {{-- Prioritas --}}
                        <span
                            class="text-xs font-semibold px-3 py-1 rounded-full ring-1 capitalize {{ $disposisi->prioritas_badge }}">
                            {{ $disposisi->prioritas }}
                        </span>
                        {{-- Status --}}
                        @php
                        $statusStyle = match($disposisi->status) {
                        'selesai' => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
                        'dibatalkan' => 'bg-red-100 text-red-700 ring-red-200',
                        default => 'bg-amber-100 text-amber-700 ring-amber-200',
                        };
                        @endphp
                        <span class="text-xs font-semibold px-3 py-1 rounded-full ring-1 capitalize {{ $statusStyle }}">
                            {{ $disposisi->status }}
                        </span>
                        @if($disposisi->isOverdue())
                        <span
                            class="text-xs font-bold px-3 py-1 rounded-full bg-red-100 text-red-700 ring-1 ring-red-200 animate-pulse">
                            ⚠ Terlambat
                        </span>
                        @endif
                    </div>
                    <h2 class="text-lg font-bold text-slate-800 leading-snug">
                        {{ $disposisi->getPerihalSurat() }}
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">
                        No. Agenda: <span class="font-semibold text-slate-700">{{ $disposisi->getNoAgendaSurat()
                            }}</span>
                    </p>
                </div>
            </div>

            {{-- Info Disposisi --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-amber-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        Informasi Disposisi
                    </h3>
                </div>
                <div class="card-body">
                    <dl class="grid sm:grid-cols-2 gap-x-8 gap-y-5">
                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Kode Disposisi
                            </dt>
                            <dd class="text-sm font-mono font-bold text-amber-700">{{ $disposisi->kode_disposisi }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal Disposisi
                            </dt>
                            <dd class="text-sm text-slate-800">{{ $disposisi->tanggal_disposisi->isoFormat('dddd, D MMMM
                                YYYY') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Batas Waktu</dt>
                            <dd
                                class="text-sm {{ $disposisi->isOverdue() ? 'text-red-600 font-semibold' : 'text-slate-800' }}">
                                {{ $disposisi->batas_waktu ? $disposisi->batas_waktu->isoFormat('dddd, D MMMM YYYY') :
                                '—' }}
                                @if($disposisi->isOverdue()) <span class="text-xs">(Terlambat)</span> @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Dibuat Oleh</dt>
                            <dd class="flex items-center gap-2">
                                <img src="{{ $disposisi->dariUser->getAvatarUrl() }}"
                                    class="w-6 h-6 rounded-lg object-cover" alt="">
                                <span class="text-sm text-slate-800">{{ $disposisi->dariUser->name }}</span>
                            </dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Instruksi</dt>
                            <dd
                                class="text-sm text-slate-800 bg-amber-50 border border-amber-100 rounded-xl p-3 leading-relaxed">
                                {{ $disposisi->instruksi }}
                            </dd>
                        </div>
                        @if($disposisi->catatan)
                        <div class="sm:col-span-2">
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Catatan</dt>
                            <dd class="text-sm text-slate-700 bg-slate-50 rounded-xl p-3 leading-relaxed">
                                {{ $disposisi->catatan }}
                            </dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>

            {{-- Surat Terkait --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <div
                            class="w-7 h-7 rounded-lg {{ $jenis === 'masuk' ? 'bg-blue-100' : 'bg-emerald-100' }} flex items-center justify-center">
                            <svg class="w-4 h-4 {{ $jenis === 'masuk' ? 'text-blue-600' : 'text-emerald-600' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        Surat {{ ucfirst($jenis) }} Terkait
                    </h3>
                </div>
                <div class="card-body">
                    @if($jenis === 'masuk' && $disposisi->suratMasuk)
                    @php $sm = $disposisi->suratMasuk; @endphp
                    <div class="flex items-start gap-4 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-slate-800">{{ $sm->perihal }}</p>
                            <p class="text-xs text-slate-600 mt-1">Dari: <span class="font-semibold">{{ $sm->asal_surat
                                    }}</span> · {{ $sm->tanggal_terima->isoFormat('D MMM Y') }}</p>
                            <p class="text-xs font-mono text-blue-700 mt-0.5">{{ $sm->no_agenda }}</p>
                        </div>
                        <a href="{{ route('surat-masuk.show', $sm) }}"
                            class="text-xs font-semibold text-blue-600 hover:text-blue-800 shrink-0 transition-colors">
                            Lihat →
                        </a>
                    </div>
                    @elseif($jenis === 'keluar' && $disposisi->suratKeluar)
                    @php $sk = $disposisi->suratKeluar; @endphp
                    <div class="flex items-start gap-4 p-4 bg-emerald-50 border border-emerald-200 rounded-xl">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-slate-800">{{ $sk->perihal }}</p>
                            <p class="text-xs text-slate-600 mt-1">Tujuan: <span class="font-semibold">{{
                                    $sk->tujuan_surat }}</span> · {{ $sk->tanggal_surat->isoFormat('D MMM Y') }}</p>
                            <p class="text-xs font-mono text-emerald-700 mt-0.5">{{ $sk->no_agenda }}</p>
                        </div>
                        <a href="{{ route('surat-keluar.show', $sk) }}"
                            class="text-xs font-semibold text-emerald-600 hover:text-emerald-800 shrink-0 transition-colors">
                            Lihat →
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Daftar Tindakan --}}
            @if($disposisi->tindakan->isNotEmpty())
            <div class="card">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-purple-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        Daftar Tindakan
                    </h3>
                </div>
                <div class="card-body space-y-2">
                    @foreach($disposisi->tindakan as $t)
                    <div class="flex items-center gap-3 p-3 bg-purple-50 border border-purple-100 rounded-xl">
                        <div class="w-6 h-6 rounded-lg bg-purple-200 flex items-center justify-center shrink-0">
                            <span class="text-xs font-bold text-purple-700">{{ $loop->iteration }}</span>
                        </div>
                        <span class="text-sm text-slate-700">{{ $t->tindakan }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Form Tanggapan (penerima yang belum selesai) --}}
            @php
            $myPivot = $pivot ?? $disposisi->penerima->where('id', auth()->id())->first();
            $canTanggapi = $myPivot && in_array($myPivot->pivot->status, ['dibaca', 'diproses']);
            @endphp
            @if($canTanggapi)
            <div class="card border-2 border-primary-200">
                <div class="card-header bg-primary-50">
                    <h3 class="font-bold text-primary-800 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-primary-200 flex items-center justify-center">
                            <svg class="w-4 h-4 text-primary-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                        </div>
                        Berikan Tanggapan
                    </h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('disposisi.tanggapi', $disposisi) }}"
                        x-data="{ loading: false }" @submit="loading = true" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Tanggapan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="tanggapan" rows="3" required maxlength="1000"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input resize-none"
                                placeholder="Tuliskan tanggapan atau laporan tindak lanjut Anda..."></textarea>
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            <button type="submit" name="status" value="diproses" :disabled="loading"
                                class="flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 disabled:opacity-70 text-white text-sm font-semibold rounded-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Tandai Sedang Diproses
                            </button>
                            <button type="submit" name="status" value="selesai" :disabled="loading"
                                class="flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 disabled:opacity-70 text-white text-sm font-semibold rounded-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Tandai Selesai
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            {{-- Tanggapan yang sudah masuk --}}
            @php $adaTanggapan = $disposisi->penerima->filter(fn($p) => $p->pivot->tanggapan); @endphp
            @if($adaTanggapan->isNotEmpty())
            <div class="card">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-green-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                        </div>
                        Tanggapan
                    </h3>
                </div>
                <div class="card-body space-y-4">
                    @foreach($adaTanggapan as $p)
                    <div class="flex gap-3">
                        <img src="{{ $p->getAvatarUrl() }}" class="w-9 h-9 rounded-xl object-cover shrink-0 mt-0.5"
                            alt="">
                        <div class="flex-1 bg-slate-50 rounded-xl p-3 border border-slate-100">
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">{{ $p->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $p->jabatan ?? $p->role }}</p>
                                </div>
                                @php
                                $tStyle = match($p->pivot->status) {
                                'selesai' => 'bg-emerald-100 text-emerald-700',
                                'diproses' => 'bg-blue-100 text-blue-700',
                                default => 'bg-slate-100 text-slate-600',
                                };
                                @endphp
                                <span
                                    class="text-[10px] font-bold px-2 py-0.5 rounded-full capitalize {{ $tStyle }} shrink-0">
                                    {{ $p->pivot->status }}
                                </span>
                            </div>
                            <p class="text-sm text-slate-700 leading-relaxed">{{ $p->pivot->tanggapan }}</p>
                            @if($p->pivot->selesai_at)
                            <p class="text-xs text-slate-400 mt-1.5">Selesai: {{
                                \Carbon\Carbon::parse($p->pivot->selesai_at)->isoFormat('D MMM Y, HH:mm') }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

        {{-- Kolom Kanan --}}
        <div class="space-y-5">

            {{-- Progress penerima --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 text-sm">Status Penerima</h3>
                </div>
                <div class="card-body space-y-3">
                    @foreach($disposisi->penerima as $p)
                    @php
                    $pvStyle = match($p->pivot->status) {
                    'selesai' => ['bg-emerald-100', 'text-emerald-600', 'bg-emerald-500'],
                    'diproses' => ['bg-blue-100', 'text-blue-600', 'bg-blue-500'],
                    'dibaca' => ['bg-slate-100', 'text-slate-500', 'bg-slate-400'],
                    default => ['bg-amber-100', 'text-amber-600', 'bg-amber-400'],
                    };
                    @endphp
                    <div class="flex items-center gap-3">
                        <div class="relative shrink-0">
                            <img src="{{ $p->getAvatarUrl() }}" class="w-9 h-9 rounded-xl object-cover" alt="">
                            <div
                                class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full {{ $pvStyle[2] }} ring-2 ring-white">
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $p->name }}</p>
                            <p class="text-xs text-slate-400 capitalize">{{ $p->pivot->status }}</p>
                        </div>
                    </div>
                    @endforeach

                    {{-- Progress bar --}}
                    @php
                    $total = $disposisi->penerima->count();
                    $selesai = $disposisi->penerima->where('pivot.status', 'selesai')->count();
                    $pct = $total > 0 ? round($selesai / $total * 100) : 0;
                    @endphp
                    <div class="pt-2 border-t border-slate-100">
                        <div class="flex items-center justify-between text-xs mb-1.5">
                            <span class="text-slate-500">Progress</span>
                            <span class="font-bold text-slate-700">{{ $selesai }}/{{ $total }} selesai</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-emerald-500 h-2 rounded-full transition-all" style="width: {{ $pct }}%">
                            </div>
                        </div>
                        <p class="text-xs text-slate-400 text-right mt-1">{{ $pct }}%</p>
                    </div>
                </div>
            </div>

            {{-- Ringkasan --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800 text-sm">Ringkasan</h3>
                </div>
                <div class="card-body space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Prioritas</span>
                        <span class="font-semibold text-slate-700 capitalize">{{ $disposisi->prioritas }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Status</span>
                        <span class="font-semibold text-slate-700 capitalize">{{ $disposisi->status }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Jenis Surat</span>
                        <span class="font-semibold text-slate-700 capitalize">{{ $jenis }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Tgl. Disposisi</span>
                        <span class="font-semibold text-slate-700 text-xs">{{
                            $disposisi->tanggal_disposisi->isoFormat('D MMM Y') }}</span>
                    </div>
                    @if($disposisi->batas_waktu)
                    <div class="flex justify-between">
                        <span class="text-slate-500">Batas Waktu</span>
                        <span
                            class="font-semibold text-xs {{ $disposisi->isOverdue() ? 'text-red-600' : 'text-slate-700' }}">
                            {{ $disposisi->batas_waktu->isoFormat('D MMM Y') }}
                        </span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-slate-500">Dibuat</span>
                        <span class="text-xs text-slate-600">{{ $disposisi->created_at->isoFormat('D MMM Y, HH:mm')
                            }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection