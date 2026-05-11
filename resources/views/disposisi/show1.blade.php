@extends('layouts.app')

@section('title', 'Detail Disposisi')
@section('page-title', 'Detail Disposisi')

@section('breadcrumb')
<span>Beranda</span> /
<a href="{{ route('disposisi.index') }}" class="text-primary-600 hover:underline">Disposisi</a> /
<span class="text-slate-600">Detail Disposisi</span>
@endsection

@section('content')
<div class="space-y-5" x-data="{ showTanggapan: false }">

    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-slate-800">Detail Disposisi</h2>
            <p class="text-sm text-slate-500">Informasi lengkap disposisi surat</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('disposisi.index') }}"
                class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
            @can('update', $disposisi)
            <a href="{{ route('disposisi.edit', $disposisi) }}"
                class="flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Disposisi
            </a>
            @endcan
        </div>
    </div>

    {{-- Fungsi helper untuk format tanggal --}}
    @php
        function formatDate($date) {
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

        function formatDateTime($date) {
            if (!$date) return '-';
            try {
                if ($date instanceof \Carbon\Carbon) {
                    return $date->isoFormat('D MMM Y, HH:mm');
                }
                if (is_string($date)) {
                    return \Carbon\Carbon::parse($date)->isoFormat('D MMM Y, HH:mm');
                }
                return '-';
            } catch (\Exception $e) {
                return '-';
            }
        }
    @endphp

    {{-- Alert Overdue --}}
    @php
        $isOverdue = false;
        if ($disposisi->batas_waktu && $disposisi->status != 'selesai') {
            try {
                $batasWaktu = $disposisi->batas_waktu instanceof \Carbon\Carbon
                    ? $disposisi->batas_waktu
                    : \Carbon\Carbon::parse($disposisi->batas_waktu);
                $isOverdue = $batasWaktu->isPast();
            } catch (\Exception $e) {
                $isOverdue = false;
            }
        }
    @endphp

    @if($isOverdue)
    <div class="bg-red-50 border-l-4 border-red-500 rounded-xl p-4">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <p class="text-sm font-semibold text-red-800">Disposisi Melewati Batas Waktu!</p>
                <p class="text-xs text-red-600">Batas waktu disposisi ini adalah {{ formatDate($disposisi->batas_waktu) }} dan belum selesai.</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Informasi Surat --}}
    <div class="card">
        <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-base font-semibold text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Informasi Surat Masuk
            </h3>
        </div>
        <div class="p-5">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="text-xs font-medium text-slate-500">No. Agenda</label>
                    <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $disposisi->suratMasuk->no_agenda ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-xs font-medium text-slate-500">No. Surat</label>
                    <p class="text-sm text-slate-800 mt-0.5">{{ $disposisi->suratMasuk->no_surat ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-xs font-medium text-slate-500">Perihal</label>
                    <p class="text-sm text-slate-800 mt-0.5">{{ $disposisi->suratMasuk->perihal ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-xs font-medium text-slate-500">Asal Surat</label>
                    <p class="text-sm text-slate-800 mt-0.5">{{ $disposisi->suratMasuk->asal_surat ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-xs font-medium text-slate-500">Tanggal Surat</label>
                    <p class="text-sm text-slate-800 mt-0.5">{{ formatDate($disposisi->suratMasuk->tanggal_surat ?? null) }}</p>
                </div>
                <div>
                    <label class="text-xs font-medium text-slate-500">Tanggal Terima</label>
                    <p class="text-sm text-slate-800 mt-0.5">{{ formatDate($disposisi->suratMasuk->tanggal_terima ?? null) }}</p>
                </div>
            </div>
            @if($disposisi->suratMasuk->file_surat ?? false)
            <div class="mt-4 pt-4 border-t border-slate-100">
                <a href="{{ asset('storage/' . $disposisi->suratMasuk->file_surat) }}" target="_blank"
                    class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Lihat File Surat
                </a>
            </div>
            @endif
        </div>
    </div>

    {{-- Informasi Disposisi --}}
    <div class="card">
        <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-base font-semibold text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Detail Disposisi
            </h3>
        </div>
        <div class="p-5">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="text-xs font-medium text-slate-500">Kode Disposisi</label>
                    <p class="text-sm font-mono font-semibold text-primary-700 bg-primary-50 inline-block px-2 py-1 rounded mt-0.5">
                        {{ $disposisi->kode_disposisi }}
                    </p>
                </div>
                <div>
                    <label class="text-xs font-medium text-slate-500">Dari</label>
                    <p class="text-sm text-slate-800 mt-0.5">{{ $disposisi->dariUser->name ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-xs font-medium text-slate-500">Tanggal Disposisi</label>
                    <p class="text-sm text-slate-800 mt-0.5">{{ formatDate($disposisi->tanggal_disposisi ?? null) }}</p>
                </div>
                <div>
                    <label class="text-xs font-medium text-slate-500">Batas Waktu</label>
                    <p class="text-sm text-slate-800 mt-0.5">
                        @if($disposisi->batas_waktu)
                            @php
                                $isDateOverdue = false;
                                try {
                                    $batasWaktu = $disposisi->batas_waktu instanceof \Carbon\Carbon
                                        ? $disposisi->batas_waktu
                                        : \Carbon\Carbon::parse($disposisi->batas_waktu);
                                    $isDateOverdue = $batasWaktu->isPast() && $disposisi->status != 'selesai';
                                } catch (\Exception $e) {}
                            @endphp
                            <span class="{{ $isDateOverdue ? 'text-red-600 font-semibold' : '' }}">
                                {{ formatDate($disposisi->batas_waktu) }}
                            </span>
                        @else
                            -
                        @endif
                    </p>
                </div>
                <div>
                    <label class="text-xs font-medium text-slate-500">Prioritas</label>
                    <div class="mt-0.5">
                        @php
                            $prioritasStyles = [
                                'rendah' => 'bg-slate-100 text-slate-600',
                                'normal' => 'bg-blue-100 text-blue-700',
                                'tinggi' => 'bg-orange-100 text-orange-700',
                                'segera' => 'bg-red-100 text-red-700',
                            ];
                            $style = $prioritasStyles[$disposisi->prioritas] ?? 'bg-slate-100 text-slate-600';
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $style }}">
                            {{ ucfirst($disposisi->prioritas) }}
                        </span>
                    </div>
                </div>
                <div>
                    <label class="text-xs font-medium text-slate-500">Status</label>
                    <div class="mt-0.5">
                        @php
                            $statusStyles = [
                                'aktif' => 'bg-blue-100 text-blue-700',
                                'selesai' => 'bg-green-100 text-green-700',
                                'dibatalkan' => 'bg-red-100 text-red-700',
                            ];
                            $statusStyle = $statusStyles[$disposisi->status] ?? 'bg-slate-100 text-slate-600';
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusStyle }}">
                            {{ ucfirst($disposisi->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-slate-100">
                <label class="text-xs font-medium text-slate-500 block mb-1.5">Instruksi</label>
                <div class="bg-slate-50 rounded-xl p-4">
                    <p class="text-sm text-slate-700 whitespace-pre-wrap">{{ $disposisi->instruksi }}</p>
                </div>
            </div>

            @if($disposisi->catatan)
            <div class="mt-4 pt-4 border-t border-slate-100">
                <label class="text-xs font-medium text-slate-500 block mb-1.5">Catatan</label>
                <div class="bg-amber-50 rounded-xl p-4">
                    <p class="text-sm text-slate-700 whitespace-pre-wrap">{{ $disposisi->catatan }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Daftar Penerima --}}
    <div class="card">
        <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-base font-semibold text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Daftar Penerima Disposisi
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="px-5 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Penerima</th>
                        <th class="px-5 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-5 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Dibaca</th>
                        <th class="px-5 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggapan</th>
                        <th class="px-5 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Selesai</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($disposisi->penerima as $penerima)
                    <tr>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-xs font-bold">
                                    {{ substr($penerima->name, 0, 2) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-800">{{ $penerima->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $penerima->jabatan ?? $penerima->role }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            @php
                                $statusText = $penerima->pivot->status ?? 'belum_dibaca';
                                $statusBadge = match($statusText) {
                                    'belum_dibaca' => 'bg-slate-100 text-slate-600',
                                    'dibaca' => 'bg-blue-100 text-blue-700',
                                    'diproses' => 'bg-orange-100 text-orange-700',
                                    'selesai' => 'bg-green-100 text-green-700',
                                    default => 'bg-slate-100 text-slate-600'
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusBadge }}">
                                {{ ucfirst(str_replace('_', ' ', $statusText)) }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-sm text-slate-600">
                            {{ formatDateTime($penerima->pivot->dibaca_at ?? null) }}
                        </td>
                        <td class="px-5 py-4">
                            @if($penerima->pivot->tanggapan)
                            <div class="max-w-xs">
                                <p class="text-sm text-slate-700">{{ $penerima->pivot->tanggapan }}</p>
                            </div>
                            @else
                            <span class="text-xs text-slate-400">Belum ada tanggapan</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-sm text-slate-600">
                            {{ formatDateTime($penerima->pivot->selesai_at ?? null) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Daftar Tindakan --}}
    @if($disposisi->tindakan && $disposisi->tindakan->count() > 0)
    <div class="card">
        <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-base font-semibold text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                Daftar Tindakan
            </h3>
        </div>
        <div class="p-5">
            <div class="space-y-2">
                @foreach($disposisi->tindakan as $tindakan)
                <div class="flex items-center gap-3">
                    <div class="w-6 h-6 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center text-xs font-bold">
                        {{ $loop->iteration }}
                    </div>
                    <p class="text-sm text-slate-700">{{ $tindakan->tindakan }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Form Tanggapan (untuk penerima) --}}
    @php
        $isRecipient = $disposisi->penerima->contains('id', auth()->id());
        $userPivot = $isRecipient ? $disposisi->penerima->where('id', auth()->id())->first()->pivot : null;
        $canRespond = $isRecipient && $userPivot && $userPivot->status != 'selesai';
    @endphp

    @if($canRespond)
    <div class="card border-primary-200 bg-primary-50/30">
        <div class="px-5 py-4 border-b border-primary-100">
            <h3 class="text-base font-semibold text-primary-800 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                Beri Tanggapan
            </h3>
            <p class="text-xs text-primary-600 mt-0.5">Anda adalah penerima disposisi ini. Silahkan beri tanggapan.</p>
        </div>
        <div class="p-5">
            <form action="{{ route('disposisi.tanggapi', $disposisi) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggapan <span class="text-red-500">*</span></label>
                        <textarea name="tanggapan" rows="4" required
                            class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                            placeholder="Tulis tanggapan Anda terhadap disposisi ini...">{{ old('tanggapan') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Status Pengerjaan <span class="text-red-500">*</span></label>
                        <select name="status" required
                            class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>
                        </select>
                        <p class="text-xs text-slate-400 mt-1">* Pilih "Selesai" jika tugas disposisi sudah Anda selesaikan</p>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-sm font-semibold transition-colors shadow-sm">
                            <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Kirim Tanggapan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @elseif($isRecipient && $userPivot && $userPivot->status == 'selesai')
    <div class="bg-green-50 border border-green-200 rounded-xl p-4">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <p class="text-sm font-semibold text-green-800">Disposisi Selesai</p>
                <p class="text-xs text-green-700">Anda telah menyelesaikan disposisi ini pada {{ formatDateTime($userPivot->selesai_at ?? null) }}</p>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
