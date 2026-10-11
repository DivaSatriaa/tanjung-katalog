
@extends('layouts.public')

@section('title', 'Peta UMKM')

@section('meta_description', 'Temukan lokasi UMKM yang telah terdaftar di katalog Kelurahan Tanjung Mas.')

@push('styles')
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    >

    <style>
        #umkm-map {
            height: 520px;
            width: 100%;
            z-index: 0;
        }

        .leaflet-popup-content-wrapper {
            border-radius: 14px;
        }

        .leaflet-popup-content {
            margin: 14px 16px;
            line-height: 1.6;
        }

        @media (max-width: 640px) {
            #umkm-map {
                height: 400px;
            }
        }
    </style>
@endpush

@section('content')

<section class="border-b border-[#CFE5E2] bg-gradient-to-br from-white via-[#F5F2EB] to-[#CFE5E2]/70">
    <div class="mx-auto max-w-7xl px-5 py-12 sm:py-16 lg:px-8">

        <div class="max-w-3xl">
            <div class="text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-[#326AAB]">
                    Beranda
                </a>

                <span class="mx-2">/</span>

                <span class="font-semibold text-[#326AAB]">Peta UMKM</span>
            </div>

            <span class="mt-7 inline-flex rounded-full border border-[#CFE5E2] bg-white/80 px-4 py-2 text-xs font-bold uppercase tracking-wider text-[#326AAB]">
                Jelajahi Lokasi Usaha
            </span>

            <h1 class="mt-5 text-3xl font-extrabold leading-tight text-[#174875] sm:text-4xl lg:text-5xl">
                Temukan UMKM di
                <span class="block text-[#326AAB]">Tanjung Mas</span>
            </h1>

            <p class="mt-5 max-w-2xl text-sm leading-7 text-gray-600 sm:text-base">
                Lihat lokasi usaha yang telah terdaftar dan temukan informasi
                UMKM melalui penanda di peta.
            </p>
        </div>

    </div>
</section>

<section class="mx-auto max-w-7xl px-5 py-10 sm:py-12 lg:px-8">

    {{-- Ringkasan --}}
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-[#174875] sm:text-2xl">
                Peta persebaran UMKM
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                {{ $mapPoints->count() }} UMKM memiliki lokasi yang dapat ditampilkan.
            </p>
        </div>

        <span class="inline-flex w-fit items-center gap-2 rounded-full bg-white px-4 py-2 text-sm text-gray-600 ring-1 ring-gray-200">
            <span class="h-2.5 w-2.5 rounded-full bg-[#326AAB]"></span>
            Lokasi terdaftar
        </span>
    </div>

    {{-- Map --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div id="umkm-map" role="region" aria-label="Peta interaktif lokasi UMKM">
        </div>
    </div>

    @if ($mapPoints->isEmpty())
        <div class="mt-6 rounded-2xl border border-dashed border-[#CFE5E2] bg-white p-6 sm:p-8">
            <h3 class="font-bold text-[#174875]">
                Belum ada lokasi UMKM yang tersedia
            </h3>

            <p class="mt-2 text-sm leading-6 text-gray-500">
                UMKM akan muncul pada peta setelah berstatus Published dan
                memiliki koordinat latitude serta longitude yang valid.
                Admin dapat melengkapi koordinat melalui halaman pengelolaan UMKM.
            </p>
        </div>
    @endif

    {{-- Daftar lokasi --}}
    @if ($mapPoints->isNotEmpty())
        <div class="mt-12">
            <h2 class="text-xl font-bold text-[#174875] sm:text-2xl">
                Daftar lokasi terdaftar
            </h2>

            <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($mapPoints as $point)
                    <a
                        href="{{ $point['url'] }}"
                        class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-[#CFE5E2] hover:shadow-md"
                    >
                        <span class="inline-flex rounded-full bg-[#CFE5E2]/70 px-3 py-1 text-xs font-semibold text-[#326AAB]">
                            {{ $point['category'] }}
                        </span>

                        <h3 class="mt-3 font-bold text-[#174875]">
                            {{ $point['name'] }}
                        </h3>

                        <p class="mt-2 line-clamp-2 text-sm leading-6 text-gray-500">
                            {{ $point['address'] ?: 'Alamat belum dilengkapi.' }}
                        </p>

                        <span class="mt-4 inline-flex text-sm font-semibold text-[#326AAB]">
                            Lihat profil →
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</section>

@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const points = {{ Illuminate\Support\Js::from($mapPoints) }};

            // Titik pusat awal peta di sekitar Semarang.
            // Ini hanya pusat tampilan, bukan penanda lokasi UMKM.
            const defaultCenter = [-6.95, 110.42];

            const map = L.map('umkm-map').setView(defaultCenter, 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution:
                    '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            }).addTo(map);

            function escapeHtml(value) {
                return String(value ?? '').replace(/[&<>"']/g, function (char) {
                    return {
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;',
                        '"': '&quot;',
                        "'": '&#039;',
                    }[char];
                });
            }

            const bounds = [];

            points.forEach(function (point) {
                const lat = Number(point.latitude);
                const lng = Number(point.longitude);

                // Jangan tampilkan koordinat yang tidak valid.
                if (
                    !Number.isFinite(lat) ||
                    !Number.isFinite(lng) ||
                    lat < -90 || lat > 90 ||
                    lng < -180 || lng > 180
                ) {
                    return;
                }

                const marker = L.marker([lat, lng]).addTo(map);

                const popup = `
                    <div style="min-width:180px">
                        <p style="font-size:11px;color:#326AAB;font-weight:700;margin-bottom:4px">
                            ${escapeHtml(point.category)}
                        </p>

                        <h3 style="font-size:15px;font-weight:700;color:#174875;margin-bottom:6px">
                            ${escapeHtml(point.name)}
                        </h3>

                        <p style="font-size:12px;color:#6b7280;margin-bottom:10px">
                            ${escapeHtml(point.address || 'Alamat belum dilengkapi.')}
                        </p>

                        <a
                            href="${escapeHtml(point.url)}"
                            style="color:#326AAB;font-size:12px;font-weight:700"
                        >
                            Lihat profil UMKM →
                        </a>
                    </div>
                `;

                marker.bindPopup(popup);
                bounds.push([lat, lng]);
            });

            if (bounds.length > 0) {
                map.fitBounds(bounds, {
                    padding: [40, 40],
                    maxZoom: 15,
                });
            }
        });
    </script>
@endpush
