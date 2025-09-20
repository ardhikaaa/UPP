<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Kunjungan;
use App\Models\Obat;
use App\Models\ObatHistory;
use App\Models\Rombel;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KunjunganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Kunjungan::with(['rombel.unit', 'rombel.kelas', 'rombel.siswa', 'obats', 'guru']);
        
        // Tambahkan search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('diagnosa', 'like', '%' . $searchTerm . '%')
                  ->orWhere('pengecekan', 'like', '%' . $searchTerm . '%')
                  ->orWhere('anamnesa', 'like', '%' . $searchTerm . '%')
                  ->orWhere('tindakan', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('rombel.siswa', function($subQuery) use ($searchTerm) {
                      $subQuery->where('nama_siswa', 'like', '%' . $searchTerm . '%');
                  })
                  ->orWhereHas('rombel.unit', function($subQuery) use ($searchTerm) {
                      $subQuery->where('unit', 'like', '%' . $searchTerm . '%');
                  })
                  ->orWhereHas('rombel.kelas', function($subQuery) use ($searchTerm) {
                      $subQuery->where('kelas', 'like', '%' . $searchTerm . '%');
                  })
                  ->orWhereHas('guru', function($subQuery) use ($searchTerm) {
                      $subQuery->where('nama', 'like', '%' . $searchTerm . '%');
                  })
                  ->orWhereHas('obats', function($subQuery) use ($searchTerm) {
                      $subQuery->where('nama_obat', 'like', '%' . $searchTerm . '%');
                  });
            });
        }
        
        $kunjungan = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Append search parameter to pagination links
        $kunjungan->appends($request->query());

        $rombel = Rombel::all();            
        $obat   = Obat::all();            
        $guru   = Guru::all();            

        return view('kunjungan_uks', compact('kunjungan', 'rombel', 'obat', 'guru'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rombel = Rombel::all();
        $obat   = Obat::all();
        $guru   = Guru::all();

        return view('kunjungan.create', compact('rombel', 'obat', 'guru'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'unit_id'       => 'required|exists:units,id',
            'kelas_id'      => 'required|exists:kelas,id',
            'siswa_id'      => 'required|exists:siswas,id',
            'obat_ids'      => 'required|array|min:1',
            'obat_ids.*'    => 'required|exists:obats,id',
            'jumlah_obat'   => 'required|array|min:1',
            'jumlah_obat.*' => 'required|integer|min:1',
            'guru_id'       => 'required|exists:gurus,id',
            'diagnosa'      => 'required|string',
            'pengecekan'    => 'required|string|max:255',
            'anamnesa'      => 'required|string',
            'tindakan'      => 'required|string',
        ]);

        // Untuk update, kita tidak perlu menolak obat dengan stok 0.
        // Validasi stok akan dilakukan berbasis delta (kenaikan saja).

        $rombel = Rombel::where('unit_id', $request->unit_id)
            ->where('kelas_id', $request->kelas_id)
            ->where('siswa_id', $request->siswa_id)
            ->firstOrFail();

        // ✅ Cek stok lebih dulu
        foreach ($request->obat_ids as $index => $obatId) {
            $obat = Obat::findOrFail($obatId);
            $jumlahObat = $request->jumlah_obat[$index];

            if ($obat->jumlah < $jumlahObat) {
                return back()
                    ->withInput()
                    ->with('error', "Stok obat '{$obat->nama_obat}' tidak mencukupi! Stok tersedia: {$obat->jumlah}, yang diminta: {$jumlahObat}. Silakan tambahkan stok obat di halaman Obat terlebih dahulu.");
            }
        }

        // ✅ Buat kunjungan
        $kunjungan = Kunjungan::create([
            'rombel_id'   => $rombel->id,
            'guru_id'     => $request->guru_id,
            'tanggal'     => now(),
            'diagnosa'    => $request->diagnosa,
            'pengecekan'  => $request->pengecekan,
            'anamnesa'    => $request->anamnesa,
            'tindakan'    => $request->tindakan,
        ]);

        // ✅ Catat obat yang diberikan
        foreach ($request->obat_ids as $index => $obatId) {
            $jumlahObat = $request->jumlah_obat[$index];

            // Insert/Update ke pivot
            if ($kunjungan->obats()->where('obat_id', $obatId)->exists()) {
                $kunjungan->obats()->updateExistingPivot($obatId, [
                    'jumlah_obat' => $jumlahObat,
                ]);
            } else {
                $kunjungan->obats()->attach($obatId, ['jumlah_obat' => $jumlahObat]);
            }

            // Kurangi stok
            $obat = Obat::findOrFail($obatId);
            $obat->decrement('jumlah', $jumlahObat);

            // Catat history keluar
            ObatHistory::create([
                'obat_id'    => $obat->id,
                'jumlah'     => $jumlahObat,
                'tipe'       => 'keluar',
                'tanggal'    => now(),
                'keterangan' => "Obat dikeluarkan untuk kunjungan ID {$kunjungan->id}",
            ]);
        }

        return redirect()->route('kunjungan.index')->with('success', 'Data kunjungan berhasil dibuat');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $kunjungan = Kunjungan::with(['rombel.unit', 'rombel.kelas', 'rombel.siswa', 'guru', 'obats'])
        ->findOrFail($id);

        return view('show', compact('kunjungan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kunjungan = Kunjungan::with(['rombel.unit', 'rombel.kelas', 'rombel.siswa', 'obats', 'guru'])->findOrFail($id);
        $rombel = Rombel::all();
        $obat = Obat::all();
        $guru = Guru::all();

        return view('kunjungan_uks', compact('kunjungan', 'rombel', 'obat', 'guru', 'id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'unit_id'       => 'required|exists:units,id',
            'kelas_id'      => 'required|exists:kelas,id',
            'siswa_id'      => 'required|exists:siswas,id',
            'obat_ids'      => 'required|array|min:1',
            'obat_ids.*'    => 'required|exists:obats,id',
            'jumlah_obat'   => 'required|array|min:1',
            'jumlah_obat.*' => 'required|integer|min:1',
            'guru_id'       => 'required|exists:gurus,id',
            'tanggal'       => 'required|date',
            'diagnosa'      => 'required|string',
            'pengecekan'    => 'required|string|max:255',
            'anamnesa'      => 'required|string',
            'tindakan'      => 'required|string',
        ]);

        // Validasi tambahan: pastikan obat yang dipilih memiliki stok > 0
        foreach ($request->obat_ids as $obatId) {
            $obat = Obat::findOrFail($obatId);
            if ($obat->jumlah <= 0) {
                return back()
                    ->withInput()
                    ->with('error', "Obat '{$obat->nama_obat}' tidak dapat dipilih karena stok habis. Silakan tambahkan stok obat di halaman Obat terlebih dahulu.");
            }
        }

        $rombel = Rombel::where('unit_id', $request->unit_id)
            ->where('kelas_id', $request->kelas_id)
            ->where('siswa_id', $request->siswa_id)
            ->firstOrFail();

        $kunjungan = Kunjungan::with('obats')->findOrFail($id);

        // Siapkan mapping jumlah lama
        $oldMap = [];
        foreach ($kunjungan->obats as $oldObat) {
            $oldMap[$oldObat->id] = (int) $oldObat->pivot->jumlah_obat;
        }

        // Siapkan mapping jumlah baru dari request
        $newMap = [];
        foreach ($request->obat_ids as $idx => $obatId) {
            $newMap[(int) $obatId] = (int) $request->jumlah_obat[$idx];
        }

        // Validasi stok hanya untuk delta positif (kenaikan)
        foreach ($newMap as $obatId => $newQty) {
            $oldQty = $oldMap[$obatId] ?? 0;
            $delta = $newQty - $oldQty;
            if ($delta > 0) {
                $obat = Obat::findOrFail($obatId);
                if ($obat->jumlah < $delta) {
                    return back()
                        ->withInput()
                        ->with('error', "Stok obat '{$obat->nama_obat}' tidak mencukupi! Stok tersedia: {$obat->jumlah}, tambahan diminta: {$delta}. Tambahkan stok di halaman Obat terlebih dahulu.");
                }
            }
        }

        // Update data kunjungan
        $kunjungan->update([
            'rombel_id'   => $rombel->id,
            'guru_id'     => $request->guru_id,
            'tanggal'     => $request->tanggal,
            'diagnosa'    => $request->diagnosa,
            'pengecekan'  => $request->pengecekan,
            'anamnesa'    => $request->anamnesa,
            'tindakan'    => $request->tindakan,
        ]);

        // Proses stok berbasis delta + catat history sesuai arah perubahan
        // Dan siapkan data sync pivot
        $syncData = [];

        // Semua obat yang terlibat (gabungan lama dan baru)
        $allObatIds = array_unique(array_merge(array_keys($oldMap), array_keys($newMap)));

        foreach ($allObatIds as $obatId) {
            $oldQty = $oldMap[$obatId] ?? 0;
            $newQty = $newMap[$obatId] ?? 0;
            $delta = $newQty - $oldQty;

            if ($delta > 0) {
                $obat = Obat::findOrFail($obatId);
                $obat->decrement('jumlah', $delta);
                ObatHistory::create([
                    'obat_id'    => $obat->id,
                    'jumlah'     => $delta,
                    'tipe'       => 'keluar',
                    'tanggal'    => now(),
                    'keterangan' => "Penyesuaian (kenaikan) kunjungan ID {$kunjungan->id}",
                ]);
            } elseif ($delta < 0) {
                $obat = Obat::findOrFail($obatId);
                $obat->increment('jumlah', abs($delta));
                ObatHistory::create([
                    'obat_id'    => $obat->id,
                    'jumlah'     => abs($delta),
                    'tipe'       => 'masuk',
                    'tanggal'    => now(),
                    'keterangan' => "Penyesuaian (penurunan) kunjungan ID {$kunjungan->id}",
                ]);
            }

            if ($newQty > 0) {
                $syncData[$obatId] = ['jumlah_obat' => $newQty];
            }
        }

        // Sinkronkan pivot sesuai jumlah baru (hapus yang tidak ada)
        $kunjungan->obats()->sync($syncData);

        return redirect()->route('kunjungan.index')->with('success', 'Data kunjungan berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kunjungan = Kunjungan::findOrFail($id);
        
        // Hapus kunjungan tanpa mengembalikan stok obat
        // Stok obat tetap pada jumlah yang sudah dikurangi
        $kunjungan->delete();
        return redirect()->route('kunjungan.index')->with('success', 'Data kunjungan berhasil dihapus.');
    }

    public function getKelas($unit_id)
    {
        try {
            // Get kelas that have rombel records for the specified unit
            $kelas = Kelas::whereHas('rombels', function($query) use ($unit_id) {
                $query->where('unit_id', $unit_id);
            })->distinct()->get(['id', 'kelas']);
            
            return response()->json($kelas);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load kelas'], 500);
        }
    }

    public function getSiswa($unit_id, $kelas_id)
    {
        try {
            // Get siswa that have rombel records for the specified unit and kelas
            $siswa = Siswa::whereHas('rombel', function($query) use ($unit_id, $kelas_id) {
                $query->where('unit_id', $unit_id)
                      ->where('kelas_id', $kelas_id);
            })->get(['id', 'nama_siswa']);

            return response()->json($siswa);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load siswa'], 500);
        }
    }

    public function getGuru($unit_id)
    {
        try {
            // Get guru that belong to the specified unit
            $guru = Guru::where('unit_id', $unit_id)->get(['id', 'nama']);

            return response()->json($guru);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load guru'], 500);
        }
    }
}