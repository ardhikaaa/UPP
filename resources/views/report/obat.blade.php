<x-app-layout>
     <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-[#142143] leading-tight">
                {{ __('Laporan Obat') }}
            </h2>
        </div>
    </x-slot>

    <div class="container">
    <h2>Laporan Obat</h2>
    <form method="GET" action="{{ route('report.obat') }}">
        <label>Tanggal:</label>
        <input type="date" name="tanggal" value="{{ $tanggal }}">
        
        <label>Bulan:</label>
        <input type="number" name="bulan" value="{{ $bulan }}" min="1" max="12">

        <label>Tahun:</label>
        <input type="number" name="tahun" value="{{ $tahun }}" min="2000" max="2100">

        <button type="submit">Filter</button>
    </form>


    <h4>📅 Report Harian ({{ $tanggal }})</h4>
    <table class="w-full text-sm text-left text-[#142143]">
                <thead class="text-xs uppercase bg-[#0072BC] text-white">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-medium text-center">Nama Obat</th>
                        <th scope="col" class="px-6 py-4 font-medium text-center">Jumlah</th>
                        <th scope="col" class="px-6 py-4 font-medium text-center">Tipe</th>
                        <th scope="col" class="px-6 py-4 font-medium text-center">Tanggal</th>
                        <th scope="col" class="px-6 py-4 font-medium text-center">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#142143]/20">
                    @forelse ($reportBulanan as $history)
                    <tr class="hover:bg-[#142143]/5 transition duration-200">
                        <td class="px-6 py-4 font-medium text-[#142143] text-center">{{ $history->obat->nama_obat }}</td>
                        <td class="px-6 py-4 font-medium text-[#142143] text-center">{{ $history->jumlah }}</td>
                        <td class="px-6 py-4 font-medium text-[#142143] text-center">{{ ucfirst($history->tipe) }}</td>
                        <td class="px-6 py-4 font-medium text-[#142143] text-center">{{ $history->tanggal }}</td>
                        <td class="px-6 py-4 font-medium text-[#142143] text-center">{{ $history->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                <tr><td colspan="5">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
</div>
</x-app-layout>