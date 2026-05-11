@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <span>Beranda</span> / <span class="text-slate-600">Dashboard</span>
@endsection

@section('content')
<div class="space-y-6 animate-fade-in-up">

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card p-5 flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ number_format($stats['surat_masuk']) }}</p>
                <p class="text-sm text-slate-500 mt-0.5">Surat Masuk</p>
            </div>
        </div>

        <div class="card p-5 flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ number_format($stats['surat_keluar']) }}</p>
                <p class="text-sm text-slate-500 mt-0.5">Surat Keluar</p>
            </div>
        </div>

        <div class="card p-5 flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ number_format($stats['disposisi_aktif']) }}</p>
                <p class="text-sm text-slate-500 mt-0.5">Disposisi Aktif</p>
            </div>
        </div>

        <div class="card p-5 flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-purple-100 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ number_format($stats['disposisi_selesai']) }}</p>
                <p class="text-sm text-slate-500 mt-0.5">Disposisi Selesai</p>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="grid lg:grid-cols-3 gap-6">
        {{-- Line chart surat per bulan --}}
        <div class="card lg:col-span-2">
            <div class="card-header flex items-center justify-between">
                <h3 class="font-bold text-slate-800">Tren Surat (12 Bulan Terakhir)</h3>
                <div class="flex items-center gap-4 text-xs text-slate-500">
                    <span class="flex items-center gap-1.5"><span class="w-3 h-1.5 rounded bg-blue-500 inline-block"></span>Masuk</span>
                    <span class="flex items-center gap-1.5"><span class="w-3 h-1.5 rounded bg-emerald-500 inline-block"></span>Keluar</span>
                </div>
            </div>
            <div class="card-body">
                <canvas id="chartSuratBulan" height="200"></canvas>
            </div>
        </div>

        {{-- Pie chart status --}}
        <div class="card">
            <div class="card-header">
                <h3 class="font-bold text-slate-800">Status Surat Masuk</h3>
            </div>
            <div class="card-body flex flex-col items-center">
                <canvas id="chartStatus" width="200" height="200"></canvas>
                <div class="mt-4 space-y-2 w-full">
                    <div class="flex items-center justify-between text-sm">
                        <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-sm bg-amber-400 inline-block"></span>Pending</span>
                        <span class="font-semibold">{{ $suratByStatus['pending'] }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-sm bg-blue-500 inline-block"></span>Diproses</span>
                        <span class="font-semibold">{{ $suratByStatus['diproses'] }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-sm bg-emerald-500 inline-block"></span>Selesai</span>
                        <span class="font-semibold">{{ $suratByStatus['selesai'] }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-sm bg-red-500 inline-block"></span>Ditolak</span>
                        <span class="font-semibold">{{ $suratByStatus['ditolak'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom row --}}
    <div class="grid lg:grid-cols-2 gap-6">
        {{-- Surat Masuk Terbaru --}}
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h3 class="font-bold text-slate-800">Surat Masuk Terbaru</h3>
                <a href="{{ route('surat-masuk.index') }}" class="text-xs text-primary-600 hover:text-primary-700 font-medium">Lihat Semua →</a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($suratMasukTerbaru as $surat)
                <a href="{{ route('surat-masuk.show', $surat) }}" class="flex items-start gap-3 px-6 py-3.5 hover:bg-slate-50 transition-colors table-row-hover">
                    <div class="w-9 h-9 rounded-xl bg-blue-100 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-700 truncate">{{ $surat->perihal }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $surat->asal_surat }} • {{ $surat->tanggal_terima->isoFormat('D MMM Y') }}</p>
                    </div>
                    <span class="badge-{{ $surat->status }} text-[10px] font-semibold px-2 py-0.5 rounded-full ring-1 capitalize shrink-0">
                        {{ $surat->status }}
                    </span>
                </a>
                @empty
                <div class="px-6 py-8 text-center text-slate-400 text-sm">Belum ada surat masuk</div>
                @endforelse
            </div>
        </div>

        {{-- Disposisi Saya --}}
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h3 class="font-bold text-slate-800">Disposisi Untuk Saya</h3>
                <a href="{{ route('disposisi.inbox') }}" class="text-xs text-primary-600 hover:text-primary-700 font-medium">Lihat Semua →</a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($disposisiSaya as $item)
                <a href="{{ route('disposisi.show', $item) }}" class="flex items-start gap-3 px-6 py-3.5 hover:bg-slate-50 transition-colors">
                    <div class="w-9 h-9 rounded-xl bg-amber-100 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-700 truncate">{{ $item->suratMasuk->perihal ?? '-' }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $item->kode_disposisi }} • {{ $item->tanggal_disposisi->isoFormat('D MMM Y') }}</p>
                    </div>
                    @if($item->pivot->status === 'belum_dibaca')
                    <span class="w-2 h-2 rounded-full bg-red-500 shrink-0 mt-2"></span>
                    @endif
                </a>
                @empty
                <div class="px-6 py-8 text-center text-slate-400 text-sm">Tidak ada disposisi untuk Anda</div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const chartData = @json($suratPerBulan);
const statusData = @json($suratByStatus);

// Line chart
const ctx1 = document.getElementById('chartSuratBulan').getContext('2d');
new Chart(ctx1, {
    type: 'line',
    data: {
        labels: chartData.map(d => d.bulan),
        datasets: [
            {
                label: 'Surat Masuk',
                data: chartData.map(d => d.masuk),
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.05)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#3b82f6',
                pointRadius: 4,
            },
            {
                label: 'Surat Keluar',
                data: chartData.map(d => d.keluar),
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.05)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#10b981',
                pointRadius: 4,
            }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { precision: 0, color: '#94a3b8', font: { size: 11 } },
                grid: { color: '#f1f5f9' }
            },
            x: {
                ticks: { color: '#94a3b8', font: { size: 11 } },
                grid: { display: false }
            }
        }
    }
});

// Doughnut chart
const ctx2 = document.getElementById('chartStatus').getContext('2d');
new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Diproses', 'Selesai', 'Ditolak'],
        datasets: [{
            data: [statusData.pending, statusData.diproses, statusData.selesai, statusData.ditolak],
            backgroundColor: ['#fbbf24', '#3b82f6', '#10b981', '#ef4444'],
            borderWidth: 0,
        }]
    },
    options: {
        responsive: true,
        cutout: '65%',
        plugins: {
            legend: { display: false },
        }
    }
});
</script>
@endpush
