<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $table = 'obats';

    protected $fillable = [
        'nama_obat',
        'jumlah'
    ];

    public function kunjungans()
    {
        return $this->belongsToMany(Kunjungan::class, 'kunjungan_obat', 'obat_id', 'kunjungan_id')
                    ->withPivot('jumlah_obat')
                    ->withTimestamps();
    }
}