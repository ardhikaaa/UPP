<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Uks') }} - Detail Laporan Siswa</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Header tanpa sidebar -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <a href="{{ route('report.siswa') }}" 
                           class="mr-4 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </a>
                        <h2 class="font-bold text-2xl text-blue-800 leading-tight flex items-center">
                            <div class="bg-yellow-400 p-2 rounded-lg mr-3">
                                <svg class="w-6 h-6 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            {{ __('Detail Laporan Siswa') }}
                        </h2>
                    </div>
                    <!-- Export PDF Button -->
                    <div class="flex items-center space-x-2">
                        <button onclick="exportToPDF()" 
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Export PDF
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="py-6 bg-gradient-to-br from-blue-50 to-yellow-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Student Info Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-6">
                                <h3 class="text-2xl font-bold text-gray-900">{{ $siswa->nama_siswa }}</h3>
                                <div class="mt-2 flex flex-wrap gap-4">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        NIS: {{ $siswa->nis }}
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        Unit: {{ $siswa->rombel->unit->unit ?? '-' }}
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                        </svg>
                                        Kelas: {{ $siswa->rombel->kelas->kelas ?? '-' }}
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Jenis Kelamin: {{ ucfirst($siswa->jenis_kelamin) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Total Kunjungan
                                    </dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        {{ $totalKunjungan }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Total Obat Digunakan
                                    </dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        {{ $totalObatDigunakan }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Kunjungan Terakhir
                                    </dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        @if($kunjunganData->count() > 0)
                                            {{ \Carbon\Carbon::parse($kunjunganData->first()->tanggal)->format('d M Y') }}
                                        @else
                                            -
                                        @endif
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kunjungan History Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Riwayat Kunjungan ke UKS</h3>
                        <p class="text-sm text-gray-600">Detail lengkap kunjungan {{ $siswa->nama_siswa }} ke UKS</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Diagnosa
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pengecekan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Anamnesa
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tindakan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Obat
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Guru
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($kunjunganData as $index => $kunjungan)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($kunjungan->tanggal)->format('d M Y') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <div class="max-w-xs">
                                                <p class="truncate">{{ $kunjungan->diagnosa ?? '-' }}</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <div class="max-w-xs">
                                                <p class="truncate">{{ $kunjungan->pengecekan ?? '-' }}</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <div class="max-w-xs">
                                                <p class="truncate">{{ $kunjungan->anamnesa ?? '-' }}</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <div class="max-w-xs">
                                                <p class="truncate">{{ $kunjungan->tindakan ?? '-' }}</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            @if($kunjungan->obats->count() > 0)
                                                <div class="space-y-1">
                                                    @foreach($kunjungan->obats as $obat)
                                                        <div class="flex items-center">
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                {{ $obat->nama_obat }} ({{ $obat->pivot->jumlah_obat }})
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-gray-500">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $kunjungan->guru->nama ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            <div class="flex flex-col items-center justify-center py-8">
                                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                <p class="text-gray-500">Belum ada riwayat kunjungan ke UKS</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </main>
    </div>

    <script>
        function exportToPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('l', 'pt', 'a4'); // landscape, points, A4

            // Data siswa (dalam implementasi nyata, ambil dari variabel Blade)
            const studentName = '{{ $siswa->nama_siswa }}';
            const studentNIS = '{{ $siswa->nis }}';
            const studentUnit = '{{ $siswa->rombel->unit->unit ?? "-" }}';
            const studentClass = '{{ $siswa->rombel->kelas->kelas ?? "-" }}';
            const totalKunjungan = '{{ $totalKunjungan }}';
            const totalObat = '{{ $totalObatDigunakan }}';

            // Header
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(20);
            doc.setTextColor(20, 33, 67);
            doc.text('LAPORAN DETAIL SISWA', 420, 40, { align: 'center' });
            
            doc.setFontSize(14);
            doc.text('Riwayat Kunjungan ke UKS', 420, 65, { align: 'center' });

            // Tanggal generate
            const today = new Date().toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            doc.setFontSize(10);
            doc.setFont('helvetica', 'normal');
            doc.text(`Digenerate pada: ${today}`, 40, 90);

            // Info siswa
            doc.setFontSize(12);
            doc.setFont('helvetica', 'bold');
            doc.text('INFORMASI SISWA', 40, 115);
            
            doc.setFontSize(10);
            doc.setFont('helvetica', 'normal');
            doc.text(`Nama: ${studentName}`, 40, 135);
            doc.text(`NIS: ${studentNIS}`, 40, 150);
            doc.text(`Unit: ${studentUnit}`, 250, 135);
            doc.text(`Kelas: ${studentClass}`, 250, 150);
            
            // Summary
            doc.text(`Total Kunjungan: ${totalKunjungan}`, 450, 135);
            doc.text(`Total Obat Digunakan: ${totalObat}`, 450, 150);

            // Garis pemisah
            doc.setDrawColor(200, 200, 200);
            doc.setLineWidth(1);
            doc.line(40, 165, 800, 165);

            // Prepare table data
            const tableData = [];
            @if($kunjunganData->count() > 0)
                @foreach($kunjunganData as $index => $k)
                    tableData.push([
                        '{{ $index + 1 }}',
                        '{{ \Carbon\Carbon::parse($k->tanggal)->format('d/m/Y') }}',
                        `{{ str_replace(["\n", "\r", "|", '"'], [' ', ' ', ' ', "'"], $k->diagnosa ?? '-') }}`,
                        `{{ str_replace(["\n", "\r", "|", '"'], [' ', ' ', ' ', "'"], $k->pengecekan ?? '-') }}`,
                        `{{ str_replace(["\n", "\r", "|", '"'], [' ', ' ', ' ', "'"], $k->anamnesa ?? '-') }}`,
                        `{{ str_replace(["\n", "\r", "|", '"'], [' ', ' ', ' ', "'"], $k->tindakan ?? '-') }}`,
                        `@if($k->obats && $k->obats->count() > 0){{ $k->obats->map(fn($o) => $o->nama_obat.' ('.($o->pivot->jumlah_obat ?? 0).')')->implode(', ') }}@else-@endif`,
                        '{{ $k->guru->nama ?? '-' }}'
                    ]);
                @endforeach
            @else
                tableData.push(['', '', 'Tidak ada data kunjungan', '', '', '', '', '']);
            @endif

            // Create table
            doc.autoTable({
                startY: 180,
                head: [['No', 'Tanggal', 'Diagnosa', 'Pengecekan', 'Anamnesa', 'Tindakan', 'Obat', 'Guru']],
                body: tableData,
                theme: 'grid',
                headStyles: {
                    fillColor: [59, 130, 246],
                    textColor: [255, 255, 255],
                    fontSize: 9,
                    fontStyle: 'bold',
                    halign: 'center',
                    valign: 'middle',
                    lineWidth: 0.75,
                    lineColor: [180, 180, 180]
                },
                bodyStyles: {
                    fontSize: 8,
                    textColor: [20, 33, 67],
                    overflow: 'linebreak',
                    lineWidth: 0.5,
                    lineColor: [200, 200, 200],
                    valign: 'top'
                },
                alternateRowStyles: {
                    fillColor: [248, 250, 252]
                },
                columnStyles: {
                    0: { cellWidth: 25, halign: 'center' },    // No
                    1: { cellWidth: 65, halign: 'center' },    // Tanggal
                    2: { cellWidth: 90, halign: 'left' },      // Diagnosa
                    3: { cellWidth: 90, halign: 'left' },      // Pengecekan
                    4: { cellWidth: 90, halign: 'left' },      // Anamnesa
                    5: { cellWidth: 90, halign: 'left' },      // Tindakan
                    6: { cellWidth: 100, halign: 'left' },     // Obat
                    7: { cellWidth: 75, halign: 'left' }       // Guru
                },
                styles: {
                    cellPadding: { top: 4, right: 3, bottom: 4, left: 3 },
                    lineWidth: 0.5,
                    lineColor: [200, 200, 200],
                    overflow: 'linebreak',
                    cellWidth: 'wrap'
                },
                tableWidth: 'wrap',
                tableLineWidth: 0.75,
                tableLineColor: [180, 180, 180],
                margin: { left: 40, right: 40, top: 20, bottom: 50 },
                pageBreak: 'auto',
                rowPageBreak: 'avoid',
                showHead: 'everyPage'
            });

            // Add page numbers and footer
            const pageCount = doc.internal.getNumberOfPages();
            const pageHeight = doc.internal.pageSize.height;
            
            for (let i = 1; i <= pageCount; i++) {
                doc.setPage(i);
                
                // Footer
                doc.setFontSize(8);
                doc.setTextColor(100, 100, 100);
                doc.text(`Halaman ${i} dari ${pageCount}`, 420, pageHeight - 20, { align: 'center' });
                doc.text('Sistem Manajemen UKS', 40, pageHeight - 20);
                
                // Add border line for footer
                doc.setDrawColor(200, 200, 200);
                doc.setLineWidth(0.5);
                doc.line(40, pageHeight - 35, 800, pageHeight - 35);
            }

            // Generate filename
            const now = new Date();
            const dateString = now.toLocaleDateString('id-ID').replace(/\//g, '-');
            const fileName = `Detail_Siswa_${studentName.replace(/\s+/g, '_')}_${dateString}.pdf`;
            
            // Save the PDF
            doc.save(fileName);
            
            // Show success message
            alert(`PDF berhasil diexport: ${fileName}`);
        }
    </script>
</body>
</html>