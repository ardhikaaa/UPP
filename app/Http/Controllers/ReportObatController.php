<?php

namespace App\Http\Controllers;

use App\Models\ObatHistory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportObatController extends Controller
{
    public function exportPdf(Request $request)
    {
        // Ambil filter dari request (sama seperti di ReportController)
        $filterType = $request->filter_type ?? 'semua';
        $tanggal = $request->tanggal ?? now()->toDateString();
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;
        $tahun = max(2000, min(2100, (int)$tahun));

        $query = ObatHistory::with('obat');

        // Filter berdasarkan tipe (sama seperti di ReportController)
        switch ($filterType) {
            case 'harian':
                $query->whereDate('tanggal', $tanggal);
                $title = "Laporan Harian - " . \Carbon\Carbon::parse($tanggal)->format('d F Y');
                break;
            case 'bulanan':
                $query->whereMonth('tanggal', $bulan)
                      ->whereYear('tanggal', $tahun);
                $title = "Laporan Bulanan - " . \Carbon\Carbon::create($tahun, $bulan)->format('F Y');
                break;
            case 'tahunan':
                $query->whereYear('tanggal', $tahun);
                $title = "Laporan Tahunan - " . $tahun;
                break;
            case 'semua':
            default:
                $title = "Laporan Semua Data History Obat";
                break;
        }

        // Ambil semua data history obat (tanpa pagination)
        $reportData = $query->orderBy('created_at', 'desc')->get();

        // Hitung summary
        $totalMasuk = $reportData->where('tipe', 'masuk')->sum('jumlah');
        $totalKeluar = $reportData->where('tipe', 'keluar')->sum('jumlah');
        $totalTransaksi = $reportData->count();

        // Data untuk PDF
        $data = [
            'reportData' => $reportData,
            'title' => $title,
            'totalMasuk' => $totalMasuk,
            'totalKeluar' => $totalKeluar,
            'totalTransaksi' => $totalTransaksi,
            'filterType' => $filterType
        ];

        // Load view PDF
        $pdf = Pdf::loadView('report.obatpdf', $data)
            ->setPaper('a4', 'portrait');

        // Generate filename berdasarkan filter
        $filename = 'Laporan_Obat_' . str_replace(' ', '_', $title) . '_' . date('d-m-Y') . '.pdf';
        
        return $pdf->download($filename);
    }
}
