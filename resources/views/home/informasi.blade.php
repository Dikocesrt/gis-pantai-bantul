@extends('layouts.public')

@section('title', 'Informasi & Berita')

@section('content')
    <!-- Hero Section -->
    <div class="bg-white text-black pt-16 pb-4">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Informasi & Berita</h1>
                <p class="text-lg md:text-xl text-black">
                    Dapatkan informasi terbaru seputar pantai-pantai di Bantul, acara, dan pengumuman penting lainnya
                </p>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="container mx-auto px-4 py-12">
        @if ($informasis->isEmpty())
            <!-- Empty State -->
            <div class="max-w-2xl mx-auto text-center py-16">
                <div class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Informasi</h3>
                <p class="text-gray-600">Informasi dan berita akan ditampilkan di sini</p>
            </div>
        @else
            <!-- Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-7xl mx-auto">
                @foreach ($informasis as $info)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden cursor-pointer group"
                        onclick="openModal('{{ $info->id }}')">
                        <!-- Image -->
                        <div class="relative h-48 bg-gray-200 overflow-hidden">
                            @if ($info->image_url)
                                <img src="{{ $info->image_url }}" alt="{{ $info->title }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            @else
                                <div
                                    class="w-full h-full flex items-center justify-center bg-gradient-to-br from-emerald-100 to-teal-100">
                                    <svg class="w-16 h-16 text-emerald-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                                        </path>
                                    </svg>
                                </div>
                            @endif

                            <!-- Badge -->
                            @if ($info->event_date)
                                <div class="absolute top-3 right-3">
                                    <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                        EVENT
                                    </span>
                                </div>
                            @else
                                <div class="absolute top-3 right-3">
                                    <span class="bg-blue-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                        BERITA
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="p-5">
                            <h3
                                class="text-xl font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-emerald-600 transition-colors">
                                {{ $info->title }}
                            </h3>
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                {{ $info->description }}
                            </p>

                            <!-- Meta Info -->
                            <div
                                class="flex items-center justify-between text-xs text-gray-500 pt-3 border-t border-gray-100">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span>{{ \Carbon\Carbon::parse($info->published_at)->format('d M Y') }}</span>
                                </div>
                                <span class="text-emerald-600 font-semibold group-hover:underline">Baca Selengkapnya
                                    →</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Modal -->
    <div id="infoModal" class="hidden fixed inset-0 bg-black/80 z-[100] flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto shadow-2xl transform transition-all relative z-[101]"
            onclick="event.stopPropagation()">
            <!-- Modal Content (will be populated by JavaScript) -->
            <div id="modalContent"></div>
        </div>
    </div>

    <script>
        const informasis = @json($informasis);

        function openModal(id) {
            const info = informasis.find(i => i.id === id);
            if (!info) return;

            const modal = document.getElementById('infoModal');
            const modalContent = document.getElementById('modalContent');

            // Build modal content
            let html = `
                <!-- Close Button -->
                <button onclick="closeModal()" class="absolute top-4 right-4 z-10 bg-white rounded-full p-2 shadow-lg hover:bg-gray-100 transition">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- Image -->
                ${info.image_url ? `
                                            <div class="relative h-64 md:h-80 bg-gray-200 overflow-hidden rounded-t-2xl">
                                                <img src="${info.image_url}" alt="${info.title}" class="w-full h-full object-cover">
                                            </div>
                                        ` : ''}

                <!-- Content -->
                <div class="p-6 md:p-8">
                    <!-- Badge & Date -->
                    <div class="flex items-center justify-between mb-4">
                        ${info.event_date ? `
                                                    <span class="bg-red-500 text-white text-sm font-bold px-4 py-1 rounded-full">EVENT</span>
                                                ` : `
                                                    <span class="bg-blue-500 text-white text-sm font-bold px-4 py-1 rounded-full">BERITA</span>
                                                `}
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>${new Date(info.published_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}</span>
                        </div>
                    </div>

                    <!-- Title -->
                    <h2 class="text-3xl font-bold text-gray-900 mb-3">${info.title}</h2>

                    <!-- Description -->
                    <p class="text-lg text-gray-700 mb-6 font-medium">${info.description}</p>

                    <!-- Event Info (if event) -->
                    ${info.event_date ? `
                                                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-5 mb-6">
                                                    <h3 class="text-lg font-bold text-emerald-900 mb-3 flex items-center gap-2">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                        Detail Acara
                                                    </h3>
                                                    <div class="space-y-2">
                                                        ${info.event_location ? `
                                    <div class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-700">Lokasi</p>
                                            <p class="text-gray-900">${info.event_location}</p>
                                        </div>
                                    </div>
                                ` : ''}
                                                        ${info.event_date ? `
                                    <div class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-700">Tanggal</p>
                                            <p class="text-gray-900">${new Date(info.event_date).toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })}</p>
                                        </div>
                                    </div>
                                ` : ''}
                                                        ${info.event_start_time || info.event_end_time ? `
                                    <div class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-700">Waktu</p>
                                            <p class="text-gray-900">${info.event_start_time || ''} ${info.event_end_time ? '- ' + info.event_end_time : ''} WIB</p>
                                        </div>
                                    </div>
                                ` : ''}
                                                        ${info.tempat_wisata ? `
                                    <div class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-700">Tempat Wisata</p>
                                            <a href="/wisata/${info.tempat_wisata.slug}" class="text-emerald-600 hover:text-emerald-700 font-medium hover:underline">${info.tempat_wisata.name}</a>
                                        </div>
                                    </div>
                                ` : ''}
                                                    </div>
                                                </div>
                                            ` : ''}

                    <!-- Content -->
                    <div class="prose prose-lg max-w-none">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Detail Informasi</h3>
                        <div class="text-gray-700 leading-relaxed whitespace-pre-line">${info.content}</div>
                    </div>
                </div>
            `;

            modalContent.innerHTML = html;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('infoModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        // Close modal when clicking outside
        document.getElementById('infoModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>
@endsection
