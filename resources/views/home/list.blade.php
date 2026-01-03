@extends('layouts.public')

@section('title', 'Tempat Wisata - Pantai Bantul')

@section('content')
    <!-- Header Section -->
    <section class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    Semua Tempat Wisata Pantai
                </h1>
                <p class="text-lg text-gray-700 max-w-2xl mx-auto">
                    Temukan dan jelajahi {{ $tempatWisata->count() }} destinasi pantai terbaik di Kabupaten Bantul
                </p>
            </div>
        </div>
    </section>

    <!-- Filter & Search Section -->
    <section class="py-6 bg-white sticky top-20 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form id="filterForm" method="GET" action="{{ route('wisata.list') }}">
                <div class="grid grid-cols-1 md:grid-cols-6 gap-3">
                    <!-- Search -->
                    <div class="md:col-span-2 relative">
                        <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                            placeholder="Cari nama pantai, lokasi..."
                            class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-sm">
                        @if (request('search'))
                            <button type="button" onclick="clearSearch()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        @endif
                    </div>

                    <!-- Filter Kecamatan -->
                    <div class="relative">
                        <button type="button" onclick="toggleDropdown('kecamatanDropdown')"
                            class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-left flex items-center justify-between hover:border-emerald-500 transition text-sm text-gray-700 font-medium">
                            <span id="kecamatanLabel">Semua Kecamatan</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div id="kecamatanDropdown"
                            class="hidden absolute z-50 w-full mt-2 bg-white border border-gray-200 rounded-lg shadow-xl max-h-60 overflow-y-auto">
                            <label class="flex items-center gap-2 px-3 py-2 hover:bg-emerald-50 cursor-pointer transition">
                                <input type="radio" name="kecamatan" value=""
                                    {{ request('kecamatan') == '' ? 'checked' : '' }}
                                    class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500"
                                    onchange="updateKecamatanLabel(this)">
                                <span class="text-sm text-gray-700">Semua Kecamatan</span>
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
                            class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-left flex items-center justify-between hover:border-emerald-500 transition text-sm text-gray-700 font-medium">
                            <span id="fasilitasLabel">Pilih Fasilitas</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div id="fasilitasDropdown"
                            class="hidden absolute z-50 w-full mt-2 bg-white border border-gray-200 rounded-lg shadow-xl max-h-60 overflow-y-auto">
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
                            class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-left flex items-center justify-between hover:border-emerald-500 transition text-sm text-gray-700 font-medium">
                            <span id="layananLabel">Pilih Layanan</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div id="layananDropdown"
                            class="hidden absolute z-50 w-full mt-2 bg-white border border-gray-200 rounded-lg shadow-xl max-h-60 overflow-y-auto">
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

                    <!-- Submit & Reset Buttons -->
                    <div class="flex gap-2">
                        <button type="submit"
                            class="px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                        <button type="button" onclick="resetFilter()"
                            class="px-3 py-2 border-2 border-gray-300 hover:border-emerald-500 text-gray-700 hover:text-emerald-600 font-medium rounded-lg transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- List Section -->
    <section class="py-10 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($tempatWisata->count() > 0)
                <div class="mb-6 flex items-center justify-between">
                    <p class="text-gray-600">
                        Menampilkan <span class="font-bold text-gray-900">{{ $tempatWisata->count() }}</span> tempat
                        wisata
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($tempatWisata as $item)
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
                    <p class="text-gray-600 mb-4">Tidak ada tempat wisata yang sesuai dengan pencarian Anda</p>
                    <button onclick="resetFilter()" class="text-emerald-600 hover:text-emerald-700 font-medium">
                        Reset Pencarian
                    </button>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Dropdown functions
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            const allDropdowns = ['kecamatanDropdown', 'fasilitasDropdown', 'layananDropdown'];

            // Close other dropdowns
            allDropdowns.forEach(dropdownId => {
                if (dropdownId !== id) {
                    document.getElementById(dropdownId).classList.add('hidden');
                }
            });

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
                label.textContent = selectedText;
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

        // Clear search
        function clearSearch() {
            document.getElementById('searchInput').value = '';
            document.getElementById('filterForm').submit();
        }

        // Reset filter
        function resetFilter() {
            window.location.href = '{{ route('wisata.list') }}';
        }

        // Initialize labels on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Kecamatan label
            const selectedKecamatan = document.querySelector('input[name="kecamatan"]:checked');
            if (selectedKecamatan && selectedKecamatan.value !== '') {
                updateKecamatanLabel(selectedKecamatan);
            }

            // Initialize Fasilitas and Layanan labels
            updateFasilitasLabel();
            updateLayananLabel();
        });
    </script>
@endpush
