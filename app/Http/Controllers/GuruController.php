<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Unit;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Guru::with(['unit']);
        
        // Tambahkan search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama', 'like', '%' . $searchTerm . '%')
                  ->orWhere('mapel', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('unit', function($subQuery) use ($searchTerm) {
                      $subQuery->where('unit', 'like', '%' . $searchTerm . '%');
                  });
            });
        }
        
        $gurus = $query->orderBy('created_at', 'desc')->paginate(5);
        
        // Append search parameter to pagination links
        $gurus->appends($request->query());

        $units = Unit::all();
        return view('guru', compact('gurus', 'units'));
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
            'unit_id' => 'required|exists:units,id',
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
            'unit_id' => 'required|exists:units,id',
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
