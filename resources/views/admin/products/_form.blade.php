
@php
    $isEdit = isset($product);
@endphp

<form
    method="POST"
    action="{{ $isEdit ? route('admin.products.update', $product) : route('admin.products.store') }}"
    enctype="multipart/form-data"
    class="space-y-6"
>
    @csrf

    @if ($isEdit)
        @method('PUT')
    @endif

    {{-- Informasi Produk --}}
    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
        <h3 class="mb-6 text-lg font-semibold text-gray-900">
            Informasi Produk
        </h3>

        <div class="space-y-6">

            {{-- UMKM --}}
            <div>
                <label for="umkm_id" class="mb-2 block text-sm font-medium text-gray-700">
                    Pemilik UMKM <span class="text-red-500">*</span>
                </label>

                <select
                    id="umkm_id"
                    name="umkm_id"
                    required
                    class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-[#326AAB] focus:ring-[#326AAB]"
                >
                    <option value="">Pilih UMKM</option>

                    @foreach ($umkms as $umkmOption)
                        <option
                            value="{{ $umkmOption->id }}"
                            @selected(old('umkm_id', $product->umkm_id ?? '') == $umkmOption->id)
                        >
                            {{ $umkmOption->name }}
                        </option>
                    @endforeach
                </select>

                @error('umkm_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                @if ($umkms->isEmpty())
                    <p class="mt-2 text-sm text-amber-600">
                        Belum ada UMKM. Tambahkan UMKM terlebih dahulu.
                    </p>

                    <a
                        href="{{ route('admin.umkms.create') }}"
                        class="mt-2 inline-block text-sm font-medium text-[#326AAB] hover:underline"
                    >
                        + Tambah UMKM
                    </a>
                @endif
            </div>

            {{-- Nama Produk --}}
            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-gray-700">
                    Nama Produk <span class="text-red-500">*</span>
                </label>

                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $product->name ?? '') }}"
                    required
                    maxlength="150"
                    class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-[#326AAB] focus:ring-[#326AAB]"
                    placeholder="Contoh: Bandeng Presto Original"
                >

                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Harga --}}
            <div>
                <label for="price" class="mb-2 block text-sm font-medium text-gray-700">
                    Harga (Rp)
                </label>

                <input
                    id="price"
                    name="price"
                    type="number"
                    min="0"
                    step="0.01"
                    value="{{ old('price', $product->price ?? '') }}"
                    class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-[#326AAB] focus:ring-[#326AAB]"
                    placeholder="15000"
                >

                @error('price')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="description" class="mb-2 block text-sm font-medium text-gray-700">
                    Deskripsi Produk
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-[#326AAB] focus:ring-[#326AAB]"
                    placeholder="Jelaskan produk, bahan, ukuran, atau keunggulannya..."
                >{{ old('description', $product->description ?? '') }}</textarea>

                @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </div>

    {{-- Foto --}}
    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
        <h3 class="mb-6 text-lg font-semibold text-gray-900">
            Foto Produk
        </h3>

        @if ($isEdit && $product->image)
            <div class="mb-5">
                <p class="mb-2 text-sm font-medium text-gray-700">Foto saat ini</p>

                <img
                    src="{{ asset('storage/' . $product->image) }}"
                    alt="{{ $product->name }}"
                    class="h-40 w-56 rounded-xl border border-gray-200 object-cover"
                >
            </div>
        @endif

        <label for="image" class="mb-2 block text-sm font-medium text-gray-700">
            {{ $isEdit ? 'Ganti Foto (opsional)' : 'Foto Produk' }}
        </label>

        <input
            id="image"
            name="image"
            type="file"
            accept=".jpg,.jpeg,.png,.webp"
            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm"
        >

        <p class="mt-2 text-xs text-gray-400">
            Format JPG, JPEG, PNG, atau WEBP. Maksimal 4 MB.
            Kosongkan jika tidak ingin mengganti foto.
        </p>

        @error('image')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Publikasi --}}
    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
        <h3 class="mb-6 text-lg font-semibold text-gray-900">
            Publikasi
        </h3>

        <div>
            <label for="status" class="mb-2 block text-sm font-medium text-gray-700">
                Status
            </label>

            <select
                id="status"
                name="status"
                required
                class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-[#326AAB] focus:ring-[#326AAB]"
            >
                <option
                    value="draft"
                    @selected(old('status', $product->status ?? 'draft') === 'draft')
                >
                    Draft — belum tampil ke publik
                </option>

                <option
                    value="published"
                    @selected(old('status', $product->status ?? 'draft') === 'published')
                >
                    Published — tampil ke publik
                </option>
            </select>

            @error('status')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <label class="mt-5 flex cursor-pointer items-start gap-3">
            <input
                type="checkbox"
                name="is_featured"
                value="1"
                @checked(old('is_featured', $product->is_featured ?? false))
                class="mt-1 rounded border-gray-300 text-[#326AAB] focus:ring-[#326AAB]"
            >

            <span>
                <span class="block text-sm font-medium text-gray-700">
                    Jadikan produk unggulan
                </span>

                <span class="mt-1 block text-xs text-gray-400">
                    Produk ini dapat ditonjolkan pada halaman katalog.
                </span>
            </span>
        </label>
    </div>

    {{-- Tombol --}}
    <div class="flex justify-end gap-3">
        <a
            href="{{ route('admin.products.index') }}"
            class="rounded-xl border border-gray-300 px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50"
        >
            Batal
        </a>

        <button
            type="submit"
            @disabled($umkms->isEmpty())
            class="rounded-xl bg-[#326AAB] px-6 py-3 text-sm font-medium text-white transition hover:bg-[#28598f] disabled:cursor-not-allowed disabled:opacity-50"
        >
            {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Produk' }}
        </button>
    </div>
</form>
