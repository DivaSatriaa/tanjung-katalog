<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin — TanjungKatalog</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#F5F2EB]">

    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <div>
                <h1 class="font-bold text-[#326AAB]">
                    TanjungKatalog
                </h1>

                <p class="text-xs text-gray-500">
                    Admin Dashboard
                </p>
            </div>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf

                <button
                    type="submit"
                    class="text-sm text-gray-600 hover:text-red-600"
                >
                    Logout
                </button>
            </form>

        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-10">

        <h2 class="text-2xl font-bold text-gray-900">
            Halo, {{ auth()->user()->name }} 👋
        </h2>

        <p class="text-gray-600 mt-1">
            Selamat datang di Admin TanjungKatalog.
        </p>

        <div class="grid md:grid-cols-3 gap-6 mt-8">

            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <p class="text-sm text-gray-500">Total UMKM</p>
                <p class="text-3xl font-bold mt-2">0</p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <p class="text-sm text-gray-500">Total Produk</p>
                <p class="text-3xl font-bold mt-2">0</p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <p class="text-sm text-gray-500">Status</p>
                <p class="text-3xl font-bold mt-2 text-green-600">
                    Aktif
                </p>
            </div>

        </div>

    </main>

</body>
</html>
