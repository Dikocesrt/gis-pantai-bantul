<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GIS Pantai Bantul') }}</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50">
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ url('/') }}" class="text-xl font-semibold text-gray-900">
                    {{ config('app.name', 'GIS Pantai Bantul') }}
                </a>

                <div class="flex items-center gap-4">
                    @guest
                        <a href="{{ route('auth.register-form') }}" class="text-gray-600 hover:text-gray-900">
                            {{ __('Daftar Admin') }}
                        </a>
                    @else
                        <div class="relative group">
                            <button class="flex items-center gap-2 text-gray-900 hover:text-gray-600">
                                {{ Auth::user()->name }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            </button>

                            <div
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg hidden group-hover:block z-50">
                                @if (Auth::user()->role === 'super_admin')
                                    <a href="{{ route('admin.verification.index') }}"
                                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100 first:rounded-t-lg">
                                        {{ __('Verifikasi Admin') }}
                                    </a>
                                    <hr class="my-1">
                                @endif

                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 last:rounded-b-lg">
                                        {{ __('Logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <main class="py-8">
        @yield('content')
    </main>
</body>

</html>
