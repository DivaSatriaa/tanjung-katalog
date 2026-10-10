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
</head>

<body class="min-h-screen bg-[#F5F2EB] text-gray-800 antialiased">

    <header class="sticky top-0 z-40 border-b border-gray-200/70 bg-[#F5F2EB]/95 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-5 px-5 py-4 lg:px-8">

            <a href="{{ route('home') }}" class="shrink-0">
                <span class="block text-xl font-extrabold tracking-tight text-[#326AAB]">
                    TanjungKatalog
                </span>

                <span class="mt-0.5 block text-xs text-gray-500">
                    UMKM Kelurahan Tanjung Mas
                </span>
            </a>

            <nav class="flex items-center gap-5 text-sm font-medium sm:gap-7">
                <a
                    href="{{ route('home') }}"
                    class="text-[#326AAB] hover:text-[#28598f]"
                >
                    Beranda
                </a>

                <a
                    href="{{ route('umkm.index') }}"
                    class="text-gray-600 transition hover:text-[#326AAB]"
                >
                    UMKM
                </a>

                <a
                    href="{{ route('home') }}#tentang"
                    class="hidden text-gray-600 transition hover:text-[#326AAB] sm:inline"
                >
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

</body>
</html>
