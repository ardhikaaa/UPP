
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-[#142143] leading-tight">
                {{ __('Data Siswa') }}
            </h2>
            <button data-modal-target="tambah-siswa-modal" data-modal-toggle="tambah-siswa-modal" 
                    class="inline-flex items-center px-4 py-2 bg-[#1a5d94] hover:bg-[#142143] focus:ring-4 focus:ring-[#1a5d94]/30 text-white text-sm font-medium rounded-lg transition duration-200">
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
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-[#142143]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" placeholder="Cari siswa berdasarkan nama atau NIS..." 
                               class="block w-full pl-10 pr-3 py-2 border border-[#142143]/30 rounded-lg leading-5 bg-white text-[#142143] placeholder-[#142143]/60 focus:outline-none focus:ring-1 focus:ring-[#1a5d94] focus:border-[#1a5d94]">
                    </div>
                </div>
                <div class="flex gap-2">
                    <button class="px-4 py-2 bg-[#e4e4e4] hover:bg-[#142143]/10 text-[#142143] rounded-lg transition duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                        </svg>
                    </button>
                </div>
            </div>
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

            <table class="w-full text-sm text-left text-[#142143]">
                <thead class="text-xs uppercase bg-[#1a5d94] text-white">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-medium">No</th>
                        <th scope="col" class="px-6 py-4 font-medium">NIS</th>
                        <th scope="col" class="px-6 py-4 font-medium">Nama Siswa</th>
                        <th scope="col" class="px-6 py-4 font-medium">No Telp Siswa</th>
                        <th scope="col" class="px-6 py-4 font-medium">No Telp Ortu</th>
                        <th scope="col" class="px-6 py-4 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#142143]/20">
                     @foreach ($siswa as $data)
                    <tr class="hover:bg-[#142143]/5 transition duration-200">
                        <td class="px-6 py-4 font-medium text-[#142143]">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-medium text-[#142143]">{{ $data->nis }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div>
                                    <div class="font-medium text-[#142143]">{{ $data->nama_siswa }}</div>
                                    <div class="text-gray-500 dark:text-gray-400 text-xs">{{ $data->jenis_kelamin }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                {{ $data->no_telp_siswa }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                               {{ $data->no_telp_ortu }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <button 
                                    class="text-[#1a5d94] hover:text-[#142143] p-1 rounded-lg hover:bg-[#1a5d94]/10 transition duration-200 btn-edit-siswa"
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
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-[#142143]/20">
            <div class="flex items-center justify-between">
                <div class="text-sm text-[#142143]">
                    Menampilkan <span class="font-medium">1</span> sampai <span class="font-medium">3</span> dari <span class="font-medium">3</span> hasil
                </div>
                <div class="flex items-center space-x-2">
                    <button class="px-3 py-1 text-sm bg-[#e4e4e4] hover:bg-[#142143]/10 text-[#142143] rounded-lg transition duration-200">
                        Sebelumnya
                    </button>
                    <button class="px-3 py-1 text-sm bg-[#1a5d94] text-white rounded-lg">1</button>
                    <button class="px-3 py-1 text-sm bg-[#e4e4e4] hover:bg-[#142143]/10 text-[#142143] rounded-lg transition duration-200">
                        Selanjutnya
                    </button>
                </div>
            </div>
        </div>
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
                    <button type="submit" class="text-white bg-[#1a5d94] hover:bg-[#142143] focus:ring-4 focus:outline-none focus:ring-[#1a5d94]/30 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
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
</script>