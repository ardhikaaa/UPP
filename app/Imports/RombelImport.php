<?php

namespace App\Imports;

use App\Models\Rombel;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Unit;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class RombelImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Normalisasi key ke lowercase
            $row = $row->toArray();
            $row = array_change_key_case($row, CASE_LOWER);

            // Mapping fleksibel untuk nama siswa
            $namaSiswa = $row['nama_siswa'] 
                      ?? $row['nama siswa'] 
                      ?? $row['siswa'] 
                      ?? $row['nama']
                      ?? $row['name']
                      ?? null;

            // Mapping fleksibel untuk kelas
            $kelas = $row['kelas'] 
                  ?? $row['class']
                  ?? $row['tingkat']
                  ?? $row['grade']
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

            // Kalau nama siswa kosong, lewati baris ini
            if (!$namaSiswa) {
                continue;
            }

            // Cari siswa berdasarkan nama
            $siswaModel = Siswa::where('nama_siswa', $namaSiswa)->first();
            if (!$siswaModel) {
                continue; // Lewati jika siswa tidak ditemukan
            }

            // Cari atau buat unit
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

            // Cari atau buat kelas
            $kelasModel = null;
            if ($kelas) {
                $kelasModel = Kelas::where('kelas', $kelas)->first();
                
                if (!$kelasModel) {
                    // Jika kelas tidak ditemukan, buat kelas baru
                    $kelasModel = Kelas::create([
                        'kelas' => $kelas
                    ]);
                }
            } else {
                // Jika kelas kosong, cari kelas default atau buat yang baru
                $kelasModel = Kelas::first();
                if (!$kelasModel) {
                    $kelasModel = Kelas::create([
                        'kelas' => 'Default'
                    ]);
                }
            }

            // Cek apakah rombel sudah ada
            $existingRombel = Rombel::where('siswa_id', $siswaModel->id)
                                  ->where('kelas_id', $kelasModel->id)
                                  ->where('unit_id', $unitModel->id)
                                  ->first();

            if (!$existingRombel) {
                // Buat rombel baru
                Rombel::create([
                    'siswa_id' => $siswaModel->id,
                    'kelas_id' => $kelasModel->id,
                    'unit_id' => $unitModel->id,
                ]);
            }
        }
    }
}
