<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Admin — TanjungKatalog</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#F5F2EB] flex items-center justify-center px-4">

    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-[#326AAB]">
                TanjungKatalog
            </h1>

            <p class="mt-2 text-gray-600">
                Admin Panel
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

            <h2 class="text-xl font-semibold text-gray-900">
                Masuk sebagai Admin
            </h2>

            <p class="text-sm text-gray-500 mt-1 mb-6">
                Kelola data UMKM dan produk TanjungKatalog.
            </p>

            <form method="POST" action="{{ route('admin.login.store') }}">
                @csrf

                <div class="mb-4">
                    <label
                        for="email"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full rounded-xl border-gray-300 focus:border-[#326AAB] focus:ring-[#326AAB] px-4 py-3"
                        placeholder="admin@example.com"
                    >

                    @error('email')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label
                        for="password"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        class="w-full rounded-xl border-gray-300 focus:border-[#326AAB] focus:ring-[#326AAB] px-4 py-3"
                        placeholder="Masukkan password"
                    >

                    @error('password')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full rounded-xl bg-[#326AAB] hover:bg-[#28598f] text-white font-medium py-3 transition"
                >
                    Masuk
                </button>
            </form>

        </div>

        <div class="text-center mt-6">
            <a
                href="/"
                class="text-sm text-gray-500 hover:text-[#326AAB]"
            >
                ← Kembali ke TanjungKatalog
            </a>
        </div>

    </div>

</body>
</html>
