<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 10px; 
            margin: 0;
            padding: 15px;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
        }
        .header h1 {
            color: #142143;
            font-size: 16px;
            margin: 0 0 8px 0;
        }
        .header h2 {
            color: #0072BC;
            font-size: 12px;
            margin: 0 0 10px 0;
        }
        .summary {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .summary h3 {
            color: #142143;
            font-size: 11px;
            margin: 0 0 8px 0;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }
        .summary-item {
            font-size: 9px;
        }
        .summary-label {
            font-weight: bold;
            color: #374151;
        }
        .summary-value {
            color: #1f2937;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 8px;
            font-size: 8px;
        }
        th, td { 
            border: 1px solid #d1d5db; 
            padding: 3px; 
            text-align: center;
        }
        th { 
            background: #3b82f6;
            color: white;
            font-weight: bold;
        }
        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 7px;
            color: #6b7280;
        }
        .no-data {
            text-align: center;
            padding: 30px;
            color: #6b7280;
            font-style: italic;
        }
        .obat-list {
            font-size: 7px;
            line-height: 1.2;
        }
        .obat-item {
            display: inline-block;
            background-color: #dbeafe;
            color: #1e40af;
            padding: 1px 4px;
            margin: 1px;
            border-radius: 2px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN KUNJUNGAN</h1>
        <h2>{{ $title }}</h2>
        <p style="font-size: 9px; color: #6b7280; margin: 0;">
            Digenerate pada: {{ \Carbon\Carbon::now()->format('d F Y H:i:s') }}
        </p>
    </div>

    <div class="summary">
        <h3>RINGKASAN:</h3>
        <div class="summary-row">
            <div class="summary-item">
                <span class="summary-label">Total Kunjungan:</span>
                <span class="summary-value">{{ number_format($totalKunjungan) }}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Siswa Unik:</span>
                <span class="summary-value">{{ number_format($totalSiswaUnik) }}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Total Obat Digunakan:</span>
                <span class="summary-value">{{ number_format($totalObatDigunakan) }}</span>
            </div>
        </div>
    </div>

    @if($reportData->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 4%;">No</th>
                    <th style="width: 8%;">Tanggal</th>
                    <th style="width: 15%;">Kelas/Unit</th>
                    <th style="width: 20%;">Nama Siswa</th>
                    <th style="width: 25%;">Diagnosa</th>
                    <th style="width: 28%;">Obat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportData as $index => $kunjungan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($kunjungan->tanggal)->format('d/m/Y') }}</td>
                    <td style="text-align: left;">
                        {{ optional(optional($kunjungan->rombel)->kelas)->kelas ?? '-' }} / 
                        {{ optional(optional($kunjungan->rombel)->unit)->unit ?? '-' }}
                    </td>
                    <td style="text-align: left;">{{ optional(optional($kunjungan->rombel)->siswa)->nama_siswa ?? '-' }}</td>
                    <td style="text-align: left;">{{ Str::limit($kunjungan->diagnosa ?? '-', 50) }}</td>
                    <td style="text-align: left;">
                        @if($kunjungan->obats && $kunjungan->obats->count() > 0)
                            <div class="obat-list">
                                @foreach($kunjungan->obats as $obat)
                                    <span class="obat-item">
                                        {{ $obat->nama_obat }} ({{ $obat->pivot->jumlah_obat ?? 0 }})
                                    </span>
                                @endforeach
                            </div>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            Tidak ada data tersedia untuk periode yang dipilih
        </div>
    @endif

    <div class="footer">
        <p>Sistem Manajemen Kunjungan - Halaman 1</p>
    </div>
</body>
</html>
