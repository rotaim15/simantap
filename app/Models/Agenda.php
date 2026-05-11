<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Agenda extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi_id',
    ];

    protected $dates = [
        'waktu_mulai',
        'waktu_selesai',
    ];
    public function pesertas(): BelongsToMany
    {
        return $this->belongsToMany(Peserta::class, 'agenda_pesertas')
            ->withPivot('status', 'catatan')
            ->withTimestamps();
    }

    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class);
    }
}
