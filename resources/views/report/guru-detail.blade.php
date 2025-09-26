<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-blue-800 leading-tight flex items-center">
                <div class="bg-yellow-400 p-2 rounded-lg mr-3">
                    <svg class="w-6 h-6 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                {{ __('Detail Guru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 bg-gradient-to-br from-blue-50 to-yellow-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-sm text-gray-500">Nama Guru</div>
                        <div class="text-lg font-semibold">{{ $guru->nama ?? '-' }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-sm text-gray-500">Mapel</div>
                        <div class="text-lg font-semibold">{{ $guru->mapel ?? '-' }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-sm text-gray-500">Unit</div>
                        <div class="text-lg font-semibold">{{ optional($guru->unit)->unit ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm text-gray-500">Total Siswa Izin di Jam Pelajaran</div>
                            <div class="text-2xl font-bold text-blue-700">{{ $totalSiswaIzin }}</div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('report.guru.detail.export.pdf', ['nama' => urlencode($guru->nama ?? ''), 'mapel' => urlencode($guru->mapel ?? ''), 'unitId' => $guru->unit_id ?? 0]) }}" class="px-4 py-2 text-sm rounded-md bg-blue-600 text-white hover:bg-blue-700">Export PDF</a>
                            <a href="{{ route('report.guru') }}" class="px-4 py-2 text-sm rounded-md bg-gray-100 hover:bg-gray-200">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Riwayat Kunjungan Siswa</h3>
                        <p class="text-sm text-gray-600">Berikut daftar siswa yang izin saat pelajaran guru ini.</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($kunjunganData as $kunjungan)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($kunjungan->tanggal)->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ optional($kunjungan->rombel->siswa)->nama_siswa ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ optional($kunjungan->rombel->kelas)->kelas ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ optional($kunjungan->rombel->unit)->unit ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Belum ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

