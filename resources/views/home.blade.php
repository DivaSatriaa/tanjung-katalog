@extends('layouts.public')

@section('title', 'Beranda')

@section('content')

{{-- Hero Section --}}
<section class="bg-[#F5F2EB] px-5 py-6 sm:py-8">
    <div class="w-full max-w-none">

        {{-- Main Hero Card --}}
        <div class="relative overflow-hidden rounded-3xl border border-[#CFE5E2] bg-gradient-to-br from-[#F8FCFD] via-[#EAF4F7] to-[#CFE5E2] shadow-[0_12px_40px_rgba(50,106,171,0.12)]">

            <div class="pointer-events-none absolute -right-16 -top-16 h-64 w-64 rounded-full bg-[#6EA8C7]/20 blur-3xl"></div>

           <div class="relative grid items-center gap-8 px-6 py-8 sm:px-10 sm:py-10 lg:grid-cols-[1.05fr_0.95fr] lg:gap-8 lg:px-12 lg:py-10 xl:px-14 xl:py-12">

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
                    action="{{ route('umkm.index') }}"
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
                        placeholder="Cari UMKM atau nama usaha..."
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
                        href="{{ route('umkm.index') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-full bg-[#326AAB] px-6 py-3.5 text-sm font-semibold text-white shadow-md shadow-[#326AAB]/20 transition hover:-translate-y-0.5 hover:bg-[#28598f]"
                    >
                        Lihat Katalog

                        <span aria-hidden="true">→</span>
                    </a>

                    <a
                        href="#kategori"
                        class="inline-flex items-center justify-center rounded-full border border-[#326AAB] bg-white/70 px-6 py-3.5 text-sm font-semibold text-[#326AAB] transition hover:bg-[#CFE5E2]/50"
                    >
                        Jelajahi Kategori
                    </a>

                </div>

            </div>

            {{-- Hero Image --}}
            <div class="relative mx-auto w-full max-w-xl lg:max-w-none">

                <div class="absolute -right-5 -top-5 h-32 w-32 rounded-full bg-[#6EA8C7]/30 blur-3xl"></div>
                <div class="absolute -bottom-6 -left-5 h-36 w-36 rounded-full bg-[#CFE5E2] blur-2xl"></div>

                <div class="relative overflow-hidden rounded-[2rem] bg-[#CFE5E2]">

                    <img
                        src="{{ asset('images/tanjung-mas-hero.jpg') }}"
                        alt="Ilustrasi kawasan pesisir dan perahu nelayan"
                        class="h-[300px] w-full object-cover sm:h-[360px] lg:h-[390px] xl:h-[420px]"
                    >

                    <div class="absolute inset-0 bg-gradient-to-t from-[#174875]/70 via-transparent to-transparent"></div>

                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white sm:p-8">

                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-white/80">
                            Potensi Lokal
                        </p>

                        <h2 class="mt-2 text-2xl font-bold sm:text-3xl">
                            Produk Lokal, Kekuatan Kita.
                        </h2>

                        <p class="mt-2 max-w-md text-sm leading-6 text-white/85">
                            Kenali pelaku usaha dan temukan produk lokal
                            kebanggaan Tanjung Mas.
                        </p>

                    </div>

                </div>

                {{-- Floating statistics --}}
                <div class="relative mx-4 -mt-7 grid grid-cols-2 gap-3 sm:absolute sm:-bottom-6 sm:left-6 sm:right-6 sm:mx-0 sm:mt-0">

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

            </div> {{-- Grid konten --}}

            {{-- Keunggulan --}}
            <div class="relative z-10 border-t border-white/70 bg-white/25 px-5 py-7 sm:px-8 lg:px-10">
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

