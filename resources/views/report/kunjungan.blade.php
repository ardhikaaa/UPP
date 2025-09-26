<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-blue-800 leading-tight flex items-center">
                <div class="bg-yellow-400 p-2 rounded-lg mr-3">
                    <svg class="w-6 h-6 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                {{ __('Laporan Kunjungan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 bg-gradient-to-br from-blue-50 to-yellow-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Form -->
            <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                <form method="GET" action="{{ route('report.kunjungan') }}">
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
                        <div class="col-span-1">
                            <label for="unit_id" class="block text-sm font-medium text-[#142143] mb-2">
                                Unit
                            </label>
                            <select name="unit_id" id="unit_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0072BC] focus:ring-[#0072BC]">
                                <option value="">Semua Unit</option>
                                @php
                                    $units = \App\Models\Unit::orderBy('unit')->get();
                                @endphp
                                @foreach($units as $u)
                                    <option value="{{ $u->id }}" {{ ($unitId ?? '') == $u->id ? 'selected' : '' }}>{{ $u->unit }}</option>
                                @endforeach
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
                            <a href="{{ route('report.kunjungan') }}" 
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
                <div class="bg-white shadow-xl rounded-2xl border border-blue-200 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-3 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-blue-600 mb-1">{{ $totalKunjungan }}</div>
                                <div class="text-sm font-semibold text-gray-600">Total Kunjungan</div>
                            </div>
                        </div>
                        @if($filterType == 'semua')
                            <div class="bg-blue-50 text-blue-700 text-xs font-medium px-3 py-2 rounded-lg text-center border border-blue-200">
                                📋 Semua waktu
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="bg-white shadow-xl rounded-2xl border border-green-200 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-gradient-to-r from-green-500 to-green-600 p-3 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-green-600 mb-1">{{ $totalSiswaUnik }}</div>
                                <div class="text-sm font-semibold text-gray-600">Siswa Unik</div>
                            </div>
                        </div>
                        @if($filterType == 'semua')
                            <div class="bg-green-50 text-green-700 text-xs font-medium px-3 py-2 rounded-lg text-center border border-green-200">
                                📋 Semua waktu
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="bg-white shadow-xl rounded-2xl border border-indigo-200 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 p-3 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-indigo-600 mb-1">{{ $totalObatDigunakan }}</div>
                                <div class="text-sm font-semibold text-gray-600">Total Obat Digunakan</div>
                            </div>
                        </div>
                        @if($filterType == 'semua')
                            <div class="bg-indigo-50 text-indigo-700 text-xs font-medium px-3 py-2 rounded-lg text-center border border-indigo-200">
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-blue-800">{{ $title }}</h3>
                        </div>
                        <div class="flex items-end gap-2">
                            @if($reportData->count() > 0)
                            <div class="flex space-x-3">
                                <button onclick="exportToPDF()" 
                                        class="bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-yellow-300 shadow-lg flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span>This Page</span>
                                </button>
                            </div>
                            @endif
                            <a href="{{ route('report.kunjungan.export.pdf', request()->query()) }}" 
                                class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-green-300 shadow-lg flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span>All Data</span>
                            </a>
                        </div>
                    </div>

                    @if($reportData->count() > 0)
                        <div class="overflow-x-auto rounded-xl border border-blue-200">
                            <table class="w-full text-sm text-blue-800" id="kunjunganTable">
                                <thead class="bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-bold text-center">No</th>
                                    <th scope="col" class="px-6 py-4 font-bold text-center">Tanggal</th>
                                    <th scope="col" class="px-6 py-4 font-bold text-center">Kelas/Unit</th>
                                    <th scope="col" class="px-6 py-4 font-bold text-center">Nama Siswa</th>
                                    {{-- <th scope="col" class="px-6 py-4 font-bold text-center">Guru</th> --}}
                                    {{-- <th scope="col" class="px-6 py-4 font-bold text-center">Anamnesa</th> --}}
                                    <th scope="col" class="px-6 py-4 font-bold text-center">Diagnosa</th>
                                    {{-- <th scope="col" class="px-6 py-4 font-bold text-center">Tindakan</th> --}}
                                    <th scope="col" class="px-6 py-4 font-bold text-center">Obat</th>
                                </tr>
                            </thead>
                                <tbody class="bg-white">
                                @forelse($reportData as $index => $kunjungan)
                                    <tr class="border-b border-blue-100 hover:bg-gradient-to-r hover:from-blue-50 hover:to-yellow-50 transition-all duration-300">
                                        <td class="px-6 py-4 font-semibold text-blue-800 text-center">
                                            <div class="bg-blue-100 w-8 h-8 rounded-full flex items-center justify-center mx-auto">
                                                {{ ($reportData->firstItem() ?? 0) + $index }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-blue-800 text-center">
                                            <div class="bg-blue-50 px-3 py-2 rounded-lg border border-blue-200">
                                                {{ \Carbon\Carbon::parse($kunjungan->tanggal)->format('d/m/Y') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-medium text-blue-800 text-center">
                                            <div class="bg-gray-50 px-3 py-2 rounded-lg">
                                                {{ optional(optional($kunjungan->rombel)->kelas)->kelas ?? '-' }} / {{ optional(optional($kunjungan->rombel)->unit)->unit ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-medium text-blue-800 text-center">
                                            <div class="bg-gray-50 px-3 py-2 rounded-lg">
                                                {{ optional(optional($kunjungan->rombel)->siswa)->nama_siswa ?? '-' }}
                                            </div>
                                        </td>
                                        {{-- <td class="px-6 py-4 font-medium text-blue-800 text-center">
                                            <div class="bg-gray-50 px-3 py-2 rounded-lg">
                                                {{ optional($kunjungan->guru)->nama ?? '-' }}
                                            </div>
                                        </td> --}}
                                        {{-- <td class="px-6 py-4 text-blue-800 text-center">
                                            <div class="bg-gray-50 px-3 py-2 rounded-lg max-w-xs mx-auto">
                                                {{ Str::limit($kunjungan->anamnesa ?? '-', 50) }}
                                            </div>
                                        </td> --}}
                                        <td class="px-6 py-4 text-blue-800 text-center">
                                            <div class="bg-gray-50 px-3 py-2 rounded-lg max-w-xs mx-auto">
                                                {{ Str::limit($kunjungan->diagnosa ?? '-', 50) }}
                                            </div>
                                        </td>
        
                                        {{-- <td class="px-6 py-4 text-blue-800 text-center">
                                            <div class="bg-gray-50 px-3 py-2 rounded-lg max-w-xs mx-auto">
                                                {{ Str::limit($kunjungan->tindakan ?? '-', 50) }}
                                            </div>
                                        </td> --}}
                                        <td class="px-6 py-4 text-blue-800 text-center">
                                            @if($kunjungan->obats && $kunjungan->obats->count() > 0)
                                                <div class="space-y-1">
                                                    @foreach($kunjungan->obats as $obat)
                                                        <div class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded inline-block">
                                                        {{ $obat->nama_obat }} ({{ $obat->pivot->jumlah_obat ?? 0 }})
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                -
                                            @endif
                                        </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-6 py-12 text-center">
                                            <div class="bg-yellow-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                                                <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                                </svg>
                                            </div>
                                            <div class="text-blue-700 font-bold text-lg mb-2">Tidak ada data tersedia</div>
                                            <div class="text-blue-600">Tidak ada data untuk periode yang dipilih</div>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
    <script>
        function toggleFilterInputs() {
            const filterType = document.getElementById('filter_type').value;
            const tanggalInput = document.getElementById('tanggal-input');
            const bulanInput = document.getElementById('bulan-input');
            const tahunInput = document.getElementById('tahun-input');
            
            tanggalInput.style.display = 'none';
            bulanInput.style.display = 'none';
            tahunInput.style.display = 'none';
            
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

        document.addEventListener('DOMContentLoaded', function() {
            toggleFilterInputs();
        });

        function exportToPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('l', 'pt', 'a4'); // landscape, points, A4

    // Header
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(18);
    doc.setTextColor(20, 33, 67);
    doc.text('LAPORAN KUNJUNGAN', 420, 40, { align: 'center' });
    
    doc.setFontSize(12);
    doc.text('{{ $title }}', 420, 60, { align: 'center' });

    // Tanggal generate
    const today = new Date().toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
    doc.setFontSize(10);
    doc.setFont('helvetica', 'normal');
    doc.text(`Digenerate pada: ${today}`, 40, 85);

    // Improved Summary Cards - Layout seperti gambar
    const cardWidth = 220;
    const cardHeight = 60;
    const cardSpacing = 20;
    const startX = 60; // Centered positioning for 3 cards
    const startY = 105;

    // Card background color and border
    const cardBgColor = [248, 250, 252]; // Light gray background
    const borderColor = [226, 232, 240]; // Light border
    const headerBgColor = [241, 245, 249]; // Slightly darker header

    // Card 1: Total Kunjungan
    doc.setFillColor(...cardBgColor);
    doc.setDrawColor(...borderColor);
    doc.setLineWidth(1);
    doc.rect(startX, startY, cardWidth, cardHeight, 'FD');
    
    // Card header
    doc.setFillColor(...headerBgColor);
    doc.rect(startX, startY, cardWidth, 20, 'F');
    doc.setDrawColor(...borderColor);
    doc.line(startX, startY + 20, startX + cardWidth, startY + 20);
    
    // Card 1 content
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(11);
    doc.setTextColor(71, 85, 105);
    doc.text('Total Kunjungan:', startX + 10, startY + 15);
    
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(18);
    doc.setTextColor(20, 33, 67);
    doc.text('{{ number_format($totalKunjungan) }}', startX + 10, startY + 45);

    // Card 2: Siswa Unik
    const card2X = startX + cardWidth + cardSpacing;
    doc.setFillColor(...cardBgColor);
    doc.setDrawColor(...borderColor);
    doc.setLineWidth(1);
    doc.rect(card2X, startY, cardWidth, cardHeight, 'FD');
    
    // Card header
    doc.setFillColor(...headerBgColor);
    doc.rect(card2X, startY, cardWidth, 20, 'F');
    doc.setDrawColor(...borderColor);
    doc.line(card2X, startY + 20, card2X + cardWidth, startY + 20);
    
    // Card 2 content
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(11);
    doc.setTextColor(71, 85, 105);
    doc.text('Siswa Unik:', card2X + 10, startY + 15);
    
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(18);
    doc.setTextColor(20, 33, 67);
    doc.text('{{ number_format($totalSiswaUnik) }}', card2X + 10, startY + 45);

    // Card 3: Total Obat Digunakan
    const card3X = card2X + cardWidth + cardSpacing;
    doc.setFillColor(...cardBgColor);
    doc.setDrawColor(...borderColor);
    doc.setLineWidth(1);
    doc.rect(card3X, startY, cardWidth, cardHeight, 'FD');
    
    // Card header
    doc.setFillColor(...headerBgColor);
    doc.rect(card3X, startY, cardWidth, 20, 'F');
    doc.setDrawColor(...borderColor);
    doc.line(card3X, startY + 20, card3X + cardWidth, startY + 20);
    
    // Card 3 content
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(11);
    doc.setTextColor(71, 85, 105);
    doc.text('Total Obat Digunakan:', card3X + 10, startY + 15);
    
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(18);
    doc.setTextColor(20, 33, 67);
    doc.text('{{ number_format($totalObatDigunakan) }}', card3X + 10, startY + 45);

    // Prepare table data
    const tableData = [];
    @if($reportData->count() > 0)
        @foreach($reportData as $index => $k)
            tableData.push([
                '{{ ($reportData->firstItem() ?? 0) + $index }}',
                '{{ \Carbon\Carbon::parse($k->tanggal)->format('d/m/Y') }}',
                '{{ optional(optional($k->rombel)->kelas)->kelas ?? '-' }} / {{ optional(optional($k->rombel)->unit)->unit ?? '-' }}',
                '{{ optional(optional($k->rombel)->siswa)->nama_siswa ?? '-' }}',
                `{{ str_replace(["\n", "\r", "|", '"'], [' ', ' ', ' ', "'"] , $k->diagnosa ?? '-') }}`,
                `@if($k->obats && $k->obats->count() > 0){{ $k->obats->map(fn($o) => $o->nama_obat.' ('.($o->pivot->jumlah_obat ?? 0).')')->implode(', ') }}@else-@endif`
            ]);
        @endforeach
    @else
        tableData.push(['', '', 'Tidak ada data', '', '', '']);
    @endif

    // Create table - adjusted startY to accommodate new card layout
    doc.autoTable({
        startY: startY + cardHeight + 30, // Increased spacing after cards
        head: [['No', 'Tanggal', 'Kelas/Unit', 'Nama Siswa', 'Diagnosa', 'Obat']],
        body: tableData,
        theme: 'grid',
        headStyles: {
            fillColor: [59, 130, 246],
            textColor: [255, 255, 255],
            fontSize: 10,
            fontStyle: 'bold',
            halign: 'center',
            valign: 'middle',
            lineWidth: 0.75,
            lineColor: [180, 180, 180]
        },
        bodyStyles: {
            fontSize: 9,
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
            0: { cellWidth: 30, halign: 'center' },     // No
            1: { cellWidth: 75, halign: 'center' },     // Tanggal
            2: { cellWidth: 120, halign: 'left' },      // Kelas/Unit
            3: { cellWidth: 150, halign: 'left' },      // Nama Siswa
            4: { cellWidth: 200, halign: 'left' },      // Diagnosa
            5: { cellWidth: 160, halign: 'left' }       // Obat
        },
        tableWidth: 'wrap',
        styles: {
            cellPadding: { top: 5, right: 5, bottom: 5, left: 5 },
            lineWidth: 0.5,
            lineColor: [200, 200, 200],
            overflow: 'linebreak',
            cellWidth: 'wrap'
        },
        tableLineWidth: 0.75,
        tableLineColor: [180, 180, 180],
        margin: { left: 30, right: 30, top: 20, bottom: 50 },
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
        doc.text('Sistem Manajemen Kunjungan', 30, pageHeight - 20);
        
        // Add border line for footer
        doc.setDrawColor(200, 200, 200);
        doc.setLineWidth(0.5);
        doc.line(30, pageHeight - 35, 810, pageHeight - 35);
    }

    // Generate filename with proper formatting
    const now = new Date();
    const dateString = now.toLocaleDateString('id-ID').replace(/\//g, '-');
    const fileName = `Laporan_Kunjungan_${dateString}.pdf`;
    
    // Save the PDF
    doc.save(fileName);
    
    // Optional: Show success message
    console.log(`PDF berhasil diexport: ${fileName}`);
}
    </script>
</x-app-layout>