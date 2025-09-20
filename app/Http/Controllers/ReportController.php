<?php

namespace App\Http\Controllers;

use App\Models\ObatHistory;
use App\Models\Kunjungan;
use App\Models\Siswa;
use App\Models\Rombel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function obat(Request $request)
    {
        // Ambil filter dari request
        $filterType = $request->filter_type ?? 'semua';
        $tanggal = $request->tanggal ?? now()->toDateString();
        $bulan = $request->bulan ?? now()->month;
        
        // Validasi tahun dengan range yang lebih fleksibel
        $tahun = $request->tahun ?? now()->year;
        $tahun = max(2000, min(2100, (int)$tahun)); // Pastikan tahun dalam range 2000-2100

        $query = ObatHistory::with('obat');

        // Filter berdasarkan tipe
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

        // Simpan base query untuk perhitungan summary (tanpa pagination)
        $summaryQuery = clone $query;

        // Data utama dengan pagination (50 per halaman)
        $reportData = (clone $query)
            ->orderBy('created_at', 'desc')
            ->paginate(50)
            ->withQueryString();

        // Hitung summary berdasarkan seluruh data hasil filter (bukan hanya halaman ini)
        $totalMasuk = (clone $summaryQuery)->where('tipe', 'masuk')->sum('jumlah');
        $totalKeluar = (clone $summaryQuery)->where('tipe', 'keluar')->sum('jumlah');
        $totalTransaksi = (clone $summaryQuery)->count();

        return view('report.obat', compact(
            'reportData', 
            'filterType', 
            'tanggal', 
            'bulan', 
            'tahun', 
            'title',
            'totalMasuk',
            'totalKeluar',
            'totalTransaksi'
        ));
    }


    public function kunjungan(Request $request)
    {
        // Ambil filter dari request
        $filterType = $request->filter_type ?? 'semua';
        $tanggal = $request->tanggal ?? now()->toDateString();
        $bulan = $request->bulan ?? now()->month;

        // Validasi tahun
        $tahun = $request->tahun ?? now()->year;
        $tahun = max(2000, min(2100, (int) $tahun));

        $query = Kunjungan::withTrashed()->with(['rombel.unit', 'rombel.kelas', 'rombel.siswa', 'obats', 'guru']);

        // Filter berdasarkan tipe
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

        // Clone untuk summary (tanpa pagination)
        $summaryQuery = clone $query;

        // Data utama dengan pagination (50 per halaman)
        $reportData = (clone $query)
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Summary berdasarkan seluruh data hasil filter
        $allForSummary = (clone $summaryQuery)
            ->with(['rombel.siswa', 'obats'])
            ->get();

        $totalKunjungan = $allForSummary->count();
        $totalObatDigunakan = $allForSummary->reduce(function ($carry, $kunjungan) {
            return $carry + $kunjungan->obats->sum(function ($obat) {
                return (int) ($obat->pivot->jumlah_obat ?? 0);
            });
        }, 0);
        $totalSiswaUnik = $allForSummary->map(function ($k) {
            return optional(optional($k->rombel)->siswa)->id;
        })->filter()->unique()->count();

        return view('report.kunjungan', compact(
            'reportData',
            'filterType',
            'tanggal',
            'bulan',
            'tahun',
            'title',
            'totalKunjungan',
            'totalObatDigunakan',
            'totalSiswaUnik'
        ));
    }

    public function siswa(Request $request)
    {
        // Ambil semua siswa dengan relasi rombel, kelas, dan unit
        $query = Siswa::with(['rombel.kelas', 'rombel.unit'])
            ->whereHas('rombel'); // Hanya siswa yang memiliki rombel

        // Search sederhana berdasarkan nama, NIS, unit, dan kelas
        if ($request->filled('search')) {
            $searchTerm = $request->get('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_siswa', 'like', '%' . $searchTerm . '%')
                    ->orWhere('nis', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('rombel.unit', function ($sub) use ($searchTerm) {
                        $sub->where('unit', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('rombel.kelas', function ($sub) use ($searchTerm) {
                        $sub->where('kelas', 'like', '%' . $searchTerm . '%');
                    });
            });
        }

        // Clone untuk summary
        $summaryQuery = clone $query;

        // Data utama dengan pagination (50 per halaman)
        $siswaData = (clone $query)
            ->orderBy('nama_siswa', 'asc')
            ->paginate(50)
            ->withQueryString();

        // Summary (seluruh data hasil filter)
        $totalSiswa = (clone $summaryQuery)->count();
        $allSiswaForSummary = (clone $summaryQuery)
            ->with(['rombel.unit', 'rombel.kelas'])
            ->get();
        $totalUnitTerdaftar = $allSiswaForSummary->pluck('rombel.unit.unit')->filter()->unique()->count();
        $totalKelasTerdaftar = $allSiswaForSummary->pluck('rombel.kelas.kelas')->filter()->unique()->count();

        return view('report.siswa', compact('siswaData', 'totalSiswa', 'totalUnitTerdaftar', 'totalKelasTerdaftar'));
    }

    public function siswaDetail(Request $request, $siswaId)
    {
        // Ambil data siswa dengan relasi lengkap
        $siswa = Siswa::with(['rombel.kelas', 'rombel.unit'])
            ->findOrFail($siswaId);

        // Ambil semua kunjungan siswa dengan relasi obat dan guru
        $kunjunganData = Kunjungan::withTrashed()
            ->with(['obats', 'guru'])
            ->whereHas('rombel', function($query) use ($siswaId) {
                $query->where('siswa_id', $siswaId);
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        // Hitung statistik
        $totalKunjungan = $kunjunganData->count();
        $totalObatDigunakan = $kunjunganData->reduce(function ($carry, $kunjungan) {
            return $carry + $kunjungan->obats->sum(function ($obat) {
                return (int) ($obat->pivot->jumlah_obat ?? 0);
            });
        }, 0);

        return view('report.siswa-detail', compact('siswa', 'kunjunganData', 'totalKunjungan', 'totalObatDigunakan'));
    }
}