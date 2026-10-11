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

<body class="min-h-screen bg-[#F5F2EB] text-gray-800 antialiased">

    <header class="sticky top-0 z-40 border-b border-gray-100 bg-white/95 backdrop-blur">
    <div class="flex w-full items-center justify-between gap-6 px-5 py-3 sm:px-7 lg:px-10 xl:px-12">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="shrink-0">
            <img
                src="{{ asset('images/tanjungkatalog-logo.png') }}"
                alt="TanjungKatalog — Katalog UMKM Kelurahan Tanjung Mas"
                class="h-auto w-48 object-contain sm:w-60"
            >
        </a>

        {{-- Navigasi Desktop --}}
        <nav class="hidden items-center gap-6 text-sm font-medium lg:flex">
            <a href="{{ route('home') }}"
               class="text-[#326AAB]">
                Beranda
            </a>

            <a href="{{ route('umkm.index') }}"
               class="text-gray-600 transition hover:text-[#326AAB]">
                UMKM
            </a>

            <a
                href="{{ route('peta.index') }}"
                class="text-gray-600 transition hover:text-[#326AAB]"
            >
                Peta
            </a>

            <a href="{{ route('home') }}#tentang"
               class="text-gray-600 transition hover:text-[#326AAB]">
                Tentang
            </a>
        </nav>

        {{-- Search --}}
        <form
            method="GET"
            action="{{ route('umkm.index') }}"
            class="hidden min-w-0 max-w-xs flex-1 xl:flex"
        >
            <input
                type="search"
                name="q"
                placeholder="Cari UMKM..."
                class="w-full rounded-full border-0 bg-[#F5F2EB] px-4 py-2.5 text-sm outline-none ring-1 ring-transparent transition focus:ring-[#326AAB]"
            >
        </form>

        {{-- Tombol Admin --}}
        <a
            href="{{ route('admin.login') }}"
            class="shrink-0 rounded-full bg-[#326AAB] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#28598f]"
        >
            Masuk
        </a>

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

    @stack('scripts')
</body>
</html>
