<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $fillable = [
        'nama',
        'mapel',
    ];

    public function kunjungan()
    {
        return $this->hasMany(Kunjungan::class, 'guru_id');
    }
}

