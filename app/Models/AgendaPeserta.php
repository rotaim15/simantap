<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgendaPeserta extends Model
{
    protected $table = 'agenda_pesertas';

    protected $fillable = [
        'agenda_id',
        'peserta_id',
        'status',
        'catatan',
    ];

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }   
}
