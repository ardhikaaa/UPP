<?php

namespace App\Http\Controllers;

use App\Models\ObatHistory;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function obat(Request $request)
    {
        // Ambil filter dari request
        $tanggal = $request->tanggal ?? now()->toDateString();
        $bulan   = $request->bulan ?? now()->month;
        $tahun   = $request->tahun ?? now()->year;

        // Report harian
        $reportHarian = ObatHistory::with('obat')
            ->whereDate('tanggal', $tanggal)
            ->get();

        // Report bulanan
        $reportBulanan = ObatHistory::with('obat')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        return view('report.obat', compact('reportHarian', 'reportBulanan', 'tanggal', 'bulan', 'tahun'));
    }


    public function kunjungan(Request $request)
    {

        return view('report.kunjungan');
    }

    public function siswa(Request $request)
    {

        return view('report.siswa');
    }
}
