<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Katalog UMKM') | TanjungKatalog</title>

    <meta
        name="description"
        content="@yield('meta_description', 'Jelajahi UMKM dan produk lokal Kelurahan Tanjung Mas, Semarang.')"
    >

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
    ];
@endphp

<header class="sticky top-0 z-40 border-b border-gray-100 bg-white/95 backdrop-blur">
    <div class="flex w-full items-center justify-between gap-6 px-5 py-3 sm:px-7 lg:px-10 xl:px-12">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="shrink-0">
            <img
                src="{{ asset('images/tanjungkatalog-logo.png') }}"
                alt="TanjungKatalog — Katalog UMKM Kelurahan Tanjung Mas"
                class="h-auto w-44 object-contain sm:w-60"
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
        <div class="mx-auto flex max-w-7xl flex-col gap-4 px-5 py-8 sm:flex-row sm:items-center sm:justify-between lg:px-8">

            <div>
                <p class="font-bold text-[#326AAB]">TanjungKatalog</p>

                <p class="mt-1 text-sm text-gray-500">
                    Katalog digital UMKM Kelurahan Tanjung Mas.
                </p>
            </div>

            <p class="text-sm text-gray-400">
                © {{ date('Y') }} TanjungKatalog
            </p>

        </div>
    </footer>

    {{-- Navigasi bawah (mobile) --}}
    <nav
        class="fixed inset-x-0 bottom-0 z-40 border-t border-gray-200 bg-white/95 pb-[env(safe-area-inset-bottom)] backdrop-blur lg:hidden"
        aria-label="Navigasi bawah"
    >
        <ul class="mx-auto grid max-w-lg grid-cols-4">
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
