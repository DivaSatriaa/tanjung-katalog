
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


@push('styles')
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    >
    <style>
        #umkm-coordinate-map {
            height: 360px;
            width: 100%;
            border-radius: 12px;
            z-index: 0;
        }
    </style>
@endpush

{{-- Pemilih koordinat --}}
<div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
    <h3 class="mb-2 text-lg font-semibold">Pilih Lokasi dari Peta</h3>

    <p class="mb-4 text-sm text-gray-500">
        Klik lokasi yang sesuai untuk mengisi koordinat otomatis.
        Kamu juga bisa menggeser pin untuk menyesuaikan posisi.
    </p>

    <div id="umkm-coordinate-map"></div>

    <p class="mt-3 text-xs text-gray-500">
        Peta menggunakan OpenStreetMap. Pastikan pin sesuai dengan
        lokasi usaha yang sebenarnya.
    </p>
</div>

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        (() => {
            const mapElement = document.getElementById('umkm-coordinate-map');
            const latInput = document.getElementById('latitude');
            const lngInput = document.getElementById('longitude');

            if (!mapElement || !latInput || !lngInput || typeof L === 'undefined') {
                return;
            }

            function readCoordinates() {
                const latText = latInput.value.trim();
                const lngText = lngInput.value.trim();

                if (latText === '' || lngText === '') {
                    return null;
                }

                const lat = Number(latText);
                const lng = Number(lngText);

                if (
                    !Number.isFinite(lat) ||
                    !Number.isFinite(lng) ||
                    lat < -90 || lat > 90 ||
                    lng < -180 || lng > 180
                ) {
                    return null;
                }

                return [lat, lng];
            }

            const existingCoordinates = readCoordinates();

            const map = L.map(mapElement).setView(
                existingCoordinates || [-6.95, 110.42],
                existingCoordinates ? 16 : 12
            );

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            let marker = null;

            function placeMarker(coordinates, recenter = false) {
                if (!marker) {
                    marker = L.marker(coordinates, {
                        draggable: true
                    }).addTo(map);

                    marker.on('dragend', () => {
                        const position = marker.getLatLng();

                        latInput.value = position.lat.toFixed(7);
                        lngInput.value = position.lng.toFixed(7);
                    });
                } else {
                    marker.setLatLng(coordinates);
                }

                if (recenter) {
                    map.setView(coordinates, 16);
                }
            }

            map.on('click', (event) => {
                const lat = event.latlng.lat;
                const lng = event.latlng.lng;

                latInput.value = lat.toFixed(7);
                lngInput.value = lng.toFixed(7);

                placeMarker([lat, lng]);
            });

            function syncFromInputs() {
                const coordinates = readCoordinates();

                if (coordinates) {
                    placeMarker(coordinates, true);
                }
            }

            latInput.addEventListener('change', syncFromInputs);
            lngInput.addEventListener('change', syncFromInputs);

            if (existingCoordinates) {
                placeMarker(existingCoordinates);
            }
        })();
    </script>
@endpush


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
            data-image-preview="cover-image-preview"
        >

        <img id="cover-image-preview" alt="" class="mt-4 hidden h-40 w-56 rounded-xl border border-gray-200 object-cover">

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
                    Draf — belum ditampilkan ke publik
                </option>

                <option
                    value="published"
                    @selected(old('status', $umkm->status ?? 'draft') === 'published')
                >
                    Terbit — ditampilkan ke publik
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
