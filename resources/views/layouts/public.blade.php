<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $pageTitle = trim($__env->yieldContent('title', 'Katalog UMKM'));
        $metaDescription = trim($__env->yieldContent('meta_description', 'Jelajahi UMKM dan produk lokal Kelurahan Tanjung Mas, Semarang.'));
        $metaImage = trim($__env->yieldContent('meta_image', asset('images/og-image.jpg')));
    @endphp

    {{-- Nilai section sudah di-escape oleh Blade, jadi dicetak tanpa escape ulang. --}}
    <title>{!! $pageTitle !!} | TanjungKatalog</title>

    <meta name="description" content="{!! $metaDescription !!}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="theme-color" content="#326AAB">

    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="TanjungKatalog">
    <meta property="og:locale" content="id_ID">
    <meta property="og:title" content="{!! $pageTitle !!} | TanjungKatalog">
    <meta property="og:description" content="{!! $metaDescription !!}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{!! $metaImage !!}">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/icon-192.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="min-h-screen bg-[#F5F2EB] pb-20 text-gray-800 antialiased lg:pb-0">

@php
    $navItems = [
        [
            'label' => 'Beranda',
            'href' => route('home'),
            'active' => request()->routeIs('home'),
            'icon' => '<path d="m3 11 9-8 9 8"/><path d="M5 10v10h14V10"/><path d="M10 20v-6h4v6"/>',
        ],
        [
            'label' => 'Produk',
            'href' => route('product.index'),
            'active' => request()->routeIs('product.*'),
            'icon' => '<path d="m3 7 9-4 9 4-9 5-9-5Z"/><path d="M3 7v10l9 5 9-5V7"/><path d="M12 12v10"/>',
        ],
        [
            'label' => 'UMKM',
            'href' => route('umkm.index'),
            'active' => request()->routeIs('umkm.*'),
            'icon' => '<path d="M3 9.5 4.5 4h15L21 9.5"/><path d="M3 9.5a3 3 0 0 0 6 0 3 3 0 0 0 6 0 3 3 0 0 0 6 0"/><path d="M5 12v8h14v-8"/>',
        ],
        [
            'label' => 'Peta',
            'href' => route('peta.index'),
            'active' => request()->routeIs('peta.*'),
            'icon' => '<path d="M12 21s7-6.2 7-11a7 7 0 0 0-14 0c0 4.8 7 11 7 11Z"/><circle cx="12" cy="10" r="2.5"/>',
        ],
        [
            'label' => 'Berita',
            'href' => route('posts.index'),
            'active' => request()->routeIs('posts.*'),
            'icon' => '<path d="M4 5a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v14a1 1 0 0 0 1 1H6a2 2 0 0 1-2-2V5Z"/><path d="M17 8h2a1 1 0 0 1 1 1v9a2 2 0 0 1-2 2"/><path d="M8 8h5M8 12h5M8 16h3"/>',
        ],
    ];
@endphp

