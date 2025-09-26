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

    <div class="bg-[#e4e4e4] shadow-sm rounded-lg overflow-hidden">
        <!-- Search Section -->
        <div class="p-6 border-b border-[#142143]/20">
            <form method="GET" action="{{ route('kunjungan.index') }}" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-[#142143]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa, diagnosa, obat, dll..." 
                               class="block w-full pl-10 pr-3 py-2 border border-[#142143]/30 rounded-lg leading-5 bg-white text-[#142143] placeholder-[#142143]/60 focus:outline-none focus:ring-1 focus:ring-[#1a5d94] focus:border-[#1a5d94]"
                               autocomplete="off">
                    </div>
                </div>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('kunjungan.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto">
            @if (session('success'))
                <div id="success-alert" class="relative p-4 mb-4 text-sm text-[#142143] bg-[#ffaf00]/20 rounded-lg flex justify-between items-start">
                    <div>
                        {{ session('success') }} 
                    </div>
                    <button type="button" onclick="document.getElementById('success-alert').remove()" class="ml-4 text-[#142143] hover:text-red-500 rounded focus:outline-none">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div id="error-alert" class="relative p-4 mb-4 text-sm text-white bg-red-500 rounded-lg flex justify-between items-start">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ session('error') }}
                    </div>
                    <button type="button" onclick="document.getElementById('error-alert').remove()" class="ml-4 text-white hover:text-gray-200 rounded focus:outline-none">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div id="validation-error-alert" class="relative p-4 mb-4 text-sm text-white bg-red-500 rounded-lg">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <strong>Terjadi kesalahan:</strong>
                    </div>
                    <ul class="list-disc list-inside ml-7">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" onclick="document.getElementById('validation-error-alert').remove()" class="absolute top-2 right-2 text-white hover:text-gray-200 rounded focus:outline-none">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif

            @if($kunjungan->count() > 0)
                <table class="w-full text-sm text-left text-[#142143]" id="Table">
                    <thead class="text-xs uppercase bg-[#0072BC] text-white">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-medium text-center">No</th>
                            <th scope="col" class="px-6 py-4 font-medium text-center">Unit/Kelas</th>
                            <th scope="col" class="px-6 py-4 font-medium text-center">Nama Siswa</th>
                            {{-- <th scope="col" class="px-6 py-4 font-medium text-center">Pengecekan</th>
                            <th scope="col" class="px-6 py-4 font-medium text-center">Anamnesa</th> --}}
                            <th scope="col" class="px-6 py-4 font-medium text-center">Diagnosa</th>
                            {{-- <th scope="col" class="px-6 py-4 font-medium text-center">Tindakan</th> --}}
                            <th scope="col" class="px-6 py-4 font-medium text-center">Obat</th>
                            {{-- <th scope="col" class="px-6 py-4 font-medium text-center">Guru</th> --}}
                            <th scope="col" class="px-6 py-4 font-medium text-center">Tanggal</th>
                            <th scope="col" class="px-6 py-4 font-medium text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#142143]/20" id="#Table">
                        @foreach ($kunjungan as $item)
                        <tr class="hover:bg-[#142143]/5 transition duration-200">
                            <td class="px-6 py-4 font-medium text-[#142143]">{{ $kunjungan->firstItem() + $loop->index }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-[#142143]">{{ $item->rombel->unit->unit }}</div>
                            <div class="text-sm text-gray-500">{{ $item->rombel->kelas->kelas }}</div>
                            </td>
                            <td class="px-6 py-4 font-medium text-[#142143] text-center">{{ $item->rombel->siswa->nama_siswa }}</td>
                            {{-- <td class="px-6 py-4 font-medium text-[#142143] text-center">{{ $item->pengecekan }}</td>
                            <td class="px-6 py-4 font-medium text-[#142143] text-center">{{ $item->anamnesa }}</td> --}}
                            <td class="px-6 py-4 font-medium text-[#142143] text-center">{{ $item->diagnosa }}</td>
                            {{-- <td class="px-6 py-4 font-medium text-[#142143] text-center">{{ $item->tindakan }}</td> --}}
                            <td class="px-6 py-4 font-medium text-[#142143] text-center">
                                @if($item->obats && $item->obats->count() > 0)
                                    @foreach($item->obats as $obatItem)
                                        <div class="text-sm">{{ $obatItem->nama_obat }} ({{ $obatItem->pivot->jumlah_obat }})</div>
                                    @endforeach
                                @else
                                    N/A
                                @endif
                            </td>
                            {{-- <td class="px-6 py-4 font-medium text-[#142143] text-center">{{ $item->guru->nama }}</td> --}}
                            <td class="px-6 py-4 font-medium text-[#142143] text-center">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}</td>
                            <td class="px-6 py-4 flex justify-center">
                                <a href="{{route('kunjungan.show', $item->id)}}">
                                    <button data-modal-target="show-kunjungan-modal" data-modal-toggle="show-kunjungan-modal"
                                        class="text-[#0072BC] hover:text-[#142143] p-1 rounded-lg hover:bg-[#0072BC]/10 transition duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </a>
                                <button 
                                    class="text-[#0072BC] hover:text-[#142143] p-1 rounded-lg hover:bg-[#1a5d94]/10 transition duration-200 btn-edit-obat"
                                    data-id         ="{{ $item->id }}"
                                    data-unit-id    ="{{ $item->rombel->unit->id }}"
                                    data-kelas-id   ="{{ $item->rombel->kelas->id }}"
                                    data-siswa-id   ="{{ $item->rombel->siswa->id }}"
                                    data-pengecekan ="{{ $item->pengecekan }}"
                                    data-anamnesa   ="{{ $item->anamnesa }}"
                                    data-diagnosa   ="{{ $item->diagnosa }}"
                                    data-tindakan   ="{{ $item->tindakan }}"
                                    data-obat-ids   ="{{ $item->obats ? $item->obats->pluck('id')->implode(',') : '' }}"
                                    data-obat-names ="{{ $item->obats ? $item->obats->pluck('nama_obat')->implode(',') : '' }}"
                                    data-jumlahs    ="{{ $item->obats ? $item->obats->pluck('pivot.jumlah_obat')->implode(',') : '' }}"
                                    data-guru-id    ="{{ $item->guru->id }}"
                                    data-tanggal    ="{{ $item->tanggal }}"
                                    data-modal-target="edit-kunjungan-modal" data-modal-toggle="edit-kunjungan-modal"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <form action="{{ route('kunjungan.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-[#ffaf00] hover:text-[#142143] p-1 rounded-lg hover:bg-[#ffaf00]/10 transition duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-[#142143]">Tidak ada data kunjungan</h3>
                    @if(request('search'))
                        <p class="mt-1 text-sm text-gray-500">Tidak ditemukan hasil untuk pencarian "<span class="font-medium">{{ request('search') }}</span>"</p>
                        <div class="mt-6">
                            <a href="{{ route('kunjungan.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#0072BC] hover:bg-[#142143] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0072BC]">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Reset Pencarian
                            </a>
                        </div>
                    @else
                        <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan data kunjungan baru.</p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-[#142143]/20">
            <div class="flex items-center justify-between">
                <div class="text-sm text-[#142143]">
                    @if(request('search'))
                        Menampilkan
                        <span class="font-medium">{{ $kunjungan->firstItem() ?? 0 }}</span>
                        sampai
                        <span class="font-medium">{{ $kunjungan->lastItem() ?? 0 }}</span>
                        dari
                        <span class="font-medium">{{ $kunjungan->total() }}</span> hasil pencarian untuk "<span class="font-medium text-[#0072BC]">{{ request('search') }}</span>"
                    @else
                        Menampilkan
                        <span class="font-medium">{{ $kunjungan->firstItem() ?? 0 }}</span>
                        sampai
                        <span class="font-medium">{{ $kunjungan->lastItem() ?? 0 }}</span>
                        dari
                        <span class="font-medium">{{ $kunjungan->total() }}</span> hasil
                    @endif
                </div>

                <div class="flex items-center space-x-2">
                    {{-- Tombol Sebelumnya --}}
                    <a href="{{ $kunjungan->previousPageUrl() ?? '#' }}"
                    class="px-3 py-1 text-sm rounded-lg transition duration-200
                            {{ $kunjungan->onFirstPage() 
                                ? 'bg-[#e4e4e4] text-gray-400 cursor-not-allowed' 
                                : 'bg-[#e4e4e4] hover:bg-[#142143]/10 text-[#142143]' }}">
                        Sebelumnya
                    </a>

                    {{-- Nomor halaman --}}
                    @php
                        $start = max(1, $kunjungan->currentPage() - 2);
                        $end = min($kunjungan->lastPage(), $kunjungan->currentPage() + 2);
                    @endphp

                    @for ($i = $start; $i <= $end; $i++)
                        <a href="{{ $kunjungan->url($i) }}"
                        class="px-3 py-1 text-sm rounded-lg transition duration-200
                                {{ $kunjungan->currentPage() == $i 
                                    ? 'bg-[#0072BC] text-white' 
                                    : 'bg-[#e4e4e4] hover:bg-[#142143]/10 text-[#142143]' }}">
                            {{ $i }}
                        </a>
                    @endfor

                    {{-- Tombol Selanjutnya --}}
                    <a href="{{ $kunjungan->nextPageUrl() ?? '#' }}"
                    class="px-3 py-1 text-sm rounded-lg transition duration-200
                            {{ $kunjungan->hasMorePages() 
                                ? 'bg-[#e4e4e4] hover:bg-[#142143]/10 text-[#142143]' 
                                : 'bg-[#e4e4e4] text-gray-400 cursor-not-allowed' }}">
                        Selanjutnya
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</x-app-layout>

    <!-- Modal Tambah Kunjungan -->
    <div id="tambah-kunjungan-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-[#e4e4e4] rounded-lg shadow-sm">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-[#142143]/20">
                    <h3 class="text-xl font-semibold text-[#142143]">
                        Tambah Data Kunjungan
                    </h3>
                    <button type="button" class="text-[#142143] bg-transparent hover:bg-[#142143]/10 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="tambah-kunjungan-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('kunjungan.store') }}" method="POST" class="p-4 md:p-5 space-y-4">
                    @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="unit_id" class="block mb-2 text-sm font-medium text-[#142143]">Unit</label>
                        <select name="unit_id" id="unit_id" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                            <option value="">-- Pilih Unit --</option>
                            @isset($units)
                                @foreach ($units as $u)
                                    <option value="{{ $u->id }}">{{ $u->unit }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div>
                        <label for="kelas_id" class="block mb-2 text-sm font-medium text-[#142143]">Kelas</label>
                        <select name="kelas_id" id="kelas_id" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                            <option value="">-- Pilih Kelas --</option>
                        </select>
                    </div>
                </div>
                    <div>
                        <label for="siswa_id" class="block mb-2 text-sm font-medium text-[#142143]">Nama Siswa</label>
                        <select name="siswa_id" id="siswa_id" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                            <option value="">-- Pilih Siswa --</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-[#142143]">Obat</label>
                        <div class="bg-white border border-[#142143]/30 rounded-lg p-3 max-h-40 overflow-y-auto">
                            @foreach ($obat as $o)
                                <div class="flex items-center mb-2">
                                    <input type="checkbox" name="obat_ids[]" value="{{ $o->id }}" id="obat_{{ $o->id }}" class="obat-checkbox w-4 h-4 text-[#1a5d94] bg-gray-100 border-gray-300 rounded focus:ring-[#1a5d94] focus:ring-2" {{ $o->jumlah <= 0 ? 'disabled' : '' }}>
                                    <label for="obat_{{ $o->id }}" class="ml-2 text-sm cursor-pointer {{ $o->jumlah <= 0 ? 'text-gray-400' : 'text-[#142143]' }}">
                                        {{ $o->nama_obat }}
                                        @if($o->jumlah <= 0)
                                            <span class="text-red-500 text-xs">(Stok Habis)</span>
                                        @else
                                            <span class="text-green-600 text-xs">(Stok: {{ $o->jumlah }})</span>
                                        @endif
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Pilih satu atau lebih obat</p>
                    </div>
                    <div id="jumlah-obat-container">
                        <!-- Container untuk input jumlah obat akan diisi oleh JavaScript -->
                    </div>
                    <div>
                        <label for="guru_id" class="block mb-2 text-sm font-medium text-[#142143]">Guru</label>
                        <select name="guru_id" id="guru_id" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                            <option value="">-- Pilih Guru --</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-[#142143]">Pengecekan</label>
                        <input type="text" name="pengecekan" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" placeholder="Masukkan diagnosa" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-[#142143]">Anamnesa</label>
                        <textarea name="anamnesa" id="anamnesa" cols="30" rows="5" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" placeholder="Masukkan anamnesa" required></textarea>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-[#142143]">Tindakan</label>
                        <textarea name="tindakan" id="tindakan" cols="30" rows="5" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" placeholder="Masukkan tindakan" required></textarea>
                    </div> 
                    <div>
                        <label class="block mb-2 text-sm font-medium text-[#142143]">Diagnosa</label>
                        <input type="text" name="diagnosa" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" placeholder="Masukkan diagnosa" required>
                    </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-[#142143]/20 rounded-b">
                    <button type="submit" class="text-white bg-[#1a5d94] hover:bg-[#142143] focus:ring-4 focus:outline-none focus:ring-[#1a5d94]/30 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
                    <button data-modal-hide="tambah-kunjungan-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-[#142143] focus:outline-none bg-[#e4e4e4] rounded-lg border border-[#142143]/30 hover:bg-[#142143]/10">Batal</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Kunjungan -->
    <div id="edit-kunjungan-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-[#e4e4e4] rounded-lg shadow-sm">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-[#142143]/20">
                    <h3 class="text-xl font-semibold text-[#142143]">
                        Edit Data Kunjungan
                    </h3>
                    <button type="button" class="text-[#142143] bg-transparent hover:bg-[#142143]/10 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="edit-kunjungan-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="form-edit-kunjungan" method="POST" class="p-4 md:p-5 space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit-id">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="edit-unit_id" class="block mb-2 text-sm font-medium text-[#142143]">Unit</label>
                            <select name="unit_id" id="edit-unit_id" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                                <option value="">-- Pilih Unit --</option>
                                @isset($units)
                                    @foreach ($units as $u)
                                        <option value="{{ $u->id }}">{{ $u->unit }}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <div>
                            <label for="edit-kelas_id" class="block mb-2 text-sm font-medium text-[#142143]">Kelas</label>
                            <select name="kelas_id" id="edit-kelas_id" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                                <option value="">-- Pilih Kelas --</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="edit-siswa_id" class="block mb-2 text-sm font-medium text-[#142143]">Nama Siswa</label>
                        <select name="siswa_id" id="edit-siswa_id" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                            <option value="">-- Pilih Siswa --</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-[#142143]">Obat</label>
                        <div class="bg-white border border-[#142143]/30 rounded-lg p-3 max-h-40 overflow-y-auto">
                            @foreach ($obat as $o)
                                <div class="flex items-center mb-2">
                                    <input type="checkbox" name="obat_ids[]" value="{{ $o->id }}" id="edit_obat_{{ $o->id }}" class="edit-obat-checkbox w-4 h-4 text-[#1a5d94] bg-gray-100 border-gray-300 rounded focus:ring-[#1a5d94] focus:ring-2" {{ $o->jumlah <= 0 ? 'disabled' : '' }}>
                                    <label for="edit_obat_{{ $o->id }}" class="ml-2 text-sm cursor-pointer {{ $o->jumlah <= 0 ? 'text-gray-400' : 'text-[#142143]' }}">
                                        {{ $o->nama_obat }}
                                        @if($o->jumlah <= 0)
                                            <span class="text-red-500 text-xs">(Stok Habis)</span>
                                        @else
                                            <span class="text-green-600 text-xs">(Stok: {{ $o->jumlah }})</span>
                                        @endif
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Pilih satu atau lebih obat</p>
                    </div>
                    <div id="edit-jumlah-obat-container">
                        <!-- Container untuk input jumlah obat akan diisi oleh JavaScript -->
                    </div>
                    <div>
                        <label for="edit-guru_id" class="block mb-2 text-sm font-medium text-[#142143]">Guru</label>
                        <select name="guru_id" id="edit-guru_id" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                            <option value="">-- Pilih Guru --</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-[#142143]">Pengecekan</label>
                        <input type="text" name="pengecekan" id="edit-pengecekan" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" placeholder="Masukkan pengecekan" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-[#142143]">Anamnesa</label>
                        <textarea name="anamnesa" id="edit-anamnesa" cols="30" rows="5" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" placeholder="Masukkan anamnesa" required></textarea>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-[#142143]">Tindakan</label>
                        <textarea name="tindakan" id="edit-tindakan" cols="30" rows="5" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" placeholder="Masukkan tindakan" required></textarea>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-[#142143]">Diagnosa</label>
                        <input type="text" name="diagnosa" id="edit-diagnosa" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" placeholder="Masukkan diagnosa" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-[#142143]">Tanggal</label>
                        <input type="date" name="tanggal" id="edit-tanggal" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                    </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-[#142143]/20 rounded-b">
                    <button type="submit" class="text-white bg-[#1a5d94] hover:bg-[#142143] focus:ring-4 focus:outline-none focus:ring-[#1a5d94]/30 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Update</button>
                    <button data-modal-hide="edit-kunjungan-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-[#142143] focus:outline-none bg-[#e4e4e4] rounded-lg border border-[#142143]/30 hover:bg-[#142143]/10">Batal</button>
                </div>
              </form>
          </div>
      </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Handle edit button clicks
    document.querySelectorAll('.btn-edit-obat').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id            = this.getAttribute('data-id');
            const unitId        = this.getAttribute('data-unit-id');
            const kelasId       = this.getAttribute('data-kelas-id');
            const siswaId       = this.getAttribute('data-siswa-id');
            const pengecekan    = this.getAttribute('data-pengecekan');
            const anamnesa      = this.getAttribute('data-anamnesa');
            const diagnosa      = this.getAttribute('data-diagnosa');
            const tindakan      = this.getAttribute('data-tindakan');
            const obatIds       = this.getAttribute('data-obat-ids');
            const obatNames     = this.getAttribute('data-obat-names');
            const jumlahs       = this.getAttribute('data-jumlahs');
            const guruId        = this.getAttribute('data-guru-id');
            const tanggal       = this.getAttribute('data-tanggal');

            // Debug: Log the data
            console.log('Edit data:', {
                id, unitId, kelasId, siswaId, pengecekan, anamnesa, diagnosa, tindakan,
                obatIds, obatNames, jumlahs, guruId, tanggal
            });
            
            // Debug: Log the arrays
            if (obatIds && obatIds !== '') {
                console.log('Obat IDs:', obatIds.split(','));
                console.log('Obat Names:', obatNames.split(','));
                console.log('Jumlahs:', jumlahs.split(','));
            }

            // Set form action
            document.getElementById('form-edit-kunjungan').action = `/kunjungan/${id}`;
            
            // Set form values
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-pengecekan').value = pengecekan;
            document.getElementById('edit-anamnesa').value = anamnesa;
            document.getElementById('edit-diagnosa').value = diagnosa;
            document.getElementById('edit-tindakan').value = tindakan;
            document.getElementById('edit-tanggal').value = tanggal;
            document.getElementById('edit-guru_id').value = guruId;
            
            // Handle multiple obat selection for edit (checkbox)
            if (obatIds && obatIds !== '') {
                const obatIdArray = obatIds.split(',');
                const obatNameArray = obatNames.split(',');
                const jumlahArray = jumlahs.split(',');
                
                // Create a mapping of obat ID to jumlah
                const obatJumlahMap = {};
                obatIdArray.forEach((obatId, index) => {
                    if (obatId && jumlahArray[index]) {
                        obatJumlahMap[obatId] = jumlahArray[index];
                    }
                });
                // Expose previous jumlah per obat for this edit session
                window.editObatJumlahMap = obatJumlahMap;
                
                // Uncheck all checkboxes first
                document.querySelectorAll('.edit-obat-checkbox').forEach(checkbox => {
                    checkbox.checked = false;
                });
                
                // Check selected obat checkboxes
                obatIdArray.forEach(obatId => {
                    if (obatId) {
                        const checkbox = document.getElementById(`edit_obat_${obatId}`);
                        if (checkbox) {
                            checkbox.checked = true;
                        }
                    }
                });
                
                // Create jumlah input fields
                const editJumlahContainer = document.getElementById('edit-jumlah-obat-container');
                editJumlahContainer.innerHTML = '';
                
                obatIdArray.forEach((obatId, index) => {
                    if (obatId && obatNameArray[index]) {
                        const div = document.createElement('div');
                        div.className = 'mb-2';
                        div.innerHTML = `
                            <label class="block mb-1 text-sm font-medium text-[#142143]">Jumlah ${obatNameArray[index]}</label>
                            <input type="number" name="jumlah_obat[]" min="1" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" placeholder="Masukkan jumlah obat" value="${obatJumlahMap[obatId] || ''}" required>
                        `;
                        editJumlahContainer.appendChild(div);
                    }
                });
                
                // Trigger the update function to ensure consistency
                if (typeof updateEditJumlahObatInputs === 'function') {
                    updateEditJumlahObatInputs();
                }
            }

            // Set dropdown values and trigger loading
            document.getElementById('edit-unit_id').value = unitId;
            
            // Load kelas for the selected unit
            if (unitId) {
                fetch(`/get-kelas/${unitId}`)
                    .then(response => response.json())
                    .then(data => {
                        const kelasSelect = document.getElementById('edit-kelas_id');
                        kelasSelect.innerHTML = '<option value="">-- Pilih Kelas --</option>';
                        data.forEach(kelas => {
                            const option = document.createElement('option');
                            option.value = kelas.id;
                            option.textContent = kelas.kelas;
                            kelasSelect.appendChild(option);
                        });
                        kelasSelect.value = kelasId;
                        
                        // Load siswa for the selected kelas and unit
                        if (kelasId) {
                            fetch(`/get-siswa/${unitId}/${kelasId}`)
                                .then(response => response.json())
                                .then(data => {
                                    const siswaSelect = document.getElementById('edit-siswa_id');
                                    siswaSelect.innerHTML = '<option value="">-- Pilih Siswa --</option>';
                                    data.forEach(siswa => {
                                        const option = document.createElement('option');
                                        option.value = siswa.id;
                                        option.textContent = siswa.nama_siswa;
                                        siswaSelect.appendChild(option);
                                    });
                                    siswaSelect.value = siswaId;
                                });
                        }
                    });

                // Load guru for the selected unit
                const editGuruSelect = document.getElementById('edit-guru_id');
                fetch(`/get-guru/${unitId}`)
                    .then(response => response.json())
                    .then(data => {
                        editGuruSelect.innerHTML = '<option value="">-- Pilih Guru --</option>';
                        data.forEach(guru => {
                            const option = document.createElement('option');
                            option.value = guru.id;
                            option.textContent = guru.nama;
                            editGuruSelect.appendChild(option);
                        });
                        editGuruSelect.value = guruId;
                    })
                    .catch(error => {
                        console.error('Error loading guru:', error);
                        editGuruSelect.innerHTML = '<option value="">Error loading guru</option>';
                    });
            }
        });
    });

    // Dynamic dropdown functionality for add modal
    const unitSelect = document.getElementById('unit_id');
    const kelasSelect = document.getElementById('kelas_id');
    const siswaSelect = document.getElementById('siswa_id');
    const guruSelect = document.getElementById('guru_id');

    // Dynamic dropdown functionality for edit modal
    const editUnitSelect = document.getElementById('edit-unit_id');
    const editKelasSelect = document.getElementById('edit-kelas_id');
    const editSiswaSelect = document.getElementById('edit-siswa_id');
    const editGuruSelect = document.getElementById('edit-guru_id');

    // When unit changes, load kelas (add modal)
    if (unitSelect) {
        unitSelect.addEventListener('change', function () {
            const unitId = this.value;
            kelasSelect.innerHTML = '<option value="">-- Pilih Kelas --</option>';
            siswaSelect.innerHTML = '<option value="">-- Pilih Siswa --</option>';
            guruSelect.innerHTML = '<option value="">-- Pilih Guru --</option>';

            if (unitId) {
                fetch(`/get-kelas/${unitId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(kelas => {
                            const option = document.createElement('option');
                            option.value = kelas.id;
                            option.textContent = kelas.kelas;
                            kelasSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error loading kelas:', error);
                        kelasSelect.innerHTML = '<option value="">Error loading kelas</option>';
                    });

                // Load guru for the selected unit
                fetch(`/get-guru/${unitId}`)
                    .then(response => response.json())
                    .then(data => {
                        guruSelect.innerHTML = '<option value="">-- Pilih Guru --</option>';
                        data.forEach(guru => {
                            const option = document.createElement('option');
                            option.value = guru.id;
                            option.textContent = guru.nama;
                            guruSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error loading guru:', error);
                        guruSelect.innerHTML = '<option value="">Error loading guru</option>';
                    });
            }
        });
    }

    // When kelas changes, load siswa (add modal)
    if (kelasSelect) {
        kelasSelect.addEventListener('change', function () {
            const kelasId = this.value;
            const unitId = unitSelect.value;
            siswaSelect.innerHTML = '<option value="">-- Pilih Siswa --</option>';

            if (kelasId && unitId) {
                fetch(`/get-siswa/${unitId}/${kelasId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(siswa => {
                            const option = document.createElement('option');
                            option.value = siswa.id;
                            option.textContent = siswa.nama_siswa;
                            siswaSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error loading siswa:', error);
                        siswaSelect.innerHTML = '<option value="">Error loading siswa</option>';
                    });
            }
        });
    }

    // When unit changes, load kelas (edit modal)
    if (editUnitSelect) {
        editUnitSelect.addEventListener('change', function () {
            const unitId = this.value;
            editKelasSelect.innerHTML = '<option value="">-- Pilih Kelas --</option>';
            editSiswaSelect.innerHTML = '<option value="">-- Pilih Siswa --</option>';
            editGuruSelect.innerHTML = '<option value="">-- Pilih Guru --</option>';

            if (unitId) {
                fetch(`/get-kelas/${unitId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(kelas => {
                            const option = document.createElement('option');
                            option.value = kelas.id;
                            option.textContent = kelas.kelas;
                            editKelasSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error loading kelas:', error);
                        editKelasSelect.innerHTML = '<option value="">Error loading kelas</option>';
                    });

                // Load guru for the selected unit
                fetch(`/get-guru/${unitId}`)
                    .then(response => response.json())
                    .then(data => {
                        editGuruSelect.innerHTML = '<option value="">-- Pilih Guru --</option>';
                        data.forEach(guru => {
                            const option = document.createElement('option');
                            option.value = guru.id;
                            option.textContent = guru.nama;
                            editGuruSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error loading guru:', error);
                        editGuruSelect.innerHTML = '<option value="">Error loading guru</option>';
                    });
            }
        });
    }

    // When kelas changes, load siswa (edit modal)
    if (editKelasSelect) {
        editKelasSelect.addEventListener('change', function () {
            const kelasId = this.value;
            const unitId = editUnitSelect.value;
            editSiswaSelect.innerHTML = '<option value="">-- Pilih Siswa --</option>';

            if (kelasId && unitId) {
                fetch(`/get-siswa/${unitId}/${kelasId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(siswa => {
                            const option = document.createElement('option');
                            option.value = siswa.id;
                            option.textContent = siswa.nama_siswa;
                            editSiswaSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error loading siswa:', error);
                        editSiswaSelect.innerHTML = '<option value="">Error loading siswa</option>';
                    });
            }
        });
    }

    // Search functionality is now handled by server-side form submission

    // Handle multiple obat selection for add modal (checkbox)
    const obatCheckboxes = document.querySelectorAll('.obat-checkbox');
    const jumlahObatContainer = document.getElementById('jumlah-obat-container');
    
    if (obatCheckboxes.length > 0 && jumlahObatContainer) {
        obatCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateJumlahObatInputs();
            });
        });
        
        function updateJumlahObatInputs() {
            const checkedCheckboxes = document.querySelectorAll('.obat-checkbox:checked');
            
            // Clear container
            jumlahObatContainer.innerHTML = '';
            
            // Create input for each checked obat
            checkedCheckboxes.forEach((checkbox, index) => {
                const label = document.querySelector(`label[for="${checkbox.id}"]`);
                const obatName = label.textContent.split('(')[0].trim(); // Remove stock info from name
                const stockText = label.textContent.match(/\(Stok: (\d+)\)/);
                const maxStock = stockText ? parseInt(stockText[1]) : 999;
                
                const div = document.createElement('div');
                div.className = 'mb-2';
                div.innerHTML = `
                    <label class="block mb-1 text-sm font-medium text-[#142143]">Jumlah ${obatName}</label>
                    <input type="number" name="jumlah_obat[]" min="1" max="${maxStock}" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" placeholder="Masukkan jumlah obat" required>
                    <p class="text-xs text-gray-500 mt-1">Maksimal: ${maxStock} (stok tersedia)</p>
                `;
                jumlahObatContainer.appendChild(div);
            });
        }
    }

    // Define updateEditJumlahObatInputs function globally
    function updateEditJumlahObatInputs() {
        const editJumlahObatContainer = document.getElementById('edit-jumlah-obat-container');
        const checkedCheckboxes = document.querySelectorAll('.edit-obat-checkbox:checked');
        
        if (!editJumlahObatContainer) return;
        
        // Store existing values before clearing
        const existingValues = {};
        const existingInputs = editJumlahObatContainer.querySelectorAll('input[name="jumlah_obat[]"]');
        existingInputs.forEach((input, index) => {
            const label = input.previousElementSibling;
            if (label) {
                const obatName = label.textContent.replace('Jumlah ', '');
                existingValues[obatName] = input.value;
            }
        });
        
        // Clear container
        editJumlahObatContainer.innerHTML = '';
        
        // Create input for each checked obat
        checkedCheckboxes.forEach((checkbox, index) => {
            const label = document.querySelector(`label[for="${checkbox.id}"]`);
            const obatName = label.textContent.split('(')[0].trim(); // Remove stock info from name
            const stockText = label.textContent.match(/\(Stok: (\d+)\)/);
            const maxStock = stockText ? parseInt(stockText[1]) : 999;
            const obatId = checkbox.value;
            const prevJumlah = (window.editObatJumlahMap && window.editObatJumlahMap[obatId]) ? parseInt(window.editObatJumlahMap[obatId]) : 0;
            const maxAvailable = maxStock + prevJumlah;
            const existingValue = existingValues[obatName] || '';
            
            const div = document.createElement('div');
            div.className = 'mb-2';
            div.innerHTML = `
                <label class="block mb-1 text-sm font-medium text-[#142143]">Jumlah ${obatName}</label>
                <input type="number" name="jumlah_obat[]" min="1" max="${maxAvailable}" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" placeholder="Masukkan jumlah obat" value="${existingValue}" required>
                <p class="text-xs text-gray-500 mt-1">Maksimal: ${maxAvailable} (stok ${maxStock} + sebelumnya ${prevJumlah})</p>
            `;
            editJumlahObatContainer.appendChild(div);
        });
    }

    // Handle multiple obat selection for edit modal (checkbox)
    const editObatCheckboxes = document.querySelectorAll('.edit-obat-checkbox');
    
    if (editObatCheckboxes.length > 0) {
        editObatCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateEditJumlahObatInputs();
            });
        });
    }
});
</script>