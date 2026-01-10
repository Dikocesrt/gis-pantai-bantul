<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'GIS Pantai Bantul - Sistem Informasi Geografis Wisata Pantai')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <!-- Leaflet MarkerCluster CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />

    <style>
        .leaflet-popup-content-wrapper {
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .leaflet-popup-content {
            margin: 0;
            min-width: 250px;
        }

        .marker-cluster-small {
            background-color: rgba(16, 185, 129, 0.6);
        }

        .marker-cluster-small div {
            background-color: rgba(16, 185, 129, 0.8);
        }

        .marker-cluster-medium {
            background-color: rgba(20, 184, 166, 0.6);
        }

        .marker-cluster-medium div {
            background-color: rgba(20, 184, 166, 0.8);
        }

        .marker-cluster-large {
            background-color: rgba(6, 182, 212, 0.6);
        }

        .marker-cluster-large div {
            background-color: rgba(6, 182, 212, 0.8);
        }
    </style>

    @stack('styles')
</head>

<body class="bg-white font-sans antialiased min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-emerald-600 to-teal-700 shadow-xl sticky top-0 z-50 backdrop-blur-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo & Brand -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div
                        class="bg-white/20 backdrop-blur-md p-3 rounded-xl group-hover:bg-white/30 transition-all duration-300 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white tracking-tight">Pantai Bantul</h1>
                        <p class="text-xs text-emerald-50">Jelajahi Keindahan Pantai DIY</p>
                    </div>
                </a>

                <!-- Desktop Navigation Menu -->
                <div class="hidden md:flex items-center gap-2">
                    <a href="{{ route('home') }}"
                        class="px-4 py-2 text-white font-medium rounded-lg hover:bg-white/20 transition-all duration-200 {{ request()->routeIs('home') ? 'bg-white/20' : '' }}">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                            Beranda
                        </div>
                    </a>
                    <a href="{{ route('wisata.list') }}"
                        class="px-4 py-2 text-white font-medium rounded-lg hover:bg-white/20 transition-all duration-200 {{ request()->routeIs('wisata.list') ? 'bg-white/20' : '' }}">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            Tempat Wisata
                        </div>
                    </a>
                    <a href="#"
                        class="px-4 py-2 text-white font-medium rounded-lg hover:bg-white/20 transition-all duration-200">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            Informasi
                        </div>
                    </a>
                    <a href="{{ route('about') }}"
                        class="px-4 py-2 text-white font-medium rounded-lg hover:bg-white/20 transition-all duration-200 {{ request()->routeIs('about') ? 'bg-white/20' : '' }}">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                            Tentang
                        </div>
                    </a>
                </div>

                <!-- Desktop Admin Button & Mobile Menu Button -->
                <div class="flex items-center gap-3">
                    <!-- Admin Button (Desktop) -->
                    <a href="{{ route('login') }}"
                        class="hidden md:inline-flex items-center gap-2 px-5 py-2.5 bg-white text-emerald-600 font-semibold rounded-lg hover:bg-emerald-50 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Admin
                    </a>

                    <!-- Mobile Menu Button -->
                    <button id="mobileMenuButton" type="button"
                        class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-white hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/50 transition-all duration-200">
                        <svg id="menuIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg id="closeIcon" class="w-6 h-6 hidden" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu"
            class="hidden md:hidden bg-emerald-700/95 backdrop-blur-lg border-t border-emerald-600/30">
            <div class="px-4 py-4 space-y-2">
                <a href="{{ route('home') }}"
                    class="flex items-center gap-3 px-4 py-3 text-white font-medium rounded-lg hover:bg-white/20 transition-all duration-200 {{ request()->routeIs('home') ? 'bg-white/20' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    Beranda
                </a>
                <a href="{{ route('wisata.list') }}"
                    class="flex items-center gap-3 px-4 py-3 text-white font-medium rounded-lg hover:bg-white/20 transition-all duration-200 {{ request()->routeIs('wisata.list') ? 'bg-white/20' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    Tempat Wisata
                </a>
                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 text-white font-medium rounded-lg hover:bg-white/20 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    Informasi
                </a>
                <a href="{{ route('about') }}"
                    class="flex items-center gap-3 px-4 py-3 text-white font-medium rounded-lg hover:bg-white/20 transition-all duration-200 {{ request()->routeIs('about') ? 'bg-white/20' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                    Tentang
                </a>

                <!-- Mobile Admin Button -->
                <div class="pt-2 border-t border-emerald-600/30">
                    <a href="{{ route('login') }}"
                        class="flex items-center justify-center gap-2 px-4 py-3 bg-white text-emerald-600 font-semibold rounded-lg hover:bg-emerald-50 transition-all duration-200 shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Admin Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');
        const menuIcon = document.getElementById('menuIcon');
        const closeIcon = document.getElementById('closeIcon');

        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInside = mobileMenuButton.contains(event.target) || mobileMenu.contains(event.target);

            if (!isClickInside && !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
                menuIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            }
        });

        // Close mobile menu when window is resized to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                mobileMenu.classList.add('hidden');
                menuIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            }
        });
    </script>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-emerald-600 to-teal-700 text-white mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="bg-white/20 backdrop-blur-md p-2 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold">Pantai Bantul</h3>
                    </div>
                    <p class="text-emerald-100 text-sm leading-relaxed">
                        Sistem Informasi Geografis untuk wisata pantai di Kabupaten Bantul, Daerah Istimewa Yogyakarta.
                    </p>
                </div>

                <div>
                    <h4 class="font-bold mb-4 text-white">Menu</h4>
                    <ul class="space-y-2 text-sm text-emerald-100">
                        <li><a href="{{ route('home') }}"
                                class="hover:text-white transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                                Beranda
                            </a></li>
                        <li><a href="{{ route('wisata.list') }}"
                                class="hover:text-white transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                                Tempat Wisata
                            </a></li>
                        <li><a href="#" class="hover:text-white transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                                Informasi
                            </a></li>
                        <li><a href="{{ route('about') }}"
                                class="hover:text-white transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                                Tentang
                            </a></li>
                        <li><a href="{{ route('login') }}"
                                class="hover:text-white transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                                Admin Login
                            </a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-4 text-white">Kontak</h4>
                    <ul class="space-y-3 text-sm text-emerald-100">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Kabupaten Bantul, Daerah Istimewa Yogyakarta</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span>info@pantaibantul.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-emerald-600/30 mt-8 pt-8 text-center text-sm text-emerald-100">
                <p>&copy; {{ date('Y') }} Pantai Bantul. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Leaflet MarkerCluster JS -->
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

    @stack('scripts')
</body>

</html>
