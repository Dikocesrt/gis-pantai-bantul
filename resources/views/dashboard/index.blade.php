@extends('layouts.dashboard')

@section('content')
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Selamat datang di GIS Pantai Bantul</h2>
        <p class="text-gray-600 mt-1">Sistem Informasi Geografis Pantai Daerah Istimewa Yogyakarta</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Kecamatan</p>
                    <h3 class="text-3xl font-bold text-gray-900">0</h3>
                </div>
                <svg class="w-12 h-12 text-blue-500 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Fasilitas</p>
                    <h3 class="text-3xl font-bold text-gray-900">0</h3>
                </div>
                <svg class="w-12 h-12 text-green-500 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                    </path>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Tipe Tempat</p>
                    <h3 class="text-3xl font-bold text-gray-900">0</h3>
                </div>
                <svg class="w-12 h-12 text-yellow-500 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01">
                    </path>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Tempat Wisata</p>
                    <h3 class="text-3xl font-bold text-gray-900">0</h3>
                </div>
                <svg class="w-12 h-12 text-red-500 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5.217m0 0a1 1 0 00-.564-.243H9m0 0a1 1 0 00-.564.243m0 0H4m15 0h2m-2 0h-5.217m0 0A1.992 1.992 0 009 12c0-.882.391-1.68 1.009-2.227m0 0H4">
                    </path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Info Section -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Sistem</h3>
        <div class="space-y-3 text-gray-600">
            <p>Halaman dashboard ini menampilkan ringkasan data dari sistem informasi geografis pantai Bantul.</p>
            <p>Gunakan menu di sidebar untuk mengelola data kecamatan, fasilitas, tipe tempat, dan tempat wisata.</p>
            @if (Auth::user()->role === 'super_admin')
                <p>Sebagai super admin, Anda juga dapat mengelola akun admin melalui menu <strong>Manajemen Admin</strong>.
                </p>
            @endif
        </div>
    </div>
@endsection
