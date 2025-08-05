<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Daftar Obat - CRUD Sederhana</title>
<script src="https://cdn.tailwindcss.com"></script>
<x-app-layout>
<style>
  body {
    background: #f9fafb;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  .badge-status {
    @apply inline-block px-3 py-1 rounded-full text-sm font-semibold;
  }
  .badge-kosong {
    @apply bg-red-200 text-red-700;
  }
  .badge-tersedia {
    @apply bg-green-200 text-green-700;
  }
  button {
    user-select: none;
  }
</style>
</head>
<body>
<main class="max-w-4xl mx-auto mt-16 px-4">
  <div class="flex items-center justify-between mb-5">
    <h1 class="text-2xl font-semibold text-gray-900 select-text">Daftar Obat</h1>
    <button id="addBtn" class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition-shadow shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400">+ Add</button>
  </div>

  <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
    <table class="min-w-full text-left border-collapse">
      <thead class="border-b border-gray-300 bg-gray-50">
        <tr>
          <th class="px-6 py-3 w-2/5 font-medium text-gray-700 cursor-pointer select-none">Nama Obat</th>
          <th class="px-6 py-3 w-1/5 font-medium text-gray-700 cursor-pointer select-none">Jumlah</th>
          <th class="px-6 py-3 w-1/5 font-medium text-gray-700 cursor-pointer select-none">Status</th>
          <th class="px-6 py-3 w-1/5 font-medium text-gray-700 select-none">Aksi</th>
        </tr>
      </thead>
      <tbody id="tableBody" class="divide-y divide-gray-200">
        <!-- Rows inserted here by JS -->
      </tbody>
    </table>
  </div>
  </x-app-layout>
</main>

