@extends('layouts.public')

@section('title', 'Katalog UMKM')

@section('meta_description', 'Jelajahi usaha dan produk lokal Kelurahan Tanjung Mas, Semarang.')

@section('content')

{{-- Page Header --}}
<section class="relative overflow-hidden border-b border-[#CFE5E2] bg-gradient-to-br from-white via-[#F5F2EB] to-[#CFE5E2]/70">

    <div class="relative mx-auto max-w-7xl px-5 py-12 sm:py-16 lg:px-8 lg:py-20">

        <div class="max-w-3xl">

            <a
                href="{{ route('home') }}"
                class="text-sm font-medium text-gray-500 transition hover:text-[#326AAB]"
            >
                Beranda
            </a>

            <span class="mx-2 text-gray-300">/</span>

            <span class="text-sm font-semibold text-[#326AAB]">
                Katalog UMKM
            </span>

            <div class="mt-7">
                <span class="inline-flex items-center gap-2 rounded-full border border-[#CFE5E2] bg-white/80 px-4 py-2 text-xs font-bold uppercase tracking-wider text-[#326AAB]">
                    <span class="h-2 w-2 rounded-full bg-[#6EA8C7]"></span>
                    Jelajahi Usaha Lokal
                </span>

                <h1 class="mt-5 text-3xl font-extrabold leading-tight tracking-tight text-[#174875] sm:text-4xl lg:text-5xl">
                    Katalog UMKM
                    <span class="block bg-gradient-to-r from-[#326AAB] to-[#6EA8C7] bg-clip-text text-transparent">
                        Kelurahan Tanjung Mas
                    </span>
                </h1>

                <p class="mt-5 max-w-2xl text-sm leading-7 text-gray-600 sm:text-base">
                    Temukan usaha lokal, kenali produk unggulannya, dan
                    hubungi pemilik usaha secara langsung melalui informasi
                    yang tersedia.
                </p>
            </div>

        </div>

    </div>

</section>

