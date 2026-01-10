<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GIS Pantai Bantul') }} - Dashboard</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite('resources/css/app.css')

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Mobile Overlay -->
        <div id="mobileOverlay" class="hidden fixed inset-0 bg-black/50 z-40 md:hidden"></div>

        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed md:relative inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-all duration-300 ease-in-out bg-linear-to-b from-emerald-600 to-teal-700 text-white shadow-2xl flex flex-col z-50 w-64">
            <div class="p-6 border-b border-emerald-500/30 flex items-center justify-between">
                <div class="flex items-center gap-3 overflow-hidden">
                    <div class="bg-white/20 backdrop-blur-sm p-2 rounded-lg shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.553-.894L9 7m0 0l6-3.446m-6 3.446v12.672m0-12.672l6 3.446m0 0V16.5">
                            </path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold whitespace-nowrap sidebar-text">GIS Pantai</h2>
                </div>
                <!-- Toggle Button (Desktop) -->
                <button onclick="toggleSidebar()"
                    class="hidden md:block text-white hover:bg-white/10 p-2 rounded-lg transition">
                    <svg id="toggleIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                    </svg>
                </button>
                <!-- Close Button (Mobile) -->
                <button onclick="closeMobileSidebar()"
                    class="md:hidden text-white hover:bg-white/10 p-2 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <div class="text-xs font-semibold text-emerald-100 uppercase tracking-wider px-4 mb-3 sidebar-text">Menu
                    Utama</div>
                <a href="{{ route('dashboard') }}" title="Dashboard"
                    class="@if (request()->routeIs('dashboard')) bg-white/20 backdrop-blur-sm shadow-lg @endif flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition-all duration-200 group">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform shrink-0" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span class="font-medium sidebar-text whitespace-nowrap">Dashboard</span>
                </a>

                <div
                    class="text-xs font-semibold text-emerald-100 uppercase tracking-wider px-4 mb-3 mt-6 sidebar-text">
                    Manajemen Data</div>
                <a href="{{ route('kecamatan.index') }}" title="Kecamatan"
                    class="@if (request()->routeIs('kecamatan.*')) bg-white/20 backdrop-blur-sm shadow-lg @endif flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition-all duration-200 group">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform shrink-0" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                        </path>
                    </svg>
                    <span class="font-medium sidebar-text whitespace-nowrap">Kecamatan</span>
                </a>
                <a href="{{ route('tempat-wisata.index') }}" title="Tempat Wisata"
                    class="@if (request()->routeIs('tempat-wisata.*')) bg-white/20 backdrop-blur-sm shadow-lg @endif flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition-all duration-200 group">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform shrink-0" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    <span class="font-medium sidebar-text whitespace-nowrap">Tempat Wisata</span>
                </a>
                <a href="{{ route('fasilitas.index') }}" title="Fasilitas"
                    class="@if (request()->routeIs('fasilitas.*')) bg-white/20 backdrop-blur-sm shadow-lg @endif flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition-all duration-200 group">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform shrink-0" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    <span class="font-medium sidebar-text whitespace-nowrap">Fasilitas</span>
                </a>
                <a href="{{ route('tipe-tempat.index') }}" title="Tipe Tempat"
                    class="@if (request()->routeIs('tipe-tempat.*')) bg-white/20 backdrop-blur-sm shadow-lg @endif flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition-all duration-200 group">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform shrink-0" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                        </path>
                    </svg>
                    <span class="font-medium sidebar-text whitespace-nowrap">Tipe Tempat</span>
                </a>
                <a href="{{ route('layanans.index') }}" title="Layanan"
                    class="@if (request()->routeIs('layanans.*')) bg-white/20 backdrop-blur-sm shadow-lg @endif flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition-all duration-200 group">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform shrink-0" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    <span class="font-medium sidebar-text whitespace-nowrap">Layanan</span>
                </a>

                @if (Auth::user()->role === 'super_admin' || Auth::user()->role === 'admin')
                    <div
                        class="text-xs font-semibold text-emerald-100 uppercase tracking-wider px-4 mb-3 mt-6 sidebar-text">
                        Administrasi</div>
                    <a href="{{ route('admin.verification.index') }}" title="Pengelolaan Admin"
                        class="@if (request()->routeIs('admin.*')) bg-white/20 backdrop-blur-sm shadow-lg @endif flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition-all duration-200 group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform shrink-0" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        <span class="font-medium sidebar-text whitespace-nowrap">Pengelolaan Admin</span>
                    </a>
                @endif
            </nav>

            <div class="p-4 border-t border-emerald-500/30">
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 sidebar-text">
                    <p class="text-xs text-emerald-100 leading-relaxed">© 2026 GIS Pantai Bantul</p>
                    <p class="text-xs text-emerald-200 font-medium">Daerah Istimewa Yogyakarta</p>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navbar -->
            <nav class="bg-white border-b border-gray-200 shadow-sm">
                <div class="px-6 py-4 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <!-- Mobile Menu Button -->
                        <button onclick="openMobileSidebar()" class="md:hidden text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-600 font-medium">
                                {{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}
                            </p>
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
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

    <script>
        let sidebarCollapsed = false;

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const toggleIcon = document.getElementById('toggleIcon');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');

            sidebarCollapsed = !sidebarCollapsed;

            if (sidebarCollapsed) {
                // Collapse sidebar
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20');
                sidebarTexts.forEach(el => el.classList.add('hidden'));
                // Rotate icon
                toggleIcon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>';
            } else {
                // Expand sidebar
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-64');
                sidebarTexts.forEach(el => el.classList.remove('hidden'));
                // Rotate icon back
                toggleIcon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>';
            }
        }

        function openMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');

            // Force icon-only mode for mobile
            sidebar.classList.remove('w-64');
            sidebar.classList.add('w-20');
            sidebarTexts.forEach(el => el.classList.add('hidden'));

            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            overlay.classList.remove('hidden');
        }

        function closeMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');

            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
            overlay.classList.add('hidden');
        }

        // Close sidebar when clicking overlay
        document.getElementById('mobileOverlay')?.addEventListener('click', closeMobileSidebar);

        // Initialize sidebar state on page load
        window.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');

            // Check if mobile view
            if (window.innerWidth < 768) {
                // Force icon-only mode for mobile
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20');
                sidebarTexts.forEach(el => el.classList.add('hidden'));
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');

            if (window.innerWidth < 768) {
                // Mobile: force icon-only and hide
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20');
                sidebar.classList.add('-translate-x-full');
                sidebarTexts.forEach(el => el.classList.add('hidden'));
                document.getElementById('mobileOverlay')?.classList.add('hidden');
            } else {
                // Desktop: restore to expanded if not manually collapsed
                if (!sidebarCollapsed) {
                    sidebar.classList.remove('w-20');
                    sidebar.classList.add('w-64');
                    sidebar.classList.remove('-translate-x-full');
                    sidebarTexts.forEach(el => el.classList.remove('hidden'));
                }
            }
        });
    </script>
</body>

</html>
