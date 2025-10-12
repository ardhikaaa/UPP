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

            // Mapping fleksibel untuk NIS
            $nis = $row['nis'] 
                ?? $row['nomor_induk'] 
                ?? $row['nomor induk'] 
                ?? $row['no_induk'] 
                ?? $row['no induk']
                ?? null;

            // Mapping fleksibel untuk nama siswa
            $namaSiswa = $row['nama_siswa'] 
                      ?? $row['nama siswa'] 
                      ?? $row['siswa'] 
                      ?? $row['nama']
                      ?? $row['name']
                      ?? null;

            // Mapping fleksibel untuk jenis kelamin
            $jenisKelamin = $row['jenis_kelamin'] 
                         ?? $row['jenis kelamin'] 
                         ?? $row['gender'] 
                         ?? $row['jk']
                         ?? $row['kelamin']
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

            // Mapping fleksibel untuk no telp siswa
            $noTelpSiswa = $row['no_telp_siswa'] 
                        ?? $row['no telp siswa'] 
                        ?? $row['telp_siswa'] 
                        ?? $row['telp siswa'] 
                        ?? $row['hp_siswa'] 
                        ?? $row['hp siswa']
                        ?? $row['telepon_siswa']
                        ?? $row['telepon siswa']
                        ?? null;

            // Mapping fleksibel untuk no telp ortu
            $noTelpOrtu = $row['no_telp_ortu'] 
                       ?? $row['no telp ortu'] 
                       ?? $row['telp_ortu'] 
                       ?? $row['telp ortu'] 
                       ?? $row['hp_ortu'] 
                       ?? $row['hp ortu']
                       ?? $row['telepon_ortu']
                       ?? $row['telepon ortu']
                       ?? $row['no_telp_orang_tua']
                       ?? $row['no telp orang tua']
                       ?? null;

            // Kalau nama siswa kosong, lewati baris ini
            if (!$namaSiswa) {
                continue;
            }

            // Cari atau buat siswa
            $siswaModel = null;
            if ($nis) {
                // Cari siswa berdasarkan NIS
                $siswaModel = Siswa::where('nis', $nis)->first();
            }
            
            if (!$siswaModel) {
                // Jika tidak ditemukan berdasarkan NIS, cari berdasarkan nama
                $siswaModel = Siswa::where('nama_siswa', $namaSiswa)->first();
            }

            if (!$siswaModel) {
                // Jika siswa tidak ditemukan, buat siswa baru
                $siswaModel = Siswa::create([
                    'nis' => $nis,
                    'nama_siswa' => $namaSiswa,
                    'jenis_kelamin' => $jenisKelamin,
                    'no_telp_siswa' => $noTelpSiswa,
                    'no_telp_ortu' => $noTelpOrtu,
                ]);
            } else {
                // Jika siswa sudah ada, update data yang kosong (jika ada)
                $updateData = [];
                if (!$siswaModel->nis && $nis) {
                    $updateData['nis'] = $nis;
                }
                if (!$siswaModel->jenis_kelamin && $jenisKelamin) {
                    $updateData['jenis_kelamin'] = $jenisKelamin;
                }
                if (!$siswaModel->no_telp_siswa && $noTelpSiswa) {
                    $updateData['no_telp_siswa'] = $noTelpSiswa;
                }
                if (!$siswaModel->no_telp_ortu && $noTelpOrtu) {
                    $updateData['no_telp_ortu'] = $noTelpOrtu;
                }
                
                if (!empty($updateData)) {
                    $siswaModel->update($updateData);
                }
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
