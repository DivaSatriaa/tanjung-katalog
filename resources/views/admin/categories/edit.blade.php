@extends('admin.layouts.app')

@section('title', 'Edit Kategori')

@section('content')

<div class="max-w-2xl">

    <div class="mb-8">
        <h2 class="text-2xl font-bold">
            Edit Kategori
        </h2>

        <p class="text-gray-500 mt-1">
            Perbarui informasi kategori.
        </p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

        <form
            method="POST"
            action="{{ route('admin.categories.update', $category) }}"
            class="space-y-6"
        >
            @csrf
            @method('PUT')

            <div>
                <label
                    for="name"
                    class="block text-sm font-medium text-gray-700 mb-2"
                >
                    Nama Kategori
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $category->name) }}"
                    required
                    autofocus
                    class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-[#326AAB] focus:ring-[#326AAB]"
                >

                @error('name')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex items-center gap-3">

                <a
                    href="{{ route('admin.categories.index') }}"
                    class="px-5 py-3 rounded-xl border border-gray-300 text-sm font-medium hover:bg-gray-50"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="px-5 py-3 rounded-xl bg-[#326AAB] text-white text-sm font-medium hover:bg-[#28598f]"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
