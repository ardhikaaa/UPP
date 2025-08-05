<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $gurus = Guru::all();
    return view('guru', compact('gurus'));
}



    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('guru.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'mapel' => 'required|string|max:255',
        ]);

        Guru::create($request->all());
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan.');
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
    public function edit(Guru $guru)
    {
        return view('guru.edit', compact('guru'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'mapel' => 'required|string|max:255',
        ]);

        $guru->update($request->all());
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guru $guru)
    {
        $guru->delete();
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
