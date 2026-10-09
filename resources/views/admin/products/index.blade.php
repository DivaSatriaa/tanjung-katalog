
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

<div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="border-b border-gray-100 bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                        Produk
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                        UMKM
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                        Harga
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                        Status
                    </th>
                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase text-gray-500">
                        Aksi
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse ($products as $product)
                    <tr class="transition hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="h-14 w-14 shrink-0 overflow-hidden rounded-xl bg-[#CFE5E2]">
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
                                    <p class="mt-1 text-sm text-gray-400">
                                        {{ $product->slug }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $product->umkm?->name ?? 'UMKM tidak tersedia' }}
                        </td>

                        <td class="px-6 py-4 text-sm font-medium text-gray-700">
                            @if ($product->price !== null)
                                Rp{{ number_format((float) $product->price, 0, ',', '.') }}
                            @else
                                <span class="text-gray-400">Belum ditentukan</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
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

                        <td class="px-6 py-4">
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
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($products->hasPages())
        <div class="border-t border-gray-100 px-6 py-4">
            {{ $products->links() }}
        </div>
    @endif
</div>

@endsection