{{-- Kategori --}}
<section class="mx-auto max-w-7xl px-5 py-8 lg:px-8" id="kategori">

    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-bold uppercase tracking-wider text-[#326AAB]">
                Jelajahi
            </p>

            <h2 class="mt-2 text-2xl font-bold text-gray-900 sm:text-3xl">
                Cari berdasarkan kategori
            </h2>
        </div>

        <a
            href="{{ route('umkm.index') }}"
            class="text-sm font-semibold text-[#326AAB] hover:underline"
        >
            Semua kategori →
        </a>
    </div>

    <div class="mt-7 flex flex-wrap gap-3">

        @forelse ($categories as $category)
            <a
                href="{{ route('umkm.index', ['category' => $category->slug]) }}"
                class="rounded-full border border-gray-200 bg-white px-5 py-3 text-sm font-medium transition hover:border-[#326AAB] hover:bg-[#326AAB] hover:text-white"
            >
                {{ $category->name }}

                <span class="ml-1 text-xs opacity-70">
                    {{ $category->umkms_count }}
                </span>
            </a>
        @empty
            <p class="text-sm text-gray-500">
                Kategori belum tersedia.
            </p>
        @endforelse

    </div>

</section>

{{-- UMKM Pilihan --}}
<section class="mx-auto max-w-7xl px-5 py-16 lg:px-8">

    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-bold uppercase tracking-wider text-[#326AAB]">
                Kenali Usahanya
            </p>

            <h2 class="mt-2 text-2xl font-bold text-gray-900 sm:text-3xl">
                UMKM pilihan
            </h2>

            <p class="mt-2 text-gray-500">
                Temukan usaha lokal dan produk yang mereka tawarkan.
            </p>
        </div>

        <a
            href="{{ route('umkm.index') }}"
            class="text-sm font-semibold text-[#326AAB] hover:underline"
        >
            Lihat semua UMKM →
        </a>
    </div>

    <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

        @forelse ($featuredUmkms as $umkm)
            <article class="group overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg">

                <a href="{{ route('umkm.show', $umkm->slug) }}" class="block">
                    <div class="aspect-[16/10] overflow-hidden bg-[#CFE5E2]">

                        @if ($umkm->cover_image)
                            <img
                                src="{{ asset('storage/' . $umkm->cover_image) }}"
                                alt="{{ $umkm->name }}"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                            >
                        @else
                            <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-[#CFE5E2] to-[#6EA8C7]/50">
                                <span class="text-5xl">🏪</span>
                            </div>
                        @endif

                    </div>
                </a>

                <div class="p-5">

                    <div class="flex items-center justify-between gap-3">
                        <span class="rounded-full bg-[#CFE5E2] px-3 py-1 text-xs font-semibold text-[#326AAB]">
                            {{ $umkm->category->name }}
                        </span>

                        <span class="text-xs text-gray-400">
                            {{ $umkm->products_count }} produk
                        </span>
                    </div>

                    <h3 class="mt-4 text-lg font-bold text-gray-900">
                        <a
                            href="{{ route('umkm.show', $umkm->slug) }}"
                            class="transition hover:text-[#326AAB]"
                        >
                            {{ $umkm->name }}
                        </a>
                    </h3>

                    <p class="mt-2 line-clamp-2 text-sm leading-6 text-gray-500">
                        {{ $umkm->description ?: 'Kenali usaha lokal dari Kelurahan Tanjung Mas.' }}
                    </p>

                    <a
                        href="{{ route('umkm.show', $umkm->slug) }}"
                        class="mt-5 inline-flex text-sm font-semibold text-[#326AAB] hover:underline"
                    >
                        Lihat profil →
                    </a>

                </div>
            </article>
        @empty
            <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-8 sm:col-span-2 lg:col-span-3">
                <p class="font-semibold text-gray-800">
                    Belum ada UMKM yang dipublikasikan.
                </p>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    UMKM yang masih berstatus Draft tidak akan ditampilkan di sini.
                    Publikasikan data melalui dashboard admin setelah datanya siap.
                </p>
            </div>
        @endforelse

    </div>

</section>

{{-- Produk Terbaru --}}
<section class="bg-white py-16">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">

        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-wider text-[#326AAB]">
                    Produk Lokal
                </p>

                <h2 class="mt-2 text-2xl font-bold text-gray-900 sm:text-3xl">
                    Produk terbaru
                </h2>
            </div>

            <a
                href="{{ route('umkm.index') }}"
                class="text-sm font-semibold text-[#326AAB] hover:underline"
            >
                Jelajahi UMKM →
            </a>
        </div>

        <div class="mt-8 grid grid-cols-2 gap-4 md:grid-cols-4 md:gap-6">

            @forelse ($latestProducts as $product)
                <article class="overflow-hidden rounded-2xl border border-gray-100 bg-[#F5F2EB]/50">

                    <div class="aspect-square overflow-hidden bg-[#CFE5E2]">

                        @if ($product->image)
                            <img
                                src="{{ asset('storage/' . $product->image) }}"
                                alt="{{ $product->name }}"
                                class="h-full w-full object-cover"
                            >
                        @else
                            <div class="flex h-full w-full items-center justify-center">
                                <span class="text-4xl">📦</span>
                            </div>
                        @endif

                    </div>

                    <div class="p-4">
                        <h3 class="line-clamp-2 font-semibold text-gray-900">
                            {{ $product->name }}
                        </h3>

                        <p class="mt-1 text-xs text-gray-500">
                            {{ $product->umkm->name }}
                        </p>

                        <p class="mt-3 font-bold text-[#326AAB]">
                            @if ($product->price !== null)
                                Rp{{ number_format((float) $product->price, 0, ',', '.') }}
                            @else
                                Hubungi penjual
                            @endif
                        </p>
                    </div>

                </article>
            @empty
                <div class="rounded-2xl border border-dashed border-gray-300 p-8 sm:col-span-2 md:col-span-4">
                    <p class="font-semibold text-gray-800">
                        Belum ada produk yang dipublikasikan.
                    </p>

                    <p class="mt-2 text-sm text-gray-500">
                        Produk akan muncul di sini setelah admin menerbitkannya.
                    </p>
                </div>
            @endforelse

        </div>

    </div>
</section>

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
