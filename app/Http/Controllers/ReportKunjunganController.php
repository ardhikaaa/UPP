<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportKunjunganController extends Controller
{
    public function exportPdf(Request $request)
    {
        // Ambil filter dari request (sama seperti di ReportController)
        $filterType = $request->filter_type ?? 'semua';
        $tanggal = $request->tanggal ?? now()->toDateString();
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;
        $tahun = max(2000, min(2100, (int)$tahun));

        $query = Kunjungan::withTrashed()->with(['rombel.unit', 'rombel.kelas', 'rombel.siswa', 'obats', 'guru']);

        // Filter berdasarkan tipe (sama seperti di ReportController)
        switch ($filterType) {
            case 'harian':
                $query->whereDate('tanggal', $tanggal);
                $title = "Laporan Kunjungan Harian - " . \Carbon\Carbon::parse($tanggal)->format('d F Y');
                break;
            case 'bulanan':
                $query->whereMonth('tanggal', $bulan)
                      ->whereYear('tanggal', $tahun);
                $title = "Laporan Kunjungan Bulanan - " . \Carbon\Carbon::create($tahun, $bulan)->format('F Y');
                break;
            case 'tahunan':
                $query->whereYear('tanggal', $tahun);
                $title = "Laporan Kunjungan Tahunan - " . $tahun;
                break;
            case 'semua':
            default:
                $title = "Laporan Semua Data Kunjungan";
                break;
        }

        // Ambil semua data kunjungan (tanpa pagination)
        $reportData = $query->orderBy('created_at', 'desc')->get();

        // Hitung summary (sama seperti di ReportController)
        $totalKunjungan = $reportData->count();
        $totalObatDigunakan = $reportData->reduce(function ($carry, $kunjungan) {
            return $carry + $kunjungan->obats->sum(function ($obat) {
                return (int) ($obat->pivot->jumlah_obat ?? 0);
            });
        }, 0);
        $totalSiswaUnik = $reportData->map(function ($k) {
            return optional(optional($k->rombel)->siswa)->id;
        })->filter()->unique()->count();

        // Data untuk PDF
        $data = [
            'reportData' => $reportData,
            'title' => $title,
            'totalKunjungan' => $totalKunjungan,
            'totalObatDigunakan' => $totalObatDigunakan,
            'totalSiswaUnik' => $totalSiswaUnik,
            'filterType' => $filterType
        ];

        // Load view PDF
        $pdf = Pdf::loadView('report.kunjunganpdf', $data)
            ->setPaper('a4', 'landscape'); // Landscape karena data kunjungan lebih lebar

        // Generate filename berdasarkan filter
        $filename = 'Laporan_Kunjungan_' . str_replace(' ', '_', $title) . '_' . date('d-m-Y') . '.pdf';
        
        return $pdf->download($filename);
    }
}
