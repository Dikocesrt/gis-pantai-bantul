<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GIS Pantai Bantul') }} - Registrasi Berhasil</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-linear-to-br from-emerald-50 to-teal-100">
    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-4xl">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="grid md:grid-cols-2">
                    <!-- Left Side - Success Icon & Info -->
                    <div
                        class="bg-linear-to-br from-emerald-600 to-teal-700 p-12 text-white flex flex-col justify-center items-center text-center">
                        <div class="mb-8">
                            <div
                                class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mb-6 mx-auto backdrop-blur-sm">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h1 class="text-4xl font-bold mb-3">Registrasi Berhasil!</h1>
                            <p class="text-emerald-100 text-lg">Akun Anda sedang dalam proses verifikasi</p>
                        </div>

                        <div class="space-y-4 max-w-sm">
                            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
                                <div class="flex items-center gap-3 mb-2">
                                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h3 class="font-semibold">Waktu Verifikasi</h3>
                                </div>
                                <p class="text-emerald-100 text-sm">Proses verifikasi memakan waktu maksimal 1x24 jam
                                </p>
                            </div>

                            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
                                <div class="flex items-center gap-3 mb-2">
                                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <h3 class="font-semibold">Notifikasi Email</h3>
                                </div>
                                <p class="text-emerald-100 text-sm">Anda akan menerima email konfirmasi setelah
                                    diverifikasi</p>
                            </div>
                        </div>

                        <div class="mt-12 pt-8 border-t border-emerald-500 w-full">
                            <p class="text-emerald-100 text-sm">© 2025 GIS Pantai Bantul. Daerah Istimewa Yogyakarta</p>
                        </div>
                    </div>

                    <!-- Right Side - Success Message & Actions -->
                    <div class="p-12 flex flex-col justify-center">
                        <div class="mb-8">
                            <div
                                class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-700 rounded-full mb-6">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-semibold text-sm">Pendaftaran Diterima</span>
                            </div>

                            <h2 class="text-3xl font-bold text-gray-900 mb-4">Terima Kasih!</h2>
                            <p class="text-gray-600 leading-relaxed mb-6">
                                Registrasi Anda telah berhasil dikirim. Silakan menunggu verifikasi dari super admin
                                sebelum dapat mengakses dashboard.
                            </p>

                            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg mb-8">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3 shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div class="flex-1">
                                        <p class="text-blue-800 text-sm font-medium mb-1">Langkah Selanjutnya</p>
                                        <p class="text-blue-700 text-sm">
                                            Pastikan email Anda aktif untuk menerima notifikasi verifikasi. Setelah
                                            diverifikasi, Anda dapat login menggunakan kredensial yang telah
                                            didaftarkan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <a href="{{ route('login') }}"
                                class="block w-full text-center bg-linear-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                Kembali ke Login
                            </a>
                            <a href="{{ route('auth.register-form') }}"
                                class="block w-full text-center border-2 border-gray-300 hover:border-emerald-500 text-gray-700 hover:text-emerald-600 font-semibold py-3 px-4 rounded-lg transition duration-200">
                                Daftar Akun Lain
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
