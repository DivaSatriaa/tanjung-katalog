@php
    $isEdit = isset($post);
@endphp

<form
    method="POST"
    action="{{ $isEdit ? route('admin.posts.update', $post) : route('admin.posts.store') }}"
    enctype="multipart/form-data"
    class="space-y-6"
>
    @csrf

    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:p-6">
        <h3 class="mb-6 text-lg font-semibold text-gray-900">Isi Berita</h3>

        <div class="space-y-6">
            <div>
                <label for="title" class="mb-2 block text-sm font-medium text-gray-700">
                    Judul <span class="text-red-500">*</span>
                </label>
                <input id="title" name="title" type="text" required maxlength="200" value="{{ old('title', $post->title ?? '') }}" placeholder="Contoh: Pelatihan Pemasaran Digital untuk UMKM Tanjung Mas" class="px-4 py-3">
                @error('title')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="excerpt" class="mb-2 block text-sm font-medium text-gray-700">Ringkasan</label>
                <textarea id="excerpt" name="excerpt" rows="2" maxlength="300" placeholder="Satu atau dua kalimat yang tampil di kartu berita." class="px-4 py-3">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                <p class="mt-1 text-xs text-gray-400">Opsional, maksimal 300 karakter. Jika kosong, diambil dari awal isi berita.</p>
                @error('excerpt')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="body" class="mb-2 block text-sm font-medium text-gray-700">
                    Isi Berita <span class="text-red-500">*</span>
                </label>
                <textarea id="body" name="body" rows="12" required placeholder="Tulis isi berita di sini..." class="px-4 py-3 leading-7">{{ old('body', $post->body ?? '') }}</textarea>
                <p class="mt-1 text-xs text-gray-400">Pisahkan paragraf dengan satu baris kosong.</p>
                @error('body')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:p-6">
        <h3 class="mb-6 text-lg font-semibold text-gray-900">Foto Sampul</h3>

        @if ($isEdit && $post->cover_image)
            <div class="mb-5">
                <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}" class="h-40 w-full max-w-sm rounded-xl border border-gray-200 object-cover">

                <label class="mt-3 inline-flex items-center gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="remove_cover_image" value="1">
                    Hapus foto sampul
                </label>
            </div>
        @endif

        <label for="cover_image" class="mb-2 block text-sm font-medium text-gray-700">
            {{ $isEdit && $post->cover_image ? 'Ganti foto (opsional)' : 'Unggah foto (opsional)' }}
        </label>
        <input id="cover_image" name="cover_image" type="file" accept=".jpg,.jpeg,.png,.webp" data-image-preview="cover-preview">
        <img id="cover-preview" alt="" class="mt-4 hidden h-40 w-full max-w-sm rounded-xl border border-gray-200 object-cover">
        <p class="mt-2 text-xs text-gray-400">Format JPG, PNG, atau WEBP. Maksimal 4 MB. Disarankan horizontal (rasio 16:10).</p>
        @error('cover_image')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:p-6">
        <h3 class="mb-6 text-lg font-semibold text-gray-900">Publikasi</h3>

        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label for="status" class="mb-2 block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status" required class="px-4 py-3">
                    <option value="draft" @selected(old('status', $post->status ?? 'draft') === 'draft')>Draf &mdash; belum tampil ke publik</option>
                    <option value="published" @selected(old('status', $post->status ?? 'draft') === 'published')>Terbit &mdash; tampil ke publik</option>
                </select>
                @error('status')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="published_at" class="mb-2 block text-sm font-medium text-gray-700">Tanggal terbit</label>
                <input id="published_at" name="published_at" type="datetime-local" value="{{ old('published_at', isset($post) && $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}" class="px-4 py-3">
                <p class="mt-1 text-xs text-gray-400">Kosongkan untuk memakai waktu saat diterbitkan. Isi tanggal mendatang untuk menjadwalkan.</p>
                @error('published_at')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
        <a href="{{ route('admin.posts.index') }}" class="rounded-xl border border-gray-300 px-6 py-3 text-center text-sm font-medium text-gray-700 transition hover:bg-gray-50">
            Batal
        </a>
        <button type="submit" class="rounded-xl bg-[#326AAB] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#28598f]">
            {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Berita' }}
        </button>
    </div>
</form>
