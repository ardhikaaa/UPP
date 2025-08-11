<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'units';
    
    protected $fillable = [
        'unit',
    ];

    public function rombels()
    {
        return $this->hasMany(Rombel::class, 'unit_id');
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'unit_id');
    }
}
