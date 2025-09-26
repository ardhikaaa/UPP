<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Detail Guru</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
        .title { font-size: 18px; font-weight: bold; }
        .meta { font-size: 12px; color: #555; }
        .summary { display: flex; gap: 16px; margin-bottom: 16px; }
        .card { border: 1px solid #ddd; padding: 10px 12px; border-radius: 6px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f3f3f3; text-align: left; }
    </style>
    </head>
<body>
    <div class="header">
        <div class="title">Laporan Detail Guru</div>
        <div class="meta">Dibuat: {{ \Carbon\Carbon::parse($generatedAt)->format('d M Y H:i') }}</div>
    </div>

    <div class="summary">
        <div class="card">
            <div>Nama Guru</div>
            <div><strong>{{ $guru->nama ?? '-' }}</strong></div>
        </div>
        <div class="card">
            <div>Mapel</div>
            <div><strong>{{ $guru->mapel ?? '-' }}</strong></div>
        </div>
        <div class="card">
            <div>Unit</div>
            <div><strong>{{ optional($guru->unit)->unit ?? '-' }}</strong></div>
        </div>
        <div class="card">
            <div>Total Siswa Izin</div>
            <div><strong>{{ $totalSiswaIzin }}</strong></div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Siswa</th>
                <th>Kelas</th>
                <th>Unit</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kunjunganData as $kunjungan)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($kunjungan->tanggal)->format('d M Y') }}</td>
                    <td>{{ optional($kunjungan->rombel->siswa)->nama_siswa ?? '-' }}</td>
                    <td>{{ optional($kunjungan->rombel->kelas)->kelas ?? '-' }}</td>
                    <td>{{ optional($kunjungan->rombel->unit)->unit ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center; color:#777;">Belum ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>

