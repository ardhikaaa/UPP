<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa = Siswa::all(); // Ambil semua data siswa
        return view('siswa', compact('siswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'nis'               => 'required|string|max:255|unique:siswas,nis',
        'nama_siswa'        => 'required|string|max:255',
        'jenis_kelamin'     => 'required|string|in:Laki-laki,Perempuan',
        'no_telp_siswa'     => 'required|string|max:15',
        'no_telp_ortu'      => 'required|string|max:15',
    ]);

    Siswa::create([
        'nis'                => $request->nis,
        'nama_siswa'         => $request->nama_siswa,
        'jenis_kelamin'      => $request->jenis_kelamin,
        'no_telp_siswa'      => $request->no_telp_siswa,
        'no_telp_ortu'       => $request->no_telp_ortu,
    ]);

    return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
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
            'nis'               => 'required|string|max:255|unique:siswas,nis,' . $id,
            'nama_siswa'        => 'required|string|max:255',
            'jenis_kelamin'     => 'required|string|in:Laki-laki,Perempuan',
            'no_telp_siswa'     => 'required|string|max:15',
            'no_telp_ortu'      => 'required|string|max:15',
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update([
            'nis'                => $request->nis,
            'nama_siswa'         => $request->nama_siswa,
            'jenis_kelamin'      => $request->jenis_kelamin,
            'no_telp_siswa'      => $request->no_telp_siswa,
            'no_telp_ortu'       => $request->no_telp_ortu,
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Siswa::findOrFail($id);
        $delete->delete();
        return redirect('siswa');
    }
}
