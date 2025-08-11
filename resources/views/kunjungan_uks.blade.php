<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Kunjungan UKS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<x-app-layout>
<body class="bg-gray-50 text-gray-800">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Data Kunjungan UKS') }}
            </h2>
            <button onclick="openModal()"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 text-white text-sm font-medium rounded-lg transition duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Kunjungan
            </button>
        </div>
    </x-slot>

    <div class="bg-white dark:bg-white-800 shadow-sm rounded-lg overflow-hidden">
        <!-- Search Section -->
        <div class="p-6 border-b border-white-200 dark:border-white-700">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-white-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input id="searchInput" type="text" placeholder="Cari kunjungan berdasarkan nama siswa..."
                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white dark:bg-white-700 dark:border-gray-600 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-white-700 dark:text-gray-200">
                <thead class="text-xs text-white-700 uppercase bg-white-50 dark:bg-blue-600 dark:text-white-200 rounded-">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-medium">No</th>
                        <th scope="col" class="px-6 py-4 font-medium">Nama</th>
                        <th scope="col" class="px-6 py-4 font-medium">Kelas</th>
                        <th scope="col" class="px-6 py-4 font-medium">Diagnosa</th>
                        <th scope="col" class="px-6 py-4 font-medium">Obat</th>
                        <th scope="col" class="px-6 py-4 font-medium">Tanggal</th>
                        <th scope="col" class="px-6 py-4 font-medium">Guru</th>
                        <th scope="col" class="px-6 py-4 font-medium">Jumlah</th>
                        <th scope="col" class="px-6 py-4 font-medium">Status</th>
                        <th scope="col" class="px-6 py-4 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody" class="divide-y divide-gray-200 dark:divide-gray-600">
                    <!-- Data will be populated by JavaScript -->
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
    <div class="flex items-center justify-between">
        <div class="text-sm text-gray-700 dark:text-gray-300">
            Menampilkan <span class="font-medium">1</span> sampai <span class="font-medium">3</span> dari <span class="font-medium">3</span> hasil
        </div>
        <div class="flex items-center space-x-2">
            <button class="px-3 py-1 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-200">
                Sebelumnya
            </button>
            <button class="px-3 py-1 text-sm bg-blue-600 text-white rounded-lg">1</button>
            <button class="px-3 py-1 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-200">
                Selanjutnya
            </button>
        </div>
    </div>
