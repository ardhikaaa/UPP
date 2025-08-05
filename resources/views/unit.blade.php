<x-app-layout>
    <div class="container mx-auto p-4">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Data Unit</h1>
            <button onclick="openModal('modalAdd')"
                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                + Tambah Unit
            </button>
        </div>

<!-- Tabel -->
<div class="relative overflow-x-auto shadow-md rounded-lg p-4 bg-white dark:bg-gray-800">
    <table class="w-full text-sm text-left text-gray-700 dark:text-gray-200">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-200">
            <tr>
                <th class="text-left py-2 px-4">Unit</th>
                <th class="text-left py-2 px-4">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
            @foreach ($units as $unit)
                <tr class="bg-white sm:rounded-lg">
                    <td class="py-4 px-4">{{ $unit->unit }}</td>
                    <td class="py-4 px-4 space-x-2">
                        <button
                            onclick="openEditModal({{ $unit->id }}, '{{ $unit->unit }}')"
                            class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-md">
                            Edit
                        </button>
                        <form action="{{ route('unit.destroy', $unit->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Yakin ingin menghapus?')"
                                class="inline-block bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded-md">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


        <!-- Modal Tambah -->
        <div id="modalAdd" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
            <div class="bg-white w-full max-w-md p-6 rounded shadow">
                <h2 class="text-lg font-bold mb-4">Tambah Data</h2>
                <form action="{{ route('unit.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-1">Unit</label>
                        <input type="text" name="unit" required class="w-full border px-3 py-2 rounded" />
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeModal('modalAdd')" class="px-4 py-2 bg-gray-300 rounded">
                            Tutup
                        </button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">
                            Tambah
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit -->
        <div id="modalEdit" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
            <div class="bg-white w-full max-w-md p-6 rounded shadow">
                <h2 class="text-lg font-bold mb-4">Edit Data</h2>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block mb-1">Unit</label>
                        <input type="text" name="unit" id="editUnit" required
                            class="w-full border px-3 py-2 rounded" />
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeModal('modalEdit')" class="px-4 py-2 bg-gray-300 rounded">
                            Tutup
                        </button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Script Modal -->
        <script>
            function toggleDropdown(id) {
                const dropdown = document.getElementById(`dropdown-${id}`);

                // Tutup semua dropdown lain dulu
                document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
                    if (el.id !== `dropdown-${id}`) el.classList.add('hidden');
                });

                // Toggle yang sedang diklik
                dropdown.classList.toggle('hidden');
            }

            // Tutup dropdown saat klik di luar
            document.addEventListener('click', function(event) {
                const dropdowns = document.querySelectorAll('[id^="dropdown-"]');
                dropdowns.forEach(drop => {
                    if (!drop.contains(event.target) && !drop.previousElementSibling.contains(event.target)) {
                        drop.classList.add('hidden');
                    }
                });
            });

            function openModal(id) {
                document.getElementById(id).classList.remove('hidden');
            }

            function closeModal(id) {
                document.getElementById(id).classList.add('hidden');
            }

            function openEditModal(id, unit) {
                const form = document.getElementById('editForm');
                form.action = `/unit/${id}`;
                document.getElementById('editUnit').value = unit;
                openModal('modalEdit');
            }
        </script>
    </div>
</x-app-layout>
