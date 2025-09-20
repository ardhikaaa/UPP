<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-[#142143] leading-tight">
                {{ __('Rombongan Belajar') }}
            </h2>
            <button data-modal-target="tambah-rombel-modal" data-modal-toggle="tambah-rombel-modal" 
                    class="inline-flex items-center px-4 py-2 bg-[#0072BC] hover:bg-[#142143] focus:ring-4 focus:ring-[#1a5d94]/30 text-white text-sm font-medium rounded-lg transition duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Buat Rombel
            </button>
        </div>
    </x-slot>

    <div class="bg-[#e4e4e4] shadow-sm rounded-lg overflow-hidden">
        <!-- Search Section -->
        <div class="p-6 border-b border-[#142143]/20">
            <form method="GET" action="{{ route('rombel.index') }}" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-[#142143]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa, kelas, atau unit..." 
                               class="block w-full pl-10 pr-3 py-2 border border-[#142143]/30 rounded-lg leading-5 bg-white text-[#142143] placeholder-[#142143]/60 focus:outline-none focus:ring-1 focus:ring-[#1a5d94] focus:border-[#1a5d94]"
                               autocomplete="off">
                    </div>
                </div>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('rombel.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
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

            @if($rombels->count() > 0)
                <table class="w-full text-sm text-left text-[#142143]" id="Table">
                    <thead class="text-xs uppercase bg-[#0072BC] text-white">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-medium text-center">No</th>
                            <th scope="col" class="px-6 py-4 font-medium text-center">Unit</th>
                            <th scope="col" class="px-6 py-4 font-medium text-center">Kelas</th>
                            <th scope="col" class="px-6 py-4 font-medium text-center">Nama Siswa</th>
                            <th scope="col" class="px-6 py-4 font-medium text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#142143]/20">
                        @foreach ($rombels as $item)
                        <tr class="hover:bg-[#142143]/5 transition duration-200">
                            <td class="px-6 py-4 font-medium text-[#142143] text-center">{{ $rombels->firstItem() + $loop->index }}</td>
                            <td class="px-6 py-4 font-medium text-[#142143] text-center">{{ $item->unit->unit }}</td>
                            <td class="px-6 py-4 font-medium text-[#142143] text-center">{{ $item->kelas->kelas }}</td>
                            <td class="px-6 py-4 font-medium text-[#142143] text-center">{{ $item->siswa->nama_siswa }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center space-x-2">
                                    <button 
                                        class="text-[#0072BC] hover:text-[#142143] p-1 rounded-lg hover:bg-[#1a5d94]/10 transition duration-200 btn-edit-rombel"
                                        data-id="{{ $item->id }}"
                                        data-unit-id="{{ $item->unit_id }}"
                                        data-kelas-id="{{ $item->kelas_id }}"
                                        data-siswa-id="{{ $item->siswa_id }}"
                                        data-modal-target="edit-rombel-modal" 
                                        data-modal-toggle="edit-rombel-modal"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <form action="{{ route('rombel.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-[#142143]">Tidak ada data rombel</h3>
                    @if(request('search'))
                        <p class="mt-1 text-sm text-gray-500">Tidak ditemukan hasil untuk pencarian "<span class="font-medium">{{ request('search') }}</span>"</p>
                        <div class="mt-6">
                            <a href="{{ route('rombel.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#0072BC] hover:bg-[#142143] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0072BC]">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Reset Pencarian
                            </a>
                        </div>
                    @else
                        <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat rombel baru.</p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($rombels->hasPages())
            <div class="px-6 py-4 border-t border-[#142143]/20">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-[#142143]">
                        @if(request('search'))
                            Menampilkan
                            <span class="font-medium">{{ $rombels->firstItem() ?? 0 }}</span>
                            sampai
                            <span class="font-medium">{{ $rombels->lastItem() ?? 0 }}</span>
                            dari
                            <span class="font-medium">{{ $rombels->total() }}</span> hasil pencarian untuk "<span class="font-medium text-[#0072BC]">{{ request('search') }}</span>"
                        @else
                            Menampilkan
                            <span class="font-medium">{{ $rombels->firstItem() ?? 0 }}</span>
                            sampai
                            <span class="font-medium">{{ $rombels->lastItem() ?? 0 }}</span>
                            dari
                            <span class="font-medium">{{ $rombels->total() }}</span> hasil
                        @endif
                    </div>

                    <div class="flex items-center space-x-2">
                        {{-- Tombol Sebelumnya --}}
                        <a href="{{ $rombels->previousPageUrl() ?? '#' }}"
                        class="px-3 py-1 text-sm rounded-lg transition duration-200
                                {{ $rombels->onFirstPage() 
                                    ? 'bg-[#e4e4e4] text-gray-400 cursor-not-allowed' 
                                    : 'bg-[#e4e4e4] hover:bg-[#142143]/10 text-[#142143]' }}">
                            Sebelumnya
                        </a>

                        {{-- Nomor halaman --}}
                        @php
                            $start = max(1, $rombels->currentPage() - 2);
                            $end = min($rombels->lastPage(), $rombels->currentPage() + 2);
                        @endphp

                        @for ($i = $start; $i <= $end; $i++)
                            <a href="{{ $rombels->url($i) }}"
                            class="px-3 py-1 text-sm rounded-lg transition duration-200
                                    {{ $rombels->currentPage() == $i 
                                        ? 'bg-[#0072BC] text-white' 
                                        : 'bg-[#e4e4e4] hover:bg-[#142143]/10 text-[#142143]' }}">
                                {{ $i }}
                            </a>
                        @endfor

                        {{-- Tombol Selanjutnya --}}
                        <a href="{{ $rombels->nextPageUrl() ?? '#' }}"
                        class="px-3 py-1 text-sm rounded-lg transition duration-200
                                {{ $rombels->hasMorePages() 
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
    <div id="tambah-rombel-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-[#e4e4e4] rounded-lg shadow-sm">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-[#142143]/20">
                    <h3 class="text-xl font-semibold text-[#142143]">
                        Tambah Data Rombel
                    </h3>
                    <button type="button" class="text-[#142143] bg-transparent hover:bg-[#142143]/10 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="tambah-rombel-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('rombel.store') }}" method="POST" class="p-4 md:p-5 space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="unit_id" class="block mb-2 text-sm font-medium text-[#142143]">Unit</label>
                            <select name="unit_id" id="unit_id" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                                <option value="">-- Pilih Unit --</option>
                                @foreach ($units as $u)
                                    <option value="{{ $u->id }}">{{ $u->unit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="kelas_id" class="block mb-2 text-sm font-medium text-[#142143]">Kelas</label>
                            <select name="kelas_id" id="kelas_id" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="siswa_id" class="block mb-2 text-sm font-medium text-[#142143]">Nama Siswa</label>
                        <select name="siswa_id" id="siswa_id" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach ($siswa as $s)
                                <option value="{{ $s->id }}">{{ $s->nama_siswa }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 md:p-5 border-t border-[#142143]/20 rounded-b">
                        <button type="submit" class="text-white bg-[#0072BC] hover:bg-[#142143] focus:ring-4 focus:outline-none focus:ring-[#1a5d94]/30 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
                        <button data-modal-hide="tambah-rombel-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-[#142143] focus:outline-none bg-[#e4e4e4] rounded-lg border border-[#142143]/30 hover:bg-[#142143]/10">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Rombel -->
    <div id="edit-rombel-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-[#e4e4e4] rounded-lg shadow-sm">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-[#142143]/20">
                    <h3 class="text-xl font-semibold text-[#142143]">
                        Edit Data Rombel
                    </h3>
                    <button type="button" class="text-[#142143] bg-transparent hover:bg-[#142143]/10 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="edit-rombel-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="form-edit-rombel" method="POST" class="p-4 md:p-5 space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit-id">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="edit-unit_id" class="block mb-2 text-sm font-medium text-[#142143]">Unit</label>
                            <select name="unit_id" id="edit-unit_id" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                                <option value="">-- Pilih Unit --</option>
                                @foreach ($units as $u)
                                    <option value="{{ $u->id }}">{{ $u->unit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="edit-kelas_id" class="block mb-2 text-sm font-medium text-[#142143]">Kelas</label>
                            <select name="kelas_id" id="edit-kelas_id" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="edit-siswa_id" class="block mb-2 text-sm font-medium text-[#142143]">Nama Siswa</label>
                        <select name="siswa_id" id="edit-siswa_id" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach ($siswa as $s)
                                <option value="{{ $s->id }}">{{ $s->nama_siswa }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 md:p-5 border-t border-[#142143]/20 rounded-b">
                        <button type="submit" class="text-white bg-[#1a5d94] hover:bg-[#142143] focus:ring-4 focus:outline-none focus:ring-[#1a5d94]/30 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Update</button>
                        <button data-modal-hide="edit-rombel-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-[#142143] focus:outline-none bg-[#e4e4e4] rounded-lg border border-[#142143]/30 hover:bg-[#142143]/10">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Handle edit button clicks
            document.querySelectorAll('.btn-edit-rombel').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const unitId = this.getAttribute('data-unit-id');
                    const kelasId = this.getAttribute('data-kelas-id');
                    const siswaId = this.getAttribute('data-siswa-id');

                    // Set form action
                    document.getElementById('form-edit-rombel').action = `/rombel/${id}`;
                    
                    // Set form values
                    document.getElementById('edit-id').value = id;
                    document.getElementById('edit-unit_id').value = unitId;
                    document.getElementById('edit-kelas_id').value = kelasId;
                    document.getElementById('edit-siswa_id').value = siswaId;
                });
            });
        });

        // Search functionality is now handled by server-side form submission
    </script>
</x-app-layout>
