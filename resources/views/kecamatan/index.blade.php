@extends('layouts.dashboard')

@section('content')
    <script>
        function showToast(toastId) {
            setTimeout(() => {
                const toast = document.getElementById(toastId);
                if (toast) {
                    toast.classList.remove('translate-x-[400px]');
                    toast.classList.add('translate-x-0');
                    console.log('Toast shown:', toastId);
                }
            }, 100);

            setTimeout(() => {
                closeToast(toastId);
            }, 5000);
        }

        function closeToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.classList.remove('translate-x-0');
                toast.classList.add('translate-x-[400px]');
                setTimeout(() => {
                    toast.remove();
                }, 500);
            }
        }
    </script>

    @if (session('success'))
        <div id="successToast"
            class="fixed top-6 right-6 z-[200] transform translate-x-[400px] transition-transform duration-500 ease-out">
            <div class="bg-white rounded-xl shadow-2xl border-l-4 border-emerald-500 p-4 min-w-[320px] max-w-md">
                <div class="flex items-start gap-3">
                    <div class="bg-emerald-100 p-2 rounded-lg shrink-0">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-gray-900 mb-1">Berhasil!</h4>
                        <p class="text-sm text-gray-600">{{ session('success') }}</p>
                    </div>
                    <button onclick="closeToast('successToast')"
                        class="text-gray-400 hover:text-gray-600 transition shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <script>
            showToast('successToast');
        </script>
    @endif

    @if (session('error') || $errors->any())
        <div id="errorToast"
            class="fixed top-6 right-6 z-[200] transform translate-x-[400px] transition-transform duration-500 ease-out">
            <div class="bg-white rounded-xl shadow-2xl border-l-4 border-red-500 p-4 min-w-[320px] max-w-md">
                <div class="flex items-start gap-3">
                    <div class="bg-red-100 p-2 rounded-lg shrink-0">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-gray-900 mb-1">Gagal!</h4>
                        @if (session('error'))
                            <p class="text-sm text-gray-600">{{ session('error') }}</p>
                        @endif
                        @if ($errors->any())
                            <ul class="text-sm text-gray-600 space-y-1 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <button onclick="closeToast('errorToast')"
                        class="text-gray-400 hover:text-gray-600 transition shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <script>
            const createModal = document.getElementById('createModal');
            const editModal = document.getElementById('editModal');
            const deleteModal = document.getElementById('deleteModal');

            if (createModal) createModal.classList.add('hidden');
            if (editModal) editModal.classList.add('hidden');
            if (deleteModal) deleteModal.classList.add('hidden');

            showToast('errorToast');
        </script>
    @endif

    <!-- Stats Card -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div
            class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-emerald-500 hover:shadow-xl transition-all duration-200">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-2">Total Kecamatan</p>
                    <h3 class="text-4xl font-bold text-gray-900">{{ $kecamatans->count() }}</h3>
                </div>
                <div class="bg-emerald-50 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div
            class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-teal-500 hover:shadow-xl transition-all duration-200">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-2">Ditambahkan Hari Ini</p>
                    <h3 class="text-4xl font-bold text-gray-900">
                        {{ $kecamatans->where('created_at', '>=', now()->startOfDay())->count() }}</h3>
                </div>
                <div class="bg-teal-50 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div
            class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-cyan-500 hover:shadow-xl transition-all duration-200">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-2">Terakhir Diperbarui</p>
                    <h3 class="text-lg font-bold text-gray-900">
                        {{ $kecamatans->first()?->updated_at?->diffForHumans() ?? 'Belum ada data' }}</h3>
                </div>
                <div class="bg-cyan-50 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Daftar Kecamatan</h3>
                <p class="text-gray-600 text-sm mt-1">Kelola semua data kecamatan</p>
            </div>
            <button onclick="openCreateModal()"
                class="inline-flex items-center gap-2 px-4 py-2 bg-linear-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                Tambah Kecamatan
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama
                            Kecamatan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Dibuat Oleh</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Tanggal Dibuat</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($kecamatans as $index => $kecamatan)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="bg-emerald-100 p-2 rounded-lg">
                                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900">{{ $kecamatan->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $kecamatan->creator?->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $kecamatan->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <button onclick='openEditModal(@json($kecamatan))'
                                        class="inline-flex items-center gap-1 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg transition-all duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                        Edit
                                    </button>
                                    <button onclick='openDeleteModal(@json($kecamatan))'
                                        class="inline-flex items-center gap-1 px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-lg transition-all duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                        </path>
                                    </svg>
                                    <p class="text-gray-600 font-medium">Belum ada data kecamatan</p>
                                    <p class="text-gray-500 text-sm mt-1">Klik tombol "Tambah Kecamatan" untuk menambahkan
                                        data</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Modal -->
    <div id="createModal" class="hidden fixed inset-0 bg-black/80 z-[100] flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all relative z-[101]">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-gray-900">Tambah Kecamatan</h3>
                    <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <form action="{{ route('kecamatan.store') }}" method="POST" class="p-6">
                @csrf
                <div class="mb-6">
                    <label for="create_name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Kecamatan
                    </label>
                    <input type="text" id="create_name" name="name" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition"
                        placeholder="Contoh: Srandakan">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeCreateModal()"
                        class="flex-1 px-4 py-3 border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-semibold rounded-lg transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-3 bg-linear-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-semibold rounded-lg transition shadow-lg">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="hidden fixed inset-0 bg-black/80 z-[100] flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all relative z-[101]">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-gray-900">Edit Kecamatan</h3>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <form id="editForm" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <div class="mb-6">
                    <label for="edit_name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Kecamatan
                    </label>
                    <input type="text" id="edit_name" name="name" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeEditModal()"
                        class="flex-1 px-4 py-3 border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-semibold rounded-lg transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-3 bg-linear-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg transition shadow-lg">
                        Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black/80 z-[100] flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all relative z-[101]">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-gray-900">Hapus Kecamatan</h3>
                    <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <form id="deleteForm" method="POST" class="p-6">
                @csrf
                @method('DELETE')
                <div class="mb-6">
                    <div class="flex items-center gap-4 p-4 bg-red-50 rounded-lg">
                        <div class="bg-red-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Apakah Anda yakin?</p>
                            <p class="text-sm text-gray-600 mt-1">Data kecamatan "<span id="delete_name"
                                    class="font-semibold"></span>" akan dihapus permanen.</p>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-3 border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-semibold rounded-lg transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition shadow-lg">
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
        }

        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
        }

        function openEditModal(kecamatan) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('edit_name').value = kecamatan.name;
            document.getElementById('editForm').action = `/kecamatan/${kecamatan.id}`;
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function openDeleteModal(kecamatan) {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('delete_name').textContent = kecamatan.name;
            document.getElementById('deleteForm').action = `/kecamatan/${kecamatan.id}`;
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('createModal').addEventListener('click', function(e) {
            if (e.target === this) closeCreateModal();
        });
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) closeEditModal();
        });
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });
    </script>
@endsection
