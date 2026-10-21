<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">

    <title>Login Admin — TanjungKatalog</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="admin-panel flex min-h-screen items-center justify-center bg-gradient-to-br from-[#F8FCFD] via-[#F5F2EB] to-[#CFE5E2] px-5 py-10 text-gray-900 antialiased">

    <main class="w-full max-w-md">

        <div class="text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-4">
                <img
                    src="{{ asset('images/lambang-kota-semarang.png') }}"
                    alt="Lambang Kota Semarang"
                    class="h-14 w-auto"
                >

                <span class="h-12 w-px bg-[#CFE5E2]" aria-hidden="true"></span>

                <img
                    src="{{ asset('images/tanjungkatalog-logo.png') }}"
                    alt="TanjungKatalog — Katalog UMKM Kelurahan Tanjung Mas"
                    class="h-auto w-56"
                >
            </a>
        </div>

        <div class="mt-8 rounded-3xl border border-[#CFE5E2] bg-white p-6 shadow-[0_12px_40px_rgba(50,106,171,0.12)] sm:p-8">

            <h1 class="text-xl font-bold text-[#174875]">
                Masuk sebagai Admin
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Kelola data UMKM, produk, dan berita TanjungKatalog.
            </p>

            <form method="POST" action="{{ route('admin.login.store') }}" class="mt-6 space-y-5">
                @csrf

                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-gray-700">
                        Email
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="admin@contoh.id"
                        class="px-4 py-3"
                    >

                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-medium text-gray-700">
                        Password
                    </label>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="Masukkan password"
                        class="px-4 py-3"
                    >

                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full rounded-xl bg-[#326AAB] px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#28598f] focus:outline-none focus:ring-2 focus:ring-[#326AAB] focus:ring-offset-2"
                >
                    Masuk
                </button>
            </form>
        </div>

        <p class="mt-6 text-center">
            <a href="{{ route('home') }}" class="text-sm text-gray-500 transition hover:text-[#326AAB]">
                &larr; Kembali ke TanjungKatalog
            </a>
        </p>

    </main>

</body>
</html>
