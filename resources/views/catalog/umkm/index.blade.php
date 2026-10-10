@extends('layouts.public')

@section('title', 'Katalog UMKM')

@section('content')
<section class="mx-auto max-w-7xl px-5 py-12 lg:px-8">

    <div>
        <p class="text-sm font-bold uppercase tracking-wider text-[#326AAB]">
            Jelajahi usaha lokal
        </p>

        <h1 class="mt-3 text-3xl font-extrabold text-gray-900 sm:text-4xl">
            Katalog UMKM
        </h1>

        <p class="mt-3 max-w-2xl leading-7 text-gray-500">
            Temukan usaha dan produk dari Kelurahan Tanjung Mas.
        </p>
    </div>

    <form
        method="GET"
        action="{{ route('umkm.index') }}"
        class="mt-8 flex flex-col gap-3 sm:flex-row"
    >
        <input
            type="search"
            name="q"
            value="{{ $search }}"
            placeholder="Cari nama usaha..."
            class="min-w-0 flex-1 rounded-xl border border-gray-200 bg-white px-4 py-3 focus:border-[#326AAB] focus:outline-none focus:ring-2 focus:ring-[#326AAB]/20"
        >

        <select
            name="category"
            class="rounded-xl border border-gray-200 bg-white px-4 py-3 focus:border-[#326AAB] focus:outline-none"
        >
            <option value="">Semua kategori</option>

            @foreach ($categories as $category)
                <option
                    value="{{ $category->slug }}"
                    @selected($categorySlug === $category->slug)
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <button
            type="submit"
            class="rounded-xl bg-[#326AAB] px-6 py-3 font-semibold text-white hover:bg-[#28598f]"
        >
            Cari
        </button>
    </form>

    <div class="mt-8 flex items-center justify-between gap-4">
        <p class="text-sm text-gray-500">
            {{ $umkms->total() }} UMKM ditemukan
        </p>

        @if ($search !== '' || $categorySlug)
            <a
                href="{{ route('umkm.index') }}"
                class="text-sm font-medium text-[#326AAB] hover:underline"
            >
                Reset filter
            </a>
        @endif
    </div>

    <div class="mt-5 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($umkms as $umkm)
            <article class="group overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">

                <a href="{{ route('umkm.show', $umkm->slug) }}" class="block">
                    <div class="aspect-[16/10] overflow-hidden bg-[#CFE5E2]">
                        @if ($umkm->cover_image)
                            <img
                                src="{{ asset('storage/' . $umkm->cover_image) }}"
                                alt="{{ $umkm->name }}"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                            >
                        @else
                            <div class="flex h-full w-full items-center justify-center">
                                <span class="text-5xl">🏪</span>
                            </div>
                        @endif
                    </div>
                </a>

                <div class="p-5">
                    <span class="inline-flex rounded-full bg-[#CFE5E2] px-3 py-1 text-xs font-semibold text-[#326AAB]">
                        {{ $umkm->category->name }}
                    </span>

                    <h2 class="mt-4 text-lg font-bold text-gray-900">
                        <a
                            href="{{ route('umkm.show', $umkm->slug) }}"
                            class="hover:text-[#326AAB]"
                        >
                            {{ $umkm->name }}
                        </a>
                    </h2>

                    <p class="mt-2 line-clamp-2 text-sm leading-6 text-gray-500">
                        {{ $umkm->description ?: 'Informasi usaha lokal Tanjung Mas.' }}
                    </p>

                    @if ($umkm->address)
                        <p class="mt-4 line-clamp-2 text-sm text-gray-500">
                            📍 {{ $umkm->address }}
                        </p>
                    @endif

                    <div class="mt-5 flex items-center justify-between border-t border-gray-100 pt-4">
                        <span class="text-xs text-gray-500">
                            {{ $umkm->products_count }} produk
                        </span>

                        <a
                            href="{{ route('umkm.show', $umkm->slug) }}"
                            class="text-sm font-semibold text-[#326AAB] hover:underline"
                        >
                            Lihat detail →
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-10 sm:col-span-2 lg:col-span-3">
                <h2 class="text-lg font-semibold text-gray-900">
                    UMKM belum ditemukan
                </h2>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    Coba ubah kata pencarian atau pilih kategori lain.
                </p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $umkms->links() }}
    </div>

</section>
@endsection