{{-- Catalog Content --}}
<section class="mx-auto max-w-7xl px-5 py-10 sm:py-12 lg:px-8">

    {{-- Search & Filter --}}
    <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-6">

        <form
            method="GET"
            action="{{ route('umkm.index') }}"
            class="grid gap-3 md:grid-cols-[minmax(0,1fr)_220px_auto]"
        >

            {{-- Search --}}
            <div class="relative">

                <label for="q" class="sr-only">
                    Cari UMKM
                </label>

                <div class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-[#6EA8C7]">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="20"
                        height="20"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.35-4.35"/>
                    </svg>
                </div>

                <input
                    id="q"
                    type="search"
                    name="q"
                    value="{{ $search }}"
                    placeholder="Cari nama atau deskripsi usaha..."
                    class="w-full rounded-xl border border-gray-200 bg-[#F9FAFA] py-3.5 pl-12 pr-4 text-sm text-gray-800 outline-none transition focus:border-[#326AAB] focus:bg-white focus:ring-2 focus:ring-[#326AAB]/10"
                >

            </div>

            {{-- Category Filter --}}
            <div>

                <label for="category" class="sr-only">
                    Filter kategori
                </label>

                <select
                    id="category"
                    name="category"
                    class="w-full rounded-xl border border-gray-200 bg-[#F9FAFA] px-4 py-3.5 text-sm text-gray-700 outline-none transition focus:border-[#326AAB] focus:bg-white focus:ring-2 focus:ring-[#326AAB]/10"
                >

                    <option value="">
                        Semua kategori
                    </option>

                    @foreach ($categories as $category)
                        <option
                            value="{{ $category->slug }}"
                            @selected($categorySlug === $category->slug)
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach

                </select>

            </div>

            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#326AAB] px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-[#28598f]"
            >
                Cari UMKM
                <span aria-hidden="true">→</span>
            </button>

        </form>

    </div>

    {{-- Category Chips --}}
    <div class="mt-7">

        <p class="mb-3 text-xs font-bold uppercase tracking-wider text-gray-500">
            Jelajahi kategori
        </p>

        <div class="flex flex-wrap gap-2">

            <a
                href="{{ route('umkm.index', ['q' => $search ?: null]) }}"
                @class([
                    'rounded-full border px-4 py-2.5 text-sm font-semibold transition',
                    'border-[#326AAB] bg-[#326AAB] text-white' => !$categorySlug,
                    'border-gray-200 bg-white text-gray-600 hover:border-[#326AAB] hover:text-[#326AAB]' => $categorySlug,
                ])
            >
                Semua UMKM
            </a>

            @foreach ($categories as $category)

                <a
                    href="{{ route('umkm.index', [
                        'category' => $category->slug,
                        'q' => $search ?: null,
                    ]) }}"
                    @class([
                        'rounded-full border px-4 py-2.5 text-sm font-semibold transition',
                        'border-[#326AAB] bg-[#326AAB] text-white' => $categorySlug === $category->slug,
                        'border-gray-200 bg-white text-gray-600 hover:border-[#326AAB] hover:text-[#326AAB]' => $categorySlug !== $category->slug,
                    ])
                >
                    {{ $category->name }}
                </a>

            @endforeach

        </div>

    </div>

    {{-- Result Header --}}
    <div class="mt-10 flex flex-col gap-3 border-b border-gray-200 pb-5 sm:flex-row sm:items-end sm:justify-between">

        <div>
            <h2 class="text-xl font-extrabold text-[#174875] sm:text-2xl">
                @if ($categorySlug)
                    @php
                        $activeCategory = $categories->firstWhere('slug', $categorySlug);
                    @endphp

                    {{ $activeCategory?->name ?? 'Hasil Pencarian' }}
                @elseif ($search !== '')
                    Hasil Pencarian
                @else
                    Semua UMKM
                @endif
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Menampilkan {{ $umkms->count() }} dari {{ $umkms->total() }} UMKM
            </p>
        </div>

        @if ($search !== '' || $categorySlug)
            <a
                href="{{ route('umkm.index') }}"
                class="inline-flex w-fit items-center gap-2 text-sm font-semibold text-[#326AAB] hover:underline"
            >
                Reset filter
                <span aria-hidden="true">↗</span>
            </a>
        @endif

    </div>

    {{-- UMKM Grid --}}
    <div class="mt-7 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

        @forelse ($umkms as $umkm)

            <article class="group flex h-full flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-[#CFE5E2] hover:shadow-xl">

                {{-- Cover --}}
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
                                    width="48"
                                    height="48"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.4"
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
                    <span class="absolute left-4 top-4 rounded-full border border-white/70 bg-white/95 px-3 py-1.5 text-xs font-semibold text-[#326AAB] shadow-sm">
                        {{ $umkm->category->name }}
                    </span>

                    {{-- Featured Badge --}}
                    @if ($umkm->is_featured)

                        <span class="absolute right-4 top-4 rounded-full bg-[#326AAB] px-3 py-1.5 text-xs font-semibold text-white shadow-sm">
                            ★ Unggulan
                        </span>

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
                        {{ $umkm->description ?: 'Profil usaha lokal dari Kelurahan Tanjung Mas.' }}
                    </p>

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

                    {{-- Card Footer --}}
                    <div class="mt-5 flex items-center justify-between gap-3 border-t border-gray-100 pt-4">

                        <div>
                            <p class="text-lg font-extrabold text-[#326AAB]">
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
                            Detail
                            <span aria-hidden="true">→</span>
                        </a>

                    </div>

                </div>

            </article>

        @empty

            {{-- Empty State --}}
            <div class="rounded-3xl border border-dashed border-[#CFE5E2] bg-white p-8 sm:col-span-2 lg:col-span-3">

                <div class="mx-auto max-w-md py-8 text-center">

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
                        UMKM belum ditemukan
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Coba gunakan kata pencarian lain atau pilih kategori berbeda.
                    </p>

                    @if ($search !== '' || $categorySlug)
                        <a
                            href="{{ route('umkm.index') }}"
                            class="mt-5 inline-flex rounded-full bg-[#326AAB] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#28598f]"
                        >
                            Tampilkan semua UMKM
                        </a>
                    @endif

                </div>

            </div>

        @endforelse

    </div>

    {{-- Pagination --}}
    @if ($umkms->hasPages())
        <div class="mt-10 border-t border-gray-200 pt-6">
            {{ $umkms->links() }}
        </div>
    @endif

</section>

@endsection
