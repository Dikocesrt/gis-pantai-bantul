@extends('layouts.dashboard')

@section('content')
    <script>
        function showToast(toastId) {
            setTimeout(() => {
                const toast = document.getElementById(toastId);
                if (toast) {
                    toast.classList.remove('translate-x-[400px]');
                    toast.classList.add('translate-x-0');
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

    @if (session('error'))
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
                        <p class="text-sm text-gray-600">{{ session('error') }}</p>
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
            showToast('errorToast');
        </script>
    @endif

    <!-- Stats Card -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div
            class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-emerald-500 hover:shadow-xl transition-all duration-200">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-2">Total Admin</p>
                    <h3 class="text-4xl font-bold text-gray-900">{{ $allAdmins->count() }}</h3>
                </div>
                <div class="bg-emerald-50 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div
            class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500 hover:shadow-xl transition-all duration-200">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-2">Menunggu Verifikasi</p>
                    <h3 class="text-4xl font-bold text-gray-900">{{ $pendingAdmins->count() }}</h3>
                </div>
                <div class="bg-yellow-50 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div
            class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-teal-500 hover:shadow-xl transition-all duration-200">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-2">Admin Terverifikasi</p>
                    <h3 class="text-4xl font-bold text-gray-900">{{ $verifiedAdmins->count() }}</h3>
                </div>
                <div class="bg-teal-50 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Admins Table -->
    @if ($pendingAdmins->count() > 0)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="bg-yellow-100 p-2 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Admin Menunggu Verifikasi</h3>
                        <p class="text-gray-600 text-sm mt-1">Verifikasi atau tolak registrasi admin baru</p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Email</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Nomor HP</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Tanggal Registrasi</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($pendingAdmins as $index => $admin)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold text-gray-900">{{ $admin->name }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $admin->email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $admin->phone ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $admin->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <button onclick='openVerifyModal(@json($admin))'
                                            class="inline-flex items-center gap-1 px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg transition-all duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Verifikasi
                                        </button>
                                        <button onclick='openRejectModal(@json($admin))'
                                            class="inline-flex items-center gap-1 px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-lg transition-all duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Tolak
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Verified Admins Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="bg-teal-100 p-2 rounded-lg">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Daftar Admin Terverifikasi</h3>
                    <p class="text-gray-600 text-sm mt-1">Kelola admin yang sudah terverifikasi</p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nomor
                            HP</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Diverifikasi Oleh</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Tanggal Verifikasi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($verifiedAdmins as $index => $admin)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold text-gray-900">{{ $admin->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $admin->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $admin->phone ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $admin->verifier?->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $admin->verified_at ? $admin->verified_at->format('d M Y, H:i') : '-' }}</td>
                            <td class="px-6 py-4">
                                @if (Auth::user()->role === 'super_admin')
                                    <button onclick='openDeleteModal(@json($admin))'
                                        class="inline-flex items-center gap-1 px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-lg transition-all duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                        Hapus
                                    </button>
                                @else
                                    <span class="text-xs text-gray-500 italic">Hanya Super Admin</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                        </path>
                                    </svg>
                                    <p class="text-gray-600 font-medium">Belum ada admin terverifikasi</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Verify Modal -->
    <div id="verifyModal" class="hidden fixed inset-0 bg-black/80 z-[100] flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all relative z-[101]">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-gray-900">Verifikasi Admin</h3>
                    <button onclick="closeVerifyModal()" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <form id="verifyForm" method="POST" class="p-6">
                @csrf
                <input type="hidden" name="verified_by" value="{{ auth()->id() }}">
                <div class="mb-6">
                    <div class="flex items-center gap-4 p-4 bg-emerald-50 rounded-lg">
                        <div class="bg-emerald-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Verifikasi admin ini?</p>
                            <p class="text-sm text-gray-600 mt-1">Admin "<span id="verify_name"
                                    class="font-semibold"></span>" akan dapat mengakses dashboard.</p>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeVerifyModal()"
                        class="flex-1 px-4 py-3 border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-semibold rounded-lg transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition shadow-lg">
                        Ya, Verifikasi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-black/80 z-[100] flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all relative z-[101]">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-gray-900">Tolak Registrasi</h3>
                    <button onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <form id="rejectForm" method="POST" class="p-6">
                @csrf
                <input type="hidden" name="reason" value="Ditolak oleh super admin">
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
                            <p class="text-sm font-semibold text-gray-900">Tolak registrasi ini?</p>
                            <p class="text-sm text-gray-600 mt-1">Admin "<span id="reject_name"
                                    class="font-semibold"></span>" akan dihapus dari sistem.</p>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeRejectModal()"
                        class="flex-1 px-4 py-3 border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-semibold rounded-lg transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition shadow-lg">
                        Ya, Tolak
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
                    <h3 class="text-2xl font-bold text-gray-900">Hapus Admin</h3>
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
                            <p class="text-sm text-gray-600 mt-1">Admin "<span id="delete_name"
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
        function openVerifyModal(admin) {
            document.getElementById('verifyModal').classList.remove('hidden');
            document.getElementById('verify_name').textContent = admin.name;
            document.getElementById('verifyForm').action = `/admin/${admin.id}/verify`;
        }

        function closeVerifyModal() {
            document.getElementById('verifyModal').classList.add('hidden');
        }

        function openRejectModal(admin) {
            document.getElementById('rejectModal').classList.remove('hidden');
            document.getElementById('reject_name').textContent = admin.name;
            document.getElementById('rejectForm').action = `/admin/${admin.id}/reject`;
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }

        function openDeleteModal(admin) {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('delete_name').textContent = admin.name;
            document.getElementById('deleteForm').action = `/admin/${admin.id}/delete`;
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('verifyModal').addEventListener('click', function(e) {
            if (e.target === this) closeVerifyModal();
        });
        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) closeRejectModal();
        });
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });
    </script>
@endsection
