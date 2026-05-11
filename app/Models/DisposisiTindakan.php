<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisposisiTindakan extends Model
{
    protected $table = 'disposisi_tindakan';

    protected $fillable = [
        'disposisi_id',
        'tindakan',
        'is_checked',
        'urutan',
    ];

    protected $casts = [
        'is_checked' => 'boolean',
    ];

    public function disposisi()
    {
        return $this->belongsTo(Disposisi::class);
    }
}
