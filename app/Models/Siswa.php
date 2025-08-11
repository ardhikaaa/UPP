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

    // Relasi ke Rombel
    public function rombel()
    {
        return $this->hasOne(Rombel::class, 'siswa_id'); // ✅ tambahkan 'siswa_id' kalau nama FK jelas
    }
}
