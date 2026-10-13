<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin') — TanjungKatalog</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="min-h-screen bg-[#F5F2EB] text-gray-900">

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
    ];
@endphp

    <div class="min-h-screen flex">

        {{-- Sidebar --}}
        <aside class="w-64 shrink-0 bg-white border-r border-gray-200 hidden md:flex flex-col">

            <div class="px-6 py-6 border-b border-gray-100">
                <h1 class="text-xl font-bold text-[#326AAB]">
                    TanjungKatalog
                </h1>

                <p class="text-xs text-gray-500 mt-1">
                    Admin Panel
                </p>
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

                    <div>
                        <h1 class="font-bold text-[#326AAB]">
                            TanjungKatalog
                        </h1>

                        <p class="text-xs text-gray-500">
                            Admin Panel
                        </p>
                    </div>

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

            <main class="p-5 md:p-8 lg:p-10">
                @yield('content')
            </main>

        </div>

    </div>

    @stack('scripts')
</body>
</html>
