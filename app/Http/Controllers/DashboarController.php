<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aktivitas;
use App\Models\Disposisi;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboarController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $stats = [
            'surat_masuk' => SuratMasuk::count(),
            'surat_keluar' => SuratKeluar::count(),
            'disposisi_aktif' => Disposisi::where('status', 'aktif')->count(),
            'disposisi_selesai' => Disposisi::where('status', 'selesai')->count(),
        ];

        $suratMasukTerbaru = SuratMasuk::with('creator')
            ->latest()
            ->take(5)
            ->get();

        $disposisiTerbaru = Disposisi::with(['suratMasuk', 'dariUser', 'penerima'])
            ->latest()
            ->take(5)
            ->get();

        $disposisiSaya = $user->disposisiDiterima()
            ->with('suratMasuk')
            ->wherePivotIn('status', ['belum_dibaca', 'dibaca', 'diproses'])
            ->latest('disposisi.created_at')
            ->take(5)
            ->get();

        $aktivitasTerbaru = Aktivitas::with('user')
            ->latest()
            ->take(10)
            ->get();

        // Chart data: surat masuk per bulan (12 bulan terakhir)
        $suratPerBulan = [];
        for ($i = 11; $i >= 0; $i--) {
            $bulan = now()->subMonths($i);
            $suratPerBulan[] = [
                'bulan' => $bulan->isoFormat('MMM YY'),
                'masuk' => SuratMasuk::whereYear('created_at', $bulan->year)
                    ->whereMonth('created_at', $bulan->month)->count(),
                'keluar' => SuratKeluar::whereYear('created_at', $bulan->year)
                    ->whereMonth('created_at', $bulan->month)->count(),
            ];
        }

        $suratByStatus = [
            'pending' => SuratMasuk::where('status', 'pending')->count(),
            'diproses' => SuratMasuk::where('status', 'diproses')->count(),
            'selesai' => SuratMasuk::where('status', 'selesai')->count(),
            'ditolak' => SuratMasuk::where('status', 'ditolak')->count(),
        ];

        return view('dashboard.index', compact(
            'stats',
            'suratMasukTerbaru',
            'disposisiTerbaru',
            'disposisiSaya',
            'aktivitasTerbaru',
            'suratPerBulan',
            'suratByStatus'
        ));
    }
}
