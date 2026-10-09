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

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

    <div class="overflow-x-auto">

        <table class="min-w-full">

            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>

                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">
                        UMKM
                    </th>

                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">
                        Kategori
                    </th>

                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">
                        Produk
                    </th>

                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">
                        Status
                    </th>

                    <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase">
                        Aksi
                    </th>

                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse ($umkms as $umkm)

                    <tr class="hover:bg-gray-50">

                        {{-- UMKM --}}
                        <td class="px-6 py-4">

                            <div class="flex items-center gap-4">

                                <div class="w-14 h-14 rounded-xl bg-[#CFE5E2] overflow-hidden flex-shrink-0">

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
                                </div>

                            </div>

                        </td>

                        {{-- Kategori --}}
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $umkm->category->name }}
                        </td>

                        {{-- Produk --}}
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $umkm->products_count }} produk
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4">

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
                        <td class="px-6 py-4">

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

                        <td
                            colspan="5"
                            class="px-6 py-16 text-center"
                        >

                            <div class="text-4xl mb-3">
                                🏪
                            </div>

                            <p class="font-medium text-gray-900">
                                Belum ada UMKM
                            </p>

                            <p class="text-sm text-gray-500 mt-1">
                                Tambahkan UMKM pertama untuk mulai mengisi katalog.
                            </p>

                            <a
                                href="{{ route('admin.umkms.create') }}"
                                class="inline-flex mt-5 rounded-xl bg-[#326AAB] px-5 py-3 text-sm font-medium text-white hover:bg-[#28598f]"
                            >
                                + Tambah UMKM
                            </a>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
