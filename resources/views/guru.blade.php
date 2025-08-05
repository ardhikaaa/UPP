<x-app-layout>
    <div class="container mx-auto p-4">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Data Guru</h1>
            <button onclick="openModal('modalAdd')"
                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                + Tambah Guru
            </button>
        </div>

        <!-- Table -->
        <div class="relative overflow-x-auto shadow-md rounded-lg p-4 bg-white dark:bg-gray-800">
            <table class="w-full text-sm text-left text-gray-700 dark:text-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-200 ">
                    <tr>
                        <th class="text-left py-2 px-4">No</th>
                        <th class="text-left py-2 px-4">Nama Guru</th>
                        <th class="text-left py-2 px-4">Mata Pelajaran</th>
                        <th class="text-left py-2 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                    @foreach ($gurus as $guru)
                        <tr class="bg-white sm:rounded-lg">
                            <td class="px-6 py-4 font-medium text-gray-900 ">
                                {{ $loop->iteration }}
                            </td>
                            <td class="py-6 px-4">{{ $guru->nama }}</td>
                            <td class="py-6 px-4">{{ $guru->mapel }}</td>
                            <td class="py-6 px-4 relative">
                                <button onclick="toggleDropdown({{ $guru->id }})"
                                    class="p-2 rounded-full hover:bg-gray-200">
                                    <!-- Icon titik 3 -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 7a2 2 0 110-4 2 2 0 010 4zm0 7a2 2 0 110-4 2 2 0 010 4zm0 7a2 2 0 110-4 2 2 0 010 4z" />
                                    </svg>
                                </button>

                                <!-- Dropdown -->
                                <div id="dropdown-{{ $guru->id }}"
                                    class="absolute right-2 mt-2 w-11 bg-white border rounded shadow hidden z-10">
                                    <button
                                        onclick="openEditModal({{ $guru->id }}, '{{ $guru->nama }}', '{{ $guru->mapel }}')"
                                        class="block w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-gray-100">
                                        Edit
                                    </button>
                                    <form action="{{ route('guru.destroy', $guru->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus?')"
                                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal Tambah -->
        <div id="modalAdd" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
            <div class="bg-white w-full max-w-md p-6 rounded shadow">
                <h2 class="text-lg font-bold mb-4">Tambah Data Guru</h2>
                <form action="{{ route('guru.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-1">Nama Guru</label>
                        <input type="text" name="nama" required class="w-full border px-3 py-2 rounded" />
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Mata Pelajaran</label>
                        <input type="text" name="mapel" required class="w-full border px-3 py-2 rounded" />
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
                <h2 class="text-lg font-bold mb-4">Edit Data Guru</h2>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block mb-1">Nama Guru</label>
                        <input type="text" name="nama" id="editNama" required
                            class="w-full border px-3 py-2 rounded" />
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Mata Pelajaran</label>
                        <input type="text" name="mapel" id="editMapel" required
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

            function openEditModal(id, nama, mapel) {
                const form = document.getElementById('editForm');
                form.action = `/guru/${id}`;
                document.getElementById('editNama').value = nama;
                document.getElementById('editMapel').value = mapel;
                openModal('modalEdit');
            }
        </script>
    </div>
</x-app-layout>
