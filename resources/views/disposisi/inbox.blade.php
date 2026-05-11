@extends('layouts.app')

@section('title', 'Kotak Masuk Disposisi')
@section('page-title', 'Kotak Masuk Disposisi')

@section('breadcrumb')
<span>Beranda</span> /
<a href="{{ route('disposisi.index') }}" class="text-primary-600 hover:underline">Disposisi</a> /
<span class="text-slate-600">Kotak Masuk</span>
@endsection

@section('content')
<div class="space-y-5" x-data="{
    showFilter: false,
    selectedDisposisi: null,
    selectedKode: null,
    showTanggapanModal: false
}">

    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-slate-800">Kotak Masuk Disposisi</h2>
            <p class="text-sm text-slate-500">Disposisi yang ditujukan kepada Anda</p>
        </div>
        <div class="flex items-center gap-2">
            <button @click="showFilter = !showFilter"
                class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                {{ request()->hasAny(['search', 'status', 'prioritas']) ? 'Filter Aktif' : 'Filter' }}
            </button>
            <a href="{{ route('disposisi.inbox') }}"
                class="flex items-center gap-2 bg-primary-50 hover:bg-primary-100 text-primary-700 px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Refresh
            </a>
        </div>
    </div>

    {{-- Filter Panel --}}
    <div class="card" x-show="showFilter" x-transition.duration.300ms x-cloak>
        <div class="p-4">
            <form method="GET" action="{{ route('disposisi.inbox') }}" class="flex flex-wrap items-center gap-3">
                <div class="relative flex-1 min-w-52">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari kode disposisi, instruksi, perihal surat..."
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white form-input transition-all">
                </div>
                <select name="status"
                    class="py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input">
                    <option value="">Semua Status</option>
                    <option value="belum_dibaca" {{ request('status')=='belum_dibaca' ? 'selected' : '' }}>Belum Dibaca
                    </option>
                    <option value="dibaca" {{ request('status')=='dibaca' ? 'selected' : '' }}>Sudah Dibaca</option>
                    <option value="diproses" {{ request('status')=='diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ request('status')=='selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                <select name="prioritas"
                    class="py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input">
                    <option value="">Semua Prioritas</option>
                    <option value="rendah" {{ request('prioritas')=='rendah' ? 'selected' : '' }}>Rendah</option>
                    <option value="normal" {{ request('prioritas')=='normal' ? 'selected' : '' }}>Normal</option>
                    <option value="tinggi" {{ request('prioritas')=='tinggi' ? 'selected' : '' }}>Tinggi</option>
                    <option value="segera" {{ request('prioritas')=='segera' ? 'selected' : '' }}>Segera</option>
                </select>
                <button type="submit"
                    class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'status', 'prioritas']))
                <a href="{{ route('disposisi.inbox') }}"
                    class="text-slate-500 hover:text-slate-700 px-3 py-2.5 text-sm transition-colors">
                    Reset
                </a>
                @endif
            </form>
        </div>
    </div>

    {{-- Statistik Ringkas --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card bg-gradient-to-r from-blue-50 to-blue-100 border-blue-200">
            <div class="p-4 flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-blue-600 uppercase tracking-wider">Belum Dibaca</p>
                    <p class="text-2xl font-bold text-blue-800 mt-1">{{ $disposisi->where('pivot.status',
                        'belum_dibaca')->count() }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-200 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="card bg-gradient-to-r from-orange-50 to-orange-100 border-orange-200">
            <div class="p-4 flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-orange-600 uppercase tracking-wider">Diproses</p>
                    <p class="text-2xl font-bold text-orange-800 mt-1">{{ $disposisi->where('pivot.status',
                        'diproses')->count() }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-orange-200 flex items-center justify-center">
                    <svg class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="card bg-gradient-to-r from-green-50 to-green-100 border-green-200">
            <div class="p-4 flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-green-600 uppercase tracking-wider">Selesai</p>
                    <p class="text-2xl font-bold text-green-800 mt-1">{{ $disposisi->where('pivot.status',
                        'selesai')->count() }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-green-200 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="card bg-gradient-to-r from-red-50 to-red-100 border-red-200">
            <div class="p-4 flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-red-600 uppercase tracking-wider">Overdue</p>
                    <p class="text-2xl font-bold text-red-800 mt-1">
                        {{ $disposisi->filter(function($item) {
                        if ($item->batas_waktu && $item->pivot->status != 'selesai') {
                        try {
                        $batasWaktu = $item->batas_waktu instanceof \Carbon\Carbon
                        ? $item->batas_waktu
                        : \Carbon\Carbon::parse($item->batas_waktu);
                        return $batasWaktu->isPast();
                        } catch (\Exception $e) {
                        return false;
                        }
                        }
                        return false;
                        })->count() }}
                    </p>
                </div>
                <div class="w-10 h-10 rounded-full bg-red-200 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Fungsi helper untuk format tanggal --}}
    @php
    function formatDateInbox($date) {
    if (!$date) return '-';
    try {
    if ($date instanceof \Carbon\Carbon) {
    return $date->isoFormat('D MMMM Y');
    }
    if (is_string($date)) {
    return \Carbon\Carbon::parse($date)->isoFormat('D MMMM Y');
    }
    return '-';
    } catch (\Exception $e) {
    return '-';
    }
    }
    @endphp

    {{-- Daftar Disposisi --}}
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            @if($disposisi->isEmpty())
            <div class="text-center py-12">
                <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <p class="text-slate-500 font-medium">Tidak ada disposisi di kotak masuk</p>
                <p class="text-sm text-slate-400 mt-1">Belum ada disposisi yang ditujukan kepada Anda</p>
            </div>
            @else
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider w-12">No</th>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Kode Disposisi
                        </th>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Perihal Surat
                        </th>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Dari</th>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Batas Waktu
                        </th>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Prioritas</th>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($disposisi as $index => $item)
                    @php
                    $pivot = $item->penerima->first()->pivot ?? null;
                    $statusText = $pivot->status ?? 'belum_dibaca';
                    $isOverdue = false;
                    if ($item->batas_waktu && $statusText != 'selesai') {
                    try {
                    $batasWaktu = $item->batas_waktu instanceof \Carbon\Carbon
                    ? $item->batas_waktu
                    : \Carbon\Carbon::parse($item->batas_waktu);
                    $isOverdue = $batasWaktu->isPast();
                    } catch (\Exception $e) {}
                    }
                    $rowClass = $statusText == 'belum_dibaca' ? 'bg-primary-50/30 hover:bg-primary-50/50' :
                    'hover:bg-slate-50/50';
                    @endphp
                    <tr class="{{ $rowClass }} transition-colors cursor-pointer"
                        onclick="window.location.href='{{ route('disposisi.show', $item) }}'">
                        <td class="px-5 py-4 text-sm text-slate-500 text-center">{{ $disposisi->firstItem() + $index }}
                        </td>
                        <td class="px-5 py-4">
                            @php
                            $statusBadge = match($statusText) {
                            'belum_dibaca' => 'bg-amber-100 text-amber-700 ring-amber-200',
                            'dibaca' => 'bg-blue-100 text-blue-700 ring-blue-200',
                            'diproses' => 'bg-orange-100 text-orange-700 ring-orange-200',
                            'selesai' => 'bg-green-100 text-green-700 ring-green-200',
                            default => 'bg-slate-100 text-slate-600'
                            };
                            @endphp
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium ring-1 {{ $statusBadge }}">
                                @if($statusText == 'belum_dibaca')
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full mr-1.5"></span>
                                @endif
                                {{ ucfirst(str_replace('_', ' ', $statusText)) }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <span
                                class="text-xs font-mono font-semibold text-primary-700 bg-primary-50 px-2 py-1 rounded">
                                {{ $item->kode_disposisi }}
                            </span>
                            @if($isOverdue)
                            <span
                                class="ml-1 inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-red-100 text-red-700">
                                Overdue
                            </span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-sm font-medium text-slate-800 max-w-xs truncate"
                                title="{{ $item->suratMasuk->perihal ?? '-' }}">
                                {{ Str::limit($item->suratMasuk->perihal ?? '-', 50) }}
                            </p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $item->suratMasuk->no_surat ?? '-' }}</p>
                        </td>
                        <td class="px-5 py-4 text-sm text-slate-600">{{ $item->dariUser->name ?? '-' }}</td>
                        <td class="px-5 py-4 text-sm text-slate-600 whitespace-nowrap">
                            {{ formatDateInbox($item->tanggal_disposisi) }}
                        </td>
                        <td class="px-5 py-4">
                            @if($item->batas_waktu)
                            <span
                                class="text-sm whitespace-nowrap {{ $isOverdue ? 'text-red-600 font-semibold' : 'text-slate-500' }}">
                                {{ formatDateInbox($item->batas_waktu) }}
                            </span>
                            @else
                            <span class="text-slate-400 text-sm">-</span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            @php
                            $prioritasStyles = [
                            'rendah' => 'bg-slate-100 text-slate-600',
                            'normal' => 'bg-blue-100 text-blue-700',
                            'tinggi' => 'bg-orange-100 text-orange-700',
                            'segera' => 'bg-red-100 text-red-700',
                            ];
                            $style = $prioritasStyles[$item->prioritas] ?? 'bg-slate-100 text-slate-600';
                            @endphp
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $style }}">
                                {{ ucfirst($item->prioritas) }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <div class="flex items-center justify-center gap-1.5" @click.stop>
                                <a href="{{ route('disposisi.show', $item) }}"
                                    class="w-8 h-8 rounded-lg bg-primary-100 hover:bg-primary-200 text-primary-700 flex items-center justify-center transition-colors"
                                    title="Lihat & Tanggapi">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                @if($statusText != 'selesai')
                                <button type="button"
                                    @click="selectedDisposisi = {{ $item->id }}; selectedKode = '{{ $item->kode_disposisi }}'; showTanggapanModal = true"
                                    class="w-8 h-8 rounded-lg bg-green-100 hover:bg-green-200 text-green-700 flex items-center justify-center transition-colors"
                                    title="Beri Tanggapan Cepat">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>

        {{-- Pagination --}}
        @if($disposisi->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $disposisi->withQueryString()->links() }}
        </div>
        @endif
    </div>

    {{-- Modal Tanggapan Cepat --}}
    <div x-show="showTanggapanModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
        x-transition.opacity.duration.200ms @click.away="showTanggapanModal = false">

        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 overflow-hidden" x-show="showTanggapanModal"
            x-transition.scale.origin.center>

            <div class="px-6 py-4 border-b border-slate-100 bg-primary-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-primary-800">Tanggapi Disposisi</h3>
                        <p class="text-xs text-primary-600 mt-0.5" x-text="'Kode: ' + selectedKode"></p>
                    </div>
                    <button @click="showTanggapanModal = false" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <form x-bind:action="'{{ url('disposisi') }}/' + selectedDisposisi + '/tanggapi'" method="POST" class="p-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggapan <span
                                class="text-red-500">*</span></label>
                        <textarea name="tanggapan" rows="4" required
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                            placeholder="Tulis tanggapan Anda terhadap disposisi ini..."></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Status Pengerjaan <span
                                class="text-red-500">*</span></label>
                        <select name="status" required
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>
                        </select>
                        <p class="text-xs text-slate-400 mt-1">* Pilih "Selesai" jika tugas disposisi sudah Anda
                            selesaikan</p>
                    </div>
                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" @click="showTanggapanModal = false"
                            class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-medium transition-colors">
                            <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Kirim Tanggapan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

<style>
    [x-cloak] {
        display: none !important;
    }

    .card {
        background-color: white;
        border-radius: 0.75rem;
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        border-width: 1px;
        border-color: rgb(226 232 240 / 1);
        overflow: hidden;
    }
</style>
@endsection