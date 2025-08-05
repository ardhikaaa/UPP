<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswas';

    protected $fillable = [
        'nis',
        'nama_siswa',
        'jenis_kelamin',
        'no_telp_siswa',
        'no_telp_ortu'
    ];
}
