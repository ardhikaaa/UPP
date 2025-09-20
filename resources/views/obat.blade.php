<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-[#142143] leading-tight">
                {{ __('Data Obat') }}
            </h2>
            <button data-modal-target="tambah-obat-modal" data-modal-toggle="tambah-obat-modal" 
                    class="inline-flex items-center px-4 py-2 bg-[#0072BC] hover:bg-[#142143] focus:ring-4 focus:ring-[#1a5d94]/30 text-white text-sm font-medium rounded-lg transition duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Obat
            </button>
        </div>
    </x-slot>

    <div class="bg-[#e4e4e4] shadow-sm rounded-lg overflow-hidden">
        <!-- Search Section -->
        <div class="p-6 border-b border-[#142143]/20">
            <form method="GET" action="{{ route('obat.index') }}" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-[#142143]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama obat atau jumlah..." 
                               class="block w-full pl-10 pr-3 py-2 border border-[#142143]/30 rounded-lg leading-5 bg-white text-[#142143] placeholder-[#142143]/60 focus:outline-none focus:ring-1 focus:ring-[#1a5d94] focus:border-[#1a5d94]"
                               autocomplete="off">
                    </div>
                </div>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('obat.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
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

            @if($obat->count() > 0)
                <table class="w-full text-sm text-left text-[#142143]" id="Table">
                    <thead class="text-xs uppercase bg-[#0072BC] text-white">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-medium text-center">No</th>
                            <th scope="col" class="px-6 py-4 font-medium text-center">Nama Obat</th>
                            <th scope="col" class="px-6 py-4 font-medium text-center">Jumlah</th>
                            <th scope="col" class="px-6 py-4 font-medium text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#142143]/20">
                        @foreach ($obat as $item)
                        <tr class="hover:bg-[#142143]/5 transition duration-200">
                            <td class="px-6 py-4 font-medium text-[#142143] text-center">{{ $obat->firstItem() + $loop->index }}</td>
                            <td class="px-6 py-4 font-medium text-[#142143] text-center">{{ $item->nama_obat }}</td>
                            <td class="px-6 py-4 font-medium text-[#142143] text-center">{{ $item->jumlah }}</td>
                            <td class="px-6 py-4 flex justify-center">
                                <div class="flex items-center space-x-2">
                                    <button 
                                        class="text-[#0072BC] hover:text-[#142143] p-1 rounded-lg hover:bg-[#0072BC]/10 transition duration-200 btn-edit-obat"
                                        data-id="{{ $item->id }}"
                                        data-obat="{{ $item->nama_obat }}"
                                        data-jumlah="{{ $item->jumlah }}"
                                        data-modal-target="edit-obat-modal" data-modal-toggle="edit-obat-modal"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <form action="{{ route('obat.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-[#142143]">Tidak ada data obat</h3>
                    @if(request('search'))
                        <p class="mt-1 text-sm text-gray-500">Tidak ditemukan hasil untuk pencarian "<span class="font-medium">{{ request('search') }}</span>"</p>
                        <div class="mt-6">
                            <a href="{{ route('obat.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#0072BC] hover:bg-[#142143] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0072BC]">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Reset Pencarian
                            </a>
                        </div>
                    @else
                        <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan data obat baru.</p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($obat->hasPages())
            <div class="px-6 py-4 border-t border-[#142143]/20">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-[#142143]">
                        @if(request('search'))
                            Menampilkan
                            <span class="font-medium">{{ $obat->firstItem() ?? 0 }}</span>
                            sampai
                            <span class="font-medium">{{ $obat->lastItem() ?? 0 }}</span>
                            dari
                            <span class="font-medium">{{ $obat->total() }}</span> hasil pencarian untuk "<span class="font-medium text-[#0072BC]">{{ request('search') }}</span>"
                        @else
                            Menampilkan
                            <span class="font-medium">{{ $obat->firstItem() ?? 0 }}</span>
                            sampai
                            <span class="font-medium">{{ $obat->lastItem() ?? 0 }}</span>
                            dari
                            <span class="font-medium">{{ $obat->total() }}</span> hasil
                        @endif
                    </div>

                    <div class="flex items-center space-x-2">
                        {{-- Tombol Sebelumnya --}}
                        <a href="{{ $obat->previousPageUrl() ?? '#' }}"
                        class="px-3 py-1 text-sm rounded-lg transition duration-200
                                {{ $obat->onFirstPage() 
                                    ? 'bg-[#e4e4e4] text-gray-400 cursor-not-allowed' 
                                    : 'bg-[#e4e4e4] hover:bg-[#142143]/10 text-[#142143]' }}">
                            Sebelumnya
                        </a>

                        {{-- Nomor halaman --}}
                        @php
                            $start = max(1, $obat->currentPage() - 2);
                            $end = min($obat->lastPage(), $obat->currentPage() + 2);
                        @endphp

                        @for ($i = $start; $i <= $end; $i++)
                            <a href="{{ $obat->url($i) }}"
                            class="px-3 py-1 text-sm rounded-lg transition duration-200
                                    {{ $obat->currentPage() == $i 
                                        ? 'bg-[#0072BC] text-white' 
                                        : 'bg-[#e4e4e4] hover:bg-[#142143]/10 text-[#142143]' }}">
                                {{ $i }}
                            </a>
                        @endfor

                        {{-- Tombol Selanjutnya --}}
                        <a href="{{ $obat->nextPageUrl() ?? '#' }}"
                        class="px-3 py-1 text-sm rounded-lg transition duration-200
                                {{ $obat->hasMorePages() 
                                    ? 'bg-[#e4e4e4] hover:bg-[#142143]/10 text-[#142143]' 
                                    : 'bg-[#e4e4e4] text-gray-400 cursor-not-allowed' }}">
                            Selanjutnya
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal Tambah Unit -->
    <div id="tambah-obat-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-[#e4e4e4] rounded-lg shadow-sm">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-[#142143]/20">
                    <h3 class="text-xl font-semibold text-[#142143]">
                        Tambah Data Obat
                    </h3>
                    <button type="button" class="text-[#142143] bg-transparent hover:bg-[#142143]/10 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="tambah-obat-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('obat.store') }}" method="POST" class="p-4 md:p-5 space-y-4">
                    @csrf
                    <div>
                        <label class="block mb-2 text-sm font-medium text-[#142143]">Obat</label>
                        <input type="text" name="nama_obat" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" placeholder="Masukkan nama obat" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-[#142143]">jumlah</label>
                        <input type="text" name="jumlah" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" placeholder="Masukkan jumlah" required>
                    </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-[#142143]/20 rounded-b">
                    <button type="submit" class="text-white bg-[#1a5d94] hover:bg-[#142143] focus:ring-4 focus:outline-none focus:ring-[#1a5d94]/30 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
                    <button data-modal-hide="tambah-obat-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-[#142143] focus:outline-none bg-[#e4e4e4] rounded-lg border border-[#142143]/30 hover:bg-[#142143]/10">Batal</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Obat -->
    <div id="edit-obat-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-[#e4e4e4] rounded-lg shadow-sm">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-[#142143]/20">
                    <h3 class="text-xl font-semibold text-[#142143]">
                        Edit Data Obat
                    </h3>
                    <button type="button" class="text-[#142143] bg-transparent hover:bg-[#142143]/10 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="edit-obat-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="form-edit-obat" method="POST" class="p-4 md:p-5 space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit-id">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-[#142143]">Obat</label>
                        <input type="text" name="nama_obat" id="edit-obat" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-[#142143]">Jumlah</label>
                        <input type="text" name="jumlah" id="edit-jumlah" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                    </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-[#142143]/20 rounded-b">
                    <button type="submit" class="text-white bg-[#0072BC] hover:bg-[#142143] focus:ring-4 focus:outline-none focus:ring-[#1a5d94]/30 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Update</button>
                    <button data-modal-hide="edit-obat-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-[#142143] focus:outline-none bg-[#e4e4e4] rounded-lg border border-[#142143]/30 hover:bg-[#142143]/10">Batal</button>
                </div>
              </form>
          </div>
      </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-edit-obat').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const obat = this.getAttribute('data-obat');
                const jumlah = this.getAttribute('data-jumlah');

                document.getElementById('edit-id').value = id;
                document.getElementById('edit-obat').value = obat;
                document.getElementById('edit-jumlah').value = jumlah;

                // Set form action
                document.getElementById('form-edit-obat').action = `/obat/${id}`;
            });
        });
    });

    // Search functionality is now handled by server-side form submission
</script>
