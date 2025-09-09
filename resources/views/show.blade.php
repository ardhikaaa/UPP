<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-[#142143] leading-tight">
                {{ __('Kunjungan UKS') }}
            </h2>
            <button data-modal-target="tambah-kunjungan-modal" data-modal-toggle="tambah-kunjungan-modal" 
                    class="inline-flex items-center px-4 py-2 bg-[#0072BC] hover:bg-[#142143] focus:ring-4 focus:ring-[#1a5d94]/30 text-white text-sm font-medium rounded-lg transition duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Data Kunjungan
            </button>
        </div>
    </x-slot>
     <div class="py-8">
        <div class="max-w-4xl mx-auto bg-white shadow rounded-lg p-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold text-gray-600">Unit</h3>
                    <p class="text-[#142143]">{{ $kunjungan->rombel->unit->unit }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-600">Kelas</h3>
                    <p class="text-[#142143]">{{ $kunjungan->rombel->kelas->kelas }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-600">Nama Siswa</h3>
                    <p class="text-[#142143]">{{ $kunjungan->rombel->siswa->nama_siswa }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-600">Guru</h3>
                    <p class="text-[#142143]">{{ $kunjungan->guru->nama }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-600">Pengecekan</h3>
                    <p class="text-[#142143]">{{ $kunjungan->pengecekan }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-600">Anamnesa</h3>
                    <p class="text-[#142143]">{{ $kunjungan->anamnesa }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-600">Diagnosa</h3>
                    <p class="text-[#142143]">{{ $kunjungan->diagnosa }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-600">Tindakan</h3>
                    <p class="text-[#142143]">{{ $kunjungan->tindakan }}</p>
                </div>

                <div class="col-span-2">
                    <h3 class="font-semibold text-gray-600">Obat</h3>
                    @if($kunjungan->obats && $kunjungan->obats->count() > 0)
                        <ul class="list-disc list-inside text-[#142143]">
                            @foreach($kunjungan->obats as $obatItem)
                                <li>{{ $obatItem->nama_obat }} ({{ $obatItem->pivot->jumlah_obat }})</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">N/A</p>
                    @endif
                </div>

                <div class="col-span-2">
                    <h3 class="font-semibold text-gray-600">Tanggal</h3>
                    <p class="text-[#142143]">
                        {{ \Carbon\Carbon::parse($kunjungan->tanggal)->translatedFormat('l, d F Y') }}
                    </p>
                </div>
            </div>

            <div class="mt-8 flex justify-between">
                <a href="{{ route('kunjungan_uks') }}" 
                   class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                   ← Kembali
                </a>
            </div>
        </div>
    </div>
</x-app-layout>