</div>

    </div>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="relative bg-white dark:bg-gray-700 rounded-lg shadow-sm w-full max-w-2xl mx-4">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-200 dark:border-gray-600">
                <h3 id="modalTitle" class="text-xl font-semibold text-gray-900 dark:text-white">
                    Tambah Kunjungan UKS
                </h3>
                <button type="button" onclick="closeModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
            <!-- Modal body -->
            <form id="form" class="p-4 md:p-5 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Siswa</label>
                        <input type="text" id="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Masukkan nama siswa" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kelas</label>
                        <input type="text" id="kelas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Masukkan kelas" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Diagnosa</label>
                        <input type="text" id="diagnosa" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Masukkan diagnosa" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Obat</label>
                        <input type="text" id="obat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Masukkan obat" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal</label>
                        <input type="date" id="tanggal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Guru</label>
                        <input type="text" id="guru" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Masukkan nama guru" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Obat</label>
                        <input type="number" id="jumlah_obat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Masukkan jumlah" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                        <select id="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                            <option value="">Pilih Status</option>
                            <option value="Kembali ke Kelas">Kembali ke Kelas</option>
                            <option value="Istirahat di UKS">Istirahat di UKS</option>
                            <option value="Pulang">Pulang</option>
                        </select>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan</button>
                    <button type="button" onclick="closeModal()" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    let siswaData = [];
    let editIndex = null;

    function renderTable() {
        const tbody = document.getElementById('tableBody');
        tbody.innerHTML = '';
        siswaData.forEach((data, index) => {
            const statusColor =
                data.status === 'Kembali ke Kelas' ? 'green' :
                data.status === 'Istirahat di UKS' ? 'yellow' : 'red';
            tbody.innerHTML += `
                <tr class="bg-white hover:bg-gray-50 dark:bg-gray-200 dark:hover:bg-gray-300 transition duration-200">
    <td class="px-6 py-4 font-medium text-gray-700 dark:text-gray-800">${index + 1}</td>
    <td class="px-6 py-4 font-medium text-gray-700 dark:text-gray-800">${data.nama}</td>
    <td class="px-6 py-4 font-medium text-gray-700 dark:text-gray-800">${data.kelas}</td>
    <td class="px-6 py-4 font-medium text-gray-700 dark:text-gray-800">${data.diagnosa}</td>
    <td class="px-6 py-4 font-medium text-gray-700 dark:text-gray-800">${data.obat}</td>
    <td class="px-6 py-4 font-medium text-gray-700 dark:text-gray-800">${data.tanggal}</td>
    <td class="px-6 py-4 font-medium text-gray-700 dark:text-gray-800">${data.guru}</td>
    <td class="px-6 py-4 font-medium text-gray-700 dark:text-gray-800">${data.jumlah}</td>
    <td class="px-6 py-4">
        <span class="inline-block px-3 py-1 text-sm rounded-full bg-${statusColor}-100 text-${statusColor}-600 dark:bg-${statusColor}-200 dark:text-${statusColor}-700">
            ${data.status}
        </span>
    </td>
    <td class="px-6 py-4">
        <div class="flex items-center space-x-2">
            <button onclick="editData(${index})" 
                class="text-blue-600 hover:text-blue-900 dark:text-blue-700 dark:hover:text-blue-900 p-1 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-200 transition duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </button>
            <button onclick="deleteData(${index})" 
                class="text-red-600 hover:text-red-900 dark:text-red-700 dark:hover:text-red-900 p-1 rounded-lg hover:bg-red-50 dark:hover:bg-red-200 transition duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </div>
    </td>
</tr>
            `;
        });
    }

    function openModal() {
        document.getElementById('modal').classList.remove('hidden');
        document.getElementById('modalTitle').innerText = editIndex === null ? 'Tambah Kunjungan UKS' : 'Edit Kunjungan UKS';
        if (editIndex !== null) {
            const data = siswaData[editIndex];
            document.getElementById('nama').value = data.nama;
            document.getElementById('kelas').value = data.kelas;
            document.getElementById('diagnosa').value = data.diagnosa;
            document.getElementById('obat').value = data.obat;
            document.getElementById('tanggal').value = data.tanggal;
            document.getElementById('guru').value = data.guru;
            document.getElementById('jumlah_obat').value = data.jumlah;
            document.getElementById('status').value = data.status;
        } else {
            document.getElementById('form').reset();
        }
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
        editIndex = null;
    }

    function deleteData(index) {
        if (confirm("Yakin ingin menghapus data ini?")) {
            siswaData.splice(index, 1);
            renderTable();
        }
    }

    function editData(index) {
        editIndex = index;
        openModal();
    }

    document.getElementById('form').addEventListener('submit', function (e) {
        e.preventDefault();
        const newData = {
            nama: document.getElementById('nama').value,
            kelas: document.getElementById('kelas').value,
            diagnosa: document.getElementById('diagnosa').value,
            obat: document.getElementById('obat').value,
            tanggal: document.getElementById('tanggal').value,
            guru: document.getElementById('guru').value,
            jumlah: document.getElementById('jumlah_obat').value,
            status: document.getElementById('status').value,
        };
        if (editIndex === null) {
            siswaData.push(newData);
        } else {
            siswaData[editIndex] = newData;
            editIndex = null;
        }
        closeModal();
        renderTable();
    });

    // Inisialisasi awal
    renderTable();
    </script>

</body>
</x-app-layout>
</html>
