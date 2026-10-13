
@extends('admin.layouts.app')

@section('title', 'Produk')

@section('content')

<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Produk</h2>
        <p class="mt-1 text-gray-500">
            Kelola produk dari UMKM yang terdaftar di TanjungKatalog.
        </p>
    </div>

    <a
        href="{{ route('admin.products.create') }}"
        class="inline-flex items-center justify-center rounded-xl bg-[#326AAB] px-5 py-3 text-sm font-medium text-white transition hover:bg-[#28598f]"
    >
        + Tambah Produk
    </a>
</div>

@if (session('success'))
    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        {{ session('error') }}
    </div>
@endif


{{-- Pencarian dan filter produk --}}
<form
    method="GET"
    action="{{ route('admin.products.index') }}"
    class="mb-6 rounded-2xl border border-gray-100 bg-white p-5 shadow-sm"
>
    <div class="grid items-end gap-4 sm:grid-cols-2 lg:grid-cols-4">

        {{-- Pencarian nama produk --}}
        <div class="lg:col-span-2">
            <label for="q" class="mb-2 block text-sm font-medium text-gray-700">
                Cari Produk
            </label>

            <input
                id="q"
                name="q"
                type="search"
                value="{{ $search }}"
                placeholder="Masukkan nama produk..."
                class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-[#326AAB] focus:ring-[#326AAB]"
            >
        </div>

        {{-- Filter UMKM --}}
        <div>
            <label for="umkm_id" class="mb-2 block text-sm font-medium text-gray-700">
                Pemilik UMKM
            </label>

            <select
                id="umkm_id"
                name="umkm_id"
                class="w-full rounded-xl border-gray-300 px-4 py-3 focus:border-[#326AAB] focus:ring-[#326AAB]"
            >
                <option value="">Semua UMKM</option>

                @foreach ($umkms as $umkm)
                    <option
                        value="{{ $umkm->id }}"
                        @selected((string) $umkmId === (string) $umkm->id)
                    >
                        {{ $umkm->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Filter status --}}
        <div>
            <label for="status" class="mb-2 block text-sm font-medium text-gray-700">
                Status Publikasi
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
            href="{{ route('admin.products.index') }}"
            class="rounded-xl border border-gray-300 px-5 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
        >
            Reset
        </a>
    </div>
</form>


<div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="border-b border-gray-100 bg-gray-50">
                <tr>
                    <th class="px-4 py-4 md:px-6 text-left text-xs font-semibold uppercase text-gray-500">
                        Produk
                    </th>
                    <th class="hidden px-4 py-4 md:px-6 text-left text-xs font-semibold uppercase text-gray-500 md:table-cell">
                        UMKM
                    </th>
                    <th class="hidden px-4 py-4 md:px-6 text-left text-xs font-semibold uppercase text-gray-500 md:table-cell">
                        Harga
                    </th>
                    <th class="hidden px-4 py-4 md:px-6 text-left text-xs font-semibold uppercase text-gray-500 md:table-cell">
                        Status
                    </th>
                    <th class="px-4 py-4 md:px-6 text-right text-xs font-semibold uppercase text-gray-500">
                        Aksi
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse ($products as $product)
                    <tr class="transition hover:bg-gray-50">
                        <td class="px-4 py-4 md:px-6">
                            <div class="flex items-center gap-4">
                                <div class="h-12 w-12 shrink-0 overflow-hidden rounded-xl bg-[#CFE5E2] md:h-14 md:w-14">
                                    @if ($product->image)
                                        <img
                                            src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->name }}"
                                            class="h-full w-full object-cover"
                                        >
                                    @else
                                        <div class="flex h-full w-full items-center justify-center text-xl text-[#326AAB]">
                                            📦
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    <p class="font-medium text-gray-900">
                                        {{ $product->name }}
                                    </p>
                                    <p class="mt-1 hidden text-sm text-gray-400 md:block">
                                        {{ $product->slug }}
                                    </p>
                                    <p class="mt-1 text-xs text-gray-500 md:hidden">
                                        {{ $product->umkm?->name ?? 'UMKM tidak tersedia' }}
                                        ·
                                        @if ($product->price !== null)
                                            Rp{{ number_format((float) $product->price, 0, ',', '.') }}
                                        @else
                                            Harga belum ditentukan
                                        @endif
                                    </p>

                                    <div class="mt-2 md:hidden">
                                        @if ($product->status === 'published')
                                            <span class="inline-flex rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700">Published</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-yellow-50 px-2.5 py-0.5 text-xs font-medium text-yellow-700">Draft</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="hidden px-4 py-4 md:px-6 text-sm text-gray-600 md:table-cell">
                            {{ $product->umkm?->name ?? 'UMKM tidak tersedia' }}
                        </td>

                        <td class="hidden px-4 py-4 md:px-6 text-sm font-medium text-gray-700 md:table-cell">
                            @if ($product->price !== null)
                                Rp{{ number_format((float) $product->price, 0, ',', '.') }}
                            @else
                                <span class="text-gray-400">Belum ditentukan</span>
                            @endif
                        </td>

                        <td class="hidden px-4 py-4 md:px-6 md:table-cell">
                            @if ($product->status === 'published')
                                <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-medium text-green-700">
                                    Published
                                </span>
                            @else
                                <span class="inline-flex rounded-full bg-yellow-50 px-3 py-1 text-xs font-medium text-yellow-700">
                                    Draft
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-4 md:px-6">
                            <div class="flex items-center justify-end gap-2">
                                <a
                                    href="{{ route('admin.products.edit', $product) }}"
                                    class="rounded-lg px-3 py-2 text-sm font-medium text-[#326AAB] hover:bg-blue-50"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('admin.products.destroy', $product) }}"
                                    onsubmit="return confirm('Yakin ingin menghapus produk ini?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="rounded-lg px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50"
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
                            @if ($search !== '' || $umkmId !== '' || $status !== '')
                                <div class="mb-3 text-4xl">🔎</div>

                                <p class="font-medium text-gray-900">
                                    Tidak ada produk yang cocok
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    Coba ubah kata kunci, UMKM, atau status publikasi.
                                </p>

                                <a
                                    href="{{ route('admin.products.index') }}"
                                    class="mt-5 inline-flex rounded-xl bg-[#326AAB] px-5 py-3 text-sm font-medium text-white hover:bg-[#28598f]"
                                >
                                    Reset Pencarian
                                </a>
                            @else
                                <div class="mb-3 text-4xl">📦</div>

                                <p class="font-medium text-gray-900">
                                    Belum ada produk
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    Tambahkan produk pertama untuk mulai mengisi katalog.
                                </p>

                                <a
                                    href="{{ route('admin.products.create') }}"
                                    class="mt-5 inline-flex rounded-xl bg-[#326AAB] px-5 py-3 text-sm font-medium text-white hover:bg-[#28598f]"
                                >
                                    + Tambah Produk
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    @if ($products->hasPages())
        <div class="border-t border-gray-100 px-4 py-4 md:px-6">
            {{ $products->links() }}
        </div>
    @endif
</div>

@endsection
