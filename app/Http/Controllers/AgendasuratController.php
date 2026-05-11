<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Carbon\Carbon;

class AgendasuratController extends Controller
{
    //  public function index(Request $request)
    // {
    //     $bulan = $request->bulan ?? now()->month;
    //     $tahun = $request->tahun ?? now()->year;

    //     // SURAT MASUK
    //     $suratMasuk = SuratMasuk::query()
    //         ->whereMonth('tanggal_surat', $bulan)
    //         ->whereYear('tanggal_surat', $tahun)
    //         ->get()
    //         ->map(function ($item) {
    //             return [
    //                 'jenis' => 'Surat Masuk',
    //                 'asal_tujuan' => $item->asal_surat,
    //                 'perihal' => $item->perihal,
    //                 'tanggal' => $item->tanggal_surat,
    //                 'jam' => ($item->waktumulai ?? '-') . ' - ' . ($item->waktuselesai ?? '-'),
    //                 'disposisi' => $item->status,
    //                 'nomor' => $item->no_agenda,
    //             ];
    //         });

    //     // SURAT KELUAR
    //     $suratKeluar = SuratKeluar::query()
    //         ->whereMonth('tanggal_surat', $bulan)
    //         ->whereYear('tanggal_surat', $tahun)
    //         ->get()
    //         ->map(function ($item) {
    //             return [
    //                 'jenis' => 'Surat Keluar',
    //                 'asal_tujuan' => $item->tujuan_surat,
    //                 'perihal' => $item->perihal,
    //                 'tanggal' => $item->tanggal_surat,
    //                 'jam' => ($item->waktumulai ?? '-') . ' - ' . ($item->waktuselesai ?? '-'),
    //                 'disposisi' => $item->status,
    //                 'nomor' => $item->no_agenda,
    //             ];
    //         });

    //     $agenda = $suratMasuk
    //         ->concat($suratKeluar)
    //         ->sortBy('tanggal')
    //         ->values();

    //     return view('agenda-surat.index', [
    //         'agenda' => $agenda,
    //         'bulan' => $bulan,
    //         'tahun' => $tahun,
    //     ]);
    // }

    // public function index()
    // {
    //     $suratMasuk = SuratMasuk::select([
    //         'id',
    //         'no_agenda',
    //         'tanggal_surat',
    //         'waktumulai',
    //         'waktuselesai',
    //         'asal_surat as instansi',
    //         'perihal',
    //         'status',
    //         'sifat',
    //     ])->get()->map(function ($item) {
    //         $item->jenis = 'Surat Masuk';
    //         return $item;
    //     });

    //     $suratKeluar = SuratKeluar::select([
    //         'id',
    //         'no_agenda',
    //         'tanggal_surat',
    //         'waktumulai',
    //         'waktuselesai',
    //         'tujuan_surat as instansi',
    //         'perihal',
    //         'status',
    //         'sifat',
    //     ])->get()->map(function ($item) {
    //         $item->jenis = 'Surat Keluar';
    //         return $item;
    //     });

    //     $agenda = $suratMasuk
    //         ->concat($suratKeluar)
    //         ->sortBy('tanggal_surat')
    //         ->groupBy(function ($item) {
    //             return Carbon::parse($item->tanggal_surat)
    //                 ->translatedFormat('l, d F Y');
    //         });

    //     return view('agenda-surat.index', compact('agenda'));
    // }

    public function index(Request $request)
    {
        Carbon::setLocale('id');

        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        $search     = $request->search;
        $startDate  = $request->start_date;
        $endDate    = $request->end_date;

        /*
        |--------------------------------------------------------------------------
        | SURAT MASUK
        |--------------------------------------------------------------------------
        */

        $suratMasuk = SuratMasuk::query()

            ->select([
                'id',
                'no_agenda',
                'tanggal_surat',
                'waktumulai',
                'waktuselesai',
                'asal_surat as instansi',
                'perihal',
                'lokasi',
                'disposisikan',
                'status',
                'sifat',
            ])

            /*
            |--------------------------------------------------------------------------
            | SEARCH
            |--------------------------------------------------------------------------
            */

            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('no_agenda', 'like', "%{$search}%")
                        ->orWhere('asal_surat', 'like', "%{$search}%")
                        ->orWhere('perihal', 'like', "%{$search}%");
                });
            })

            /*
            |--------------------------------------------------------------------------
            | FILTER TANGGAL
            |--------------------------------------------------------------------------
            */

            ->when($startDate, function ($query) use ($startDate) {

                $query->whereDate('tanggal_surat', '>=', $startDate);
            })

            ->when($endDate, function ($query) use ($endDate) {

                $query->whereDate('tanggal_surat', '<=', $endDate);
            })

            ->get()

            ->map(function ($item) {

                $item->jenis = 'Surat Masuk';

                return $item;
            });

        /*
        |--------------------------------------------------------------------------
        | SURAT KELUAR
        |--------------------------------------------------------------------------
        */

        $suratKeluar = SuratKeluar::query()

            ->select([
                'id',
                'no_agenda',
                'tanggal_surat',
                'waktumulai',
                'waktuselesai',
                'tujuan_surat as instansi',
                'disposisikan',
                'lokasi',
                'perihal',
                'status',
                'sifat',
            ])

            /*
            |--------------------------------------------------------------------------
            | SEARCH
            |--------------------------------------------------------------------------
            */

            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('no_agenda', 'like', "%{$search}%")
                        ->orWhere('tujuan_surat', 'like', "%{$search}%")
                        ->orWhere('perihal', 'like', "%{$search}%");
                });
            })

            /*
            |--------------------------------------------------------------------------
            | FILTER TANGGAL
            |--------------------------------------------------------------------------
            */

            ->when($startDate, function ($query) use ($startDate) {

                $query->whereDate('tanggal_surat', '>=', $startDate);
            })

            ->when($endDate, function ($query) use ($endDate) {

                $query->whereDate('tanggal_surat', '<=', $endDate);
            })

            ->get()

            ->map(function ($item) {

                $item->jenis = 'Surat Keluar';

                return $item;
            });

        /*
        |--------------------------------------------------------------------------
        | GABUNGKAN DATA
        |--------------------------------------------------------------------------
        */

        $agenda = $suratMasuk
            ->concat($suratKeluar)
            ->sortBy('tanggal_surat')
            ->groupBy(function ($item) {

                return Carbon::parse($item->tanggal_surat)
                    ->translatedFormat('l, d F Y');
            });

        return view('agenda-surat.index', compact(
            'agenda',
            'search',
            'startDate',
            'endDate'
        ));
    }
}
