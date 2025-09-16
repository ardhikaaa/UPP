<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObatHistory extends Model
{
    protected $table = 'obat_histories';

    protected $fillable = [
        'obat_id',
        'jumlah',
        'tipe',
        'tanggal',
        'keterangan',
    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}
