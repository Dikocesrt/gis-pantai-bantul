@extends('layouts.public')

@section('title', 'Tentang - Pantai Bantul')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-emerald-600 to-teal-700 py-20">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 backdrop-blur-md rounded-2xl mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">
                    Tentang Sistem Informasi Geografis Pantai Bantul
                </h1>
                <p class="text-xl text-emerald-50 leading-relaxed">
                    Platform digital yang memudahkan Anda menjelajahi keindahan pantai-pantai di Kabupaten Bantul, Daerah
                    Istimewa Yogyakarta
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Introduction -->
            <div class="max-w-4xl mx-auto mb-16">
                <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl p-8 border border-emerald-100">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Apa itu GIS Pantai Bantul?</h2>
                    <div class="space-y-4 text-lg text-gray-700 leading-relaxed">
                        <p>
                            <strong>Sistem Informasi Geografis (GIS) Pantai Bantul</strong> adalah platform digital berbasis
                            web yang dirancang khusus untuk membantu wisatawan, peneliti, dan masyarakat umum dalam
                            mengeksplorasi destinasi wisata pantai di Kabupaten Bantul, Daerah Istimewa Yogyakarta.
                        </p>
                        <p>
                            Dengan memanfaatkan teknologi pemetaan interaktif dan database komprehensif, sistem ini
                            menyediakan informasi lengkap tentang lokasi, fasilitas, kondisi pantai, dan berbagai aspek
                            penting lainnya yang membantu Anda merencanakan kunjungan dengan lebih baik.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="mb-16">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Fitur Unggulan</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Berbagai fitur yang memudahkan Anda dalam menjelajahi
                        pantai-pantai di Bantul</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div
                        class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="bg-emerald-100 w-14 h-14 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Peta Interaktif</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Visualisasi lokasi pantai dengan peta interaktif yang dilengkapi marker clustering dan boundary
                            kecamatan untuk navigasi yang mudah.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div
                        class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="bg-teal-100 w-14 h-14 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Filter Pencarian</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Temukan pantai sesuai preferensi dengan filter berdasarkan kecamatan, fasilitas, layanan, dan
                            kondisi pantai yang tersedia.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div
                        class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="bg-cyan-100 w-14 h-14 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Informasi Lengkap</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Detail komprehensif setiap pantai meliputi deskripsi, alamat, koordinat, foto, fasilitas,
                            layanan, dan jam operasional.
                        </p>
                    </div>

                    <!-- Feature 4 -->
                    <div
                        class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="bg-emerald-100 w-14 h-14 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Kondisi Pantai</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Informasi kondisi pantai seperti tingkat keamanan, kebersihan, aksesibilitas jalan, kondisi
                            ombak, keteduhan, dan kenyamanan lingkungan.
                        </p>
                    </div>

                    <!-- Feature 5 -->
                    <div
                        class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="bg-teal-100 w-14 h-14 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Informasi Harga</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Transparansi harga tiket masuk dan tarif parkir untuk berbagai jenis kendaraan, membantu Anda
                            mempersiapkan budget kunjungan.
                        </p>
                    </div>

                    <!-- Feature 6 -->
                    <div
                        class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="bg-cyan-100 w-14 h-14 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Sosial Media</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Akses langsung ke website dan sosial media resmi setiap pantai untuk informasi terkini dan
                            promosi menarik.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Technology Stack -->
            <div class="mb-16">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Teknologi yang Digunakan</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Platform ini dibangun dengan teknologi modern untuk performa
                        optimal</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div
                        class="bg-white rounded-xl shadow-lg p-6 text-center border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="text-4xl mb-3">🗺️</div>
                        <h4 class="font-bold text-gray-900 mb-1">Leaflet.js</h4>
                        <p class="text-sm text-gray-600">Peta Interaktif</p>
                    </div>
                    <div
                        class="bg-white rounded-xl shadow-lg p-6 text-center border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="text-4xl mb-3">🎨</div>
                        <h4 class="font-bold text-gray-900 mb-1">Tailwind CSS</h4>
                        <p class="text-sm text-gray-600">UI Framework</p>
                    </div>
                    <div
                        class="bg-white rounded-xl shadow-lg p-6 text-center border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="text-4xl mb-3">⚡</div>
                        <h4 class="font-bold text-gray-900 mb-1">Laravel</h4>
                        <p class="text-sm text-gray-600">Backend Framework</p>
                    </div>
                    <div
                        class="bg-white rounded-xl shadow-lg p-6 text-center border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="text-4xl mb-3">☁️</div>
                        <h4 class="font-bold text-gray-900 mb-1">Cloudinary</h4>
                        <p class="text-sm text-gray-600">Image Storage</p>
                    </div>
                </div>
            </div>

            <!-- Benefits Section -->
            <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl p-8 md:p-12 border border-emerald-100">
                <div class="max-w-4xl mx-auto">
                    <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Manfaat Sistem</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-start gap-4">
                            <div class="bg-emerald-500 rounded-full p-2 shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">Untuk Wisatawan</h4>
                                <p class="text-gray-700">Memudahkan perencanaan perjalanan dengan informasi lengkap dan
                                    akurat tentang destinasi pantai.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="bg-emerald-500 rounded-full p-2 shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">Untuk Pengelola</h4>
                                <p class="text-gray-700">Mempromosikan destinasi wisata dan menyediakan informasi terkini
                                    kepada calon pengunjung.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="bg-emerald-500 rounded-full p-2 shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">Untuk Pemerintah</h4>
                                <p class="text-gray-700">Mendukung promosi pariwisata daerah dan penyediaan data geografis
                                    yang terstruktur.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="bg-emerald-500 rounded-full p-2 shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">Untuk Peneliti</h4>
                                <p class="text-gray-700">Menyediakan data geografis dan informasi pantai untuk keperluan
                                    penelitian dan analisis.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="mt-16 text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Siap Menjelajahi Pantai Bantul?</h2>
                <p class="text-gray-600 mb-8 max-w-2xl mx-auto">
                    Mulai petualangan Anda sekarang dan temukan keindahan pantai-pantai tersembunyi di Kabupaten Bantul
                </p>
                <div class="flex flex-wrap items-center justify-center gap-4">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold rounded-xl transition-all duration-200 shadow-xl hover:shadow-2xl transform hover:scale-105">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                            </path>
                        </svg>
                        Jelajahi Peta
                    </a>
                    <a href="{{ route('wisata.list') }}"
                        class="inline-flex items-center gap-3 px-8 py-4 bg-white hover:bg-gray-50 text-emerald-600 font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl border-2 border-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        Lihat Semua Pantai
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