<script>
(() => {
  const tableBody = document.getElementById('tableBody');
  const addBtn = document.getElementById('addBtn');

  // Initial data example
  let obatList = [
    { id: 1, nama: 'Paracetamol', jumlah: 100, status: 'Kosong' },
    { id: 2, nama: 'Paracetamol', jumlah: 100, status: 'Tersedia' }
  ];
  let idCounter = 3;

  // Status options for editing
  const statusOptions = ['Kosong', 'Tersedia'];

  // Render table from obatList
  function renderTable() {
    tableBody.innerHTML = '';
    obatList.forEach(obat => {
      const tr = document.createElement('tr');

      // Nama Obat column
      const namaTd = document.createElement('td');
      namaTd.className = 'px-6 py-4 font-normal text-gray-900';

      // Jumlah column
      const jumlahTd = document.createElement('td');
      jumlahTd.className = 'px-6 py-4 font-normal text-gray-900';

      // Status column
      const statusTd = document.createElement('td');
      statusTd.className = 'px-6 py-4';

      // Aksi column (buttons)
      const aksiTd = document.createElement('td');
      aksiTd.className = 'px-6 py-4 flex gap-2';

      if (obat.editing) {
        // Editing state: Input fields for nama, jumlah, status > select
        const namaInput = document.createElement('input');
        namaInput.type = 'text';
        namaInput.value = obat.nama || '';
        namaInput.placeholder = "Nama Obat";
        namaInput.className = "w-full border border-gray-300 rounded px-3 py-1 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400";

        const jumlahInput = document.createElement('input');
        jumlahInput.type = 'number';
        jumlahInput.min = '0';
        jumlahInput.value = obat.jumlah !== null && obat.jumlah !== undefined ? obat.jumlah : '';
        jumlahInput.placeholder = "Jumlah";
        jumlahInput.className = "w-full border border-gray-300 rounded px-3 py-1 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400";

        const statusSelect = document.createElement('select');
        statusSelect.className = "w-full border border-gray-300 rounded px-3 py-1 text-gray-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-400";
        statusOptions.forEach(opt => {
          const option = document.createElement('option');
          option.value = opt;
          option.textContent = opt;
          if (opt === obat.status) option.selected = true;
          statusSelect.appendChild(option);
        });

        namaTd.appendChild(namaInput);
        jumlahTd.appendChild(jumlahInput);
        statusTd.appendChild(statusSelect);

        // Save button
        const saveBtn = document.createElement('button');
        saveBtn.textContent = 'Save';
        saveBtn.className = 'bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400';
        saveBtn.onclick = () => {
          // Validate inputs for nama and jumlah
          const newNama = namaInput.value.trim();
          const newJumlahRaw = jumlahInput.value.trim();
          const newJumlah = newJumlahRaw === '' ? null : parseInt(newJumlahRaw, 10);
          const newStatus = statusSelect.value;

          if (newNama === '') {
            alert('Nama Obat tidak boleh kosong.');
            namaInput.focus();
            return;
          }
          if (newJumlahRaw !== '' && (isNaN(newJumlah) || newJumlah < 0)) {
            alert('Jumlah harus angka positif atau 0.');
            jumlahInput.focus();
            return;
          }

          obat.nama = newNama;
          obat.jumlah = newJumlahRaw === '' ? 0 : newJumlah;
          obat.status = newStatus;
          delete obat.editing;
          renderTable();
        };

        // Cancel button
        const cancelBtn = document.createElement('button');
        cancelBtn.textContent = 'Cancel';
        cancelBtn.className = 'bg-gray-300 text-gray-700 px-3 py-1 rounded hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400';
        cancelBtn.onclick = () => {
          // If new row was added and canceled without save, remove row entirely
          if (obat.isNew) {
            obatList = obatList.filter(o => o.id !== obat.id);
          } else {
            delete obat.editing;
          }
          renderTable();
        };

        aksiTd.appendChild(saveBtn);
        aksiTd.appendChild(cancelBtn);

      } else {
        // Display mode with text & badges

        // Nama Obat text
        namaTd.textContent = obat.nama;

        // Jumlah text, formatted or empty for 0 or null
        jumlahTd.textContent = (obat.jumlah !== null && obat.jumlah !== undefined) ? obat.jumlah : '';

        // Status badge with color depending on value
        const spanStatus = document.createElement('span');
        spanStatus.className = 'badge-status ' + (obat.status === 'Kosong' ? 'badge-kosong' : 'badge-tersedia');
        spanStatus.textContent = obat.status;
        statusTd.appendChild(spanStatus);

        // Buttons Hapus and Edit
        const hapusBtn = document.createElement('button');
        hapusBtn.textContent = 'Hapus';
        hapusBtn.className = 'bg-red-200 text-red-700 px-3 py-1 rounded hover:bg-red-300 focus:outline-none focus:ring-2 focus:ring-red-400';
        hapusBtn.onclick = () => {
          if (confirm('Apakah Anda yakin ingin menghapus baris ini?')) {
            obatList = obatList.filter(o => o.id !== obat.id);
            renderTable();
          }
        };

        const editBtn = document.createElement('button');
        editBtn.textContent = 'Edit';
        editBtn.className = 'bg-indigo-200 text-indigo-700 px-3 py-1 rounded hover:bg-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-400';
        editBtn.onclick = () => {
          obat.editing = true;
          renderTable();
        };

        aksiTd.appendChild(hapusBtn);
        aksiTd.appendChild(editBtn);
      }

      tr.appendChild(namaTd);
      tr.appendChild(jumlahTd);
      tr.appendChild(statusTd);
      tr.appendChild(aksiTd);
      tableBody.appendChild(tr);
    });
  }

  addBtn.onclick = () => {
    // Add a new empty row in editing mode on top
    const newObat = {
      id: idCounter++,
      nama: '',
      jumlah: null,
      status: 'Kosong',
      editing: true,
      isNew: true
    };
    obatList.unshift(newObat);
    renderTable();
  };

  // Initial render
  renderTable();
})();
</script>
</body>
</html>

