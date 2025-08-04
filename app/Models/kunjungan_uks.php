<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kunjungan_uks extends Model
{
    //
    protected $table = 'kunjungan_uks' ;

    protected $fillable = [
        'nama_siswa',
        'kelas',
        'diagnosa',
        'obat',
        'tanggal',
        'guru',
        'jumlah_obat',
        'status',
    ];
}
