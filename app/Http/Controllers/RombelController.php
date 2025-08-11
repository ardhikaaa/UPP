<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Rombel;
use App\Models\Siswa;
use App\Models\Unit;
use Illuminate\Http\Request;

class RombelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rombels = Rombel::with(['siswa', 'kelas', 'unit'])->get();
        $units = Unit::all();            // <-- tambah ini
        $kelas = Kelas::all();            // <-- tambah ini
        $siswa = Siswa::all();            // <-- tambah ini
        return view('rombel', compact('rombels', 'units', 'kelas', 'siswa'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = Unit::all();
        $kelas = Kelas::all();
        $siswa = Siswa::all();

    return view('rombel.create', compact('units', 'kelas', 'siswa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'unit_id'  => 'required|exists:units,id',
        'kelas_id' => 'required|exists:kelas,id',
        'siswa_id' => 'required|exists:siswas,id',
    ]);

    Rombel::create([
        'unit_id'  => $request->unit_id,
        'kelas_id' => $request->kelas_id,
        'siswa_id' => $request->siswa_id,
    ]);

    return redirect()->route('rombel.index')->with('success', 'Rombel berhasil dibuat');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Rombel::findOrFail($id);
        $delete->delete();
        return redirect()->route('rombel.index')->with('success', 'Data rombel berhasil dihapus.');
    }
}
