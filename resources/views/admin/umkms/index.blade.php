@extends('admin.layouts.app')

@section('title', 'UMKM')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">

    <div>
        <h2 class="text-2xl font-bold">
            UMKM
        </h2>

        <p class="text-gray-500 mt-1">
            Kelola data UMKM yang tampil di TanjungKatalog.
        </p>
    </div>

    <a
        href="{{ route('admin.umkms.create') }}"
        class="inline-flex items-center justify-center rounded-xl bg-[#326AAB] px-5 py-3 text-sm font-medium text-white hover:bg-[#28598f] transition"
    >
        + Tambah UMKM
    </a>

</div>

@if (session('success'))
    <div class="mb-6 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
        {{ session('success') }}
    </div>
@endif


{{-- Pencarian dan filter UMKM --}}
<form
    method="GET"
    action="{{ route('admin.umkms.index') }}"
    class="mb-6 rounded-2xl border border-gray-100 bg-white p-5 shadow-sm"
>
    <div class="grid items-end gap-4 sm:grid-cols-2 lg:grid-cols-4">

        {{-- Pencarian --}}
        <div class="lg:col-span-2">
            <label for="q" class="mb-2 block text-sm font-medium text-gray-700">
                Cari UMKM
            </label>

            <input
                id="q"
                name="q"
                type="search"
                value="{{ $search }}"
                placeholder="Nama UMKM atau nama pemilik..."
                class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-[#326AAB] focus:ring-[#326AAB]"
            >
        </div>

        {{-- Filter kategori --}}
        <div>
            <label for="category_id" class="mb-2 block text-sm font-medium text-gray-700">
                Kategori
            </label>

            <select
                id="category_id"
                name="category_id"
                class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-[#326AAB] focus:ring-[#326AAB]"
            >
                <option value="">Semua kategori</option>

                @foreach ($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        @selected((string) $categoryId === (string) $category->id)
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Filter status --}}
        <div>
            <label for="status" class="mb-2 block text-sm font-medium text-gray-700">
                Status publikasi
            </label>

            <select
                id="status"
                name="status"
                class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-[#326AAB] focus:ring-[#326AAB]"
            >
                <option value="">Semua status</option>

                <option value="published" @selected($status === 'published')>
                    Published
                </option>

                <option value="draft" @selected($status === 'draft')>
                    Draft
                </option>
            </select>
        </div>

    </div>

    <div class="mt-5 flex flex-wrap gap-3">
        <button
            type="submit"
            class="rounded-xl bg-[#326AAB] px-5 py-3 text-sm font-medium text-white transition hover:bg-[#28598f]"
        >
            Cari & Filter
        </button>

        <a
            href="{{ route('admin.umkms.index') }}"
            class="rounded-xl border border-gray-300 px-5 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
        >
            Reset
        </a>
    </div>
</form>


<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

    <div class="overflow-x-auto">

        <table class="min-w-full">

            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>

                    <th class="text-left px-4 py-4 md:px-6 text-xs font-semibold text-gray-500 uppercase">
                        UMKM
                    </th>

                    <th class="hidden text-left px-4 py-4 md:px-6 text-xs font-semibold text-gray-500 uppercase md:table-cell">
                        Kategori
                    </th>

                    <th class="hidden text-left px-4 py-4 md:px-6 text-xs font-semibold text-gray-500 uppercase md:table-cell">
                        Produk
                    </th>

                    <th class="hidden text-left px-4 py-4 md:px-6 text-xs font-semibold text-gray-500 uppercase md:table-cell">
                        Status
                    </th>

                    <th class="text-right px-4 py-4 md:px-6 text-xs font-semibold text-gray-500 uppercase">
                        Aksi
                    </th>

                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse ($umkms as $umkm)

                    <tr class="hover:bg-gray-50">

                        {{-- UMKM --}}
                        <td class="px-4 py-4 md:px-6">

                            <div class="flex items-center gap-4">

                                <div class="h-12 w-12 rounded-xl bg-[#CFE5E2] overflow-hidden shrink-0 md:h-14 md:w-14">

                                    @if ($umkm->cover_image)
                                        <img
                                            src="{{ asset('storage/' . $umkm->cover_image) }}"
                                            alt="{{ $umkm->name }}"
                                            class="w-full h-full object-cover"
                                        >
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-[#326AAB] text-xl">
                                            🏪
                                        </div>
                                    @endif

                                </div>

                                <div>
                                    <div class="font-medium text-gray-900">
                                        {{ $umkm->name }}
                                    </div>

                                    @if ($umkm->owner_name)
                                        <div class="text-sm text-gray-400 mt-1">
                                            {{ $umkm->owner_name }}
                                        </div>
                                    @endif

                                    <div class="mt-1 text-xs text-gray-500 md:hidden">
                                        {{ $umkm->category->name }} · {{ $umkm->products_count }} produk
                                    </div>

                                    <div class="mt-2 md:hidden">
                                        @if ($umkm->status === 'published')
                                            <span class="inline-flex rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700">Published</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-yellow-50 px-2.5 py-0.5 text-xs font-medium text-yellow-700">Draft</span>
                                        @endif
                                    </div>
                                </div>

                            </div>

                        </td>

                        {{-- Kategori --}}
                        <td class="hidden px-4 py-4 md:px-6 text-sm text-gray-600 md:table-cell">
                            {{ $umkm->category->name }}
                        </td>

                        {{-- Produk --}}
                        <td class="hidden px-4 py-4 md:px-6 text-sm text-gray-600 md:table-cell">
                            {{ $umkm->products_count }} produk
                        </td>

                        {{-- Status --}}
                        <td class="hidden px-4 py-4 md:px-6 md:table-cell">

                            @if ($umkm->status === 'published')

                                <span class="inline-flex items-center rounded-full bg-green-50 px-3 py-1 text-xs font-medium text-green-700">
                                    Published
                                </span>

                            @else

                                <span class="inline-flex items-center rounded-full bg-yellow-50 px-3 py-1 text-xs font-medium text-yellow-700">
                                    Draft
                                </span>

                            @endif

                        </td>

                        {{-- Aksi --}}
                        <td class="px-4 py-4 md:px-6">

                            <div class="flex items-center justify-end gap-2">

                                <a
                                    href="{{ route('admin.umkms.edit', $umkm) }}"
                                    class="px-3 py-2 rounded-lg text-sm font-medium text-[#326AAB] hover:bg-blue-50"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('admin.umkms.destroy', $umkm) }}"
                                    onsubmit="return confirm('Hapus UMKM ini? Semua produk milik UMKM ini juga akan terhapus.');"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="px-3 py-2 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50"
                                    >
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

               
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="mb-3 text-4xl">
                                @if ($search !== '' || $categoryId !== '' || $status !== '')
                                    🔎
                                @else
                                    🏪
                                @endif
                            </div>

                            @if ($search !== '' || $categoryId !== '' || $status !== '')
                                <p class="font-medium text-gray-900">
                                    Tidak ada UMKM yang cocok
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    Coba ubah kata kunci, kategori, atau status publikasi.
                                </p>

                                <a
                                    href="{{ route('admin.umkms.index') }}"
                                    class="mt-5 inline-flex rounded-xl bg-[#326AAB] px-5 py-3 text-sm font-medium text-white hover:bg-[#28598f]"
                                >
                                    Reset Pencarian
                                </a>
                            @else
                                <p class="font-medium text-gray-900">
                                    Belum ada UMKM
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    Tambahkan UMKM pertama untuk mulai mengisi katalog.
                                </p>

                                <a
                                    href="{{ route('admin.umkms.create') }}"
                                    class="mt-5 inline-flex rounded-xl bg-[#326AAB] px-5 py-3 text-sm font-medium text-white hover:bg-[#28598f]"
                                >
                                    + Tambah UMKM
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforelse


            </tbody>

        </table>

    </div>

</div>

@if ($umkms->hasPages())
    <div class="mt-6">
        {{ $umkms->links() }}
    </div>
@endif

@endsection
