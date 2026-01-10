@extends('layouts.public')

@section('title', 'Beranda - Pantai Bantul')

@section('content')
    <!-- Hero Section with Description -->
    <section class="relative bg-white py-16 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                    Temukan Pesona Pantai <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-700">Bantul</span>
                </h1>
                <p class="text-lg text-gray-600 leading-relaxed mb-4">
                    Kabupaten Bantul memiliki garis pantai yang membentang sepanjang pesisir selatan Yogyakarta,
                    menawarkan keindahan alam yang memukau dengan pasir putih, ombak yang menantang, dan pemandangan
                    sunset yang spektakuler. Dari Pantai Parangtritis yang legendaris hingga pantai-pantai tersembunyi
                    yang menawan, setiap destinasi memiliki keunikan dan daya tariknya sendiri.
                </p>
                <p class="text-lg text-gray-600 leading-relaxed">
                    Sistem Informasi Geografis ini hadir untuk membantu Anda menjelajahi dan menemukan destinasi wisata
                    pantai terbaik di Bantul. Gunakan peta interaktif dan filter pencarian untuk merencanakan petualangan
                    pantai Anda dengan mudah dan menyenangkan.
                </p>
            </div>
        </div>
    </section>

    <!-- Map Section with Integrated Filter -->
    <section class="py-12 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-3">Peta Lokasi Wisata Pantai</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Jelajahi {{ $tempatWisata->count() }} destinasi pantai di Bantul
                    melalui peta interaktif</p>
            </div>

            <!-- Map Container with Filter Bar -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
                <!-- Compact Filter Bar -->
                <div class="bg-gradient-to-r from-emerald-600 to-teal-700 p-4">
                    <form id="filterForm" method="GET" action="{{ route('home') }}" class="space-y-4">
                        <!-- Filter Title -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2 text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                                    </path>
                                </svg>
                                <span class="font-semibold text-sm">Filter Peta</span>
                            </div>
                            <button type="button" onclick="resetFilter()"
                                class="text-xs text-white/90 hover:text-white font-medium transition flex items-center gap-1 bg-white/10 hover:bg-white/20 px-3 py-1.5 rounded-lg">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                    </path>
                                </svg>
                                Reset
                            </button>
                        </div>

                        <!-- Filter Inputs -->
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                            <!-- Filter Kecamatan -->
                            <div class="relative">
                                <button type="button" onclick="toggleDropdown('kecamatanDropdown')"
                                    class="w-full px-3 py-2 bg-white/95 backdrop-blur-sm border border-white/20 rounded-lg text-left flex items-center justify-between hover:bg-white transition text-sm text-gray-700 font-medium">
                                    <span id="kecamatanLabel">Kecamatan</span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div id="kecamatanDropdown"
                                    class="hidden absolute z-[9999] w-full mt-2 bg-white border border-gray-200 rounded-lg shadow-xl max-h-60 overflow-y-auto">
                                    <label
                                        class="flex items-center gap-2 px-3 py-2 hover:bg-emerald-50 cursor-pointer transition">
                                        <input type="radio" name="kecamatan" value=""
                                            {{ request('kecamatan') == '' ? 'checked' : '' }}
                                            class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500"
                                            onchange="updateKecamatanLabel(this)">
                                        <span class="text-sm text-gray-700">Semua</span>
                                    </label>
                                    @foreach ($kecamatans as $kecamatan)
                                        <label
                                            class="flex items-center gap-2 px-3 py-2 hover:bg-emerald-50 cursor-pointer transition">
                                            <input type="radio" name="kecamatan" value="{{ $kecamatan->id }}"
                                                {{ request('kecamatan') == $kecamatan->id ? 'checked' : '' }}
                                                class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500"
                                                onchange="updateKecamatanLabel(this)">
                                            <span class="text-sm text-gray-700">{{ $kecamatan->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Filter Fasilitas -->
                            <div class="relative">
                                <button type="button" onclick="toggleDropdown('fasilitasDropdown')"
                                    class="w-full px-3 py-2 bg-white/95 backdrop-blur-sm border border-white/20 rounded-lg text-left flex items-center justify-between hover:bg-white transition text-sm text-gray-700 font-medium">
                                    <span id="fasilitasLabel">Pilih Fasilitas</span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div id="fasilitasDropdown"
                                    class="hidden absolute z-[9999] w-full mt-2 bg-white border border-gray-200 rounded-lg shadow-xl max-h-60 overflow-y-auto">
                                    @foreach ($fasilitas as $item)
                                        <label
                                            class="flex items-center gap-2 px-3 py-2 hover:bg-emerald-50 cursor-pointer transition">
                                            <input type="checkbox" name="fasilitas[]" value="{{ $item->id }}"
                                                {{ in_array($item->id, request('fasilitas', [])) ? 'checked' : '' }}
                                                class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500"
                                                onchange="updateFasilitasLabel()">
                                            @if ($item->icon_url)
                                                <img src="{{ $item->icon_url }}" alt="{{ $item->name }}"
                                                    class="w-5 h-5 object-contain">
                                            @endif
                                            <span class="text-sm text-gray-700">{{ $item->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Filter Layanan -->
                            <div class="relative">
                                <button type="button" onclick="toggleDropdown('layananDropdown')"
                                    class="w-full px-3 py-2 bg-white/95 backdrop-blur-sm border border-white/20 rounded-lg text-left flex items-center justify-between hover:bg-white transition text-sm text-gray-700 font-medium">
                                    <span id="layananLabel">Pilih Layanan</span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div id="layananDropdown"
                                    class="hidden absolute z-[9999] w-full mt-2 bg-white border border-gray-200 rounded-lg shadow-xl max-h-60 overflow-y-auto">
                                    @foreach ($layanans as $item)
                                        <label
                                            class="flex items-center gap-2 px-3 py-2 hover:bg-emerald-50 cursor-pointer transition">
                                            <input type="checkbox" name="layanan[]" value="{{ $item->id }}"
                                                {{ in_array($item->id, request('layanan', [])) ? 'checked' : '' }}
                                                class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500"
                                                onchange="updateLayananLabel()">
                                            @if ($item->icon_url)
                                                <img src="{{ $item->icon_url }}" alt="{{ $item->name }}"
                                                    class="w-5 h-5 object-contain">
                                            @endif
                                            <span class="text-sm text-gray-700">{{ $item->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Filter Kondisi Pantai (NEW) -->
                            <div class="relative">
                                <button type="button" onclick="toggleDropdown('kondisiDropdown')"
                                    class="w-full px-3 py-2 bg-white/95 backdrop-blur-sm border border-white/20 rounded-lg text-left flex items-center justify-between hover:bg-white transition text-sm text-gray-700 font-medium">
                                    <span id="kondisiLabel">Kondisi Pantai</span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div id="kondisiDropdown"
                                    class="hidden absolute z-[9999] w-full mt-2 bg-white border border-gray-200 rounded-lg shadow-xl max-h-96 overflow-y-auto">

                                    <!-- Tingkat Keamanan -->
                                    <div class="border-b border-gray-100">
                                        <div class="px-3 py-2 bg-gray-50 sticky top-0">
                                            <p class="text-xs font-bold text-gray-700 uppercase tracking-wide">Tingkat
                                                Keamanan</p>
                                        </div>
                                        @foreach (\App\Models\TempatWisata::SAFETY_LEVELS as $key => $value)
                                            <label
                                                class="flex items-center gap-2 px-3 py-2 hover:bg-emerald-50 cursor-pointer transition">
                                                <input type="checkbox" name="beach_conditions[]"
                                                    value="safety_level:{{ $key }}"
                                                    {{ in_array('safety_level:' . $key, request('beach_conditions', [])) ? 'checked' : '' }}
                                                    class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500"
                                                    onchange="updateKondisiLabel()">
                                                <span class="text-sm text-gray-700">{{ $value }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    <!-- Tingkat Kebersihan -->
                                    <div class="border-b border-gray-100">
                                        <div class="px-3 py-2 bg-gray-50 sticky top-0">
                                            <p class="text-xs font-bold text-gray-700 uppercase tracking-wide">Tingkat
                                                Kebersihan</p>
                                        </div>
                                        @foreach (\App\Models\TempatWisata::CLEANLINESS_LEVELS as $key => $value)
                                            <label
                                                class="flex items-center gap-2 px-3 py-2 hover:bg-emerald-50 cursor-pointer transition">
                                                <input type="checkbox" name="beach_conditions[]"
                                                    value="cleanliness_level:{{ $key }}"
                                                    {{ in_array('cleanliness_level:' . $key, request('beach_conditions', [])) ? 'checked' : '' }}
                                                    class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500"
                                                    onchange="updateKondisiLabel()">
                                                <span class="text-sm text-gray-700">{{ $value }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    <!-- Aksesibilitas Jalan -->
                                    <div class="border-b border-gray-100">
                                        <div class="px-3 py-2 bg-gray-50 sticky top-0">
                                            <p class="text-xs font-bold text-gray-700 uppercase tracking-wide">
                                                Aksesibilitas Jalan</p>
                                        </div>
                                        @foreach (\App\Models\TempatWisata::ROAD_ACCESSIBILITY as $key => $value)
                                            <label
                                                class="flex items-center gap-2 px-3 py-2 hover:bg-emerald-50 cursor-pointer transition">
                                                <input type="checkbox" name="beach_conditions[]"
                                                    value="road_accessibility:{{ $key }}"
                                                    {{ in_array('road_accessibility:' . $key, request('beach_conditions', [])) ? 'checked' : '' }}
                                                    class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500"
                                                    onchange="updateKondisiLabel()">
                                                <span class="text-sm text-gray-700">{{ $value }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    <!-- Kondisi Ombak -->
                                    <div class="border-b border-gray-100">
                                        <div class="px-3 py-2 bg-gray-50 sticky top-0">
                                            <p class="text-xs font-bold text-gray-700 uppercase tracking-wide">Kondisi
                                                Ombak</p>
                                        </div>
                                        @foreach (\App\Models\TempatWisata::WAVE_CONDITIONS as $key => $value)
                                            <label
                                                class="flex items-center gap-2 px-3 py-2 hover:bg-emerald-50 cursor-pointer transition">
                                                <input type="checkbox" name="beach_conditions[]"
                                                    value="wave_condition:{{ $key }}"
                                                    {{ in_array('wave_condition:' . $key, request('beach_conditions', [])) ? 'checked' : '' }}
                                                    class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500"
                                                    onchange="updateKondisiLabel()">
                                                <span class="text-sm text-gray-700">{{ $value }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    <!-- Tingkat Keteduhan -->
                                    <div class="border-b border-gray-100">
                                        <div class="px-3 py-2 bg-gray-50 sticky top-0">
                                            <p class="text-xs font-bold text-gray-700 uppercase tracking-wide">
                                                Tingkat Keteduhan</p>
                                        </div>
                                        @foreach (\App\Models\TempatWisata::SHADE_COMFORT as $key => $value)
                                            <label
                                                class="flex items-center gap-2 px-3 py-2 hover:bg-emerald-50 cursor-pointer transition">
                                                <input type="checkbox" name="beach_conditions[]"
                                                    value="shade_comfort:{{ $key }}"
                                                    {{ in_array('shade_comfort:' . $key, request('beach_conditions', [])) ? 'checked' : '' }}
                                                    class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500"
                                                    onchange="updateKondisiLabel()">
                                                <span class="text-sm text-gray-700">{{ $value }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    <!-- Kenyamanan Lingkungan -->
                                    <div>
                                        <div class="px-3 py-2 bg-gray-50 sticky top-0">
                                            <p class="text-xs font-bold text-gray-700 uppercase tracking-wide">Kenyamanan
                                                Lingkungan</p>
                                        </div>
                                        @foreach (\App\Models\TempatWisata::ENVIRONMENT_COMFORT as $key => $value)
                                            <label
                                                class="flex items-center gap-2 px-3 py-2 hover:bg-emerald-50 cursor-pointer transition">
                                                <input type="checkbox" name="beach_conditions[]"
                                                    value="environment_comfort:{{ $key }}"
                                                    {{ in_array('environment_comfort:' . $key, request('beach_conditions', [])) ? 'checked' : '' }}
                                                    class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500"
                                                    onchange="updateKondisiLabel()">
                                                <span class="text-sm text-gray-700">{{ $value }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-white hover:bg-gray-50 text-emerald-600 font-bold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Terapkan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Map Info Bar -->
                <div class="px-6 py-3 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="font-medium">Menampilkan <span
                                class="text-emerald-600 font-bold">{{ $tempatWisata->count() }}</span> lokasi di
                            peta</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                        <span>Live Map</span>
                    </div>
                </div>

                <!-- Map -->
                <div id="map" class="w-full h-[500px]"></div>
            </div>
        </div>
    </section>

    <!-- List Section -->
    <section id="daftar-wisata" class="py-12 bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-900 mb-3">Destinasi Pilihan</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Temukan pantai-pantai terbaik yang kami rekomendasikan untuk
                    Anda</p>
            </div>

            @if ($randomWisata->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                    @foreach ($randomWisata as $item)
                        <div
                            class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
                            <div class="relative h-48 overflow-hidden group">
                                @if (isset($item->primary_image_url))
                                    <img src="{{ $item->primary_image_url }}" alt="{{ $item->name }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div
                                        class="w-full h-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center">
                                        <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent">
                                </div>
                                <div class="absolute top-3 right-3">
                                    <span
                                        class="inline-flex items-center gap-1 px-3 py-1 bg-white/95 backdrop-blur-sm text-emerald-700 text-xs font-semibold rounded-full shadow-lg">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $item->kecamatan?->name ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-5">
                                <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-1">{{ $item->name }}</h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    {{ Str::limit($item->description, 80) }}
                                </p>

                                <div class="flex items-center gap-2 text-xs text-gray-500 mb-4">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="line-clamp-1">{{ $item->address }}</span>
                                </div>

                                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <div class="flex items-center gap-1">
                                        @foreach ($item->fasilitas->take(3) as $fas)
                                            <div class="relative group">
                                                <div
                                                    class="w-7 h-7 bg-emerald-50 rounded-lg p-1.5 border border-emerald-100 cursor-help transition-all duration-200 group-hover:bg-emerald-100 group-hover:border-emerald-200">
                                                    <img src="{{ $fas->icon_url ?? '' }}" alt="{{ $fas->name }}"
                                                        class="w-full h-full object-contain">
                                                </div>
                                                <!-- Tooltip -->
                                                <div
                                                    class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-white text-xs rounded-lg whitespace-nowrap opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 pointer-events-none z-10">
                                                    {{ $fas->name }}
                                                    <div
                                                        class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-900">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if ($item->fasilitas->count() > 3)
                                            <span
                                                class="text-xs text-gray-500 ml-1 font-medium">+{{ $item->fasilitas->count() - 3 }}</span>
                                        @endif
                                    </div>

                                    <a href="{{ route('home.show', $item->slug) }}"
                                        class="inline-flex items-center gap-1 px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-sm font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                        Detail
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- See More Button -->
                <div class="text-center">
                    <a href="{{ route('wisata.list') }}"
                        class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold rounded-xl transition-all duration-200 shadow-xl hover:shadow-2xl transform hover:scale-105">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        <span>Lihat Semua Tempat Wisata</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                    <p class="text-gray-500 text-sm mt-4">Jelajahi semua destinasi pantai di Bantul
                    </p>
                </div>
            @else
                <div class="bg-white rounded-xl shadow-lg p-12 text-center border border-gray-200">
                    <div class="bg-gray-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Tidak Ada Data</h3>
                    <p class="text-gray-600">Tidak ada tempat wisata yang sesuai dengan filter yang dipilih</p>
                    <button onclick="resetFilter()" class="mt-4 text-emerald-600 hover:text-emerald-700 font-medium">
                        Reset Filter
                    </button>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('styles')
    <style>
        /* Custom map tile styling */
        .leaflet-tile-pane {
            filter: saturate(1.1) brightness(1.05);
        }

        /* Fix z-index for map container */
        #map {
            position: relative;
            z-index: 1;
        }

        /* Ensure map panes don't overlap navbar */
        .leaflet-pane {
            z-index: auto !important;
        }

        .leaflet-map-pane {
            z-index: 1 !important;
        }

        /* Fix z-index hierarchy for leaflet layers */
        .leaflet-overlay-pane {
            z-index: 400 !important;
        }

        .leaflet-shadow-pane {
            z-index: 500 !important;
        }

        .leaflet-marker-pane {
            z-index: 600 !important;
        }

        .leaflet-tooltip-pane {
            z-index: 650 !important;
        }

        .leaflet-popup-pane {
            z-index: 700 !important;
        }

        /* Fix marker container */
        .custom-marker {
            background: transparent !important;
            border: none !important;
        }

        /* Smooth hover effect for marker */
        .custom-marker:hover .relative>div:last-child {
            transform: scale(1.1);
            transition: transform 0.2s ease-in-out;
        }

        /* Ensure popup links are white */
        .leaflet-popup-content a {
            color: white !important;
            text-decoration: none !important;
        }

        /* Custom popup styling */
        .leaflet-popup-content-wrapper {
            padding: 0;
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .leaflet-popup-content {
            margin: 0;
        }

        .leaflet-popup-tip-container {
            display: none;
        }

        /* Kecamatan popup styling */
        .kecamatan-popup .leaflet-popup-content-wrapper {
            background: white;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .kecamatan-popup .leaflet-popup-content {
            margin: 0;
            min-width: 120px;
        }

        /* Polygon hover cursor */
        .leaflet-interactive {
            cursor: pointer;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Initialize map with custom styling
        const map = L.map('map', {
            zoomControl: true,
            scrollWheelZoom: true
        }).setView([-8.1456, 110.3695], 11);

        // Use CartoDB Positron for cleaner look
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 19
        }).addTo(map);

        // Render Kecamatan Boundaries (Polygons)
        const kecamatansWithBoundary = @json($kecamatansWithBoundary);
        const boundaryLayers = {};

        kecamatansWithBoundary.forEach(kecamatan => {
            if (kecamatan.boundary_geojson) {
                try {
                    const geojson = JSON.parse(kecamatan.boundary_geojson);
                    const color = kecamatan.color || '#10b981';

                    const layer = L.geoJSON(geojson, {
                        style: {
                            color: color,
                            weight: 2,
                            opacity: 0.8,
                            fillColor: color,
                            fillOpacity: 0.1
                        },
                        onEachFeature: function(feature, layer) {
                            // Add popup with kecamatan name
                            layer.bindPopup(`
                                <div class="text-center p-2">
                                    <p class="font-bold text-gray-900">${kecamatan.name}</p>
                                </div>
                            `, {
                                className: 'kecamatan-popup'
                            });

                            // Hover effect
                            layer.on('mouseover', function(e) {
                                this.setStyle({
                                    weight: 3,
                                    fillOpacity: 0.2
                                });
                            });

                            layer.on('mouseout', function(e) {
                                this.setStyle({
                                    weight: 2,
                                    fillOpacity: 0.1
                                });
                            });

                            // Click to zoom
                            layer.on('click', function(e) {
                                if (kecamatan.center_lat && kecamatan.center_lng) {
                                    map.setView([kecamatan.center_lat, kecamatan.center_lng],
                                        13, {
                                            animate: true,
                                            duration: 1
                                        });
                                } else {
                                    map.fitBounds(e.target.getBounds(), {
                                        padding: [50, 50]
                                    });
                                }
                            });
                        }
                    }).addTo(map);

                    boundaryLayers[kecamatan.id] = layer;
                } catch (error) {
                    console.error('Error parsing GeoJSON for', kecamatan.name, error);
                }
            }
        });

        // Custom icon with gradient
        const customIcon = L.divIcon({
            className: 'custom-marker',
            html: `<div class="relative pointer-events-none">
                    <div class="absolute -inset-2 bg-emerald-400 rounded-full opacity-20"></div>
                    <div class="relative bg-gradient-to-br from-emerald-500 to-teal-600 w-10 h-10 rounded-full flex items-center justify-center shadow-xl border-4 border-white pointer-events-auto">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>`,
            iconSize: [40, 40],
            iconAnchor: [20, 40],
            popupAnchor: [0, -40]
        });

        // Add markers with clustering
        const markers = L.markerClusterGroup({
            spiderfyOnMaxZoom: true,
            showCoverageOnHover: false,
            zoomToBoundsOnClick: true,
            maxClusterRadius: 50
        });

        const tempatWisata = @json($tempatWisata);

        tempatWisata.forEach(item => {
            if (item.latitude && item.longitude) {
                const marker = L.marker([item.latitude, item.longitude], {
                    icon: customIcon
                });

                const imageUrl = item.primary_image_url || '';
                const popupContent = `
                    <div class="p-0 min-w-[280px]">
                        ${imageUrl ? `<img src="${imageUrl}" alt="${item.name}" class="w-full h-36 object-cover rounded-t-lg">` : ''}
                        <div class="p-4">
                            <h3 class="font-bold text-lg text-gray-900 mb-2">${item.name}</h3>
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">${item.description || ''}</p>
                            <div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>${item.kecamatan?.name || 'N/A'}</span>
                            </div>
                            <a href="/wisata/${item.slug}" class="block w-full text-center px-4 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-sm font-semibold rounded-lg transition shadow-md hover:shadow-lg no-underline">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                `;

                marker.bindPopup(popupContent, {
                    maxWidth: 300,
                    className: 'custom-popup'
                });

                markers.addLayer(marker);
            }
        });

        map.addLayer(markers);

        // Fit bounds if there are markers
        if (tempatWisata.length > 0) {
            const bounds = markers.getBounds();
            if (bounds.isValid()) {
                map.fitBounds(bounds, {
                    padding: [50, 50]
                });
            }
        }

        // Dropdown functions
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            dropdown.classList.toggle('hidden');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const kecamatanDropdown = document.getElementById('kecamatanDropdown');
            const fasilitasDropdown = document.getElementById('fasilitasDropdown');
            const layananDropdown = document.getElementById('layananDropdown');

            if (!event.target.closest('#kecamatanDropdown') && !event.target.closest(
                    'button[onclick*="kecamatanDropdown"]')) {
                kecamatanDropdown.classList.add('hidden');
            }

            if (!event.target.closest('#fasilitasDropdown') && !event.target.closest(
                    'button[onclick*="fasilitasDropdown"]')) {
                fasilitasDropdown.classList.add('hidden');
            }

            if (!event.target.closest('#layananDropdown') && !event.target.closest(
                    'button[onclick*="layananDropdown"]')) {
                layananDropdown.classList.add('hidden');
            }
        });

        // Update Kecamatan label
        function updateKecamatanLabel(radio) {
            const label = document.getElementById('kecamatanLabel');
            const selectedText = radio.parentElement.querySelector('span').textContent;

            if (radio.value === '') {
                label.textContent = 'Semua Kecamatan';
            } else {
                label.textContent = `${selectedText}`;
            }
        }

        // Update Fasilitas label
        function updateFasilitasLabel() {
            const checkboxes = document.querySelectorAll('input[name="fasilitas[]"]:checked');
            const label = document.getElementById('fasilitasLabel');
            if (checkboxes.length > 0) {
                label.textContent = `${checkboxes.length} Dipilih`;
            } else {
                label.textContent = 'Pilih Fasilitas';
            }
        }

        // Update Layanan label
        function updateLayananLabel() {
            const checkboxes = document.querySelectorAll('input[name="layanan[]"]:checked');
            const label = document.getElementById('layananLabel');
            if (checkboxes.length > 0) {
                label.textContent = `${checkboxes.length} Dipilih`;
            } else {
                label.textContent = 'Pilih Layanan';
            }
        }

        // Update Kondisi Pantai label
        function updateKondisiLabel() {
            const checkboxes = document.querySelectorAll('input[name="beach_conditions[]"]:checked');
            const label = document.getElementById('kondisiLabel');
            if (checkboxes.length > 0) {
                label.textContent = `${checkboxes.length} Kondisi Dipilih`;
            } else {
                label.textContent = 'Kondisi Pantai';
            }
        }

        // Reset filter
        function resetFilter() {
            window.location.href = '{{ route('home') }}';
        }

        // Initialize labels on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Kecamatan label
            const selectedKecamatan = document.querySelector('input[name="kecamatan"]:checked');
            if (selectedKecamatan && selectedKecamatan.value !== '') {
                updateKecamatanLabel(selectedKecamatan);
            }

            // Initialize Fasilitas, Layanan, and Kondisi labels
            updateFasilitasLabel();
            updateLayananLabel();
            updateKondisiLabel();
        });
    </script>
@endpush
