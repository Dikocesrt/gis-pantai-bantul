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

                    <!-- Informasi Kondisi Pantai -->
                    @if (
                        $tempatWisata->safety_level ||
                            $tempatWisata->cleanliness_level ||
                            $tempatWisata->road_accessibility ||
                            $tempatWisata->wave_condition ||
                            $tempatWisata->shade_comfort ||
                            $tempatWisata->environment_comfort)
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Informasi Kondisi Pantai
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if ($tempatWisata->safety_level)
                                    <div
                                        class="flex items-start gap-3 p-4 bg-gray-50 rounded-lg hover:bg-emerald-50 transition">
                                        <div class="bg-emerald-100 p-2 rounded-lg shrink-0">
                                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-600 mb-1">Tingkat Keamanan</p>
                                            <p class="text-sm font-bold text-gray-900">
                                                {{ \App\Models\TempatWisata::SAFETY_LEVELS[$tempatWisata->safety_level] ?? $tempatWisata->safety_level }}
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                @if ($tempatWisata->cleanliness_level)
                                    <div
                                        class="flex items-start gap-3 p-4 bg-gray-50 rounded-lg hover:bg-emerald-50 transition">
                                        <div class="bg-emerald-100 p-2 rounded-lg shrink-0">
                                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-600 mb-1">Tingkat Kebersihan</p>
                                            <p class="text-sm font-bold text-gray-900">
                                                {{ \App\Models\TempatWisata::CLEANLINESS_LEVELS[$tempatWisata->cleanliness_level] ?? $tempatWisata->cleanliness_level }}
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                @if ($tempatWisata->road_accessibility)
                                    <div
                                        class="flex items-start gap-3 p-4 bg-gray-50 rounded-lg hover:bg-emerald-50 transition">
                                        <div class="bg-emerald-100 p-2 rounded-lg shrink-0">
                                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-600 mb-1">Aksesibilitas Jalan</p>
                                            <p class="text-sm font-bold text-gray-900">
                                                {{ \App\Models\TempatWisata::ROAD_ACCESSIBILITY[$tempatWisata->road_accessibility] ?? $tempatWisata->road_accessibility }}
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                @if ($tempatWisata->wave_condition)
                                    <div
                                        class="flex items-start gap-3 p-4 bg-gray-50 rounded-lg hover:bg-emerald-50 transition">
                                        <div class="bg-emerald-100 p-2 rounded-lg shrink-0">
                                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-600 mb-1">Kondisi Ombak</p>
                                            <p class="text-sm font-bold text-gray-900">
                                                {{ \App\Models\TempatWisata::WAVE_CONDITIONS[$tempatWisata->wave_condition] ?? $tempatWisata->wave_condition }}
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                @if ($tempatWisata->shade_comfort)
                                    <div
                                        class="flex items-start gap-3 p-4 bg-gray-50 rounded-lg hover:bg-emerald-50 transition">
                                        <div class="bg-emerald-100 p-2 rounded-lg shrink-0">
                                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-600 mb-1">Tingkat Keteduhan</p>
                                            <p class="text-sm font-bold text-gray-900">
                                                {{ \App\Models\TempatWisata::SHADE_COMFORT[$tempatWisata->shade_comfort] ?? $tempatWisata->shade_comfort }}
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                @if ($tempatWisata->environment_comfort)
                                    <div
                                        class="flex items-start gap-3 p-4 bg-gray-50 rounded-lg hover:bg-emerald-50 transition">
                                        <div class="bg-emerald-100 p-2 rounded-lg shrink-0">
                                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-600 mb-1">Kenyamanan Lingkungan</p>
                                            <p class="text-sm font-bold text-gray-900">
                                                {{ \App\Models\TempatWisata::ENVIRONMENT_COMFORT[$tempatWisata->environment_comfort] ?? $tempatWisata->environment_comfort }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

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

                    <!-- Entrance Fee -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                                </path>
                            </svg>
                            Harga Tiket Masuk
                        </h3>
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-gray-900">Tiket Masuk</span>
                                    <div class="relative group">
                                        <svg class="w-4 h-4 text-gray-500 cursor-help" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <div
                                            class="absolute left-0 bottom-full mb-2 hidden group-hover:block w-64 p-3 bg-gray-900 text-white text-sm rounded-lg shadow-xl z-10">
                                            <div class="relative">
                                                Tiket masuk ini berlaku untuk 1x kunjungan dan dapat digunakan untuk
                                                mengunjungi semua pantai di Bantul
                                                <div
                                                    class="absolute left-4 top-full w-0 h-0 border-l-8 border-r-8 border-t-8 border-l-transparent border-r-transparent border-t-gray-900">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-lg font-bold text-gray-900">
                                    Rp {{ number_format(env('ENTRANCE_FEE', 15000), 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Parking Fees -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2">
                                </path>
                            </svg>
                            Tarif Parkir
                        </h3>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="font-medium text-gray-900">Motor</span>
                                <span class="font-bold">
                                    Rp {{ number_format(env('PARKING_FEE_MOTOR', 5000), 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="font-medium text-gray-900">Mobil</span>
                                <span class="font-bold">
                                    Rp {{ number_format(env('PARKING_FEE_MOBIL', 10000), 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="font-medium text-gray-900">Kereta Mini</span>
                                <span class="font-bold">
                                    Rp {{ number_format(env('PARKING_FEE_KERETA_MINI', 10000), 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="font-medium text-gray-900">Mini Bus</span>
                                <span class="font-bold">
                                    Rp {{ number_format(env('PARKING_FEE_MINI_BUS', 10000), 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="font-medium text-gray-900">Bus Besar</span>
                                <span class="font-bold">
                                    Rp {{ number_format(env('PARKING_FEE_BUS_BESAR', 20000), 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
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
