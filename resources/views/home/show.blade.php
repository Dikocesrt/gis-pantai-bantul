@extends('layouts.public')

@section('title', $tempatWisata->name . ' - GIS Pantai Bantul')

@section('content')
    <!-- Main Content -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Image Gallery -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        @if ($tempatWisata->images->count() > 0)
                            <div class="relative">
                                <img id="mainImage" src="{{ $tempatWisata->images->first()->image_url }}"
                                    alt="{{ $tempatWisata->name }}" class="w-full h-96 object-cover">
                            </div>
                            @if ($tempatWisata->images->count() > 1)
                                <div class="p-4 bg-gray-50">
                                    <div class="grid grid-cols-4 gap-3">
                                        @foreach ($tempatWisata->images as $image)
                                            <button onclick="changeImage('{{ $image->image_url }}')"
                                                class="aspect-square rounded-lg overflow-hidden hover:ring-4 hover:ring-emerald-500 transition">
                                                <img src="{{ $image->image_url }}" alt="{{ $tempatWisata->name }}"
                                                    class="w-full h-full object-cover">
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @else
                            <div
                                class="w-full h-96 bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center">
                                <svg class="w-32 h-32 text-white opacity-50" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $tempatWisata->name }}</h1>

                        <div class="flex flex-wrap items-center gap-4 mb-6">
                            <span
                                class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-lg font-medium">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $tempatWisata->kecamatan?->name ?? 'N/A' }}
                            </span>

                            @if ($tempatWisata->tipeTempat)
                                <span
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-teal-100 text-teal-700 rounded-lg font-medium">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                        </path>
                                    </svg>
                                    {{ $tempatWisata->tipeTempat->name }}
                                </span>
                            @endif
                        </div>

                        <div class="prose max-w-none">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">Deskripsi</h3>
                            <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $tempatWisata->description }}
                            </p>
                        </div>
                    </div>

                    <!-- Fasilitas -->
                    @if ($tempatWisata->fasilitas->count() > 0)
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                                Fasilitas
                            </h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach ($tempatWisata->fasilitas as $item)
                                    <div
                                        class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-emerald-50 transition">
                                        @if ($item->icon_url)
                                            <img src="{{ $item->icon_url }}" alt="{{ $item->name }}"
                                                class="w-8 h-8 object-contain">
                                        @endif
                                        <span class="text-sm font-medium text-gray-700">{{ $item->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Layanan -->
                    @if ($tempatWisata->layanans->count() > 0)
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Layanan
                            </h3>
                            <div class="space-y-3">
                                @foreach ($tempatWisata->layanans as $item)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <div class="flex items-center gap-3">
                                            @if ($item->icon_url)
                                                <img src="{{ $item->icon_url }}" alt="{{ $item->name }}"
                                                    class="w-8 h-8 object-contain">
                                            @endif
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $item->name }}</p>
                                                @if ($item->pivot->duration)
                                                    <p class="text-sm text-gray-600">Durasi: {{ $item->pivot->duration }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        @if ($item->pivot->price)
                                            <div class="text-right">
                                                <p class="font-bold text-emerald-600">
                                                    Rp {{ number_format($item->pivot->price, 0, ',', '.') }}
                                                </p>
                                                @if ($item->pivot->price_unit)
                                                    <p class="text-xs text-gray-600">{{ $item->pivot->price_unit }}</p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Opening Hours -->
                    @if ($tempatWisata->openingHours->count() > 0)
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Jam Operasional
                            </h3>
                            <div class="space-y-2">
                                @php
                                    $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                                @endphp
                                @foreach ($tempatWisata->openingHours as $hours)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-900">{{ $days[$hours->day_of_week] }}</span>
                                        <div class="text-right">
                                            @if ($hours->open_time && $hours->close_time)
                                                <span class="text-gray-700">
                                                    {{ date('H:i', strtotime($hours->open_time)) }} -
                                                    {{ date('H:i', strtotime($hours->close_time)) }}
                                                </span>
                                            @endif
                                            @if ($hours->note)
                                                <p class="text-xs text-gray-600">{{ $hours->note }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Location Info -->
                    <div class="bg-white rounded-xl shadow-lg p-6 sticky top-24">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Informasi Lokasi</h3>

                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-emerald-600 mt-1 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 mb-1">Alamat</p>
                                    <p class="text-sm text-gray-600">{{ $tempatWisata->address }}</p>
                                </div>
                            </div>

                            @if ($tempatWisata->phone)
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-emerald-600 mt-1 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 mb-1">Telepon</p>
                                        <a href="tel:{{ $tempatWisata->phone }}"
                                            class="text-sm text-emerald-600 hover:text-emerald-700">
                                            {{ $tempatWisata->phone }}
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-emerald-600 mt-1 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                    </path>
                                </svg>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 mb-1">Koordinat</p>
                                    <p class="text-sm text-gray-600">{{ $tempatWisata->latitude }},
                                        {{ $tempatWisata->longitude }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Map -->
                        <div class="mt-6">
                            <div id="detailMap" class="w-full h-64 rounded-lg overflow-hidden"></div>
                        </div>

                        <!-- Directions Button -->
                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $tempatWisata->latitude }},{{ $tempatWisata->longitude }}"
                            target="_blank"
                            class="mt-4 w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-emerald-600 to-teal-700 hover:from-emerald-700 hover:to-teal-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                </path>
                            </svg>
                            Petunjuk Arah
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Change main image
        function changeImage(url) {
            document.getElementById('mainImage').src = url;
        }

        // Initialize detail map
        const detailMap = L.map('detailMap').setView([{{ $tempatWisata->latitude }}, {{ $tempatWisata->longitude }}],
            15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19
        }).addTo(detailMap);

        // Custom marker
        const customIcon = L.divIcon({
            className: 'custom-marker',
            html: `<div class="bg-emerald-600 w-12 h-12 rounded-full flex items-center justify-center shadow-lg border-4 border-white">
                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                    </svg>
                </div>`,
            iconSize: [48, 48],
            iconAnchor: [24, 48]
        });

        L.marker([{{ $tempatWisata->latitude }}, {{ $tempatWisata->longitude }}], {
            icon: customIcon
        }).addTo(detailMap);
    </script>
@endpush
