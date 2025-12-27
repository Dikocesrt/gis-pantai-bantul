@extends('layouts.dashboard')

@section('content')
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
                            <div class="text-sm text-gray-600 space-y-1">
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

    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('tempat-wisata.index') }}" class="text-gray-600 hover:text-gray-900 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="text-3xl font-bold text-gray-900">Edit Tempat Wisata</h2>
        </div>
        <p class="text-gray-600 ml-9">Perbarui informasi tempat wisata</p>
    </div>

    <form action="{{ route('tempat-wisata.update', $tempatWisata->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

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
                        <input type="text" id="name" name="name"
                            value="{{ old('name', $tempatWisata->name) }}" required
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
                                        {{ old('tipe_tempat_id', $tempatWisata->tipe_tempat_id) == $tipe->id ? 'checked' : '' }}
                                        class="peer sr-only" required>
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
                            placeholder="Deskripsikan tempat wisata ini...">{{ old('description', $tempatWisata->description) }}</textarea>
                        @error('description')
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
                            placeholder="Masukkan alamat lengkap...">{{ old('address', $tempatWisata->address) }}</textarea>
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
                                    {{ old('kecamatan_id', $tempatWisata->kecamatan_id) == $kecamatan->id ? 'selected' : '' }}>
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
                            <input type="text" id="latitude" name="latitude"
                                value="{{ old('latitude', $tempatWisata->latitude) }}"
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
                            <input type="text" id="longitude" name="longitude"
                                value="{{ old('longitude', $tempatWisata->longitude) }}"
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
                        <input type="text" id="phone" name="phone"
                            value="{{ old('phone', $tempatWisata->phone) }}"
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
                                    {{ in_array($item->id, old('fasilitas', $tempatWisata->fasilitas->pluck('id')->toArray())) ? 'checked' : '' }}
                                    class="peer sr-only">
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

                <!-- TEMPORARY: Image features disabled for testing -->
                <!--
                                    @if ($tempatWisata->images->isNotEmpty())
    <div class="mb-8">
                                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                                Gambar Saat Ini
                                            </label>
                                            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                                                @foreach ($tempatWisata->images as $image)
    <div class="relative group">
                                                        <img src="{{ $image->image_url }}" alt="{{ $image->caption }}"
                                                            class="w-full h-32 object-cover rounded-lg border-2 border-gray-200">
                                                        @if ($image->is_primary)
    <div
                                                                class="absolute top-2 left-2 bg-emerald-500 text-white px-2 py-1 rounded text-xs font-semibold">
                                                                Utama
                                                            </div>
    @endif
                                                        <label class="absolute top-2 right-2 cursor-pointer">
                                                            <input type="checkbox" name="delete_images[]" value="{{ $image->id }}"
                                                                class="peer sr-only">
                                                            <div
                                                                class="bg-white peer-checked:bg-red-500 p-1.5 rounded-full shadow-lg transition">
                                                                <svg class="w-4 h-4 text-gray-400 peer-checked:text-white" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                    </path>
                                                                </svg>
                                                            </div>
                                                        </label>
                                                        @if ($image->caption)
    <div
                                                                class="absolute bottom-2 left-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded truncate">
                                                                {{ $image->caption }}
                                                            </div>
    @endif
                                                    </div>
    @endforeach
                                            </div>
                                            <p class="text-xs text-gray-500 mt-2">Centang ikon tempat sampah untuk menghapus gambar</p>
                                        </div>
    @endif
                                    -->

                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm text-blue-700">Fitur upload dan hapus gambar masih dalam pengembangan
                    </p>
                </div>

                <!-- TEMPORARY: Upload new images disabled for testing
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                                        Upload Gambar Baru (Maksimal 10 gambar)
                                    </label>
                                    <div
                                        class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-emerald-500 transition">
                                        <input type="file" id="images" name="images[]" multiple accept="image/*"
                                            onchange="previewImages(event)" class="hidden">
                                        <label for="images" class="cursor-pointer">
                                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <p class="text-sm text-gray-600 mb-1">Klik untuk upload gambar</p>
                                            <p class="text-xs text-gray-500">Format: JPEG, JPG, PNG, GIF, WEBP. Maksimal 10 MB per file</p>
                                        </label>
                                    </div>
                                    <div id="imagePreview" class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-4 hidden"></div>
                                </div>
                                -->
            </div>

            <!-- Tab 4: Jam Operasional -->
            <div class="tab-content hidden">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Jam Operasional</h3>
                <p class="text-sm text-gray-600 mb-6">Isi jam buka dan tutup untuk setiap hari. Kosongkan jika tutup.</p>

                <div class="space-y-4">
                    @php
                        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                        $existingHours = $tempatWisata->openingHours->keyBy('day_of_week');
                    @endphp
                    @foreach ($days as $index => $day)
                        @php
                            $hours = $existingHours->get($index);
                            // Format time to H:i (remove seconds if present)
                            $openTime = $hours && $hours->open_time ? substr($hours->open_time, 0, 5) : '';
                            $closeTime = $hours && $hours->close_time ? substr($hours->close_time, 0, 5) : '';
                        @endphp
                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                            <div class="w-24">
                                <span class="text-sm font-semibold text-gray-700">{{ $day }}</span>
                            </div>
                            <input type="hidden" name="opening_hours[{{ $index }}][day_of_week]"
                                value="{{ $index }}">
                            <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-3">
                                <div>
                                    <input type="time" name="opening_hours[{{ $index }}][open_time]"
                                        value="{{ old("opening_hours.{$index}.open_time", $openTime) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition text-sm">
                                </div>
                                <div>
                                    <input type="time" name="opening_hours[{{ $index }}][close_time]"
                                        value="{{ old("opening_hours.{$index}.close_time", $closeTime) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition text-sm">
                                </div>
                                <div>
                                    <input type="text" name="opening_hours[{{ $index }}][note]"
                                        value="{{ old("opening_hours.{$index}.note", $hours->note ?? '') }}"
                                        placeholder="Catatan (opsional)"
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
                        Perbarui Data
                    </div>
                </button>
            </div>
        </div>
    </form>

    <script>
        let currentTab = 0;
        showTab(currentTab);

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
                switchTab(newTab);
            }
        }

        function previewImages(event) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';
            preview.classList.remove('hidden');

            const files = event.target.files;

            for (let i = 0; i < Math.min(files.length, 10); i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative group';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg border-2 border-gray-200">
                        <label class="absolute top-2 right-2 cursor-pointer">
                            <input type="radio" name="primary_image_index" value="${i}"
                                class="peer sr-only">
                            <div class="bg-white peer-checked:bg-emerald-500 p-1.5 rounded-full shadow-lg transition">
                                <svg class="w-4 h-4 text-gray-400 peer-checked:text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </div>
                        </label>
                        <div class="absolute bottom-2 left-2">
                            <input type="text" name="captions[]" placeholder="Caption (opsional)"
                                class="text-xs px-2 py-1 bg-white/90 border border-gray-300 rounded">
                        </div>
                    `;
                    preview.appendChild(div);
                }

                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
