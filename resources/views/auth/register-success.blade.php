@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-lg shadow-md p-8">
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <h3 class="text-lg font-semibold text-green-900 mb-2">{{ __('Selamat!') }}</h3>
                    <p class="text-green-700 text-sm mb-3">
                        {{ __('Registrasi Anda berhasil. Silakan menunggu verifikasi dari admin atau super admin sebelum dapat mengakses dashboard.') }}
                    </p>
                    <p class="text-green-700 text-sm">
                        {{ __('Anda akan menerima notifikasi melalui email ketika akun Anda telah diverifikasi.') }}
                    </p>
                </div>

                <div class="text-center">
                    <a href="{{ route('auth.register-form') }}"
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                        {{ __('Kembali ke Beranda') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
