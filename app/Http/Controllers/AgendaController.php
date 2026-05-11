<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use Carbon\Carbon;

class AgendaController extends Controller
{
    public function index()
    {
        $masuk = SuratMasuk::get()->map(function ($s) {

            return [
                'id' => 'SM-' . $s->id,
                'no_agenda' => $s->no_agenda,
                'jenis' => 'masuk',
                'instansi' => $s->asal_surat,
                'perihal' => $s->perihal,

                'tanggal' => Carbon::parse(
                    $s->tanggal_terima
                )->format('Y-m-d'),

                'waktu_mulai' => $s->waktumulai
                    ? Carbon::parse($s->waktumulai)->format('H:i')
                    : '',

                'waktu_selesai' => $s->waktuselesai
                    ? Carbon::parse($s->waktuselesai)->format('H:i')
                    : '',

                'sifat' => $s->sifat,
                'status' => $s->status,
            ];
        });

        $keluar = SuratKeluar::get()->map(function ($s) {

            return [
                'id' => 'SK-' . $s->id,
                'no_agenda' => $s->no_agenda,
                'jenis' => 'keluar',
                'instansi' => $s->tujuan_surat,
                'perihal' => $s->perihal,

                'tanggal' => Carbon::parse(
                    $s->tanggal_surat
                )->format('Y-m-d'),

                'waktu_mulai' => $s->waktumulai
                    ? Carbon::parse($s->waktumulai)->format('H:i')
                    : '',

                'waktu_selesai' => $s->waktuselesai
                    ? Carbon::parse($s->waktuselesai)->format('H:i')
                    : '',

                'sifat' => $s->sifat,
                'status' => $s->status,
            ];
        });

        $agendaData = $masuk
            ->merge($keluar)
            ->sortByDesc('tanggal')
            ->values()
            ->toArray(); // PENTING

        return view('agenda.index2', compact('agendaData'));
    }
}
