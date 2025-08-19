<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-[#142143] leading-tight">
                {{ __('Kunjungan UKS') }}
            </h2>
            <button data-modal-target="tambah-kunjungan-modal" data-modal-toggle="tambah-kunjungan-modal" 
                    class="inline-flex items-center px-4 py-2 bg-[#1a5d94] hover:bg-[#142143] focus:ring-4 focus:ring-[#1a5d94]/30 text-white text-sm font-medium rounded-lg transition duration-200">
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
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-[#142143]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" placeholder="Cari info kunjungan..." 
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
                        <th scope="col" class="px-6 py-4 font-medium">Unit</th>
                        <th scope="col" class="px-6 py-4 font-medium">Kelas</th>
                        <th scope="col" class="px-6 py-4 font-medium">Nama Siswa</th>
                        <th scope="col" class="px-6 py-4 font-medium">Diagnosa</th>
                        <th scope="col" class="px-6 py-4 font-medium">Obat</th>
                        <th scope="col" class="px-6 py-4 font-medium">Jumlah</th>
                        <th scope="col" class="px-6 py-4 font-medium">Guru</th>
                        <th scope="col" class="px-6 py-4 font-medium">Tanggal</th>
                        <th scope="col" class="px-6 py-4 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#142143]/20">
                    @foreach ($kunjungan as $item)
                    <tr class="hover:bg-[#142143]/5 transition duration-200">
                        <td class="px-6 py-4 font-medium text-[#142143]">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-medium text-[#142143]">{{ $item->rombel->unit->unit }}</td>
                        <td class="px-6 py-4 font-medium text-[#142143]">{{ $item->rombel->kelas->kelas }}</td>
                        <td class="px-6 py-4 font-medium text-[#142143]">{{ $item->rombel->siswa->nama_siswa }}</td>
                        <td class="px-6 py-4 font-medium text-[#142143]">{{ $item->diagnosa }}</td>
                        <td class="px-6 py-4 font-medium text-[#142143]">{{ $item->obat->nama_obat }}</td>
                        <td class="px-6 py-4 font-medium text-[#142143]">{{ $item->jumlah_obat }}</td>
                        <td class="px-6 py-4 font-medium text-[#142143]">{{ $item->guru->nama }}</td>
                        <td class="px-6 py-4 font-medium text-[#142143]">{{ $item->tanggal }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <button 
                                    class="text-[#1a5d94] hover:text-[#142143] p-1 rounded-lg hover:bg-[#1a5d94]/10 transition duration-200 btn-edit-obat"
                                    data-id         ="{{ $item->id }}"
                                    data-unit-id    ="{{ $item->rombel->unit->id }}"
                                    data-kelas-id   ="{{ $item->rombel->kelas->id }}"
                                    data-siswa-id   ="{{ $item->rombel->siswa->id }}"
                                    data-diagnosa   ="{{ $item->diagnosa }}"
                                    data-obat-id    ="{{ $item->obat->id }}"
                                    data-jumlah     ="{{ $item->jumlah_obat }}"
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
                    Menampilkan <span class="font-medium">1</span> sampai <span class="font-medium">{{ $kunjungan->count() }}</span> dari <span class="font-medium">{{ $kunjungan->count() }}</span> hasil
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

    <!-- Modal Tambah Unit -->
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
                            @php
                                $uniqueUnits = $rombel->unique('unit_id');
                            @endphp
                            @foreach ($uniqueUnits as $r)
                                <option value="{{ $r->unit->id }}">{{ $r->unit->unit }}</option>
                            @endforeach
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
                        <label for="obat_id" class="block mb-2 text-sm font-medium text-[#142143]">Obat</label>
                        <select name="obat_id" id="obat_id" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                            <option value="">-- Pilih Obat --</option>
                            @foreach ($obat as $o)
                                <option value="{{ $o->id }}">{{ $o->nama_obat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="guru_id" class="block mb-2 text-sm font-medium text-[#142143]">Guru</label>
                        <select name="guru_id" id="guru_id" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                            <option value="">-- Pilih Guru --</option>
                            @foreach ($guru as $g)
                                <option value="{{ $g->id }}">{{ $g->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-[#142143]">Diagnosa</label>
                        <input type="text" name="diagnosa" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" placeholder="Masukkan diagnosa" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-[#142143]">Jumlah Obat</label>
                        <input type="text" name="jumlah_obat" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" placeholder="Masukkan jumlah obat" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-[#142143]">Tanggal</label>
                        <input type="date" name="tanggal" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
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
                                @php
                                    $uniqueUnits = $rombel->unique('unit_id');
                                @endphp
                                @foreach ($uniqueUnits as $r)
                                    <option value="{{ $r->unit->id }}">{{ $r->unit->unit }}</option>
                                @endforeach
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
                        <label for="edit-obat_id" class="block mb-2 text-sm font-medium text-[#142143]">Obat</label>
                        <select name="obat_id" id="edit-obat_id" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                            <option value="">-- Pilih Obat --</option>
                            @foreach ($obat as $o)
                                <option value="{{ $o->id }}">{{ $o->nama_obat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="edit-guru_id" class="block mb-2 text-sm font-medium text-[#142143]">Guru</label>
                        <select name="guru_id" id="edit-guru_id" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" required>
                            <option value="">-- Pilih Guru --</option>
                            @foreach ($guru as $g)
                                <option value="{{ $g->id }}">{{ $g->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-[#142143]">Diagnosa</label>
                        <input type="text" name="diagnosa" id="edit-diagnosa" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" placeholder="Masukkan diagnosa" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-[#142143]">Jumlah Obat</label>
                        <input type="text" name="jumlah_obat" id="edit-jumlah_obat" class="bg-white border border-[#142143]/30 text-[#142143] text-sm rounded-lg focus:ring-[#1a5d94] focus:border-[#1a5d94] block w-full p-2.5" placeholder="Masukkan jumlah obat" required>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Handle edit button clicks
    document.querySelectorAll('.btn-edit-obat').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const unitId = this.getAttribute('data-unit-id');
            const kelasId = this.getAttribute('data-kelas-id');
            const siswaId = this.getAttribute('data-siswa-id');
            const diagnosa = this.getAttribute('data-diagnosa');
            const obatId = this.getAttribute('data-obat-id');
            const jumlah = this.getAttribute('data-jumlah');
            const guruId = this.getAttribute('data-guru-id');
            const tanggal = this.getAttribute('data-tanggal');

            // Set form action
            document.getElementById('form-edit-kunjungan').action = `/kunjungan/${id}`;
            
            // Set form values
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-diagnosa').value = diagnosa;
            document.getElementById('edit-jumlah_obat').value = jumlah;
            document.getElementById('edit-tanggal').value = tanggal;
            document.getElementById('edit-obat_id').value = obatId;
            document.getElementById('edit-guru_id').value = guruId;

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
            }
        });
    });

    // Dynamic dropdown functionality for add modal
    const unitSelect = document.getElementById('unit_id');
    const kelasSelect = document.getElementById('kelas_id');
    const siswaSelect = document.getElementById('siswa_id');

    // Dynamic dropdown functionality for edit modal
    const editUnitSelect = document.getElementById('edit-unit_id');
    const editKelasSelect = document.getElementById('edit-kelas_id');
    const editSiswaSelect = document.getElementById('edit-siswa_id');

    // When unit changes, load kelas (add modal)
    if (unitSelect) {
        unitSelect.addEventListener('change', function () {
            const unitId = this.value;
            kelasSelect.innerHTML = '<option value="">-- Pilih Kelas --</option>';
            siswaSelect.innerHTML = '<option value="">-- Pilih Siswa --</option>';

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
});
</script>
