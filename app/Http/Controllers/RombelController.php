<?php

namespace App\Http\Controllers;

use App\Imports\RombelImport;
use App\Models\Kelas;
use App\Models\Rombel;
use App\Models\Siswa;
use App\Models\Unit;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RombelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Rombel::with(['siswa', 'kelas', 'unit']);
        
        // Tambahkan search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->whereHas('siswa', function($subQuery) use ($searchTerm) {
                    $subQuery->where('nama_siswa', 'like', '%' . $searchTerm . '%');
                })
                ->orWhereHas('kelas', function($subQuery) use ($searchTerm) {
                    $subQuery->where('kelas', 'like', '%' . $searchTerm . '%');
                })
                ->orWhereHas('unit', function($subQuery) use ($searchTerm) {
                    $subQuery->where('unit', 'like', '%' . $searchTerm . '%');
                });
            });
        }
        
        $rombels = $query->orderBy('created_at', 'desc')->paginate(50);
        
        // Append search parameter to pagination links
        $rombels->appends($request->query());
        
        $units = Unit::all();
        $kelas = Kelas::all();
        $siswa = Siswa::all();
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
        $rombel = Rombel::with(['siswa', 'kelas', 'unit'])->findOrFail($id);
        $units = Unit::all();
        $kelas = Kelas::all();
        $siswa = Siswa::all();
        
        return response()->json([
            'rombel' => $rombel,
            'units' => $units,
            'kelas' => $kelas,
            'siswa' => $siswa
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'unit_id'  => 'required|exists:units,id',
            'kelas_id' => 'required|exists:kelas,id',
            'siswa_id' => 'required|exists:siswas,id',
        ]);

        $rombel = Rombel::findOrFail($id);
        $rombel->update([
            'unit_id'  => $request->unit_id,
            'kelas_id' => $request->kelas_id,
            'siswa_id' => $request->siswa_id,
        ]);

        return redirect()->route('rombel.index')->with('success', 'Data rombel berhasil diperbarui.');
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

    /**
     * Import data rombel from Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new RombelImport, $request->file('file'));
            return redirect()->route('rombel.index')->with('success', 'Data rombel berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->route('rombel.index')->with('error', 'Terjadi kesalahan saat mengimport data: ' . $e->getMessage());
        }
    }
}
