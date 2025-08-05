<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $units = Unit::all();
    return view('unit', compact('units'));
}



    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('unit.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $request->validate([
            'unit' => 'required|string|max:255',
        ]);

        Unit::create($request->all());
        return redirect()->route('unit.index')->with('success', 'Data unit berhasil ditambahkan.');
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
    public function edit(Unit $unit)
    {
        return view('unit.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'unit' => 'required|string|max:255',
        ]);

        $unit->update($request->all());
        return redirect()->route('unit.index')->with('success', 'Data unit berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('unit.index')->with('success', 'Data unit berhasil dihapus.');
    }
}
