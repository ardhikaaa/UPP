<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-blue-800 leading-tight flex items-center">
                <div class="bg-yellow-400 p-2 rounded-lg mr-3">
                    <svg class="w-6 h-6 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                {{ __('Laporan Obat') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 bg-gradient-to-br from-blue-50 to-yellow-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Form -->
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                        <form method="GET" action="{{ route('report.obat') }}">
                            <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-6 gap-4">
                                <div class="col-span-1">
                                    <label for="filter_type" class="block text-sm font-medium text-[#142143] mb-2">
                                        Tipe Filter
                                    </label>
                                    <select name="filter_type" id="filter_type" 
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0072BC] focus:ring-[#0072BC]" 
                                            onchange="toggleFilterInputs()">
                                        <option value="semua" {{ ($filterType ?? 'semua') == 'semua' ? 'selected' : '' }}>Semua Data</option>
                                        <option value="harian" {{ ($filterType ?? '') == 'harian' ? 'selected' : '' }}>Harian</option>
                                        <option value="bulanan" {{ ($filterType ?? '') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                                        <option value="tahunan" {{ ($filterType ?? '') == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                                    </select>
                                </div>
                                
                                <div class="col-span-1" id="tanggal-input" style="{{ ($filterType ?? '') == 'harian' ? '' : 'display: none;' }}">
                                    <label for="tanggal" class="block text-sm font-medium text-[#142143] mb-2">
                                        Tanggal
                                    </label>
                                    <input type="date" name="tanggal" id="tanggal" 
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0072BC] focus:ring-[#0072BC]" 
                                           value="{{ $tanggal ?? now()->toDateString() }}">
                                </div>
                                
                                <div class="col-span-1" id="bulan-input" style="{{ ($filterType ?? '') == 'bulanan' ? '' : 'display: none;' }}">
                                    <label for="bulan" class="block text-sm font-medium text-[#142143] mb-2">
                                        Bulan
                                    </label>
                                    <select name="bulan" id="bulan" 
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0072BC] focus:ring-[#0072BC]">
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ ($bulan ?? now()->month) == $i ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                
                                <div class="col-span-1" id="tahun-input" style="{{ in_array($filterType ?? '', ['bulanan', 'tahunan']) ? '' : 'display: none;' }}">
                                    <label for="tahun" class="block text-sm font-medium text-[#142143] mb-2">
                                        Tahun
                                    </label>
                                    <input type="number" name="tahun" id="tahun" 
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0072BC] focus:ring-[#0072BC]" 
                                           value="{{ $tahun ?? now()->year }}" min="2000" max="2100">
                                </div>
                                
                                <div class="col-span-1 lg:col-span-2 flex items-end space-x-2">
                                    <button type="submit" 
                                            class="bg-[#0072BC] hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition duration-200">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                        </svg>
                                        Filter
                                    </button>
                                    <a href="{{ route('report.obat') }}" 
                                       class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-md transition duration-200">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                        Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white shadow-xl rounded-2xl border border-green-200 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-gradient-to-r from-green-500 to-green-600 p-3 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-green-600 mb-1">{{ $totalMasuk }}</div>
                                <div class="text-sm font-semibold text-gray-600">Obat Masuk</div>
                            </div>
                        </div>
                        @if($filterType == 'semua')
                            <div class="bg-green-50 text-green-700 text-xs font-medium px-3 py-2 rounded-lg text-center border border-green-200">
                                📋 Semua waktu
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="bg-white shadow-xl rounded-2xl border border-red-200 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-gradient-to-r from-red-500 to-red-600 p-3 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-red-600 mb-1">{{ $totalKeluar }}</div>
                                <div class="text-sm font-semibold text-gray-600">Obat Keluar</div>
                            </div>
                        </div>
                        @if($filterType == 'semua')
                            <div class="bg-red-50 text-red-700 text-xs font-medium px-3 py-2 rounded-lg text-center border border-red-200">
                                📋 Semua waktu
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="bg-white shadow-xl rounded-2xl border border-blue-200 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-3 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-blue-600 mb-1">{{ $totalTransaksi }}</div>
                                <div class="text-sm font-semibold text-gray-600">Total Transaksi</div>
                            </div>
                        </div>
                        @if($filterType == 'semua')
                            <div class="bg-blue-50 text-blue-700 text-xs font-medium px-3 py-2 rounded-lg text-center border border-blue-200">
                                📋 Semua waktu
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Report Table -->
            <div class="bg-white shadow-xl rounded-2xl border border-yellow-200">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <div class="bg-yellow-400 p-3 rounded-xl mr-4">
                                <svg class="w-6 h-6 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2-2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-blue-800">{{ $title }}</h3>
                        </div>
                        
                        @if($reportData->count() > 0)
                        <div class="flex space-x-3">
                            <button onclick="exportToPDF()" 
                                    class="bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-yellow-300 shadow-lg flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span>Export PDF</span>
                            </button>
                        </div>
                        @endif
                    </div>
                    
                    @if($reportData->count() > 0)
                        <div class="overflow-x-auto rounded-xl border border-blue-200">
                            <table class="w-full text-sm text-blue-800">
                                <thead class="bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 font-bold text-center">No</th>
                                        <th scope="col" class="px-6 py-4 font-bold text-center">Nama Obat</th>
                                        <th scope="col" class="px-6 py-4 font-bold text-center">Jumlah</th>
                                        <th scope="col" class="px-6 py-4 font-bold text-center">Tipe</th>
                                        <th scope="col" class="px-6 py-4 font-bold text-center">Tanggal</th>
                                        <th scope="col" class="px-6 py-4 font-bold text-center">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach($reportData as $index => $history)
                                    <tr class="border-b border-blue-100 hover:bg-gradient-to-r hover:from-blue-50 hover:to-yellow-50 transition-all duration-300">
                                        <td class="px-6 py-4 font-semibold text-blue-800 text-center">
                                            <div class="bg-blue-100 w-8 h-8 rounded-full flex items-center justify-center mx-auto">
                                                {{ ($reportData->firstItem() ?? 0) + $index }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-blue-800 text-center">{{ $history->obat->nama_obat }}</td>
                                        <td class="px-6 py-4 font-bold text-blue-800 text-center">
                                            <div class="bg-yellow-100 px-3 py-1 rounded-full inline-block">
                                                {{ $history->jumlah }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-center">
                                            <span class="px-4 py-2 text-sm font-bold rounded-full shadow-sm {{ $history->tipe == 'masuk' ? 'bg-gradient-to-r from-green-400 to-green-500 text-white' : 'bg-gradient-to-r from-red-400 to-red-500 text-white' }}">
                                                {{ ucfirst($history->tipe) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-blue-800 text-center">
                                            <div class="bg-blue-50 px-3 py-2 rounded-lg border border-blue-200">
                                                {{ \Carbon\Carbon::parse($history->tanggal)->format('d/m/Y') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-medium text-blue-800 text-center">
                                            <div class="bg-gray-50 px-3 py-2 rounded-lg">
                                                {{ $history->keterangan ?? '-' }}
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination (match kunjungan_uks UI) -->
                        <div class="mt-6 px-6 py-4 border-t border-[#142143]/20">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-[#142143]">
                                    Menampilkan
                                    <span class="font-medium">{{ $reportData->firstItem() ?? 0 }}</span>
                                    sampai
                                    <span class="font-medium">{{ $reportData->lastItem() ?? 0 }}</span>
                                    dari
                                    <span class="font-medium">{{ $reportData->total() }}</span> hasil
                                </div>

                                <div class="flex items-center space-x-2">
                                    <a href="{{ $reportData->previousPageUrl() ?? '#' }}"
                                       class="px-3 py-1 text-sm rounded-lg transition duration-200 {{ $reportData->onFirstPage() ? 'bg-[#e4e4e4] text-gray-400 cursor-not-allowed' : 'bg-[#e4e4e4] hover:bg-[#142143]/10 text-[#142143]' }}">
                                        Sebelumnya
                                    </a>

                                    @php
                                        $start = max(1, $reportData->currentPage() - 2);
                                        $end = min($reportData->lastPage(), $reportData->currentPage() + 2);
                                    @endphp

                                    @for ($i = $start; $i <= $end; $i++)
                                        <a href="{{ $reportData->url($i) }}"
                                           class="px-3 py-1 text-sm rounded-lg transition duration-200 {{ $reportData->currentPage() == $i ? 'bg-[#0072BC] text-white' : 'bg-[#e4e4e4] hover:bg-[#142143]/10 text-[#142143]' }}">
                                            {{ $i }}
                                        </a>
                                    @endfor

                                    <a href="{{ $reportData->nextPageUrl() ?? '#' }}"
                                       class="px-3 py-1 text-sm rounded-lg transition duration-200 {{ $reportData->hasMorePages() ? 'bg-[#e4e4e4] hover:bg-[#142143]/10 text-[#142143]' : 'bg-[#e4e4e4] text-gray-400 cursor-not-allowed' }}">
                                        Selanjutnya
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="bg-yellow-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                            </div>
                            <div class="text-blue-700 font-bold text-lg mb-2">Tidak ada data tersedia</div>
                            <div class="text-blue-600">Tidak ada data untuk periode yang dipilih</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk toggle input berdasarkan filter type -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
    <script>
         function toggleFilterInputs() {
            const filterType = document.getElementById('filter_type').value;
            const tanggalInput = document.getElementById('tanggal-input');
            const bulanInput = document.getElementById('bulan-input');
            const tahunInput = document.getElementById('tahun-input');
            
            // Hide all inputs first
            tanggalInput.style.display = 'none';
            bulanInput.style.display = 'none';
            tahunInput.style.display = 'none';
            
            // Show relevant inputs
            switch(filterType) {
                case 'harian':
                    tanggalInput.style.display = 'block';
                    break;
                case 'bulanan':
                    bulanInput.style.display = 'block';
                    tahunInput.style.display = 'block';
                    break;
                case 'tahunan':
                    tahunInput.style.display = 'block';
                    break;
            }
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            toggleFilterInputs(); // Set initial state
        });

        // Function untuk export PDF
        function exportToPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Konfigurasi font dan warna
            doc.setFont("helvetica", "bold");
            doc.setFontSize(18);
            doc.setTextColor(20, 33, 67); // Blue color

            // Header
            doc.text('LAPORAN OBAT', 105, 20, null, null, 'center');
            doc.setFontSize(12);
            doc.text('{{ $title }}', 105, 30, null, null, 'center');
            
            // Tanggal generate
            const today = new Date().toLocaleDateString('id-ID');
            doc.setFontSize(10);
            doc.setFont("helvetica", "normal");
            doc.text(`Digenerate pada: ${today}`, 20, 45);

            // Summary Box
            doc.setFillColor(240, 248, 255); // Light blue background
            doc.rect(20, 55, 170, 30, 'F');
            doc.setDrawColor(59, 130, 246); // Blue border
            doc.rect(20, 55, 170, 30, 'S');
            
            doc.setFont("helvetica", "bold");
            doc.setFontSize(11);
            doc.setTextColor(20, 33, 67);
            doc.text('RINGKASAN:', 25, 65);
            
            doc.setFont("helvetica", "normal");
            doc.setFontSize(10);
            doc.text(`Obat Masuk: {{ $totalMasuk }}`, 25, 73);
            doc.text(`Obat Keluar: {{ $totalKeluar }}`, 85, 73);
            doc.text(`Total Transaksi: {{ $totalTransaksi }}`, 145, 73);

            // Prepare table data
            const tableData = [];
            @if($reportData->count() > 0)
                @foreach($reportData as $index => $history)
                    tableData.push([
                        '{{ ($reportData->firstItem() ?? 0) + $index }}',
                        '{{ $history->obat->nama_obat }}',
                        '{{ $history->jumlah }}',
                        '{{ ucfirst($history->tipe) }}',
                        '{{ \Carbon\Carbon::parse($history->tanggal)->format('d/m/Y') }}',
                        '{{ $history->keterangan ?? '-' }}'
                    ]);
                @endforeach
            @endif

            // Table
            doc.autoTable({
                startY: 95,
                head: [['No', 'Nama Obat', 'Jumlah', 'Tipe', 'Tanggal', 'Keterangan']],
                body: tableData,
                theme: 'striped',
                headStyles: {
                    fillColor: [59, 130, 246], // Blue
                    textColor: [255, 255, 255], // White
                    fontSize: 10,
                    fontStyle: 'bold',
                    halign: 'center'
                },
                bodyStyles: {
                    fontSize: 9,
                    halign: 'center',
                    textColor: [20, 33, 67]
                },
                alternateRowStyles: {
                    fillColor: [248, 250, 252] // Light gray
                },
                columnStyles: {
                    0: { cellWidth: 15 }, // No
                    1: { cellWidth: 50, halign: 'left' }, // Nama Obat
                    2: { cellWidth: 20 }, // Jumlah
                    3: { cellWidth: 20 }, // Tipe
                    4: { cellWidth: 25 }, // Tanggal
                    5: { cellWidth: 40, halign: 'left' } // Keterangan
                },
                margin: { left: 20, right: 20 },
                didDrawCell: function(data) {
                    // Highlight tipe masuk/keluar dengan warna
                    if (data.column.index === 3 && data.cell.section === 'body') {
                        const tipe = data.cell.text[0];
                        if (tipe === 'Masuk') {
                            doc.setFillColor(34, 197, 94); // Green
                        } else if (tipe === 'Keluar') {
                            doc.setFillColor(239, 68, 68); // Red
                        }
                        doc.rect(data.cell.x, data.cell.y, data.cell.width, data.cell.height, 'F');
                        doc.setTextColor(255, 255, 255);
                        doc.text(tipe, data.cell.x + data.cell.width/2, data.cell.y + data.cell.height/2 + 2, {align: 'center'});
                    }
                }
            });

            // Footer
            const pageCount = doc.internal.getNumberOfPages();
            for (let i = 1; i <= pageCount; i++) {
                doc.setPage(i);
                doc.setFontSize(8);
                doc.setTextColor(100, 100, 100);
                doc.text(`Halaman ${i} dari ${pageCount}`, 105, 290, null, null, 'center');
                doc.text('Sistem Manajemen Obat', 20, 290);
            }

            // Save PDF
            const fileName = `Laporan_Obat_${new Date().getTime()}.pdf`;
            doc.save(fileName);

            // Show success notification
            showNotification('PDF berhasil diexport!', 'success');
        }

        // Function untuk show notification
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-xl shadow-lg transform transition-all duration-500 translate-x-full`;
            
            if (type === 'success') {
                notification.className += ' bg-green-500 text-white';
                notification.innerHTML = `
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>${message}</span>
                    </div>
                `;
            }
            
            document.body.appendChild(notification);
            
            // Show notification
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            // Hide notification after 3 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 500);
            }, 3000);
        }
    </script>

    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        .shake {
            animation: shake 0.5s ease-in-out;
        }
    </style>
</x-app-layout>