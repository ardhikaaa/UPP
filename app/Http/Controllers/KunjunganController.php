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
    public function index()
    {
        $kunjungan = Kunjungan::with(['rombel.unit', 'rombel.kelas', 'rombel.siswa', 'obats', 'guru'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

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

        $kunjungan = Kunjungan::findOrFail($id);

        // Kembalikan stok obat lama + catat history pengembalian
        foreach ($kunjungan->obats as $obat) {
            $obat->jumlah += $obat->pivot->jumlah_obat;
            $obat->save();

            ObatHistory::create([
                'obat_id'    => $obat->id,
                'jumlah'     => $obat->pivot->jumlah_obat,
                'tipe'       => 'masuk',
                'tanggal'    => now(),
                'keterangan' => "Rollback stok dari update kunjungan ID {$kunjungan->id}",
            ]);
        }

        // Hapus relasi obat lama
        $kunjungan->obats()->detach();

        // Validasi stok obat baru
        foreach ($request->obat_ids as $index => $obatId) {
            $obat = Obat::findOrFail($obatId);
            $jumlahObat = $request->jumlah_obat[$index];

            if ($obat->jumlah < $jumlahObat) {
                return back()
                    ->withInput()
                    ->with('error', "Stok obat '{$obat->nama_obat}' tidak mencukupi! Stok tersedia: {$obat->jumlah}, yang diminta: {$jumlahObat}. Silakan tambahkan stok obat di halaman Obat terlebih dahulu.");
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

        // Tambahkan obat baru + kurangi stok + catat history keluar
        foreach ($request->obat_ids as $index => $obatId) {
            $obat = Obat::findOrFail($obatId);
            $jumlahObat = $request->jumlah_obat[$index];

            // Kurangi stok
            $obat->decrement('jumlah', $jumlahObat);

            // Attach ke kunjungan
            $kunjungan->obats()->attach($obatId, ['jumlah_obat' => $jumlahObat]);

            // Catat history keluar
            ObatHistory::create([
                'obat_id'    => $obat->id,
                'jumlah'     => $jumlahObat,
                'tipe'       => 'keluar',
                'tanggal'    => now(),
                'keterangan' => "Obat dikeluarkan (update) untuk kunjungan ID {$kunjungan->id}",
            ]);
        }

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