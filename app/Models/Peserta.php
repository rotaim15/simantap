<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $table = 'pesertas';
    protected $fillable = ['nama', 'email', 'no_tlp', 'jabatan', 'instansi', 'tipe', 'user_id'];

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }
    public function agendas()
    {
        return $this->belongsToMany(Agenda::class, 'agenda_pesertas')
            ->withPivot('status', 'catatan')
            ->withTimestamps();
    }
}
