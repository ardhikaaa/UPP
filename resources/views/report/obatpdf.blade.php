<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 11px; 
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #142143;
            font-size: 18px;
            margin: 0 0 10px 0;
        }
        .header h2 {
            color: #0072BC;
            font-size: 14px;
            margin: 0 0 15px 0;
        }
        .summary {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .summary h3 {
            color: #142143;
            font-size: 12px;
            margin: 0 0 10px 0;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .summary-item {
            font-size: 10px;
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
            margin-top: 10px;
            font-size: 9px;
        }
        th, td { 
            border: 1px solid #d1d5db; 
            padding: 4px; 
            text-align: center;
        }
        th { 
            background: #3b82f6;
            color: white;
            font-weight: bold;
        }
        .tipe-masuk {
            background-color: #dcfce7;
            color: #166534;
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 3px;
        }
        .tipe-keluar {
            background-color: #fef2f2;
            color: #dc2626;
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 3px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 8px;
            color: #6b7280;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #6b7280;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN OBAT</h1>
        <h2>{{ $title }}</h2>
        <p style="font-size: 10px; color: #6b7280; margin: 0;">
            Digenerate pada: {{ \Carbon\Carbon::now()->format('d F Y H:i:s') }}
        </p>
    </div>

    <div class="summary">
        <h3>RINGKASAN:</h3>
        <div class="summary-row">
            <div class="summary-item">
                <span class="summary-label">Obat Masuk:</span>
                <span class="summary-value">{{ number_format($totalMasuk) }}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Obat Keluar:</span>
                <span class="summary-value">{{ number_format($totalKeluar) }}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Total Transaksi:</span>
                <span class="summary-value">{{ number_format($totalTransaksi) }}</span>
            </div>
        </div>
    </div>

    @if($reportData->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Nama Obat</th>
                    <th style="width: 10%;">Jumlah</th>
                    <th style="width: 10%;">Tipe</th>
                    <th style="width: 15%;">Tanggal</th>
                    <th style="width: 35%;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportData as $index => $history)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="text-align: left;">{{ $history->obat->nama_obat }}</td>
                    <td>{{ number_format($history->jumlah) }}</td>
                    <td>
                        @if($history->tipe == 'masuk')
                            <span class="tipe-masuk">MASUK</span>
                        @else
                            <span class="tipe-keluar">KELUAR</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($history->tanggal)->format('d/m/Y') }}</td>
                    <td style="text-align: left;">{{ $history->keterangan ?? '-' }}</td>
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
        <p>Sistem Manajemen Obat - Halaman 1</p>
    </div>
</body>
</html>
