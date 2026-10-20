@extends('layouts.public')

@section('title', $umkm->name)

@section('meta_description', \Illuminate\Support\Str::limit($umkm->description ?: 'Profil UMKM ' . $umkm->name . ' di Kelurahan Tanjung Mas.', 160))

@if ($umkm->cover_image)
    @section('meta_image', asset('storage/' . $umkm->cover_image))
@endif

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
                    <x-icon name="store" class="h-16 w-16" />
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

            <p class="mt-5 whitespace-pre-line break-words leading-7 text-gray-600">{{ $umkm->description ?: 'Informasi lengkap mengenai usaha ini akan ditambahkan.' }}</p>

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
                        $whatsappNumber = preg_replace('/\D+/', '', (string) $umkm->whatsapp);

                        if (str_starts_with($whatsappNumber, '0')) {
                            $whatsappNumber = '62' . substr($whatsappNumber, 1);
                        } elseif (str_starts_with($whatsappNumber, '8')) {
                            $whatsappNumber = '62' . $whatsappNumber;
                        }

                        $whatsappMessage = 'Halo, saya menemukan usaha '
                            . $umkm->name
                            . ' melalui TanjungKatalog. Saya ingin bertanya tentang produk yang tersedia.';

                        $whatsappUrl = 'https://wa.me/' . $whatsappNumber
                            . '?text=' . rawurlencode($whatsappMessage);
                    @endphp

                    <a
                        href="{{ $whatsappUrl }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 rounded-xl bg-[#16865A] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#116B47] focus:outline-none focus:ring-2 focus:ring-[#16865A] focus:ring-offset-2"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            class="h-5 w-5"
                            aria-hidden="true"
                        >
                            <path d="M20.52 3.48A11.87 11.87 0 0012.04 0C5.48 0 .14 5.33.14 11.89c0 2.1.55 4.15 1.59 5.96L0 24l6.31-1.66a11.9 11.9 0 005.72 1.46h.01c6.56 0 11.9-5.34 11.9-11.9a11.82 11.82 0 00-3.42-8.42zM12.04 21.8a9.9 9.9 0 01-5.05-1.38l-.36-.21-3.75.99 1-3.65-.24-.38a9.86 9.86 0 01-1.52-5.28c0-5.48 4.46-9.94 9.93-9.94a9.88 9.88 0 017.03 2.91 9.86 9.86 0 012.91 7.03c0 5.48-4.46 9.91-9.95 9.91zm5.46-7.43c-.3-.15-1.77-.87-2.05-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.95 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.47-.89-.79-1.49-1.77-1.66-2.07-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.08-.79.37-.27.3-1.04 1.02-1.04 2.49 0 1.47 1.07 2.89 1.22 3.09.15.2 2.11 3.22 5.1 4.51.71.31 1.27.49 1.71.63.72.23 1.37.2 1.88.12.58-.09 1.77-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.07-.12-.27-.2-.57-.35z"/>
                        </svg>

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
                <article class="group flex h-full flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white transition hover:-translate-y-1 hover:shadow-lg">

                    {{-- Foto produk yang bisa diklik --}}
                    <a
                        href="{{ route('product.show', $product->slug) }}"
                        aria-label="Lihat detail {{ $product->name }}"
                        class="block aspect-square overflow-hidden bg-gradient-to-br from-[#EAF4F7] to-[#CFE5E2]"
                    >
                        @if ($product->image)
                            <img
                                src="{{ asset('storage/' . $product->image) }}"
                                alt="{{ $product->name }}"
                                loading="lazy"
                                class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                            >
                        @else
                            <div class="flex h-full w-full items-center justify-center">
                                <x-icon name="box" class="h-10 w-10" />
                            </div>
                        @endif
                    </a>

                    <div class="flex flex-1 flex-col p-4">

                        {{-- Nama produk yang bisa diklik --}}
                        <h3 class="font-semibold text-[#174875] transition group-hover:text-[#326AAB]">
                            <a href="{{ route('product.show', $product->slug) }}">
                                {{ $product->name }}
                            </a>
                        </h3>

                        {{-- Harga --}}
                        <p class="mt-2 font-bold text-[#326AAB]">
                            @if ($product->price !== null)
                                Rp{{ number_format((float) $product->price, 0, ',', '.') }}
                            @else
                                Hubungi penjual
                            @endif
                        </p>

                        {{-- Deskripsi --}}
                        @if ($product->description)
                            <p class="mt-2 line-clamp-2 text-sm leading-6 text-gray-500">
                                {{ $product->description }}
                            </p>
                        @endif

                        {{-- Tombol detail --}}
                        <a
                            href="{{ route('product.show', $product->slug) }}"
                            class="mt-auto mt-4 inline-flex items-center justify-center gap-2 rounded-xl border border-[#326AAB]/30 px-3 py-2.5 text-sm font-semibold text-[#326AAB] transition hover:border-[#326AAB] hover:bg-[#326AAB] hover:text-white"
                        >
                            Lihat Produk
                            <span aria-hidden="true">→</span>
                        </a>

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
