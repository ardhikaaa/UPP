<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kunjungan extends Model
{
    use SoftDeletes;
    protected $table = 'kunjungans';

     protected $fillable = [
        'rombel_id',
        'diagnosa',
        'tanggal',
        'guru_id',
        'pengecekan',
        'anamnesa',
        'tindakan',
    ];

    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombel_id');
    }

    public function obats()
    {
        return $this->belongsToMany(Obat::class, 'kunjungan_obat', 'kunjungan_id', 'obat_id')
                    ->withPivot('jumlah_obat')
                    ->withTimestamps();
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
}