<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>CRUD Status Siswa</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
  <div class="flex min-h-screen">
    <main class="flex-1 p-10">
      <h1 class="text-3xl font-bold mb-6">Status Siswa</h1>
      <div class="flex justify-between items-center mb-4">
        <input id="searchInput" type="text" placeholder="Search" class="border border-gray-300 rounded py-2 px-4 w-1/3">
        <button onclick="openModal()" class="bg-indigo-600 text-white py-2 px-4 rounded">Add New</button>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full max-w-6xl bg-white border border-gray-200">
          <thead>
            <tr class="bg-gray-200 text-gray-700">
              <th class="py-2 px-4 border">Nama Siswa</th>
              <th class="py-2 px-4 border">Kelas</th>
              <th class="py-2 px-4 border">Diagnosa</th>
              <th class="py-2 px-4 border">Obat</th>
              <th class="py-2 px-4 border">Tanggal</th>
              <th class="py-2 px-4 border">Guru</th>
              <th class="py-2 px-4 border">Jumlah Obat</th>
              <th class="py-2 px-4 border">Status</th>
              <th class="py-2 px-4 border">Aksi</th>
            </tr>
          </thead>
          <tbody id="tableBody"></tbody>
        </table>
      </div>
    </main>
  </div>

  <!-- Modal -->
  <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
  <div class="bg-white p-8 rounded-xl w-[90%] max-w-3xl shadow-xl">
      <h2 id="modalTitle" class="text-xl font-bold mb-4">Add Siswa</h2>
      <form id="form" method="POST" action="{{ route('kunjungan-uks.index') }}">
  @csrf
        <div class="grid grid-cols-2 gap-4 mb-4">
          <input type="text" id="nama" placeholder="Nama Siswa" class="border p-2 rounded" required>
          <input type="text" id="kelas" placeholder="Kelas" class="border p-2 rounded" required>
          <input type="text" id="diagnosa" placeholder="Diagnosa" class="border p-2 rounded" required>
          <input type="text" id="obat" placeholder="Obat" class="border p-2 rounded" required>
          <input type="date" id="tanggal" class="border p-2 rounded" required>
          <input type="text" id="guru" placeholder="Guru" class="border p-2 rounded" required>
          <input type="number" id="jumlah_obat" placeholder="Jumlah Obat" class="border p-2 rounded" required>
          <select id="status" class="border p-2 rounded" required>
            <option value="">Pilih Status</option>
            <option value="Kembali ke Kelas">Kembali ke Kelas</option>
            <option value="Istirahat di UKS">Istirahat di UKS</option>
            <option value="Pulang">Pulang</option>
          </select>
        </div>
        <div class="flex justify-end space-x-2">
          <button type="button" onclick="closeModal()" class="bg-gray-300 px-4 py-2 rounded">Batal</button>
          <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Simpan</button>
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
          <tr class="border-b hover:bg-gray-100 text-center">
            <td class="py-2 px-4 border">${data.nama}</td>
            <td class="py-2 px-4 border">${data.kelas}</td>
            <td class="py-2 px-4 border">${data.diagnosa}</td>
            <td class="py-2 px-4 border">${data.obat}</td>
            <td class="py-2 px-4 border">${data.tanggal}</td>
            <td class="py-2 px-4 border">${data.guru}</td>
            <td class="py-2 px-4 border">${data.jumlah}</td>
            <td class="py-2 px-4 border">
              <span class="bg-${statusColor}-100 text-${statusColor}-600 px-3 py-1 rounded-full text-sm">${data.status}</span>
            </td>
            <td class="py-2 px-4 border">
              <div class="flex justify-center gap-2">
                <button onclick="editData(${index})" class="text-blue-600 hover:underline">Edit</button>
                <button onclick="deleteData(${index})" class="text-red-600 hover:underline">Delete</button>
              </div>
            </td>
          </tr>
        `;
      });
    }

    function openModal() {
      document.getElementById('modal').classList.remove('hidden');
      document.getElementById('modalTitle').innerText = editIndex === null ? 'Add Siswa' : 'Edit Siswa';
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

  const formData = {
    nama: document.getElementById('nama').value,
    kelas: document.getElementById('kelas').value,
    diagnosa: document.getElementById('diagnosa').value,
    obat: document.getElementById('obat').value,
    tanggal: document.getElementById('tanggal').value,
    guru: document.getElementById('guru').value,
    jumlah_obat: document.getElementById('jumlah_obat').value,
    status: document.getElementById('status').value,
  };

  fetch("/kunjungan-uks", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
    },
    body: JSON.stringify(formData),
  })
  .then((res) => {
    if (!res.ok) throw new Error("Gagal menyimpan");
    return res.json();
  })
  .then((data) => {
    alert("Data berhasil disimpan!");
    closeModal();
    location.reload(); // Atau bisa fetch ulang data untuk tampilkan tanpa reload
  })
  .catch((error) => {
    alert("Terjadi kesalahan: " + error.message);
  });
});


    // Inisialisasi awal
    renderTable();
  </script>
</body>
</html>
