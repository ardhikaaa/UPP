<?php

namespace App\Imports;

use App\Models\Obat;
use App\Models\ObatHistory;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class ObatImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Normalisasi key ke lowercase
            $row = $row->toArray();
            $row = array_change_key_case($row, CASE_LOWER);

            // Mapping fleksibel untuk nama obat
            $nama = $row['nama_obat'] 
                 ?? $row['nama obat'] 
                 ?? $row['obat'] 
                 ?? $row['nama'] 
                 ?? null;

            // Mapping fleksibel untuk jumlah
            $jumlah = $row['jumlah'] 
                    ?? $row['jumlah_obat']
                    ?? $row['jumlah obat']
                    ?? $row['banyak'] 
                    ?? $row['stok'] 
                    ?? $row['stok_obat'] 
                    ?? $row['stok obat'] 
                    ?? $row['qty'] 
                    ?? 0;

            // Kalau nama kosong, lewati baris ini
            if (!$nama) {
                continue;
            }

            // Cek apakah obat dengan nama yang sama sudah ada
            $obat = Obat::where('nama_obat', $nama)->first();

            if ($obat) {
                // Jika obat sudah ada, tambahkan jumlahnya
                $jumlahLama = $obat->jumlah;
                $obat->increment('jumlah', (int) $jumlah);
                
                // Catat history untuk penambahan stok
                ObatHistory::create([
                    'obat_id'   => $obat->id,
                    'jumlah'    => (int) $jumlah,
                    'tipe'      => 'masuk',
                    'tanggal'   => now(),
                    'keterangan'=> 'Stok obat ditambahkan dari import Excel (stok lama: ' . $jumlahLama . ', ditambah: ' . (int) $jumlah . ')',
                ]);
            } else {
                // Jika obat belum ada, buat obat baru
                $obat = Obat::create([
                    'nama_obat' => $nama,
                    'jumlah'    => (int) $jumlah, // pastikan angka
                ]);

                // Catat history untuk obat yang baru dibuat
                ObatHistory::create([
                    'obat_id'   => $obat->id,
                    'jumlah'    => $obat->jumlah,
                    'tipe'      => 'masuk',
                    'tanggal'   => now(),
                    'keterangan'=> 'Stok obat baru diimport dari Excel',
                ]);
            }
        }
    }
}
