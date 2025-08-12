<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Kunjungan;
use App\Models\Obat;
use App\Models\Rombel;
use App\Models\Siswa;
use Illuminate\Http\Request;

class KunjunganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kunjungan = Kunjungan::with(['rombel.unit', 'rombel.kelas', 'rombel.siswa', 'obat', 'guru'])->get();
        $rombel    = Rombel::all();            
        $obat      = Obat::all();            
        $guru      = Guru::all();            
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
        'unit_id'     => 'required|exists:units,id',
        'kelas_id'    => 'required|exists:kelas,id',
        'siswa_id'    => 'required|exists:siswas,id',
        'obat_id'     => 'required|exists:obats,id',
        'guru_id'     => 'required|exists:gurus,id',
        'tanggal'     => 'required|date',
        'diagnosa'    => 'required|string',
        'jumlah_obat' => 'required|integer'
    ]);

    $rombel = Rombel::where('unit_id', $request->unit_id)
        ->where('kelas_id', $request->kelas_id)
        ->where('siswa_id', $request->siswa_id)
        ->firstOrFail();

    Kunjungan::create([
        'rombel_id'   => $rombel->id,
        'obat_id'     => $request->obat_id,
        'guru_id'     => $request->guru_id,
        'tanggal'     => $request->tanggal,
        'diagnosa'    => $request->diagnosa,
        'jumlah_obat' => $request->jumlah_obat
    ]);

    return redirect()->route('kunjungan.index')->with('success', 'Data kunjungan berhasil dibuat');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'unit_id'     => 'required|exists:units,id',
            'kelas_id'    => 'required|exists:kelas,id',
            'siswa_id'    => 'required|exists:siswas,id',
            'obat_id'     => 'required|exists:obats,id',
            'guru_id'     => 'required|exists:gurus,id',
            'tanggal'     => 'required|date',
            'diagnosa'    => 'required|string',
            'jumlah_obat' => 'required|integer'
        ]);

        $rombel = Rombel::where('unit_id', $request->unit_id)
            ->where('kelas_id', $request->kelas_id)
            ->where('siswa_id', $request->siswa_id)
            ->firstOrFail();

        $kunjungan = Kunjungan::findOrFail($id);
        $kunjungan->update([
            'rombel_id'   => $rombel->id,
            'obat_id'     => $request->obat_id,
            'guru_id'     => $request->guru_id,
            'tanggal'     => $request->tanggal,
            'diagnosa'    => $request->diagnosa,
            'jumlah_obat' => $request->jumlah_obat
        ]);

        return redirect()->route('kunjungan.index')->with('success', 'Data kunjungan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Kunjungan::findOrFail($id);
        $delete->delete();
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
}
