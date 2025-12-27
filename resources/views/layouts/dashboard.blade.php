<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GIS Pantai Bantul') }} - Dashboard</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-slate-800 to-slate-900 text-white shadow-lg hidden md:flex flex-col">
            <div class="p-6 border-b border-slate-700">
                <h2 class="text-xl font-bold flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5.447-2.724A1 1 0 003 16.382V5.618a1 1 0 011.553-.894L9 7m0 0l6-3.446m-6 3.446v12.672m0-12.672l6 3.446m0 0V16.5">
                        </path>
                    </svg>
                    GIS Pantai
                </h2>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-4 mb-4">Menu Utama</div>
                <a href="{{ route('dashboard') }}"
                    class="@if (request()->routeIs('dashboard')) bg-slate-700 @endif flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-slate-700 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-4m0 0l4 4m-4-4V3">
                        </path>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-4 mb-4 mt-6">Manajemen Data
                </div>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-slate-700 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                        </path>
                    </svg>
                    <span>Manajemen Kecamatan</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-slate-700 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                        </path>
                    </svg>
                    <span>Manajemen Fasilitas</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-slate-700 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01">
                        </path>
                    </svg>
                    <span>Manajemen Tipe Tempat</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-slate-700 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5.217m0 0a1 1 0 00-.564-.243H9m0 0a1 1 0 00-.564.243m0 0H4m15 0h2m-2 0h-5.217m0 0A1.992 1.992 0 009 12c0-.882.391-1.68 1.009-2.227m0 0H4">
                        </path>
                    </svg>
                    <span>Manajemen Tempat Wisata</span>
                </a>

                @if (Auth::user()->role === 'super_admin')
                    <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-4 mb-4 mt-6">
                        Administrasi</div>
                    <a href="{{ route('admin.verification.index') }}"
                        class="@if (request()->routeIs('admin.*')) bg-slate-700 @endif flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-slate-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m7.528-4.528a9 9 0 11-18.056 0m18.056 0A9 9 0 009 3m9 0a9 9 0 00-9 9">
                            </path>
                        </svg>
                        <span>Manajemen Admin</span>
                    </a>
                @endif
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navbar -->
            <nav class="bg-white border-b border-gray-200 shadow-sm">
                <div class="px-6 py-4 flex justify-between items-center">
                    <h1 class="text-xl font-semibold text-gray-900">Dashboard</h1>

                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-600">{{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}
                            </p>
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </nav>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto">
                <div class="p-6">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>

</html>
