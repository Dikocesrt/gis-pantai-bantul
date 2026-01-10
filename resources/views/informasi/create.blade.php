@extends('layouts.dashboard')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('informasi.index') }}"
                    class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </a>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Tambah Informasi Baru</h1>
            <p class="text-gray-600 mt-2">Tambahkan berita atau informasi event terbaru</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <form action="{{ route('informasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="p-6 space-y-6">
                    <!-- Judul -->
                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                            Judul <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition @error('title') border-red-500 @enderror"
                            placeholder="Contoh: Perayaan Tahun Baru di Pantai Parangtritis">
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi Singkat -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Deskripsi Singkat <span class="text-red-500">*</span>
                        </label>
                        <textarea id="description" name="description" rows="2" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition resize-none @error('description') border-red-500 @enderror"
                            placeholder="Ringkasan singkat (1-2 kalimat)">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konten -->
                    <div>
                        <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">
                            Konten <span class="text-red-500">*</span>
                        </label>
                        <textarea id="content" name="content" rows="8" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition resize-none @error('content') border-red-500 @enderror"
                            placeholder="Tulis konten lengkap di sini. Tekan Enter untuk membuat paragraf baru.">{{ old('content') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Paragraf akan otomatis diformat. Tidak perlu menggunakan tag
                            HTML.</p>
                        @error('content')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gambar -->
                    <div>
                        <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                            Gambar <span class="text-red-500">*</span>
                        </label>
                        <input type="file" id="image" name="image" accept="image/*" required
                            onchange="previewImage(event)"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition @error('image') border-red-500 @enderror">
                        <p class="text-xs text-gray-500 mt-1">Format: JPEG, JPG, PNG, GIF, WEBP. Maksimal 10 MB</p>
                        @error('image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <div id="image_preview" class="mt-3 hidden">
                            <img id="preview_img" src="" alt="Preview"
                                class="w-full max-w-md h-48 object-cover rounded-lg border-2 border-gray-200">
                        </div>
                    </div>

                    <!-- Toggle Event -->
                    <div class="border-t border-gray-200 pt-6">
                        <div class="flex items-center gap-3 mb-4">
                            <input type="checkbox" id="is_event" name="is_event" value="1"
                                {{ old('is_event') ? 'checked' : '' }} onchange="toggleEventFields()"
                                class="w-5 h-5 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                            <label for="is_event" class="text-sm font-semibold text-gray-700">
                                Ini adalah informasi event
                            </label>
                        </div>

                        <!-- Event Fields (Hidden by default) -->
                        <div id="event_fields" class="space-y-6 {{ old('is_event') ? '' : 'hidden' }}">
                            <!-- Event Location -->
                            <div>
                                <label for="event_location" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Lokasi Event <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="event_location" name="event_location"
                                    value="{{ old('event_location') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition @error('event_location') border-red-500 @enderror"
                                    placeholder="Contoh: Pantai Parangtritis">
                                @error('event_location')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Event Date -->
                            <div>
                                <label for="event_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tanggal Event <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="event_date" name="event_date" value="{{ old('event_date') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition @error('event_date') border-red-500 @enderror">
                                @error('event_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Event Time -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="event_start_time" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Jam Mulai <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" id="event_start_time" name="event_start_time"
                                        value="{{ old('event_start_time') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition @error('event_start_time') border-red-500 @enderror">
                                    @error('event_start_time')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="event_end_time" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Jam Selesai <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" id="event_end_time" name="event_end_time"
                                        value="{{ old('event_end_time') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition @error('event_end_time') border-red-500 @enderror">
                                    @error('event_end_time')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tempat Wisata (Optional) -->
                            <div>
                                <label for="tempat_wisata_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Terkait Tempat Wisata (Opsional)
                                </label>
                                <select id="tempat_wisata_id" name="tempat_wisata_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition @error('tempat_wisata_id') border-red-500 @enderror">
                                    <option value="">-- Pilih Tempat Wisata --</option>
                                    @foreach ($tempatWisatas as $tempat)
                                        <option value="{{ $tempat->id }}"
                                            {{ old('tempat_wisata_id') == $tempat->id ? 'selected' : '' }}>
                                            {{ $tempat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tempat_wisata_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex gap-3 justify-end">
                    <a href="{{ route('informasi.index') }}"
                        class="px-6 py-3 border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-semibold rounded-lg transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-semibold rounded-lg transition shadow-lg">
                        Simpan Informasi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('image_preview').classList.remove('hidden');
                    document.getElementById('preview_img').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }

        function toggleEventFields() {
            const isChecked = document.getElementById('is_event').checked;
            const eventFields = document.getElementById('event_fields');

            if (isChecked) {
                eventFields.classList.remove('hidden');
            } else {
                eventFields.classList.add('hidden');
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleEventFields();
        });
    </script>
@endsection
