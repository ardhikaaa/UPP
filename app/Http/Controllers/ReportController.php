<?php

namespace App\Http\Controllers;

use App\Models\ObatHistory;
use App\Models\Kunjungan;
use App\Models\Siswa;
use App\Models\Rombel;
use App\Models\Unit;
use App\Models\Guru;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $unitId = $request->unit_id; // optional

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

        // Filter per Unit (melalui relasi rombel)
        $selectedUnitName = null;
        if (!empty($unitId)) {
            $query->whereHas('rombel', function($q) use ($unitId) {
                $q->where('unit_id', $unitId);
            });

            // Tambahkan label unit pada judul jika valid
            $unit = Unit::find($unitId);
            if ($unit) {
                $selectedUnitName = $unit->unit;
                $title .= " - Unit " . $selectedUnitName;
            }
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
            'totalSiswaUnik',
            'unitId'
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

    public function guru(Request $request)
    {
        // Ambil semua guru dan deduplikasi berdasarkan kombinasi nama + mapel
        // Gunakan join ke units agar pencarian by unit dapat dilakukan
        $query = Guru::query()
            ->leftJoin('units', 'units.id', '=', 'gurus.unit_id')
            ->select(
                'gurus.nama',
                'gurus.mapel',
                'gurus.unit_id',
                DB::raw('MAX(units.unit) as unit_name')
            )
            ->groupBy('gurus.nama', 'gurus.mapel', 'gurus.unit_id');

        // Search berdasarkan nama, mapel, dan unit
        if ($request->filled('search')) {
            $searchTerm = $request->get('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('gurus.nama', 'like', '%' . $searchTerm . '%')
                    ->orWhere('gurus.mapel', 'like', '%' . $searchTerm . '%')
                    ->orWhere('units.unit', 'like', '%' . $searchTerm . '%');
            });
        }

        // Clone untuk summary
        $summaryQuery = clone $query;

        // Data utama dengan pagination (50 per halaman)
        $guruData = (clone $query)
            ->orderBy('gurus.nama', 'asc')
            ->orderBy('unit_name', 'asc')
            ->paginate(50)
            ->withQueryString();

        // Summary (seluruh data hasil filter)
        // Untuk query dengan groupBy, gunakan get()->count() agar menghitung jumlah grup
        $totalGuru = (clone $summaryQuery)->get()->count();
        $allGuruForSummary = (clone $summaryQuery)->get();
        $totalUnitTerdaftar = $allGuruForSummary->pluck('unit_name')->filter()->unique()->count();

        return view('report.guru', compact('guruData', 'totalGuru', 'totalUnitTerdaftar'));
    }

    public function guruDetail(Request $request, $nama, $mapel, $unitId)
    {
        // Normalisasi parameter
        $nama = urldecode($nama);
        $mapel = urldecode($mapel);
        $unitId = (int) $unitId;

        // Ambil data guru referensi
        $guruRef = Guru::with('unit')
            ->where('nama', $nama)
            ->where('mapel', $mapel)
            ->where('unit_id', $unitId)
            ->first();

        // Ambil semua kunjungan yang di-handle guru tsb (soft-deleted disertakan)
        $kunjunganData = Kunjungan::withTrashed()
            ->with(['rombel.siswa'])
            ->where('guru_id', optional($guruRef)->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        // Hitung jumlah siswa unik yang izin (berdasarkan rombel->siswa)
        $totalSiswaIzin = $kunjunganData->pluck('rombel.siswa.id')->filter()->unique()->count();

        return view('report.guru-detail', [
            'guru' => $guruRef,
            'kunjunganData' => $kunjunganData,
            'totalSiswaIzin' => $totalSiswaIzin,
        ]);
    }

    public function guruDetailExportPdf(Request $request, $nama, $mapel, $unitId)
    {
        $nama = urldecode($nama);
        $mapel = urldecode($mapel);
        $unitId = (int) $unitId;

        $guruRef = Guru::with('unit')
            ->where('nama', $nama)
            ->where('mapel', $mapel)
            ->where('unit_id', $unitId)
            ->first();

        $kunjunganData = Kunjungan::withTrashed()
            ->with(['rombel.siswa', 'rombel.kelas', 'rombel.unit'])
            ->where('guru_id', optional($guruRef)->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        $totalSiswaIzin = $kunjunganData->pluck('rombel.siswa.id')->filter()->unique()->count();

        $pdf = Pdf::loadView('report.pdf.guru-detail', [
            'guru' => $guruRef,
            'kunjunganData' => $kunjunganData,
            'totalSiswaIzin' => $totalSiswaIzin,
            'generatedAt' => now(),
        ])->setPaper('a4', 'portrait');

        $safeNama = preg_replace('/[^A-Za-z0-9_-]+/', '-', $nama);
        $safeMapel = preg_replace('/[^A-Za-z0-9_-]+/', '-', $mapel ?? 'mapel');
        $fileName = "laporan-guru-{$safeNama}-{$safeMapel}-unit{$unitId}-" . now()->format('Ymd_His') . ".pdf";

        return $pdf->download($fileName);
    }
}