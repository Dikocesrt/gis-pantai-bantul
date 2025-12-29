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

    <!-- Toast Notification for Success -->
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

    <!-- Toast Notification for Errors -->
    @if (session('error') || $errors->any())
        <div id="errorToast"
            class="fixed top-6 right-6 z-[200] transform translate-x-[400px] transition-transform duration-500 ease-out max-w-md">
            <div class="bg-white rounded-xl shadow-2xl border-l-4 border-red-500 p-4">
                <div class="flex items-start gap-3">
                    <div class="bg-red-100 p-2 rounded-lg shrink-0">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 max-h-[400px] overflow-y-auto">
                        <h4 class="text-sm font-bold text-gray-900 mb-1">Gagal!</h4>
                        @if (session('error'))
                            <p class="text-sm text-gray-600">{{ Str::limit(session('error'), 200) }}</p>
                        @endif
                        @if ($errors->any())
                            <div class="text-sm text-gray-600 space-y-1 mt-2">
                                @foreach ($errors->all() as $error)
                                    <p>• {{ $error }}</p>
                                @endforeach
                            </div>
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
            showToast('errorToast');
        </script>
    @endif

    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('tempat-wisata.index') }}" class="text-gray-600 hover:text-gray-900 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="text-3xl font-bold text-gray-900">Tambah Tempat Wisata</h2>
        </div>
        <p class="text-gray-600 ml-9">Lengkapi form untuk menambahkan tempat wisata baru</p>
    </div>

    <form action="{{ route('tempat-wisata.store') }}" method="POST" enctype="multipart/form-data" id="tempatWisataForm">
        @csrf

        <!-- Tabs Navigation -->
        <div class="bg-white rounded-t-xl shadow-lg border-b border-gray-200">
            <div class="flex overflow-x-auto">
                <button type="button" onclick="switchTab(0)"
                    class="tab-button flex-1 px-6 py-4 text-sm font-semibold transition-all duration-200 border-b-2 border-emerald-500 text-emerald-600 bg-emerald-50">
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Informasi Dasar</span>
                    </div>
                </button>
                <button type="button" onclick="switchTab(1)"
                    class="tab-button flex-1 px-6 py-4 text-sm font-semibold transition-all duration-200 border-b-2 border-transparent text-gray-600 hover:text-gray-900 hover:bg-gray-50">
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Lokasi & Kontak</span>
                    </div>
                </button>
                <button type="button" onclick="switchTab(2)"
                    class="tab-button flex-1 px-6 py-4 text-sm font-semibold transition-all duration-200 border-b-2 border-transparent text-gray-600 hover:text-gray-900 hover:bg-gray-50">
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>Fasilitas & Gambar</span>
                    </div>
                </button>
                <button type="button" onclick="switchTab(3)"
                    class="tab-button flex-1 px-6 py-4 text-sm font-semibold transition-all duration-200 border-b-2 border-transparent text-gray-600 hover:text-gray-900 hover:bg-gray-50">
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Jam Operasional</span>
                    </div>
                </button>
            </div>
        </div>

        <!-- Tab Contents -->
        <div class="bg-white rounded-b-xl shadow-lg p-8">
            <!-- Tab 1: Informasi Dasar -->
            <div class="tab-content">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Informasi Dasar Tempat Wisata</h3>

                <div class="grid grid-cols-1 gap-6">
                    <!-- Nama Tempat -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Tempat Wisata <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition"
                            placeholder="Contoh: Pantai Parangtritis">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tipe Tempat -->
                    <div>
                        <label for="tipe_tempat_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tipe Tempat <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            @foreach ($tipeTempats as $tipe)
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="tipe_tempat_id" value="{{ $tipe->id }}"
                                        {{ old('tipe_tempat_id') == $tipe->id ? 'checked' : '' }} class="peer sr-only"
                                        required>
                                    <div
                                        class="flex flex-col items-center gap-2 p-4 border-2 border-gray-300 rounded-lg transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-50 hover:border-emerald-300">
                                        <img src="{{ $tipe->icon_url }}" alt="{{ $tipe->name }}"
                                            class="w-12 h-12 object-contain">
                                        <span class="text-sm font-medium text-gray-700">{{ $tipe->name }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('tipe_tempat_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea id="description" name="description" rows="5"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition"
                            placeholder="Deskripsikan tempat wisata ini...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Aktif -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Status Publikasi
                        </label>
                        <div class="flex items-center gap-6">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="is_active" value="1"
                                    {{ old('is_active', '1') == '1' ? 'checked' : '' }} class="peer sr-only">
                                <div
                                    class="flex items-center gap-3 px-6 py-4 border-2 border-gray-300 rounded-lg transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-50 hover:border-emerald-300">
                                    <div class="bg-emerald-100 peer-checked:bg-emerald-500 p-2 rounded-full transition">
                                        <svg class="w-5 h-5 text-emerald-600 peer-checked:text-white" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">Aktif</p>
                                        <p class="text-xs text-gray-600">Tampilkan di aplikasi</p>
                                    </div>
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="is_active" value="0"
                                    {{ old('is_active') == '0' ? 'checked' : '' }} class="peer sr-only">
                                <div
                                    class="flex items-center gap-3 px-6 py-4 border-2 border-gray-300 rounded-lg transition-all peer-checked:border-gray-500 peer-checked:bg-gray-50 hover:border-gray-400">
                                    <div class="bg-gray-100 peer-checked:bg-gray-500 p-2 rounded-full transition">
                                        <svg class="w-5 h-5 text-gray-600 peer-checked:text-white" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">Tidak Aktif</p>
                                        <p class="text-xs text-gray-600">Sembunyikan dari aplikasi</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('is_active')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Tab 2: Lokasi & Kontak -->
            <div class="tab-content hidden">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Lokasi & Informasi Kontak</h3>

                <div class="grid grid-cols-1 gap-6">
                    <!-- Alamat -->
                    <div>
                        <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                            Alamat Lengkap <span class="text-red-500">*</span>
                        </label>
                        <textarea id="address" name="address" rows="3" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition"
                            placeholder="Masukkan alamat lengkap...">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kecamatan -->
                    <div>
                        <label for="kecamatan_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Kecamatan <span class="text-red-500">*</span>
                        </label>
                        <select id="kecamatan_id" name="kecamatan_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition">
                            <option value="">Pilih Kecamatan</option>
                            @foreach ($kecamatans as $kecamatan)
                                <option value="{{ $kecamatan->id }}"
                                    {{ old('kecamatan_id') == $kecamatan->id ? 'selected' : '' }}>
                                    {{ $kecamatan->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('kecamatan_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Koordinat -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="latitude" class="block text-sm font-semibold text-gray-700 mb-2">
                                Latitude
                            </label>
                            <input type="text" id="latitude" name="latitude" value="{{ old('latitude') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition"
                                placeholder="-8.0123456">
                            @error('latitude')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="longitude" class="block text-sm font-semibold text-gray-700 mb-2">
                                Longitude
                            </label>
                            <input type="text" id="longitude" name="longitude" value="{{ old('longitude') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition"
                                placeholder="110.0123456">
                            @error('longitude')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Nomor Telepon -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nomor Telepon
                        </label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition"
                            placeholder="08xxxxxxxxxx">
                        @error('phone')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Tab 3: Fasilitas & Gambar -->
            <div class="tab-content hidden">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Fasilitas & Gambar</h3>

                <!-- Fasilitas -->
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Fasilitas yang Tersedia
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach ($fasilitas as $item)
                            <label class="relative cursor-pointer">
                                <input type="checkbox" name="fasilitas[]" value="{{ $item->id }}"
                                    {{ in_array($item->id, old('fasilitas', [])) ? 'checked' : '' }} class="peer sr-only">
                                <div
                                    class="flex flex-col items-center gap-2 p-4 border-2 border-gray-300 rounded-lg transition-all peer-checked:border-teal-500 peer-checked:bg-teal-50 hover:border-teal-300">
                                    <img src="{{ $item->icon_url }}" alt="{{ $item->name }}"
                                        class="w-10 h-10 object-contain">
                                    <span class="text-xs font-medium text-gray-700 text-center">{{ $item->name }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Layanan -->
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Layanan yang Tersedia
                    </label>
                    <div class="space-y-3">
                        @foreach ($layanans as $item)
                            <div class="border-2 border-gray-300 rounded-lg p-4 hover:border-cyan-300 transition"
                                id="layanan_container_{{ $item->id }}">
                                <div class="flex items-start gap-4">
                                    <!-- Checkbox & Icon -->
                                    <label class="flex items-center gap-3 cursor-pointer flex-shrink-0">
                                        <input type="checkbox" name="layanans[]" value="{{ $item->id }}"
                                            {{ in_array($item->id, old('layanans', [])) ? 'checked' : '' }}
                                            onchange="toggleLayananFields('{{ $item->id }}')"
                                            class="w-5 h-5 text-cyan-600 border-gray-300 rounded focus:ring-cyan-500">
                                        <img src="{{ $item->icon_url }}" alt="{{ $item->name }}"
                                            class="w-10 h-10 object-contain">
                                        <span class="text-sm font-semibold text-gray-900">{{ $item->name }}</span>
                                    </label>

                                    <!-- Fields (hidden by default) -->
                                    <div id="layanan_fields_{{ $item->id }}"
                                        class="flex-1 grid grid-cols-1 md:grid-cols-4 gap-3 {{ in_array($item->id, old('layanans', [])) ? '' : 'hidden' }}">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Harga</label>
                                            <input type="number" name="layanan_price[{{ $item->id }}]"
                                                value="{{ old('layanan_price.' . $item->id) }}" min="0"
                                                placeholder="0"
                                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Satuan</label>
                                            <input type="text" name="layanan_price_unit[{{ $item->id }}]"
                                                value="{{ old('layanan_price_unit.' . $item->id) }}"
                                                placeholder="per jam"
                                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Durasi</label>
                                            <input type="text" name="layanan_duration[{{ $item->id }}]"
                                                value="{{ old('layanan_duration.' . $item->id) }}" placeholder="1 jam"
                                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                                            <select name="layanan_is_available[{{ $item->id }}]"
                                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none">
                                                <option value="1"
                                                    {{ old('layanan_is_available.' . $item->id, '1') == '1' ? 'selected' : '' }}>
                                                    Tersedia</option>
                                                <option value="0"
                                                    {{ old('layanan_is_available.' . $item->id) == '0' ? 'selected' : '' }}>
                                                    Tidak Tersedia</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Upload Gambar -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Upload Gambar (Maksimal 5 gambar)
                    </label>
                    <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-3 mb-4">
                        <p class="text-sm text-emerald-700 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Klik ikon bintang untuk menandai gambar utama</span>
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @for ($i = 0; $i < 5; $i++)
                            <div class="relative">
                                <div class="border-2 border-dashed border-gray-300 rounded-lg overflow-hidden hover:border-emerald-500 transition"
                                    style="aspect-ratio: 4/3;">
                                    <input type="file" id="image_{{ $i }}" name="images[]"
                                        accept="image/*" onchange="previewImage({{ $i }})" class="hidden">

                                    <div id="placeholder_{{ $i }}"
                                        class="w-full h-full flex flex-col items-center justify-center cursor-pointer bg-gray-50 hover:bg-gray-100 transition"
                                        onclick="document.getElementById('image_{{ $i }}').click()">
                                        <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <p class="text-sm text-gray-600 font-medium">Gambar {{ $i + 1 }}</p>
                                        <p class="text-xs text-gray-500 mt-1">Klik untuk upload</p>
                                    </div>

                                    <div id="preview_{{ $i }}" class="hidden w-full h-full relative group">
                                        <img id="img_{{ $i }}" src="" alt="Preview"
                                            class="w-full h-full object-cover">

                                        <!-- Primary Image Radio Button -->
                                        <label class="absolute top-2 right-2 cursor-pointer z-10"
                                            title="Tandai sebagai gambar utama">
                                            <input type="radio" name="primary_image_index" value="{{ $i }}"
                                                {{ $i === 0 ? 'checked' : '' }} class="peer sr-only">
                                            <div
                                                class="bg-white peer-checked:bg-emerald-500 p-2 rounded-full shadow-lg transition hover:scale-110">
                                                <svg class="w-5 h-5 text-gray-400 peer-checked:text-white"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </label>

                                        <!-- Remove Button -->
                                        <button type="button" onclick="removeImage({{ $i }})"
                                            class="absolute top-2 left-2 bg-red-500 hover:bg-red-600 text-white p-2 rounded-full shadow-lg transition hover:scale-110 z-10"
                                            title="Hapus gambar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>

                                        <!-- Change Image Button -->
                                        <button type="button"
                                            onclick="document.getElementById('image_{{ $i }}').click()"
                                            class="absolute bottom-2 left-2 right-2 bg-black/70 hover:bg-black/80 text-white text-xs py-2 px-3 rounded transition opacity-0 group-hover:opacity-100">
                                            Ganti Gambar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Tab 4: Jam Operasional -->
            <div class="tab-content hidden">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Jam Operasional</h3>
                <p class="text-sm text-gray-600 mb-6">Isi jam buka dan tutup untuk setiap hari. Kosongkan jika tutup.</p>

                <div class="space-y-4">
                    @php
                        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                    @endphp
                    @foreach ($days as $index => $day)
                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                            <div class="w-24">
                                <span class="text-sm font-semibold text-gray-700">{{ $day }}</span>
                            </div>
                            <input type="hidden" name="opening_hours[{{ $index }}][day_of_week]"
                                value="{{ $index }}">
                            <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-3">
                                <div>
                                    <input type="time" name="opening_hours[{{ $index }}][open_time]"
                                        value="{{ old("opening_hours.{$index}.open_time") }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition text-sm">
                                </div>
                                <div>
                                    <input type="time" name="opening_hours[{{ $index }}][close_time]"
                                        value="{{ old("opening_hours.{$index}.close_time") }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition text-sm">
                                </div>
                                <div>
                                    <input type="text" name="opening_hours[{{ $index }}][note]"
                                        value="{{ old("opening_hours.{$index}.note") }}" placeholder="Catatan (opsional)"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition text-sm">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="bg-white rounded-xl shadow-lg p-6 mt-6 flex justify-between">
            <button type="button" id="prevBtn" onclick="changeTab(-1)"
                class="px-6 py-3 border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-semibold rounded-lg transition hidden">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Sebelumnya
                </div>
            </button>
            <div class="flex gap-3 ml-auto">
                <a href="{{ route('tempat-wisata.index') }}"
                    class="px-6 py-3 border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-semibold rounded-lg transition">
                    Batal
                </a>
                <button type="button" id="nextBtn" onclick="changeTab(1)"
                    class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition shadow-lg">
                    <div class="flex items-center gap-2">
                        Selanjutnya
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </div>
                </button>
                <button type="submit" id="submitBtn"
                    class="hidden px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition shadow-lg">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Simpan Data
                    </div>
                </button>
            </div>
        </div>
    </form>

    <script>
        let currentTab = 0;
        showTab(currentTab);

        // Debug: Log form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            console.log('Form is being submitted');
            console.log('Form data:', new FormData(this));
        });

        function showTab(n) {
            const tabs = document.getElementsByClassName("tab-content");
            const tabButtons = document.getElementsByClassName("tab-button");

            tabs[n].classList.remove("hidden");

            // Update tab button styles
            tabButtons[n].classList.remove("border-transparent", "text-gray-600", "hover:text-gray-900",
                "hover:bg-gray-50");
            tabButtons[n].classList.add("border-emerald-500", "text-emerald-600", "bg-emerald-50");

            // Update navigation buttons
            document.getElementById("prevBtn").classList.toggle("hidden", n === 0);
            document.getElementById("nextBtn").classList.toggle("hidden", n === tabs.length - 1);
            document.getElementById("submitBtn").classList.toggle("hidden", n !== tabs.length - 1);
        }

        function switchTab(n) {
            const tabs = document.getElementsByClassName("tab-content");
            const tabButtons = document.getElementsByClassName("tab-button");

            // Hide current tab
            tabs[currentTab].classList.add("hidden");
            tabButtons[currentTab].classList.remove("border-emerald-500", "text-emerald-600", "bg-emerald-50");
            tabButtons[currentTab].classList.add("border-transparent", "text-gray-600", "hover:text-gray-900",
                "hover:bg-gray-50");

            currentTab = n;
            showTab(currentTab);
        }

        function changeTab(direction) {
            const tabs = document.getElementsByClassName("tab-content");
            const newTab = currentTab + direction;

            if (newTab >= 0 && newTab < tabs.length) {
                // Validate current tab before moving forward
                if (direction > 0 && !validateCurrentTab()) {
                    return;
                }
                switchTab(newTab);
            }
        }

        function validateCurrentTab() {
            const tabs = document.getElementsByClassName("tab-content");
            const currentTabElement = tabs[currentTab];
            const requiredFields = currentTabElement.querySelectorAll('[required]');
            let isValid = true;
            let firstInvalidField = null;

            requiredFields.forEach(field => {
                // Remove previous error styling
                field.classList.remove('border-red-500');
                const errorMsg = field.parentElement.querySelector('.error-message');
                if (errorMsg) errorMsg.remove();

                // Check if field is valid
                if (!field.value || (field.type === 'radio' && !currentTabElement.querySelector(
                        `input[name="${field.name}"]:checked`))) {
                    isValid = false;
                    if (!firstInvalidField) firstInvalidField = field;

                    // Add error styling
                    field.classList.add('border-red-500');

                    // Add error message
                    const errorDiv = document.createElement('p');
                    errorDiv.className = 'error-message mt-2 text-sm text-red-600';
                    errorDiv.textContent = 'Field ini wajib diisi';
                    field.parentElement.appendChild(errorDiv);
                }
            });

            // Check radio buttons for tipe_tempat
            if (currentTab === 0) {
                const tipeTempatChecked = currentTabElement.querySelector('input[name="tipe_tempat_id"]:checked');
                if (!tipeTempatChecked) {
                    isValid = false;
                    const tipeTempatContainer = currentTabElement.querySelector('input[name="tipe_tempat_id"]').closest(
                        'div').parentElement;
                    const existingError = tipeTempatContainer.querySelector('.error-message');
                    if (!existingError) {
                        const errorDiv = document.createElement('p');
                        errorDiv.className = 'error-message mt-2 text-sm text-red-600';
                        errorDiv.textContent = 'Silakan pilih tipe tempat';
                        tipeTempatContainer.appendChild(errorDiv);
                    }
                }
            }

            if (!isValid && firstInvalidField) {
                firstInvalidField.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }

            return isValid;
        }

        // Form submission validation
        document.getElementById('tempatWisataForm').addEventListener('submit', function(e) {
            if (!validateCurrentTab()) {
                e.preventDefault();
                return false;
            }
        });

        function previewImage(index) {
            const input = document.getElementById(`image_${index}`);
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById(`img_${index}`).src = e.target.result;
                    document.getElementById(`placeholder_${index}`).classList.add('hidden');
                    document.getElementById(`preview_${index}`).classList.remove('hidden');
                }

                reader.readAsDataURL(file);
            }
        }

        function removeImage(index) {
            const input = document.getElementById(`image_${index}`);
            input.value = '';

            document.getElementById(`img_${index}`).src = '';
            document.getElementById(`placeholder_${index}`).classList.remove('hidden');
            document.getElementById(`preview_${index}`).classList.add('hidden');

            // If this was the primary image, set the first available image as primary
            const radio = document.querySelector(`input[name="primary_image_index"][value="${index}"]`);
            if (radio && radio.checked) {
                // Find first image that has a file
                for (let i = 0; i < 5; i++) {
                    const otherInput = document.getElementById(`image_${i}`);
                    if (otherInput.files.length > 0) {
                        document.querySelector(`input[name="primary_image_index"][value="${i}"]`).checked = true;
                        break;
                    }
                }
            }
        }

        function toggleLayananFields(layananId) {
            const checkbox = document.querySelector(`input[name="layanans[]"][value="${layananId}"]`);
            const fields = document.getElementById(`layanan_fields_${layananId}`);
            const container = document.getElementById(`layanan_container_${layananId}`);

            if (checkbox.checked) {
                fields.classList.remove('hidden');
                container.classList.add('border-cyan-500', 'bg-cyan-50');
                container.classList.remove('border-gray-300');
            } else {
                fields.classList.add('hidden');
                container.classList.remove('border-cyan-500', 'bg-cyan-50');
                container.classList.add('border-gray-300');

                // Clear field values when unchecked
                fields.querySelectorAll('input, select').forEach(input => {
                    if (input.type === 'number') {
                        input.value = '';
                    } else if (input.tagName === 'SELECT') {
                        input.value = '1';
                    } else {
                        input.value = '';
                    }
                });
            }
        }
    </script>
@endsection
