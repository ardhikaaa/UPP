<?php

namespace App\Http\Controllers;

use App\Models\kunjungan_uks;
use Illuminate\Http\Request;

class kunjungan_uksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = kunjungan_uks::latest()->get();
        return view('kunjungan_uks.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kunjungan_uks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required',
            'kelas' => 'required',
            'diagnosa' => 'required',
            'obat' => 'required',
            'tanggal' => 'required|date',
            'guru' => 'required',
            'jumlah_obat' => 'required|integer',
            'status' => 'required'
        ]);

        kunjungan_uks::create($request->all());

        return redirect()->route('kunjungan_uks.index')->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = kunjungan_uks::findOrFail($id);
        return view('kunjungan_uks.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = kunjungan_uks::findOrFail($id);
        return view('kunjungan_uks.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_siswa' => 'required',
            'kelas' => 'required',
            'diagnosa' => 'required',
            'obat' => 'required',
            'tanggal' => 'required|date',
            'guru' => 'required',
            'jumlah_obat' => 'required|integer',
            'status' => 'required'
        ]);

        $data = kunjungan_uks::findOrFail($id);
        $data->update($request->all());

        return redirect()->route('kunjungan_uks.index')->with('success', 'Data berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = kunjungan_uks::findOrFail($id);
        $data->delete();

        return redirect()->route('kunjungan_uks.index')->with('success', 'Data berhasil dihapus.');
    }
}
