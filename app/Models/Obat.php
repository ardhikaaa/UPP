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

    public function kunjungan()
    {
        return $this->hasMany(Kunjungan::class, 'obat_id');
    }
}