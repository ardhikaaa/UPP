<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = [
        'kelas',
        'unit_id' // penting untuk relasi
    ];

    public function rombels()
    {
        return $this->hasMany(Rombel::class, 'kelas_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}