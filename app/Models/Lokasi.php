<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    protected $table = 'lokasis';
    protected $fillable = [
        'nama_lokasi',
        'alamat',
        'koordinat',
        'kapasitas',
        'keterangan',
        'status',
        'created_by',
        'updated_by'
    ];

    public function scopeAvailable($query)
    {
        return $query->where('status', 'aktif');
    }

    public function agenda()
    {
        return $this->hasMany(Agenda::class, 'lokasi_id');
    }
}
