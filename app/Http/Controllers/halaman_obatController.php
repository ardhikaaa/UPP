<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\ObatHistory;
use Illuminate\Http\Request;

class halaman_obatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Obat::query();
        
        // Tambahkan search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama_obat', 'like', '%' . $searchTerm . '%')
                  ->orWhere('jumlah', 'like', '%' . $searchTerm . '%');
            });
        }
        
        $obat = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Append search parameter to pagination links
        $obat->appends($request->query());
        
        return view('obat', compact('obat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('obat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'jumlah'    => 'required|integer|max:255',
        ]);

        $obat = Obat::create($request->all());

        // Catat history stok masuk
        ObatHistory::create([
        'obat_id'   => $obat->id,
        'jumlah'    => $request->jumlah,
        'tipe'      => 'masuk',
        'tanggal'   => now(),
        'keterangan'=> 'Stok awal obat ditambahkan',
        ]);

        return redirect()->route('obat.index')->with('success', 'Data obat berhasil ditambahkan.');
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
        $obat = Obat::findOrFail($id);
        return view('obat.edit', compact('obat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       $request->validate([
            'nama_obat' => 'required|string|max:255',
            'jumlah'    => 'required|integer|max:255',
        ]);

        $obat = Obat::findOrFail($id);

         // Hitung selisih stok lama & baru
        $selisih = $request->jumlah - $obat->jumlah;

        // update data obat
        $obat->update($request->all());

        // Kalau ada perubahan stok, simpan history
        if ($selisih != 0) {
            ObatHistory::create([
                'obat_id'   => $obat->id,
                'jumlah'    => abs($selisih),
                'tipe'      => $selisih > 0 ? 'masuk' : 'keluar',
                'tanggal'   => now(),
                'keterangan'=> 'Perubahan stok melalui update data obat',
            ]);
        }

        return redirect()->route('obat.index')->with('success', 'Data obat berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Obat::findOrFail($id);
        $delete->delete();
        return redirect()->route('obat.index')->with('success', 'Data obat berhasil dihapus.');
    }
}
