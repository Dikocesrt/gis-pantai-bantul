@extends('layouts.dashboard')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Selamat datang di GIS Pantai Bantul</h2>
        <p class="text-gray-600 mt-2 font-medium">Sistem Informasi Geografis Pantai Daerah Istimewa Yogyakarta</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div
            class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-emerald-500 hover:shadow-xl transition-all duration-200">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-2">Kecamatan</p>
                    <h3 class="text-4xl font-bold text-gray-900">{{ $stats['kecamatan'] }}</h3>
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
                    <p class="text-gray-600 text-sm font-medium mb-2">Fasilitas</p>
                    <h3 class="text-4xl font-bold text-gray-900">{{ $stats['fasilitas'] }}</h3>
                </div>
                <div class="bg-teal-50 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div
            class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-cyan-500 hover:shadow-xl transition-all duration-200">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-2">Tipe Tempat</p>
                    <h3 class="text-4xl font-bold text-gray-900">{{ $stats['tipe_tempat'] }}</h3>
                </div>
                <div class="bg-cyan-50 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div
            class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition-all duration-200">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-2">Tempat Wisata</p>
                    <h3 class="text-4xl font-bold text-gray-900">{{ $stats['tempat_wisata'] }}</h3>
                </div>
                <div class="bg-blue-50 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Section -->
    <div class="bg-white rounded-xl shadow-lg p-8">
        <div class="flex items-start gap-4 mb-6">
            <div class="bg-emerald-50 p-3 rounded-lg">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Informasi Sistem</h3>
                <div class="space-y-3 text-gray-600 leading-relaxed">
                    <p>Halaman dashboard ini menampilkan ringkasan data dari sistem informasi geografis pantai Bantul.</p>
                    <p>Gunakan menu di sidebar untuk mengelola data kecamatan, fasilitas, tipe tempat, dan tempat wisata.
                    </p>
                    @if (Auth::user()->role === 'super_admin')
                        <p class="font-medium text-emerald-700">Sebagai super admin, Anda juga dapat mengelola akun admin
                            melalui menu <span class="font-semibold">Pengelolaan Admin</span>.
                        </p>
                    @endif
                    @if (Auth::user()->role === 'admin')
                        <p class="font-medium text-emerald-700">Sebagai admin, Anda dapat membantu verifikasi admin baru
                            melalui menu <span class="font-semibold">Pengelolaan Admin</span>.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
