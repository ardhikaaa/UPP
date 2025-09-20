<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class SiswaImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Normalisasi key ke lowercase
            $row = $row->toArray();
            $row = array_change_key_case($row, CASE_LOWER);

            // Mapping fleksibel untuk NIS
            $nis = $row['nis'] 
                 ?? $row['no_induk'] 
                 ?? $row['no induk'] 
                 ?? $row['nomor_induk'] 
                 ?? $row['nomor induk'] 
                 ?? $row['student_id']
                 ?? null;

            // Mapping fleksibel untuk nama siswa
            $nama = $row['nama_siswa'] 
                 ?? $row['nama siswa'] 
                 ?? $row['nama'] 
                 ?? $row['name']
                 ?? $row['siswa']
                 ?? null;

            // Mapping fleksibel untuk jenis kelamin
            $jenisKelamin = $row['jenis_kelamin'] 
                          ?? $row['jenis kelamin'] 
                          ?? $row['gender'] 
                          ?? $row['jk']
                          ?? $row['kelamin']
                          ?? null;

            // Mapping fleksibel untuk nomor telepon siswa
            $noTelpSiswa = $row['no_telp_siswa'] 
                         ?? $row['no telp siswa'] 
                         ?? $row['no_telp'] 
                         ?? $row['no telp'] 
                         ?? $row['telepon_siswa'] 
                         ?? $row['telepon siswa'] 
                         ?? $row['phone']
                         ?? $row['telp']
                         ?? null;

            // Mapping fleksibel untuk nomor telepon orang tua
            $noTelpOrtu = $row['no_telp_ortu'] 
                        ?? $row['no telp ortu'] 
                        ?? $row['no_telp_orang_tua'] 
                        ?? $row['no telp orang tua'] 
                        ?? $row['telepon_ortu'] 
                        ?? $row['telepon ortu'] 
                        ?? $row['phone_ortu']
                        ?? $row['telp_ortu']
                        ?? $row['no_telp_wali']
                        ?? $row['no telp wali']
                        ?? null;

            // Kalau NIS atau nama kosong, lewati baris ini
            if (!$nis || !$nama) {
                continue;
            }

            // Normalisasi jenis kelamin
            if ($jenisKelamin) {
                $jenisKelamin = strtolower(trim($jenisKelamin));
                if (in_array($jenisKelamin, ['l', 'laki', 'laki-laki', 'male', 'pria'])) {
                    $jenisKelamin = 'Laki-laki';
                } elseif (in_array($jenisKelamin, ['p', 'perempuan', 'female', 'wanita'])) {
                    $jenisKelamin = 'Perempuan';
                } else {
                    $jenisKelamin = 'Laki-laki'; // default
                }
            } else {
                $jenisKelamin = 'Laki-laki'; // default
            }

            // Jika nomor telepon kosong, beri nilai default
            if (!$noTelpSiswa) {
                $noTelpSiswa = '-';
            }
            if (!$noTelpOrtu) {
                $noTelpOrtu = '-';
            }

            // Cek apakah NIS sudah ada
            $existingSiswa = Siswa::where('nis', $nis)->first();
            if ($existingSiswa) {
                // Update data yang sudah ada
                $existingSiswa->update([
                    'nama_siswa' => $nama,
                    'jenis_kelamin' => $jenisKelamin,
                    'no_telp_siswa' => $noTelpSiswa,
                    'no_telp_ortu' => $noTelpOrtu,
                ]);
            } else {
                // Buat siswa baru
                Siswa::create([
                    'nis' => $nis,
                    'nama_siswa' => $nama,
                    'jenis_kelamin' => $jenisKelamin,
                    'no_telp_siswa' => $noTelpSiswa,
                    'no_telp_ortu' => $noTelpOrtu,
                ]);
            }
        }
    }
}
