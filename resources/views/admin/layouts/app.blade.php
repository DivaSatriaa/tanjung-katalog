<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="robots" content="noindex, nofollow">

    <title>@yield('title', 'Admin') — TanjungKatalog</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="admin-panel min-h-screen bg-[#F5F2EB] text-gray-900 antialiased">

@php
    $adminNav = [
        [
            'label' => 'Dashboard',
            'href' => route('admin.dashboard'),
            'active' => request()->routeIs('admin.dashboard'),
            'icon' => '<rect x="3" y="3" width="7" height="9" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/><rect x="14" y="12" width="7" height="9" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/>',
        ],
        [
            'label' => 'Kategori',
            'href' => route('admin.categories.index'),
            'active' => request()->routeIs('admin.categories.*'),
            'icon' => '<path d="M3 3h8l10 10-8 8L3 11V3Z"/><circle cx="7.5" cy="7.5" r="1.2" fill="currentColor"/>',
        ],
        [
            'label' => 'UMKM',
            'href' => route('admin.umkms.index'),
            'active' => request()->routeIs('admin.umkms.*'),
            'icon' => '<path d="M3 9.5 4.5 4h15L21 9.5"/><path d="M3 9.5a3 3 0 0 0 6 0 3 3 0 0 0 6 0 3 3 0 0 0 6 0"/><path d="M5 12v8h14v-8"/>',
        ],
        [
            'label' => 'Produk',
            'href' => route('admin.products.index'),
            'active' => request()->routeIs('admin.products.*'),
            'icon' => '<path d="m3 7 9-4 9 4-9 5-9-5Z"/><path d="M3 7v10l9 5 9-5V7"/><path d="M12 12v10"/>',
        ],
        [
            'label' => 'Berita',
            'href' => route('admin.posts.index'),
            'active' => request()->routeIs('admin.posts.*'),
            'icon' => '<path d="M4 5a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v14a1 1 0 0 0 1 1H6a2 2 0 0 1-2-2V5Z"/><path d="M17 8h2a1 1 0 0 1 1 1v9a2 2 0 0 1-2 2"/><path d="M8 8h5M8 12h5M8 16h3"/>',
        ],
    ];
