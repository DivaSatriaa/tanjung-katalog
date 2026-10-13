
@extends('layouts.public')

@section('title', $product->name . ' | TanjungKatalog')

@section('content')

@php
    $umkm = $product->umkm;

    // Normalisasi nomor WhatsApp Indonesia.
    $whatsappNumber = preg_replace('/\D+/', '', (string) $umkm->whatsapp);

    if (str_starts_with($whatsappNumber, '0')) {
        $whatsappNumber = '62' . substr($whatsappNumber, 1);
    } elseif (str_starts_with($whatsappNumber, '8')) {
        $whatsappNumber = '62' . $whatsappNumber;
    }

    $whatsappMessage = 'Halo, saya tertarik dengan produk '
        . $product->name
        . ' dari '
        . $umkm->name
        . '. Apakah produk ini masih tersedia?';

    $whatsappUrl = $whatsappNumber !== ''
        ? 'https://wa.me/' . $whatsappNumber
            . '?text=' . rawurlencode($whatsappMessage)
        : null;
@endphp

<main class="min-h-screen bg-[#F7FAFC]">
    <div class="mx-auto max-w-7xl px-5 py-8 sm:px-8 sm:py-12">

        {{-- Breadcrumb --}}
        <nav class="mb-7 flex flex-wrap items-center gap-2 text-sm text-gray-500"
             aria-label="Breadcrumb">
            <a href="{{ route('home') }}"
               class="transition hover:text-[#326AAB]">
                Beranda
            </a>

            <span>/</span>

            <a href="{{ route('umkm.index') }}"
               class="transition hover:text-[#326AAB]">
                Katalog UMKM
            </a>

            <span>/</span>

            <span class="font-medium text-[#174875]">
                {{ $product->name }}
            </span>
        </nav>

        {{-- Detail produk --}}
        <div class="grid items-start gap-8 lg:grid-cols-2 lg:gap-12">

            {{-- Foto produk --}}
            <section class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">
                <div class="relative aspect-square overflow-hidden bg-gradient-to-br from-[#EAF4F7] to-[#CFE5E2]">

                    @if ($product->image)
                        <img
                            src="{{ asset('storage/' . $product->image) }}"
                            alt="Foto produk {{ $product->name }}"
                            class="h-full w-full object-cover"
                        >
                    @else
                        <div class="flex h-full flex-col items-center justify-center text-[#326AAB]">
                            <span class="text-7xl" aria-hidden="true">📦</span>
                            <p class="mt-4 text-sm font-medium">
                                Foto produk belum tersedia
                            </p>
                        </div>
                    @endif

                    @if ($product->is_featured)
                        <span class="absolute left-5 top-5 rounded-full bg-white/95 px-4 py-2 text-xs font-semibold text-[#326AAB] shadow-sm">
                            Produk Unggulan
                        </span>
                    @endif
                </div>
            </section>

            {{-- Informasi produk --}}
            <section class="flex flex-col">

                <div class="flex flex-wrap items-center gap-2">
                    <span class="rounded-full bg-[#CFE5E2] px-3 py-1.5 text-xs font-semibold text-[#174875]">
                        {{ $umkm->category?->name ?? 'UMKM Lokal' }}
                    </span>

                    <span class="rounded-full bg-green-50 px-3 py-1.5 text-xs font-medium text-green-700">
                        Tersedia di katalog
                    </span>
                </div>

                <h1 class="mt-5 text-3xl font-extrabold leading-tight tracking-tight text-[#174875] sm:text-4xl">
                    {{ $product->name }}
                </h1>

                {{-- Harga --}}
                <div class="mt-5">
                    @if ($product->price !== null)
                        <p class="text-3xl font-bold text-[#326AAB]">
                            Rp{{ number_format((float) $product->price, 0, ',', '.') }}
                        </p>
                    @else
                        <p class="text-lg font-semibold text-gray-600">
                            Harga dapat ditanyakan ke penjual
                        </p>
                    @endif
                </div>

                {{-- Deskripsi --}}
                <div class="mt-7 border-t border-gray-200 pt-6">
                    <h2 class="text-lg font-bold text-[#174875]">
                        Deskripsi Produk
                    </h2>

                    <div class="mt-3 whitespace-pre-line break-words text-sm leading-7 text-gray-600 sm:text-base">
                        @if ($product->description)
                            {{ $product->description }}
                        @else
                            Informasi produk belum ditambahkan oleh penjual.
                        @endif
                    </div>
                </div>

                {{-- Informasi penjual --}}
                <div class="mt-7 rounded-2xl border border-gray-200 bg-white p-5 sm:p-6">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Dijual oleh
                    </p>

                    <div class="mt-3 flex items-start gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#EAF4F7] text-xl text-[#326AAB]">
                            🏪
                        </div>

                        <div class="min-w-0 flex-1">
                            <h2 class="break-words text-lg font-bold text-[#174875]">
                                {{ $umkm->name }}
                            </h2>

                            @if ($umkm->owner_name)
                                <p class="mt-1 text-sm text-gray-500">
                                    Pemilik: {{ $umkm->owner_name }}
                                </p>
                            @endif

                            @if ($umkm->address)
                                <p class="mt-3 flex items-start gap-2 text-sm leading-6 text-gray-600">
                                    <span aria-hidden="true">📍</span>
                                    <span>{{ $umkm->address }}</span>
                                </p>
                            @endif

                            <a
                                href="{{ route('umkm.show', $umkm->slug) }}"
                                class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-[#326AAB] hover:text-[#174875]"
                            >
                                Lihat Profil UMKM
                                <span aria-hidden="true">→</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Hubungi melalui WhatsApp --}}
                <div class="mt-6">
                    @if ($whatsappUrl)
                        <a
                            href="{{ $whatsappUrl }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex w-full items-center justify-center gap-3 rounded-2xl bg-[#16865A] px-6 py-4 text-center font-bold text-white shadow-sm transition hover:bg-[#116B47] focus:outline-none focus:ring-2 focus:ring-[#16865A] focus:ring-offset-2"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="h-6 w-6 shrink-0"
                                aria-hidden="true"
                            >
                                <path d="M20.52 3.48A11.87 11.87 0 0012.04 0C5.48 0 .14 5.33.14 11.89c0 2.1.55 4.15 1.59 5.96L0 24l6.31-1.66a11.9 11.9 0 005.72 1.46h.01c6.56 0 11.9-5.34 11.9-11.9a11.82 11.82 0 00-3.42-8.42zM12.04 21.8a9.9 9.9 0 01-5.05-1.38l-.36-.21-3.75.99 1-3.65-.24-.38a9.86 9.86 0 01-1.52-5.28c0-5.48 4.46-9.94 9.93-9.94a9.88 9.88 0 017.03 2.91 9.86 9.86 0 012.91 7.03c0 5.48-4.46 9.91-9.95 9.91zm5.46-7.43c-.3-.15-1.77-.87-2.05-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.95 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.47-.89-.79-1.49-1.77-1.66-2.07-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.08-.79.37-.27.3-1.04 1.02-1.04 2.49 0 1.47 1.07 2.89 1.22 3.09.15.2 2.11 3.22 5.1 4.51.71.31 1.27.49 1.71.63.72.23 1.37.2 1.88.12.58-.09 1.77-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.07-.12-.27-.2-.57-.35z"/>
                            </svg>

                            <span>Hubungi UMKM via WhatsApp</span>
                        </a>

                        <p class="mt-3 text-center text-xs leading-5 text-gray-500">
                            Pesan awal akan disiapkan otomatis.
                            Periksa pesan sebelum mengirimkannya.
                        </p>
                    @else
                        <div class="rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 text-center">
                            <p class="font-semibold text-amber-800">
                                Kontak WhatsApp belum tersedia
                            </p>

                            <p class="mt-1 text-sm text-amber-700">
                                Silakan buka profil UMKM untuk melihat informasi lainnya.
                            </p>
                        </div>
                    @endif
                </div>

                <a
                    href="{{ route('umkm.index') }}"
                    class="mt-5 inline-flex items-center justify-center gap-2 rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-600 transition hover:border-[#326AAB] hover:text-[#326AAB]"
                >
                    <span aria-hidden="true">←</span>
                    Kembali ke Katalog
                </a>

            </section>
        </div>
    </div>
</main>

@endsection
