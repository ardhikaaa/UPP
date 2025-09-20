<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\Unit;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class GuruImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Normalisasi key ke lowercase
            $row = $row->toArray();
            $row = array_change_key_case($row, CASE_LOWER);

            // Mapping fleksibel untuk nama guru
            $nama = $row['nama_guru'] 
                 ?? $row['nama guru'] 
                 ?? $row['guru'] 
                 ?? $row['nama'] 
                 ?? $row['name']
                 ?? null;

            // Mapping fleksibel untuk mata pelajaran
            $mapel = $row['mata_pelajaran'] 
                   ?? $row['mata pelajaran'] 
                   ?? $row['mapel'] 
                   ?? $row['pelajaran']
                   ?? $row['subject']
                   ?? $row['mata_pel']
                   ?? $row['mata pel']
                   ?? null;

            // Mapping fleksibel untuk unit
            $unit = $row['unit'] 
                  ?? $row['unit_kerja'] 
                  ?? $row['unit kerja'] 
                  ?? $row['departemen'] 
                  ?? $row['department']
                  ?? $row['bagian']
                  ?? $row['section']
                  ?? null;

            // Kalau nama kosong, lewati baris ini
            if (!$nama) {
                continue;
            }

            // Jika mapel kosong, beri nilai default
            if (!$mapel) {
                $mapel = 'Tidak Diketahui';
            }

            // Cari unit berdasarkan nama unit
            $unitModel = null;
            if ($unit) {
                $unitModel = Unit::where('unit', $unit)->first();
                
                if (!$unitModel) {
                    // Jika unit tidak ditemukan, buat unit baru
                    $unitModel = Unit::create([
                        'unit' => $unit
                    ]);
                }
            } else {
                // Jika unit kosong, cari unit default atau buat yang baru
                $unitModel = Unit::first();
                if (!$unitModel) {
                    $unitModel = Unit::create([
                        'unit' => 'Default'
                    ]);
                }
            }

            // Buat guru baru
            Guru::create([
                'nama' => $nama,
                'mapel' => $mapel,
                'unit_id' => $unitModel->id,
            ]);
        }
    }
}
