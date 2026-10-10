@extends('layouts.public')

@section('title', $umkm->name)

@section('meta_description', $umkm->description ?: 'Profil UMKM ' . $umkm->name . ' di Kelurahan Tanjung Mas.')

@section('content')

<section class="mx-auto max-w-7xl px-5 py-10 lg:px-8">

    <a
        href="{{ route('umkm.index') }}"
        class="text-sm font-semibold text-[#326AAB] hover:underline"
    >
        ← Kembali ke katalog
    </a>

    {{-- Profil UMKM --}}
    <div class="mt-6 grid gap-8 lg:grid-cols-2">

        <div class="overflow-hidden rounded-3xl bg-[#CFE5E2]">
            @if ($umkm->cover_image)
                <img
                    src="{{ asset('storage/' . $umkm->cover_image) }}"
                    alt="{{ $umkm->name }}"
                    class="h-full min-h-72 max-h-[480px] w-full object-cover"
                >
            @else
                <div class="flex min-h-72 items-center justify-center">
                    <span class="text-7xl">🏪</span>
                </div>
            @endif
        </div>

        <div class="flex flex-col justify-center">

            <span class="w-fit rounded-full bg-[#CFE5E2] px-3 py-1.5 text-sm font-semibold text-[#326AAB]">
                {{ $umkm->category->name }}
            </span>

            <h1 class="mt-5 text-3xl font-extrabold text-gray-900 sm:text-4xl">
                {{ $umkm->name }}
            </h1>

            @if ($umkm->owner_name)
                <p class="mt-3 text-gray-500">
                    Pemilik: {{ $umkm->owner_name }}
                </p>
            @endif

            <p class="mt-5 whitespace-pre-line leading-7 text-gray-600">
                {{ $umkm->description ?: 'Informasi lengkap mengenai usaha ini akan ditambahkan.' }}
            </p>

            @if ($umkm->address)
                <div class="mt-6">
                    <p class="text-sm font-semibold text-gray-900">Alamat</p>

                    <p class="mt-2 leading-6 text-gray-500">
                        {{ $umkm->address }}
                    </p>
                </div>
            @endif

            {{-- Kontak --}}
            <div class="mt-7 flex flex-wrap gap-3">

                @if ($umkm->whatsapp)
                    @php
                        $whatsappNumber = preg_replace('/\D+/', '', $umkm->whatsapp);
                    @endphp

                    <a
                        href="https://wa.me/{{ $whatsappNumber }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="rounded-xl bg-[#326AAB] px-5 py-3 text-sm font-semibold text-white hover:bg-[#28598f]"
                    >
                        Hubungi via WhatsApp
                    </a>
                @endif

                @if ($umkm->instagram)
                    @php
                        $instagramUsername = ltrim($umkm->instagram, '@');
                    @endphp

                    <a
                        href="https://instagram.com/{{ $instagramUsername }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 hover:border-[#326AAB]"
                    >
                        Instagram
                    </a>
                @endif

                @if ($umkm->latitude !== null && $umkm->longitude !== null)
                    <a
                        href="https://www.google.com/maps?q={{ $umkm->latitude }},{{ $umkm->longitude }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 hover:border-[#326AAB]"
                    >
                        Buka Google Maps
                    </a>
                @endif

            </div>
        </div>

    </div>

    {{-- Daftar Produk --}}
    <div class="mt-16">

        <p class="text-sm font-bold uppercase tracking-wider text-[#326AAB]">
            Produk Lokal
        </p>

        <h2 class="mt-2 text-2xl font-bold text-gray-900 sm:text-3xl">
            Produk dari {{ $umkm->name }}
        </h2>

        <div class="mt-7 grid grid-cols-2 gap-4 md:grid-cols-4 md:gap-6">

            @forelse ($umkm->products as $product)
                <article class="overflow-hidden rounded-2xl border border-gray-100 bg-white">

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
                        <h3 class="font-semibold text-gray-900">
                            {{ $product->name }}
                        </h3>

                        <p class="mt-2 font-bold text-[#326AAB]">
                            @if ($product->price !== null)
                                Rp{{ number_format((float) $product->price, 0, ',', '.') }}
                            @else
                                Hubungi penjual
                            @endif
                        </p>

                        @if ($product->description)
                            <p class="mt-2 line-clamp-2 text-sm text-gray-500">
                                {{ $product->description }}
                            </p>
                        @endif
                    </div>

                </article>
            @empty
                <p class="text-sm leading-6 text-gray-500 sm:col-span-2 md:col-span-4">
                    Belum ada produk yang dipublikasikan untuk UMKM ini.
                </p>
            @endforelse

        </div>
    </div>

</section>

@endsection
