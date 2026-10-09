
@php
    $isEdit = isset($umkm);
@endphp

<form
    method="POST"
    action="{{ $isEdit ? route('admin.umkms.update', $umkm) : route('admin.umkms.store') }}"
    enctype="multipart/form-data"
    class="space-y-6"
>
    @csrf

    @if ($isEdit)
        @method('PUT')
    @endif

    {{-- Informasi Dasar --}}
    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
        <h3 class="mb-6 text-lg font-semibold">Informasi Dasar</h3>

        <div class="grid gap-6 md:grid-cols-2">
            <div class="md:col-span-2">
                <label for="name" class="mb-2 block text-sm font-medium">
                    Nama UMKM <span class="text-red-500">*</span>
                </label>

                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $umkm->name ?? '') }}"
                    required
                    autofocus
                    class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-[#326AAB] focus:ring-[#326AAB]"
                    placeholder="Contoh: Bandeng Presto Bu Sari"
                >

                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category_id" class="mb-2 block text-sm font-medium">
                    Kategori <span class="text-red-500">*</span>
                </label>

                <select
                    id="category_id"
                    name="category_id"
                    required
                    class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-[#326AAB] focus:ring-[#326AAB]"
                >
                    <option value="">Pilih kategori</option>

                    @foreach ($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            @selected(old('category_id', $umkm->category_id ?? '') == $category->id)
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                @error('category_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                @if ($categories->isEmpty())
                    <p class="mt-2 text-sm text-amber-600">
                        Belum ada kategori.
                        Buat kategori terlebih dahulu sebelum menambahkan UMKM.
                    </p>
                @endif
            </div>

            <div>
                <label for="owner_name" class="mb-2 block text-sm font-medium">
                    Nama Pemilik
                </label>

                <input
                    id="owner_name"
                    name="owner_name"
                    type="text"
                    value="{{ old('owner_name', $umkm->owner_name ?? '') }}"
                    class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-[#326AAB] focus:ring-[#326AAB]"
                >

                @error('owner_name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label for="description" class="mb-2 block text-sm font-medium">
                    Deskripsi Usaha
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-[#326AAB] focus:ring-[#326AAB]"
                    placeholder="Ceritakan tentang usaha ini..."
                >{{ old('description', $umkm->description ?? '') }}</textarea>

                @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- Kontak --}}
    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
        <h3 class="mb-6 text-lg font-semibold">Kontak</h3>

        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label for="phone" class="mb-2 block text-sm font-medium">
                    Nomor Telepon
                </label>

                <input
                    id="phone"
                    name="phone"
                    type="text"
                    value="{{ old('phone', $umkm->phone ?? '') }}"
                    class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-[#326AAB] focus:ring-[#326AAB]"
                    placeholder="08xxxxxxxxxx"
                >

                @error('phone')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="whatsapp" class="mb-2 block text-sm font-medium">
                    WhatsApp
                </label>

                <input
                    id="whatsapp"
                    name="whatsapp"
                    type="text"
                    value="{{ old('whatsapp', $umkm->whatsapp ?? '') }}"
                    class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-[#326AAB] focus:ring-[#326AAB]"
                    placeholder="628123456789"
                >

                <p class="mt-1 text-xs text-gray-400">
                    Gunakan format internasional untuk tautan WhatsApp.
                </p>

                @error('whatsapp')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label for="instagram" class="mb-2 block text-sm font-medium">
                    Instagram
                </label>

                <input
                    id="instagram"
                    name="instagram"
                    type="text"
                    value="{{ old('instagram', $umkm->instagram ?? '') }}"
                    class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-[#326AAB] focus:ring-[#326AAB]"
                    placeholder="@namaakun"
                >

                @error('instagram')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- Lokasi --}}
    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
        <h3 class="mb-2 text-lg font-semibold">Lokasi</h3>

        <p class="mb-6 text-sm text-gray-500">
            Koordinat akan digunakan untuk menempatkan UMKM pada peta.
        </p>

        <div class="grid gap-6 md:grid-cols-2">
            <div class="md:col-span-2">
                <label for="address" class="mb-2 block text-sm font-medium">
                    Alamat
                </label>

                <textarea
                    id="address"
                    name="address"
                    rows="3"
                    class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-[#326AAB] focus:ring-[#326AAB]"
                >{{ old('address', $umkm->address ?? '') }}</textarea>

                @error('address')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="latitude" class="mb-2 block text-sm font-medium">
                    Latitude
                </label>

                <input
                    id="latitude"
                    name="latitude"
                    type="number"
                    step="any"
                    min="-90"
                    max="90"
                    value="{{ old('latitude', $umkm->latitude ?? '') }}"
                    class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-[#326AAB] focus:ring-[#326AAB]"
                    placeholder="-6.9..."
                >

                @error('latitude')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="longitude" class="mb-2 block text-sm font-medium">
                    Longitude
                </label>

                <input
                    id="longitude"
                    name="longitude"
                    type="number"
                    step="any"
                    min="-180"
                    max="180"
                    value="{{ old('longitude', $umkm->longitude ?? '') }}"
                    class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-[#326AAB] focus:ring-[#326AAB]"
                    placeholder="110.4..."
                >

                @error('longitude')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- Foto --}}
    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
        <h3 class="mb-6 text-lg font-semibold">Foto UMKM</h3>

        @if ($isEdit && $umkm->cover_image)
            <div class="mb-5">
                <p class="mb-2 text-sm font-medium text-gray-700">Foto saat ini</p>

                <img
                    src="{{ asset('storage/' . $umkm->cover_image) }}"
                    alt="Foto {{ $umkm->name }}"
                    class="h-40 w-56 rounded-xl border border-gray-200 object-cover"
                >
            </div>
        @endif

        <label for="cover_image" class="mb-2 block text-sm font-medium">
            {{ $isEdit ? 'Ganti Foto Cover (opsional)' : 'Foto Cover' }}
        </label>

        <input
            id="cover_image"
            name="cover_image"
            type="file"
            accept=".jpg,.jpeg,.png,.webp"
            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm"
        >

        <p class="mt-2 text-xs text-gray-400">
            JPG, JPEG, PNG, atau WEBP. Maksimal 4 MB.
            Kosongkan saat mengedit jika foto tidak ingin diganti.
        </p>

        @error('cover_image')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Publikasi --}}
    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
        <h3 class="mb-6 text-lg font-semibold">Publikasi</h3>

        <div>
            <label for="status" class="mb-2 block text-sm font-medium">
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
                    @selected(old('status', $umkm->status ?? 'draft') === 'draft')
                >
                    Draft — belum ditampilkan ke publik
                </option>

                <option
                    value="published"
                    @selected(old('status', $umkm->status ?? 'draft') === 'published')
                >
                    Published — ditampilkan ke publik
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
                @checked(old('is_featured', $umkm->is_featured ?? false))
                class="mt-1 rounded border-gray-300 text-[#326AAB] focus:ring-[#326AAB]"
            >

            <span>
                <span class="block text-sm font-medium text-gray-700">
                    Jadikan UMKM unggulan
                </span>

                <span class="mt-1 block text-xs text-gray-400">
                    UMKM unggulan dapat diprioritaskan pada halaman beranda.
                </span>
            </span>
        </label>
    </div>

    {{-- Actions --}}
    <div class="flex items-center justify-end gap-3">
        <a
            href="{{ route('admin.umkms.index') }}"
            class="rounded-xl border border-gray-300 px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50"
        >
            Batal
        </a>

        <button
            type="submit"
            class="rounded-xl bg-[#326AAB] px-6 py-3 text-sm font-medium text-white transition hover:bg-[#28598f]"
        >
            {{ $isEdit ? 'Simpan Perubahan' : 'Simpan UMKM' }}
        </button>
    </div>
</form>