<header class="sticky top-0 z-40 border-b border-gray-100 bg-white/95 backdrop-blur">
    <div class="flex w-full items-center justify-between gap-6 px-5 py-3 sm:px-7 lg:px-10 xl:px-12">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-3 sm:gap-4">
            <img
                src="{{ asset('images/lambang-kota-semarang.png') }}"
                alt="Lambang Kota Semarang"
                class="h-10 w-auto sm:h-12"
            >

            <span class="h-9 w-px bg-gray-200 sm:h-10" aria-hidden="true"></span>

            <img
                src="{{ asset('images/tanjungkatalog-logo.png') }}"
                alt="TanjungKatalog — Katalog UMKM Kelurahan Tanjung Mas"
                class="h-auto w-40 object-contain sm:w-56"
            >
        </a>

        {{-- Navigasi Desktop --}}
        <nav class="hidden items-center gap-6 text-sm font-medium lg:flex" aria-label="Navigasi utama">
            @foreach ($navItems as $item)
                <a
                    href="{{ $item['href'] }}"
                    @class([
                        'transition hover:text-[#326AAB]',
                        'text-[#326AAB]' => $item['active'],
                        'text-gray-600' => ! $item['active'],
                    ])
                    @if ($item['active']) aria-current="page" @endif
                >
                    {{ $item['label'] }}
                </a>
            @endforeach

            <a href="{{ route('home') }}#tentang" class="text-gray-600 transition hover:text-[#326AAB]">
                Tentang
            </a>
        </nav>

        {{-- Search Desktop --}}
        <form
            method="GET"
            action="{{ route('product.index') }}"
            class="hidden min-w-0 max-w-xs flex-1 xl:flex"
        >
            <label for="header-search" class="sr-only">Cari produk atau UMKM</label>

            <input
                id="header-search"
                type="search"
                name="q"
                placeholder="Cari produk atau UMKM..."
                class="w-full rounded-full border-0 bg-[#F5F2EB] px-4 py-2.5 text-sm outline-none ring-1 ring-transparent transition focus:ring-[#326AAB]"
            >
        </form>

        {{-- Tombol menu mobile --}}
        <button
            type="button"
            id="mobile-menu-button"
            class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full text-[#326AAB] transition hover:bg-[#EAF4F7] lg:hidden"
            aria-controls="mobile-menu"
            aria-expanded="false"
            aria-label="Buka menu"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path data-menu-icon="open" d="M4 7h16M4 12h16M4 17h16"/>
                <path data-menu-icon="close" class="hidden" d="m6 6 12 12M18 6 6 18"/>
            </svg>
        </button>

    </div>

    {{-- Panel menu mobile --}}
    <div id="mobile-menu" class="hidden border-t border-gray-100 bg-white px-5 pb-5 pt-4 sm:px-7 lg:hidden">
        <form method="GET" action="{{ route('product.index') }}" class="relative">
            <label for="mobile-search" class="sr-only">Cari produk atau UMKM</label>

            <div class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-[#6EA8C7]">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="m21 21-4.35-4.35"/>
                </svg>
            </div>

            <input
                id="mobile-search"
                type="search"
                name="q"
                placeholder="Cari produk atau UMKM..."
                class="w-full rounded-full border-0 bg-[#F5F2EB] py-3 pl-11 pr-4 text-sm outline-none ring-1 ring-transparent transition focus:ring-[#326AAB]"
            >
        </form>

        <nav class="mt-3 flex flex-col text-sm font-medium" aria-label="Navigasi seluler">
            @foreach ($navItems as $item)
                <a
                    href="{{ $item['href'] }}"
                    @class([
                        'rounded-xl px-3 py-3 transition',
                        'bg-[#EAF4F7] text-[#326AAB]' => $item['active'],
                        'text-gray-700 hover:bg-[#F5F2EB]' => ! $item['active'],
                    ])
                    @if ($item['active']) aria-current="page" @endif
                >
                    {{ $item['label'] }}
                </a>
            @endforeach

            <a href="{{ route('home') }}#tentang" class="rounded-xl px-3 py-3 text-gray-700 transition hover:bg-[#F5F2EB]">
                Tentang
            </a>
        </nav>
    </div>
</header>

    <main>
        @yield('content')
    </main>

    <footer class="mt-20 border-t border-gray-200 bg-white">
        <div class="mx-auto grid max-w-7xl gap-10 px-5 py-12 sm:grid-cols-2 lg:grid-cols-[1.4fr_1fr_1fr] lg:px-8">

            <div>
                <a href="{{ route('home') }}" class="inline-block">
                    <img
                        src="{{ asset('images/tanjungkatalog-logo.png') }}"
                        alt="TanjungKatalog"
                        class="h-auto w-52"
                        loading="lazy"
                    >
                </a>

                <p class="mt-4 max-w-sm text-sm leading-6 text-gray-500">
                    Katalog digital untuk mengenalkan usaha dan produk lokal warga
                    Kelurahan Tanjung Mas, Semarang. Dukung UMKM, majukan Tanjung Mas.
                </p>

                <div class="mt-6 inline-flex items-center gap-3 rounded-2xl border border-gray-100 bg-[#F8FCFD] py-3 pl-3 pr-5">
                    <img
                        src="{{ asset('images/lambang-kota-semarang.png') }}"
                        alt="Lambang Kota Semarang"
                        class="h-12 w-auto"
                        loading="lazy"
                    >

                    <div class="leading-tight">
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-gray-400">
                            Pemerintah Kota Semarang
                        </p>
                        <p class="mt-0.5 text-sm font-bold text-[#174875]">
                            Kelurahan Tanjung Mas
                        </p>
                        <p class="mt-0.5 text-xs text-gray-500">
                            Kecamatan Semarang Utara
                        </p>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-sm font-bold uppercase tracking-wider text-[#174875]">
                    Jelajahi
                </h2>

                <ul class="mt-4 space-y-2.5 text-sm">
                    @foreach ($navItems as $item)
                        <li>
                            <a href="{{ $item['href'] }}" class="text-gray-600 transition hover:text-[#326AAB]">
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h2 class="text-sm font-bold uppercase tracking-wider text-[#174875]">
                    Lokasi
                </h2>

                <p class="mt-4 flex items-start gap-2 text-sm leading-6 text-gray-600">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-[#326AAB]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 21s7-6.2 7-11a7 7 0 0 0-14 0c0 4.8 7 11 7 11Z"/>
                        <circle cx="12" cy="10" r="2.5"/>
                    </svg>
                    <span>
                        Kelurahan Tanjung Mas,<br>
                        Kecamatan Semarang Utara,<br>
                        Kota Semarang, Jawa Tengah
                    </span>
                </p>

                <a
                    href="{{ route('peta.index') }}"
                    class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-[#326AAB] hover:underline"
                >
                    Lihat peta UMKM
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>

        </div>

        <div class="border-t border-gray-100">
            <div class="mx-auto flex max-w-7xl flex-col gap-2 px-5 py-5 text-xs text-gray-400 sm:flex-row sm:items-center sm:justify-between lg:px-8">
                <p>&copy; {{ date('Y') }} TanjungKatalog. Katalog UMKM Kelurahan Tanjung Mas.</p>
                <p>Data usaha dikelola oleh admin kelurahan.</p>
            </div>
        </div>
    </footer>

    {{-- Navigasi bawah (mobile) --}}
    <nav
        class="fixed inset-x-0 bottom-0 z-40 border-t border-gray-200 bg-white/95 pb-[env(safe-area-inset-bottom)] backdrop-blur lg:hidden"
        aria-label="Navigasi bawah"
    >
        <ul class="mx-auto grid max-w-lg grid-cols-5">
            @foreach ($navItems as $item)
                <li>
                    <a
                        href="{{ $item['href'] }}"
                        @class([
                            'flex flex-col items-center gap-1 px-2 py-2.5 text-[11px] font-semibold transition',
                            'text-[#326AAB]' => $item['active'],
                            'text-gray-500 hover:text-[#326AAB]' => ! $item['active'],
                        ])
                        @if ($item['active']) aria-current="page" @endif
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            {!! $item['icon'] !!}
                        </svg>
                        {{ $item['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    @stack('scripts')
</body>
</html>