@endphp

    <div class="min-h-screen flex">

        {{-- Sidebar --}}
        <aside class="w-64 shrink-0 bg-white border-r border-gray-200 hidden md:sticky md:top-0 md:flex md:h-screen flex-col">

            <div class="px-5 py-5 border-b border-gray-100">
                <a href="{{ route('admin.dashboard') }}" class="block">
                    <img
                        src="{{ asset('images/tanjungkatalog-logo.png') }}"
                        alt="TanjungKatalog"
                        class="h-auto w-44"
                    >
                </a>

                <span class="mt-2 inline-flex rounded-full bg-[#EAF4F7] px-2.5 py-1 text-[11px] font-semibold uppercase tracking-wider text-[#326AAB]">
                    Panel Admin
                </span>
            </div>

            <nav class="flex-1 p-4 space-y-1" aria-label="Navigasi admin">
                @foreach ($adminNav as $item)
                    <a
                        href="{{ $item['href'] }}"
                        @class([
                            'flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition',
                            'bg-[#EAF4F7] text-[#326AAB]' => $item['active'],
                            'text-gray-700 hover:bg-gray-100' => ! $item['active'],
                        ])
                        @if ($item['active']) aria-current="page" @endif
                    >
                        <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            {!! $item['icon'] !!}
                        </svg>
                        {{ $item['label'] }}
                    </a>
                @endforeach

                <a
                    href="{{ route('home') }}"
                    target="_blank"
                    rel="noopener"
                    class="mt-4 flex items-center gap-3 rounded-xl border border-dashed border-gray-200 px-4 py-3 text-sm font-medium text-gray-600 transition hover:border-[#326AAB] hover:text-[#326AAB]"
                >
                    <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M14 4h6v6"/><path d="M20 4 10 14"/><path d="M19 14v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h5"/>
                    </svg>
                    Lihat situs
                </a>
            </nav>

            <div class="p-4 border-t border-gray-100">

                <div class="px-4 py-3 mb-2">
                    <p class="text-sm font-medium">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-xs text-gray-500 mt-1">
                        Administrator
                    </p>
                </div>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="w-full text-left px-4 py-3 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50"
                    >
                        Logout
                    </button>
                </form>

            </div>
        </aside>

        {{-- Main Content --}}
        <div class="min-w-0 flex-1">

            {{-- Mobile Header --}}
            <header class="sticky top-0 z-30 border-b border-gray-200 bg-white md:hidden">
                <div class="flex items-center justify-between px-5 py-3">

                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                        <img
                            src="{{ asset('images/tanjungkatalog-logo.png') }}"
                            alt="TanjungKatalog"
                            class="h-auto w-36"
                        >
                        <span class="rounded-full bg-[#EAF4F7] px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wider text-[#326AAB]">
                            Admin
                        </span>
                    </a>

                    <button
                        type="button"
                        id="mobile-menu-button"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full text-[#326AAB] transition hover:bg-[#EAF4F7]"
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

                <div id="mobile-menu" class="hidden border-t border-gray-100 px-5 pb-4 pt-3">
                    <nav class="flex flex-col gap-1" aria-label="Navigasi admin seluler">
                        @foreach ($adminNav as $item)
                            <a
                                href="{{ $item['href'] }}"
                                @class([
                                    'flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition',
                                    'bg-[#EAF4F7] text-[#326AAB]' => $item['active'],
                                    'text-gray-700 hover:bg-gray-100' => ! $item['active'],
                                ])
                                @if ($item['active']) aria-current="page" @endif
                            >
                                <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    {!! $item['icon'] !!}
                                </svg>
                                {{ $item['label'] }}
                            </a>
                        @endforeach

                        <a
                            href="{{ route('home') }}"
                            target="_blank"
                            rel="noopener"
                            class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-gray-700 hover:bg-gray-100"
                        >
                            <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M14 4h6v6"/><path d="M20 4 10 14"/><path d="M19 14v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h5"/>
                            </svg>
                            Lihat situs
                        </a>
                    </nav>

                    <form method="POST" action="{{ route('admin.logout') }}" class="mt-2 border-t border-gray-100 pt-2">
                        @csrf

                        <button
                            type="submit"
                            class="w-full rounded-xl px-3 py-3 text-left text-sm font-medium text-red-600 hover:bg-red-50"
                        >
                            Logout ({{ auth()->user()->name }})
                        </button>
                    </form>
                </div>
            </header>

            <main class="mx-auto max-w-7xl p-5 md:p-8 lg:p-10">
                @foreach (['success' => 'border-green-200 bg-green-50 text-green-800', 'error' => 'border-red-200 bg-red-50 text-red-700'] as $flashKey => $flashClasses)
                    @if (session($flashKey))
                        <div
                            role="{{ $flashKey === 'error' ? 'alert' : 'status' }}"
                            class="mb-6 flex items-start gap-3 rounded-xl border px-4 py-3 text-sm {{ $flashClasses }}"
                        >
                            <svg class="mt-0.5 h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                @if ($flashKey === 'success')
                                    <path d="M20 6 9 17l-5-5"/>
                                @else
                                    <circle cx="12" cy="12" r="9"/><path d="M12 8v4M12 16h.01"/>
                                @endif
                            </svg>
                            <span>{{ session($flashKey) }}</span>
                        </div>
                    @endif
                @endforeach

                @if ($errors->any())
                    <div role="alert" class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <p class="font-semibold">Periksa kembali isian berikut:</p>
                        <ul class="mt-1 list-inside list-disc space-y-0.5">
                            @foreach ($errors->all() as $errorMessage)
                                <li>{{ $errorMessage }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>

        </div>

    </div>

    @stack('scripts')
</body>
</html>
