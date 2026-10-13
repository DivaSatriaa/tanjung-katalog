@extends('layouts.public')

@section('title', $activeCategory?->name ?? 'Katalog Produk')

@section('meta_description', 'Temukan produk unggulan UMKM Kelurahan Tanjung Mas, Semarang.')

@section('content')

@php
    $categoryTitle = $activeCategory?->name ?? 'Semua Produk';
    $isFiltered = $search !== '' || $categorySlug !== '' || $sort !== 'terbaru';
@endphp

<div class="mx-auto max-w-7xl px-5 py-8 sm:py-10 lg:px-8">

    {{-- Breadcrumb --}}
    <nav class="mb-6 flex flex-wrap items-center gap-2 text-sm text-gray-500" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="transition hover:text-[#326AAB]">
            Beranda
        </a>

        <span class="text-gray-300">/</span>

        @if ($activeCategory)
            <a href="{{ route('product.index') }}" class="transition hover:text-[#326AAB]">
                Produk
            </a>

            <span class="text-gray-300">/</span>

            <span class="font-semibold text-[#326AAB]">
                {{ $activeCategory->name }}
            </span>
        @else
            <span class="font-semibold text-[#326AAB]">
                Produk
            </span>
        @endif
    </nav>

    <div class="grid grid-cols-[minmax(0,1fr)] items-start gap-8 lg:grid-cols-[240px_minmax(0,1fr)]">

        {{-- Sidebar kategori (desktop) --}}
        <aside class="hidden rounded-2xl border border-gray-100 bg-white p-5 shadow-sm lg:sticky lg:top-24 lg:block">
            <h2 class="text-sm font-bold uppercase tracking-wider text-gray-500">
                Kategori
            </h2>

            <ul class="mt-4 space-y-1">
                <li>
                    <a
                        href="{{ route('product.index', ['q' => $search ?: null, 'sort' => $sort !== 'terbaru' ? $sort : null]) }}"
                        @class([
                            'flex items-center justify-between gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition',
                            'bg-[#EAF4F7] text-[#326AAB]' => $categorySlug === '',
                            'text-gray-600 hover:bg-[#F5F2EB] hover:text-[#326AAB]' => $categorySlug !== '',
                        ])
                        @if ($categorySlug === '') aria-current="page" @endif
                    >
                        <span>Semua</span>
                        <span class="text-xs text-gray-400">{{ $totalProducts }}</span>
                    </a>
                </li>

                @foreach ($categories as $category)
                    <li>
                        <a
                            href="{{ route('product.index', [
                                'category' => $category->slug,
                                'q' => $search ?: null,
                                'sort' => $sort !== 'terbaru' ? $sort : null,
                            ]) }}"
                            @class([
                                'flex items-center justify-between gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition',
                                'bg-[#EAF4F7] text-[#326AAB]' => $categorySlug === $category->slug,
                                'text-gray-600 hover:bg-[#F5F2EB] hover:text-[#326AAB]' => $categorySlug !== $category->slug,
                            ])
                            @if ($categorySlug === $category->slug) aria-current="page" @endif
                        >
                            <span class="flex min-w-0 items-center gap-2.5">
                                <x-category-icon :category="$category" class="h-4 w-4 shrink-0" />
                                <span class="leading-5">{{ $category->name }}</span>
                            </span>
                            <span class="text-xs text-gray-400">{{ $category->products_count }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </aside>

        <div class="min-w-0">

            {{-- Judul --}}
            <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
                <h1 class="text-2xl font-extrabold tracking-tight text-[#174875] sm:text-3xl">
                    {{ $search !== '' ? 'Hasil pencarian' : $categoryTitle }}
                </h1>

                <p class="text-sm text-gray-500">
                    {{ $products->total() }} produk
                </p>
            </div>

            {{-- Pencarian & urutan --}}
            <form
                method="GET"
                action="{{ route('product.index') }}"
                class="mt-5 grid gap-3 sm:grid-cols-[minmax(0,1fr)_200px_auto]"
            >
                @if ($categorySlug !== '')
                    <input type="hidden" name="category" value="{{ $categorySlug }}">
                @endif

                <div class="relative">
                    <label for="q" class="sr-only">Cari produk</label>

                    <div class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-[#6EA8C7]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.35-4.35"/>
                        </svg>
                    </div>

                    <input
                        id="q"
                        type="search"
                        name="q"
                        value="{{ $search }}"
                        placeholder="Cari produk atau UMKM..."
                        class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-11 pr-4 text-sm text-gray-800 outline-none transition focus:border-[#326AAB] focus:ring-2 focus:ring-[#326AAB]/10"
                    >
                </div>

                <div>
                    <label for="sort" class="sr-only">Urutkan</label>

                    <select
                        id="sort"
                        name="sort"
                        class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-700 outline-none transition focus:border-[#326AAB] focus:ring-2 focus:ring-[#326AAB]/10"
                    >
                        @foreach ($sortOptions as $value => $label)
                            <option value="{{ $value }}" @selected($sort === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-xl bg-[#326AAB] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#28598f]"
                >
                    Terapkan
                </button>
            </form>

            {{-- Kategori (mobile) --}}
            <div class="-mx-5 mt-5 overflow-x-auto px-5 lg:hidden">
                <div class="flex w-max gap-2 pb-1">
                    <a
                        href="{{ route('product.index', ['q' => $search ?: null, 'sort' => $sort !== 'terbaru' ? $sort : null]) }}"
                        @class([
                            'rounded-full border px-4 py-2 text-sm font-semibold transition',
                            'border-[#326AAB] bg-[#326AAB] text-white' => $categorySlug === '',
                            'border-gray-200 bg-white text-gray-600 hover:border-[#326AAB] hover:text-[#326AAB]' => $categorySlug !== '',
                        ])
                    >
                        Semua
                    </a>

                    @foreach ($categories as $category)
                        <a
                            href="{{ route('product.index', [
                                'category' => $category->slug,
                                'q' => $search ?: null,
                                'sort' => $sort !== 'terbaru' ? $sort : null,
                            ]) }}"
                            @class([
                                'rounded-full border px-4 py-2 text-sm font-semibold transition',
                                'border-[#326AAB] bg-[#326AAB] text-white' => $categorySlug === $category->slug,
                                'border-gray-200 bg-white text-gray-600 hover:border-[#326AAB] hover:text-[#326AAB]' => $categorySlug !== $category->slug,
                            ])
                        >
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            @if ($isFiltered)
                <a
                    href="{{ route('product.index') }}"
                    class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-[#326AAB] hover:underline"
                >
                    Reset filter
                    <span aria-hidden="true">↗</span>
                </a>
            @endif

            {{-- Grid produk --}}
            <div class="mt-6 grid grid-cols-2 gap-4 sm:gap-5 xl:grid-cols-3">

                @forelse ($products as $product)
                    <x-product-card :product="$product" />
                @empty
                    <div class="col-span-full rounded-2xl border border-dashed border-[#CFE5E2] bg-white p-8 text-center">
                        <h2 class="text-lg font-bold text-[#174875]">
                            Produk tidak ditemukan
                        </h2>

                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                            Coba gunakan kata kunci lain atau pilih kategori yang berbeda.
                        </p>

                        <a
                            href="{{ route('product.index') }}"
                            class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-[#326AAB] hover:underline"
                        >
                            Lihat semua produk
                            <span aria-hidden="true">→</span>
                        </a>
                    </div>
                @endforelse

            </div>

            @if ($products->hasPages())
                <div class="mt-10">
                    {{ $products->links() }}
                </div>
            @endif

        </div>
    </div>
</div>

@endsection
