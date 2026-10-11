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

    <div class="min-h-screen flex">

        {{-- Sidebar --}}
        <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col">

            <div class="px-6 py-6 border-b border-gray-100">
                <h1 class="text-xl font-bold text-[#326AAB]">
                    TanjungKatalog
                </h1>

                <p class="text-xs text-gray-500 mt-1">
                    Admin Panel
                </p>
            </div>

            <nav class="flex-1 p-4 space-y-1">

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="block px-4 py-3 rounded-xl text-sm font-medium hover:bg-gray-100"
                >
                    Dashboard
                </a>

                <a
                    href="{{ route('admin.categories.index') }}"
                    class="block px-4 py-3 rounded-xl text-sm font-medium hover:bg-gray-100"
                >
                    Kategori
                </a>

                <a
                    href="{{ route('admin.umkms.index') }}"
                    class="block px-4 py-3 rounded-xl text-sm font-medium hover:bg-gray-100"
                >
                    UMKM
                </a>

                <a
                    href="{{route('admin.products.index')}}"
                    class="block px-4 py-3 rounded-xl text-sm font-medium hover:bg-gray-100"
                >
                    Produk
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
        <div class="flex-1">

            {{-- Mobile Header --}}
            <header class="md:hidden bg-white border-b border-gray-200 px-5 py-4">
                <div class="flex items-center justify-between">

                    <div>
                        <h1 class="font-bold text-[#326AAB]">
                            TanjungKatalog
                        </h1>

                        <p class="text-xs text-gray-500">
                            Admin Panel
                        </p>
                    </div>

                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf

                        <button
                            type="submit"
                            class="text-sm text-red-600"
                        >
                            Logout
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
