
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-[#142143] leading-tight">
                {{ __('Data Siswa') }}
            </h2>
            <button data-modal-target="tambah-siswa-modal" data-modal-toggle="tambah-siswa-modal" 
                    class="inline-flex items-center px-4 py-2 bg-[#0072BC] hover:bg-[#142143] focus:ring-4 focus:ring-[#1a5d94]/30 text-white text-sm font-medium rounded-lg transition duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Siswa
            </button>
        </div>
    </x-slot>

    <div class="bg-[#e4e4e4] shadow-sm rounded-lg overflow-hidden">
        <!-- Search Section -->
        <div class="p-6 border-b border-[#142143]/20">
            <form method="GET" action="{{ route('siswa.index') }}" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-[#142143]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIS, nama siswa, jenis kelamin, atau nomor telepon..." 
                               class="block w-full pl-10 pr-3 py-2 border border-[#142143]/30 rounded-lg leading-5 bg-white text-[#142143] placeholder-[#142143]/60 focus:outline-none focus:ring-1 focus:ring-[#1a5d94] focus:border-[#1a5d94]"
                               autocomplete="off">
                    </div>
                </div>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('siswa.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Import Section -->
        {{-- <div class="p-6 border-b border-[#142143]/20">
            <form action="{{ route('siswa.import') }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row gap-4 items-end">
                @csrf
                <div class="flex-1">
                    <label class="block mb-2 text-sm font-medium text-[#142143]">Pilih File Excel</label>
                    <div class="relative">
                        <input type="file" name="file" required accept=".xlsx,.xls" 
                            class="block w-full text-sm text-[#142143] file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-[#0072BC] file:text-white hover:file:bg-[#142143] file:cursor-pointer file:transition file:duration-200 border border-[#142143]/30 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-[#1a5d94] focus:border-[#1a5d94]">
                    </div>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-[#0072BC] hover:bg-[#142143] focus:ring-4 focus:ring-[#1a5d94]/30 text-white text-sm font-medium rounded-lg transition duration-200 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                        </svg>
                        Import Excel
                    </button>
                    <a href="https://drive.google.com/drive/folders/1DDkOI3DgCpm8aVCKTMdr9l7w_wHULgP_?usp=sharing" target="_blank" class="inline-flex items-center px-6 py-2 bg-white border border-[#0072BC] hover:bg-[#0072BC] hover:text-white focus:ring-4 focus:ring-[#1a5d94]/30 text-[#0072BC] text-sm font-medium rounded-lg transition duration-200 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Unduh Template
                    </a>
                </div>
            </form>
        </div> --}}

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
                <div id="error-alert" class="relative p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg flex justify-between items-start">
                    <div>
                        {{ session('error') }}
                    </div>
                    <button type="button" onclick="document.getElementById('error-alert').remove()" class="ml-4 text-red-700 hover:text-red-500 rounded focus:outline-none">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif

            @if($siswa->count() > 0)
                <table class="w-full text-sm text-left text-[#142143]" id="Table">
                    <thead class="text-xs uppercase bg-[#0072BC] text-white">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-medium text-center">No</th>
                            <th scope="col" class="px-6 py-4 font-medium text-center">NIS</th>
                            <th scope="col" class="px-6 py-4 font-medium text-center">Nama Siswa</th>
                            <th scope="col" class="px-6 py-4 font-medium text-center">No Telp Siswa</th>
                            <th scope="col" class="px-6 py-4 font-medium text-center">No Telp Ortu</th>
                            <th scope="col" class="px-6 py-4 font-medium text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#142143]/20">
                         @foreach ($siswa as $data)
                        <tr class="hover:bg-[#142143]/5 transition duration-200">
                            <td class="px-6 py-4 font-medium text-[#142143] text-center">{{ $siswa->firstItem() + $loop->index }}</td>
                            <td class="px-6 py-4 font-medium text-[#142143] text-center">{{ $data->nis }}</td>
                            <td class="px-6 py-4 flex justify-center">
                                <div class="flex items-center">
                                    <div>
                                        <div class="font-medium text-[#142143] text-center">{{ $data->nama_siswa }}</div>
                                        <div class="text-gray-500 dark:text-gray-400 text-xs text-center">{{ $data->jenis_kelamin }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    {{ $data->no_telp_siswa }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                   {{ $data->no_telp_ortu }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center space-x-2">
                                    <button 
                                        class="text-[#0072BC] hover:text-[#142143] p-1 rounded-lg hover:bg-[#1a5d94]/10 transition duration-200 btn-edit-siswa"
                                        data-id="{{ $data->id }}"
                                        data-nis="{{ $data->nis }}"
                                        data-nama_siswa="{{ $data->nama_siswa }}"
                                        data-jenis_kelamin="{{ $data->jenis_kelamin }}"
                                        data-no_telp_siswa="{{ $data->no_telp_siswa }}"
                                        data-no_telp_ortu="{{ $data->no_telp_ortu }}"
                                        data-modal-target="edit-siswa-modal" data-modal-toggle="edit-siswa-modal"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <form action="{{ route('siswa.destroy', $data->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                    @csrf
                                     @method('DELETE')
                                        <button class="text-[#ffaf00] hover:text-[#142143] p-1 rounded-lg hover:bg-[#ffaf00]/10 transition duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-[#142143]">Tidak ada data siswa</h3>
                    @if(request('search'))
                        <p class="mt-1 text-sm text-gray-500">Tidak ditemukan hasil untuk pencarian "<span class="font-medium">{{ request('search') }}</span>"</p>
                        <div class="mt-6">
                            <a href="{{ route('siswa.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#0072BC] hover:bg-[#142143] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0072BC]">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Reset Pencarian
                            </a>
                        </div>
                    @else
                        <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan data siswa baru.</p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($siswa->hasPages())
            <div class="px-6 py-4 border-t border-[#142143]/20">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-[#142143]">
                        @if(request('search'))
                            Menampilkan
                            <span class="font-medium">{{ $siswa->firstItem() ?? 0 }}</span>
                            sampai
                            <span class="font-medium">{{ $siswa->lastItem() ?? 0 }}</span>
                            dari
                            <span class="font-medium">{{ $siswa->total() }}</span> hasil pencarian untuk "<span class="font-medium text-[#0072BC]">{{ request('search') }}</span>"
                        @else
                            Menampilkan
                            <span class="font-medium">{{ $siswa->firstItem() ?? 0 }}</span>
                            sampai
                            <span class="font-medium">{{ $siswa->lastItem() ?? 0 }}</span>
                            dari
                            <span class="font-medium">{{ $siswa->total() }}</span> hasil
                        @endif
                    </div>

                    <div class="flex items-center space-x-2">
                        {{-- Tombol Sebelumnya --}}
                        <a href="{{ $siswa->previousPageUrl() ?? '#' }}"
                        class="px-3 py-1 text-sm rounded-lg transition duration-200
                                {{ $siswa->onFirstPage() 
                                    ? 'bg-[#e4e4e4] text-gray-400 cursor-not-allowed' 
                                    : 'bg-[#e4e4e4] hover:bg-[#142143]/10 text-[#142143]' }}">
                            Sebelumnya
                        </a>

                        {{-- Nomor halaman --}}
                        @php
                            $start = max(1, $siswa->currentPage() - 2);
                            $end = min($siswa->lastPage(), $siswa->currentPage() + 2);
                        @endphp

                        @for ($i = $start; $i <= $end; $i++)
                            <a href="{{ $siswa->url($i) }}"
                            class="px-3 py-1 text-sm rounded-lg transition duration-200
                                    {{ $siswa->currentPage() == $i 
                                        ? 'bg-[#0072BC] text-white' 
                                        : 'bg-[#e4e4e4] hover:bg-[#142143]/10 text-[#142143]' }}">
                                {{ $i }}
                            </a>
                        @endfor

                        {{-- Tombol Selanjutnya --}}
                        <a href="{{ $siswa->nextPageUrl() ?? '#' }}"
                        class="px-3 py-1 text-sm rounded-lg transition duration-200
                                {{ $siswa->hasMorePages() 
                                    ? 'bg-[#e4e4e4] hover:bg-[#142143]/10 text-[#142143]' 
                                    : 'bg-[#e4e4e4] text-gray-400 cursor-not-allowed' }}">
                            Selanjutnya
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal Tambah Siswa -->
    <div id="tambah-siswa-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-[#e4e4e4] rounded-lg shadow-sm">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-[#142143]/20">
                    <h3 class="text-xl font-semibold text-[#142143]">
                        Tambah Data Siswa
                    </h3>
                    <button type="button" class="text-[#142143] bg-transparent hover:bg-[#142143]/10 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="tambah-siswa-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('siswa.store') }}" method="POST" class="p-4 md:p-5 space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-[#142143]">NIS</label>
                            <input type="text" name="nis" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" placeholder="Masukkan NIS" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-[#142143]">Nama Lengkap</label>
                            <input type="text" name="nama_siswa" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" placeholder="Masukkan nama lengkap" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-[#142143]">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-[#142143]">No Telp Siswa</label>
                            <input type="tel" name="no_telp_siswa" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" placeholder="081234567890" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-[#142143]">No Telp Orang Tua</label>
                            <input type="tel" name="no_telp_ortu" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" placeholder="081234567891" required>
                        </div>
                    </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-[#142143]/20 rounded-b">
                    <button type="submit" class="text-white bg-[#0072BC] hover:bg-[#142143] focus:ring-4 focus:outline-none focus:ring-[#1a5d94]/30 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
                    <button data-modal-hide="tambah-siswa-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-[#142143] focus:outline-none bg-[#e4e4e4] rounded-lg border border-[#142143]/30 hover:bg-[#142143]/10">Batal</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Siswa -->
    <div id="edit-siswa-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-[#e4e4e4] rounded-lg shadow-sm">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-[#142143]/20">
                    <h3 class="text-xl font-semibold text-[#142143]">
                        Edit Data Siswa
                    </h3>
                    <button type="button" class="text-[#142143] bg-transparent hover:bg-[#142143]/10 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="edit-siswa-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="form-edit-siswa" method="POST" class="p-4 md:p-5 space-y-4">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="id" id="edit-id">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-[#142143]">NIS</label>
                            <input type="text" name="nis" id="edit-nis" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-[#142143]">Nama Lengkap</label>
                            <input type="text" name="nama_siswa" id="edit-nama_siswa" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-[#142143]">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="edit-jenis_kelamin" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-[#142143]">No Telp Siswa</label>
                            <input type="tel" name="no_telp_siswa" id="edit-no_telp_siswa" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-[#142143]">No Telp Orang Tua</label>
                            <input type="tel" name="no_telp_ortu" id="edit-no_telp_ortu" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                        </div>
                    </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-[#142143]/20 rounded-b">
                    <button type="submit" class="text-white bg-[#1a5d94] hover:bg-[#142143] focus:ring-4 focus:outline-none focus:ring-[#1a5d94]/30 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Update</button>
                    <button data-modal-hide="edit-siswa-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-[#142143] focus:outline-none bg-[#e4e4e4] rounded-lg border border-[#142143]/30 hover:bg-[#142143]/10">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-edit-siswa').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const nis = this.getAttribute('data-nis');
                const nama_siswa = this.getAttribute('data-nama_siswa');
                const jenis_kelamin = this.getAttribute('data-jenis_kelamin');
                const no_telp_siswa = this.getAttribute('data-no_telp_siswa');
                const no_telp_ortu = this.getAttribute('data-no_telp_ortu');

                document.getElementById('edit-id').value = id;
                document.getElementById('edit-nis').value = nis;
                document.getElementById('edit-nama_siswa').value = nama_siswa;
                document.getElementById('edit-jenis_kelamin').value = jenis_kelamin;
                document.getElementById('edit-no_telp_siswa').value = no_telp_siswa;
                document.getElementById('edit-no_telp_ortu').value = no_telp_ortu;

                // Set form action
                document.getElementById('form-edit-siswa').action = `/siswa/${id}`;
            });
        });
    });

    // Search functionality is now handled by server-side form submission
</script>