@extends('layouts.public')

@section('title', 'Beranda')

@section('content')

{{-- Hero Section --}}
<section class="bg-[#F5F2EB] px-5 py-6 sm:py-8">
    <div class="w-full max-w-none">

        {{-- Main Hero Card --}}
        <div class="relative overflow-hidden rounded-3xl border border-[#CFE5E2] bg-gradient-to-br from-[#F8FCFD] via-[#EAF4F7] to-[#CFE5E2] shadow-[0_12px_40px_rgba(50,106,171,0.12)]">

            <div class="pointer-events-none absolute -right-16 -top-16 h-64 w-64 rounded-full bg-[#6EA8C7]/20 blur-3xl"></div>

           <div class="relative grid grid-cols-[minmax(0,1fr)] items-center gap-8 px-6 py-8 sm:px-10 sm:py-10 lg:grid-cols-[1.05fr_0.95fr] lg:gap-8 lg:px-12 lg:py-10 xl:px-14 xl:py-12">

            {{-- Headline --}}
            <div class="relative z-10">

                <span class="inline-flex items-center gap-2 rounded-full border border-[#CFE5E2] bg-white/80 px-4 py-2 text-xs font-bold uppercase tracking-wider text-[#326AAB]">
                    <span class="h-2 w-2 rounded-full bg-[#6EA8C7]"></span>
                    Katalog UMKM Tanjung Mas
                </span>

                <h1 class="mt-6 max-w-2xl text-4xl font-extrabold leading-[1.12] tracking-tight text-[#174875] sm:text-5xl xl:text-6xl">
                    Dukung UMKM,
                    <span class="mt-1 block bg-gradient-to-r from-[#326AAB] to-[#6EA8C7] bg-clip-text text-transparent">
                        Majukan Tanjung Mas
                    </span>
                </h1>

                <p class="mt-6 max-w-lg text-base leading-7 text-gray-600 sm:text-lg">
                    Temukan berbagai produk unggulan UMKM di Kelurahan
                    Tanjung Mas. Mari dukung produk lokal untuk ekonomi
                    yang lebih kuat.
                </p>

                {{-- Search --}}
                <form
                    method="GET"
                    action="{{ route('product.index') }}"
                    class="mt-8 flex max-w-lg items-center gap-2 rounded-2xl border border-gray-200 bg-white p-2 shadow-sm focus-within:border-[#6EA8C7] focus-within:ring-2 focus-within:ring-[#6EA8C7]/20"
                >
                    <span class="pl-3 text-[#326AAB]" aria-hidden="true">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="21"
                            height="21"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.35-4.35"/>
                        </svg>
                    </span>

                    <input
                        type="search"
                        name="q"
                        placeholder="Cari produk atau UMKM..."
                        aria-label="Cari produk atau UMKM"
                        class="min-w-0 flex-1 border-0 bg-transparent px-2 py-3 text-sm outline-none focus:ring-0"
                    >

                    <button
                        type="submit"
                        class="shrink-0 rounded-xl bg-[#326AAB] px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#28598f]"
                    >
                        Cari
                    </button>
                </form>

                {{-- CTA --}}
                <div class="mt-5 flex flex-wrap gap-3">

                    <a
                        href="{{ route('product.index') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-full bg-[#326AAB] px-6 py-3.5 text-sm font-semibold text-white shadow-md shadow-[#326AAB]/20 transition hover:-translate-y-0.5 hover:bg-[#28598f]"
                    >
                        Lihat Katalog
                        <span aria-hidden="true">&rarr;</span>
                    </a>

                    <a
                        href="{{ route('peta.index') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-full border border-[#326AAB] bg-white/70 px-6 py-3.5 text-sm font-semibold text-[#326AAB] transition hover:bg-[#CFE5E2]/50"
                    >
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 21s7-6.2 7-11a7 7 0 0 0-14 0c0 4.8 7 11 7 11Z"/>
                            <circle cx="12" cy="10" r="2.5"/>
                        </svg>
                        Lihat Peta UMKM
                    </a>

                </div>

            </div>

            {{-- Hero Image --}}
            <div class="relative mx-auto w-full max-w-xl pb-7 lg:max-w-none">

                <div class="pointer-events-none absolute -right-5 -top-5 h-32 w-32 rounded-full bg-[#6EA8C7]/25 blur-3xl"></div>

                <div class="relative overflow-hidden rounded-[2rem] rounded-tl-[5rem] border border-white/70 bg-[#CFE5E2] shadow-lg shadow-[#326AAB]/10">

                    <img
                        src="{{ asset('images/tanjung-mas-hero.jpg') }}"
                        alt="Pemandangan kawasan pelabuhan Tanjung Mas, Semarang"
                        class="h-[320px] w-full object-cover sm:h-[380px] lg:h-[410px] xl:h-[440px]"
                    >

                    {{-- Overlay agar teks tetap terbaca --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-[#174875]/80 via-[#174875]/10 to-transparent"></div>

                    {{-- Caption --}}
                    <div class="absolute inset-x-0 bottom-0 px-6 pb-24 pt-10 sm:px-8 sm:pb-24">

                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-white/80">
                            Potensi Lokal
                        </p>

                        <h2 class="mt-2 text-xl font-bold text-white sm:text-2xl">
                            Produk Lokal, Kekuatan Kita.
                        </h2>

                        <p class="mt-2 max-w-md text-sm leading-5 text-white/85">
                            Kenali pelaku usaha dan temukan produk lokal kebanggaan Tanjung Mas.
                        </p>

                    </div>
                </div>

                {{-- Statistik dinamis --}}
                <div class="absolute inset-x-4 bottom-0 grid grid-cols-2 gap-3 sm:inset-x-6">

                    <div class="rounded-2xl border border-white/80 bg-white/95 p-4 shadow-lg backdrop-blur">
                        <p class="text-2xl font-extrabold text-[#326AAB]">
                            {{ $totalUmkms }}
                        </p>

                        <p class="mt-1 text-xs font-medium text-gray-500 sm:text-sm">
                            UMKM terpublikasi
                        </p>
                    </div>

                    <div class="rounded-2xl border border-white/80 bg-white/95 p-4 shadow-lg backdrop-blur">
                        <p class="text-2xl font-extrabold text-[#326AAB]">
                            {{ $totalProducts }}
                        </p>

                        <p class="mt-1 text-xs font-medium text-gray-500 sm:text-sm">
                            Produk terpublikasi
                        </p>
                    </div>

                </div>

            </div>

            {{-- Keunggulan --}}
            <div class="relative z-10 w-full lg:col-span-2 border-t border-white/70 bg-white/25 px-5 py-7 sm:px-8 lg:px-10">
                <div class="grid grid-cols-2 gap-6 md:grid-cols-4">

                    {{-- Katalog --}}
                    <div class="px-2 py-2 text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white/80 text-[#326AAB]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9.5 12 4l9 5.5"/>
                                <path d="M5 10v10h14V10"/>
                                <path d="M9 20v-6h6v6"/>
                            </svg>
                        </div>
                        <h3 class="mt-3 font-bold text-[#174875]">Katalog Lengkap</h3>
                        <p class="mx-auto mt-2 max-w-44 text-xs leading-5 text-gray-500 sm:text-sm">
                            Temukan profil dan produk UMKM Tanjung Mas.
                        </p>
                    </div>

                    {{-- Lokasi --}}
                    <div class="px-2 py-2 text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white/80 text-[#326AAB]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"/>
                                <circle cx="12" cy="10" r="2.5"/>
                            </svg>
                        </div>
                        <h3 class="mt-3 font-bold text-[#174875]">Peta Lokasi</h3>
                        <p class="mx-auto mt-2 max-w-44 text-xs leading-5 text-gray-500 sm:text-sm">
                            Kenali lokasi usaha dengan mudah.
                        </p>
                    </div>

                    {{-- Produk --}}
                    <div class="px-2 py-2 text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white/80 text-[#326AAB]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m12 3 2.7 5.5 6.1.9-4.4 4.3 1 6.1-5.4-2.9-5.4 2.9 1-6.1-4.4-4.3 6.1-.9L12 3Z"/>
                            </svg>
                        </div>
                        <h3 class="mt-3 font-bold text-[#174875]">Produk Unggulan</h3>
                        <p class="mx-auto mt-2 max-w-44 text-xs leading-5 text-gray-500 sm:text-sm">
                            Lihat produk pilihan dari UMKM lokal.
                        </p>
                    </div>

                    {{-- Dukung Lokal --}}
                    <div class="px-2 py-2 text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white/80 text-[#326AAB]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="10" cy="7" r="4"/>
                                <path d="M20 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        </div>
                        <h3 class="mt-3 font-bold text-[#174875]">Dukung Lokal</h3>
                        <p class="mx-auto mt-2 max-w-44 text-xs leading-5 text-gray-500 sm:text-sm">
                            Bersama memajukan ekonomi warga.
                        </p>
                    </div>

                </div>
            </div>
        </div> {{-- Main Hero Card --}}
    </div> {{-- Container --}}
</section>



{{-- Kategori UMKM --}}
<section id="kategori" class="mx-auto max-w-7xl px-5 py-14 lg:px-8">

    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-bold uppercase tracking-wider text-[#326AAB]">
                Jelajahi
            </p>

            <h2 class="mt-2 text-2xl font-extrabold text-[#174875] sm:text-3xl">
                Temukan berdasarkan kategori
            </h2>

            <p class="mt-2 text-sm leading-6 text-gray-500 sm:text-base">
                Jelajahi berbagai jenis usaha dan produk lokal Tanjung Mas.
            </p>
        </div>

        <a
            href="{{ route('umkm.index') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-[#326AAB] transition hover:gap-3"
        >
            Lihat semua UMKM <span>→</span>
        </a>
    </div>

    <div class="mt-7 grid grid-cols-4 gap-x-2 gap-y-4 sm:grid-cols-3 sm:gap-4 md:grid-cols-4 lg:grid-cols-6">

        @forelse ($categories as $category)
            <a
                href="{{ route('umkm.index', ['category' => $category->slug]) }}"
                class="group rounded-2xl text-center transition duration-300 sm:border sm:border-gray-100 sm:bg-white sm:p-5 sm:shadow-sm sm:hover:-translate-y-1 sm:hover:border-[#CFE5E2] sm:hover:shadow-lg"
            >

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-[#326AAB] shadow-sm transition group-hover:bg-[#326AAB]/10 sm:bg-[#CFE5E2]/60 sm:shadow-none">
                    <x-category-icon :category="$category" />
                </div>

                <h3 class="mt-2 text-[11px] font-semibold leading-tight text-[#174875] transition group-hover:text-[#326AAB] sm:mt-4 sm:text-sm sm:font-bold">
                    {{ $category->name }}
                </h3>

                <p class="mt-2 hidden text-xs text-gray-500 sm:block">
                    {{ $category->umkms_count }} UMKM
                </p>

            </a>
        @empty
            <div class="col-span-full rounded-2xl border border-dashed border-gray-300 bg-white p-8">
                <p class="font-semibold text-gray-800">
                    Kategori belum tersedia.
                </p>

                <p class="mt-2 text-sm text-gray-500">
                    Kategori dapat ditambahkan melalui dashboard administrator.
                </p>
            </div>
        @endforelse

    </div>

</section>



{{-- UMKM Pilihan --}}
<section class="mx-auto max-w-7xl px-5 py-14 lg:px-8">

    {{-- Section Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

        <div>
            <p class="text-sm font-bold uppercase tracking-[0.15em] text-[#326AAB]">
                Kenali Usaha Lokal
            </p>

            <h2 class="mt-2 text-2xl font-extrabold tracking-tight text-[#174875] sm:text-3xl">
                UMKM Pilihan
            </h2>

            <p class="mt-2 max-w-xl text-sm leading-6 text-gray-500 sm:text-base">
                Kenali para pelaku usaha dan temukan produk lokal kebanggaan Tanjung Mas.
            </p>
        </div>

        <a
            href="{{ route('umkm.index') }}"
            class="inline-flex w-fit shrink-0 items-center gap-2 text-sm font-semibold text-[#326AAB] transition hover:gap-3"
        >
            Lihat semua UMKM
            <span aria-hidden="true">→</span>
        </a>

    </div>

    {{-- UMKM Cards --}}
    <div class="-mx-5 mt-8 flex snap-x snap-mandatory gap-4 overflow-x-auto px-5 pb-3 sm:mx-0 sm:grid sm:grid-cols-2 sm:gap-6 sm:overflow-visible sm:px-0 sm:pb-0 lg:grid-cols-3">

        @forelse ($featuredUmkms as $umkm)

            <article class="group flex h-full w-[82%] shrink-0 snap-start flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-[#CFE5E2] hover:shadow-xl sm:w-auto">

                {{-- Cover Image --}}
                <a
                    href="{{ route('umkm.show', $umkm->slug) }}"
                    class="relative block overflow-hidden"
                >
                    <div class="aspect-[4/3] overflow-hidden bg-gradient-to-br from-[#EAF4F7] to-[#CFE5E2]">

                        @if ($umkm->cover_image)
                            <img
                                src="{{ asset('storage/' . $umkm->cover_image) }}"
                                alt="Foto {{ $umkm->name }}"
                                loading="lazy"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                            >
                        @else
                            <div class="flex h-full w-full flex-col items-center justify-center text-[#326AAB]">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="52"
                                    height="52"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.3"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M3 9.5 12 4l9 5.5"/>
                                    <path d="M5 10v10h14V10"/>
                                    <path d="M9 20v-6h6v6"/>
                                </svg>

                                <span class="mt-3 text-sm font-medium">
                                    Foto UMKM
                                </span>
                            </div>
                        @endif

                    </div>

                    {{-- Category Badge --}}
                    <div class="absolute left-4 top-4">
                        <span class="inline-flex rounded-full border border-white/70 bg-white/95 px-3 py-1.5 text-xs font-semibold text-[#326AAB] shadow-sm backdrop-blur">
                            {{ $umkm->category->name }}
                        </span>
                    </div>

                    {{-- Featured Badge --}}
                    @if ($umkm->is_featured)
                        <div class="absolute right-4 top-4">
                            <span class="inline-flex items-center gap-1 rounded-full bg-[#326AAB] px-3 py-1.5 text-xs font-semibold text-white shadow-sm">
                                <span aria-hidden="true">★</span>
                                Unggulan
                            </span>
                        </div>
                    @endif

                </a>

                {{-- Card Content --}}
                <div class="flex flex-1 flex-col p-5">

                    <h3 class="text-lg font-bold leading-snug text-[#174875] transition group-hover:text-[#326AAB]">
                        <a href="{{ route('umkm.show', $umkm->slug) }}">
                            {{ $umkm->name }}
                        </a>
                    </h3>

                    <p class="mt-2 line-clamp-3 flex-1 text-sm leading-6 text-gray-500">
                        {{ $umkm->description ?: 'Profil dan informasi usaha lokal dari Kelurahan Tanjung Mas.' }}
                    </p>

                    {{-- Location --}}
                    @if ($umkm->address)
                        <div class="mt-4 flex items-start gap-2 text-sm text-gray-500">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="17"
                                height="17"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="mt-0.5 shrink-0 text-[#6EA8C7]"
                            >
                                <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"/>
                                <circle cx="12" cy="10" r="2.5"/>
                            </svg>

                            <span class="line-clamp-2">
                                {{ $umkm->address }}
                            </span>
                        </div>
                    @endif

                    {{-- Footer --}}
                    <div class="mt-5 flex items-center justify-between gap-3 border-t border-gray-100 pt-4">

                        <div>
                            <p class="text-lg font-bold text-[#326AAB]">
                                {{ $umkm->products_count }}
                            </p>

                            <p class="text-xs text-gray-500">
                                Produk tersedia
                            </p>
                        </div>

                        <a
                            href="{{ route('umkm.show', $umkm->slug) }}"
                            class="inline-flex items-center gap-2 rounded-full border border-[#326AAB]/30 px-4 py-2.5 text-sm font-semibold text-[#326AAB] transition hover:border-[#326AAB] hover:bg-[#326AAB] hover:text-white"
                        >
                            Lihat Detail
                            <span aria-hidden="true">→</span>
                        </a>

                    </div>

                </div>

            </article>

        @empty

            <div class="w-full shrink-0 rounded-2xl border border-dashed border-[#CFE5E2] bg-white p-8 sm:col-span-2 lg:col-span-3">
                <div class="mx-auto max-w-md py-5 text-center">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#CFE5E2]/60 text-[#326AAB]">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="32"
                            height="32"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M3 9.5 12 4l9 5.5"/>
                            <path d="M5 10v10h14V10"/>
                            <path d="M9 20v-6h6v6"/>
                        </svg>
                    </div>

                    <h3 class="mt-5 text-lg font-bold text-[#174875]">
                        UMKM pilihan segera hadir
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        UMKM akan ditampilkan di sini setelah data usaha siap dan dipublikasikan.
                    </p>

                    <a
                        href="{{ route('umkm.index') }}"
                        class="mt-5 inline-flex items-center gap-2 font-semibold text-[#326AAB] hover:underline"
                    >
                        Jelajahi katalog
                        <span aria-hidden="true">→</span>
                    </a>

                </div>
            </div>

        @endforelse

    </div>

</section>


{{-- Produk Terbaru --}}
<section class="bg-white py-14 sm:py-16">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">

        {{-- Section Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.15em] text-[#326AAB]">
                    Produk Lokal
                </p>

                <h2 class="mt-2 text-2xl font-extrabold tracking-tight text-[#174875] sm:text-3xl">
                    Produk Terbaru
                </h2>

                <p class="mt-2 max-w-xl text-sm leading-6 text-gray-500 sm:text-base">
                    Temukan produk pilihan dari pelaku UMKM Kelurahan Tanjung Mas.
                </p>
            </div>

            <a
                href="{{ route('product.index') }}"
                class="inline-flex w-fit shrink-0 items-center gap-2 text-sm font-semibold text-[#326AAB] transition hover:gap-3"
            >
                Lihat semua produk
                <span aria-hidden="true">→</span>
            </a>
        </div>

        {{-- Product Cards --}}
        <div class="mt-8 grid grid-cols-2 gap-4 sm:gap-5 lg:grid-cols-4">

            @forelse ($latestProducts as $product)

                <x-product-card :product="$product" />

            @empty

                <div class="rounded-2xl border border-dashed border-[#CFE5E2] bg-[#F5F2EB]/50 p-8 sm:col-span-2 lg:col-span-4">
                    <div class="mx-auto max-w-md py-5 text-center">

                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#CFE5E2]/60 text-[#326AAB]">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="32"
                                height="32"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="m3 7 9-4 9 4-9 5-9-5Z"/>
                                <path d="M3 7v10l9 5 9-5V7"/>
                                <path d="M12 12v10"/>
                            </svg>
                        </div>

                        <h3 class="mt-5 text-lg font-bold text-[#174875]">
                            Produk segera hadir
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-gray-500">
                            Produk akan ditampilkan setelah data dan foto siap dipublikasikan oleh admin.
                        </p>

                        <a
                            href="{{ route('umkm.index') }}"
                            class="mt-5 inline-flex items-center gap-2 font-semibold text-[#326AAB] hover:underline"
                        >
                            Lihat katalog UMKM
                            <span aria-hidden="true">→</span>
                        </a>

                    </div>
                </div>

            @endforelse

        </div>

    </div>
</section>


{{-- Berita Terbaru --}}
@if ($latestPosts->isNotEmpty())
    <section class="mx-auto max-w-7xl px-5 py-14 lg:px-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.15em] text-[#326AAB]">
                    Kabar Tanjung Mas
                </p>

                <h2 class="mt-2 text-2xl font-extrabold tracking-tight text-[#174875] sm:text-3xl">
                    Berita Terbaru
                </h2>

                <p class="mt-2 max-w-xl text-sm leading-6 text-gray-500 sm:text-base">
                    Kegiatan, pelatihan, dan kabar terbaru seputar UMKM Kelurahan Tanjung Mas.
                </p>
            </div>

            <a
                href="{{ route('posts.index') }}"
                class="inline-flex w-fit shrink-0 items-center gap-2 text-sm font-semibold text-[#326AAB] transition hover:gap-3"
            >
                Semua berita
                <span aria-hidden="true">&rarr;</span>
            </a>
        </div>

        <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($latestPosts as $post)
                <x-post-card :post="$post" />
            @endforeach
        </div>
    </section>
@endif


{{-- Tentang --}}
<section id="tentang" class="mx-auto max-w-4xl px-5 py-16 text-center">

    <p class="text-sm font-bold uppercase tracking-wider text-[#326AAB]">
        Tentang TanjungKatalog
    </p>

    <h2 class="mt-3 text-2xl font-bold text-gray-900 sm:text-3xl">
        Mendekatkan produk lokal dengan masyarakat
    </h2>

    <p class="mx-auto mt-5 max-w-2xl leading-7 text-gray-600">
        TanjungKatalog merupakan katalog digital untuk membantu masyarakat
        mengenal usaha dan produk UMKM Kelurahan Tanjung Mas. Pengunjung dapat
        melihat informasi usaha dan produk, kemudian menghubungi penjual secara
        langsung melalui kontak yang tersedia.
    </p>

</section>

@endsection
