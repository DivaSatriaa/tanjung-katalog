@extends('layouts.public')

@section('title', 'Beranda')

@section('content')

{{-- Hero --}}
<section class="overflow-hidden">
    <div class="mx-auto grid max-w-7xl items-center gap-12 px-5 py-16 md:grid-cols-2 md:py-24 lg:px-8">

        <div>
            <span class="inline-flex items-center rounded-full bg-[#CFE5E2] px-4 py-2 text-xs font-bold uppercase tracking-wider text-[#326AAB]">
                UMKM Lokal · Tanjung Mas
            </span>

            <h1 class="mt-6 max-w-xl text-4xl font-extrabold leading-tight tracking-tight text-gray-900 sm:text-5xl lg:text-6xl">
                Temukan Produk Lokal,
                <span class="text-[#326AAB]">Dukung Usaha Tanjung Mas.</span>
            </h1>

            <p class="mt-6 max-w-lg text-base leading-7 text-gray-600">
                Jelajahi usaha dan produk lokal dari pelaku UMKM di Kelurahan
                Tanjung Mas, Semarang.
            </p>

            <form
                method="GET"
                action="{{ route('umkm.index') }}"
                class="mt-8 flex max-w-lg flex-col gap-3 sm:flex-row"
            >
                <input
                    type="search"
                    name="q"
                    placeholder="Cari nama UMKM..."
                    class="min-w-0 flex-1 rounded-xl border border-gray-200 bg-white px-4 py-3.5 outline-none transition focus:border-[#326AAB] focus:ring-2 focus:ring-[#326AAB]/20"
                >

                <button
                    type="submit"
                    class="rounded-xl bg-[#326AAB] px-6 py-3.5 font-semibold text-white transition hover:bg-[#28598f]"
                >
                    Cari UMKM
                </button>
            </form>

            <a
                href="{{ route('umkm.index') }}"
                class="mt-5 inline-flex text-sm font-semibold text-[#326AAB] hover:underline"
            >
                Jelajahi semua UMKM →
            </a>
        </div>

        {{-- Hero Visual --}}
        <div class="relative">
            <div class="absolute -right-8 -top-8 h-40 w-40 rounded-full bg-[#CFE5E2]/70 blur-2xl"></div>
            <div class="absolute -bottom-8 -left-8 h-40 w-40 rounded-full bg-[#6EA8C7]/20 blur-2xl"></div>

            <div class="relative overflow-hidden rounded-[2rem] bg-[#326AAB] p-8 text-white sm:p-12">
                <div class="absolute -right-16 -top-12 h-64 w-64 rounded-full border-[35px] border-white/10"></div>

                <div class="relative">
                    <span class="text-sm font-medium text-white/75">
                        Potensi Ekonomi Lokal
                    </span>

                    <h2 class="mt-4 text-3xl font-bold leading-tight sm:text-4xl">
                        Dari usaha lokal,
                        untuk masa depan yang lebih baik.
                    </h2>

                    <p class="mt-4 max-w-sm leading-7 text-white/80">
                        Kenali pelaku usaha, temukan produknya, dan hubungi
                        pemilik usaha secara langsung.
                    </p>

                    <div class="mt-10 grid grid-cols-2 gap-4">

                        <div class="rounded-2xl border border-white/15 bg-white/10 p-5">
                            <p class="text-3xl font-bold">
                                {{ $totalUmkms }}
                            </p>

                            <p class="mt-2 text-sm text-white/75">
                                UMKM terpublikasi
                            </p>
                        </div>

                        <div class="rounded-2xl border border-white/15 bg-white/10 p-5">
                            <p class="text-3xl font-bold">
                                {{ $totalProducts }}
                            </p>

                            <p class="mt-2 text-sm text-white/75">
                                Produk terpublikasi
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
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
