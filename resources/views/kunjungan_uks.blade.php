<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CRUD Status Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800">
    <div class="min-h-screen flex items-start justify-center pt-6 px-6">
        <main class="w-full max-w-7xl mt-0">
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-3xl font-bold">Status Siswa</h1>
                    <button onclick="openModal()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow">
                        + Tambah Siswa
                    </button>
                </div>

                <div class="flex items-center mb-4">
                    <input id="searchInput" type="text" placeholder="Cari siswa..."
                        class="w-1/3 border border-gray-300 rounded-lg py-2 px-4 focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                </div>

                <div class="overflow-x-auto rounded-lg border">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="bg-indigo-50 text-black-700 text-left text-sm uppercase">
                                <th class="py-3 px-4 border-b">Nama</th>
                                <th class="py-3 px-4 border-b">Kelas</th>
                                <th class="py-3 px-4 border-b">Diagnosa</th>
                                <th class="py-3 px-4 border-b">Obat</th>
                                <th class="py-3 px-4 border-b">Tanggal</th>
                                <th class="py-3 px-4 border-b">Guru</th>
                                <th class="py-3 px-4 border-b">Jumlah</th>
                                <th class="py-3 px-4 border-b">Status</th>
                                <th class="py-3 px-4 border-b text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="text-sm text-gray-700 text-center"></tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white border border-gray-200 rounded-2xl w-[90%] max-w-3xl shadow-2xl px-8 py-6 space-y-6">
            <h2 id="modalTitle" class="text-xl font-bold mb-4">Add Siswa</h2>
            <form id="form">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <input type="text" id="nama" placeholder="Nama Siswa"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        required>
                    <input type="text" id="kelas" placeholder="Kelas"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        required>
                    <input type="text" id="diagnosa" placeholder="Diagnosa"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        required>
                    <input type="text" id="obat" placeholder="Obat"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        required>
                    <input type="date" id="tanggal"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        required>
                    <input type="text" id="guru" placeholder="Guru"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        required>
                    <input type="number" id="jumlah_obat" placeholder="Jumlah Obat"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        required>
                    <select id="status"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        required>
                        <option value="">Pilih Status</option>
                        <option value="Kembali ke Kelas">Kembali ke Kelas</option>
                        <option value="Istirahat di UKS">Istirahat di UKS</option>
                        <option value="Pulang">Pulang</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeModal()"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-5 py-2 rounded-lg transition">Batal</button>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg shadow transition">Simpan</button>
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
          <tr class="hover:bg-gray-50 transition">
            <td class="py-2 px-4 border-b">${data.nama}</td>
            <td class="py-2 px-4 border-b">${data.kelas}</td>
            <td class="py-2 px-4 border-b">${data.diagnosa}</td>
            <td class="py-2 px-4 border-b">${data.obat}</td>
            <td class="py-2 px-4 border-b">${data.tanggal}</td>
            <td class="py-2 px-4 border-b">${data.guru}</td>
            <td class="py-2 px-4 border-b">${data.jumlah}</td>
            <td class="py-2 px-4 border-b">
              <span class="inline-block px-3 py-1 text-sm rounded-full bg-${statusColor}-100 text-${statusColor}-600">
                ${data.status}
              </span>
            </td>
            <td class="py-2 px-4 border-b">
              <div class="flex justify-center space-x-2">
                <button onclick="editData(${index})" class="text-indigo-600 hover:underline">Edit</button>
                <button onclick="deleteData(${index})" class="text-red-600 hover:underline">Hapus</button>
              </div>
            </td>
          </tr>
        `;
      });
    }

    function openModal() {
      document.getElementById('modal').classList.remove('hidden');
      document.getElementById('modalTitle').innerText = editIndex === null ? 'Tambah Siswa' : 'Edit Siswa';
      if (editIndex !== null) {
        const data = siswaData[editIndex];
        document.getElementById('nama').value = data.nama;
        document.getElementById('kelas').value = data.kelas;
        document.getElementById('diagnosa').value = data.diagnosa;
        document.getElementById('obat').value = data.obat;
        document.getElementById('tanggal').value = data.tanggal;
        document.getElementById('guru').value = data.guru;
        document.getElementById('jumlah').value = data.jumlah;
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
        jumlah: document.getElementById('jumlah').value,
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
</html>
