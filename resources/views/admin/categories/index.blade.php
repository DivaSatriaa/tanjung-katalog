@extends('admin.layouts.app')

@section('title', 'Kategori')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">

    <div>
        <h2 class="text-2xl font-bold">
            Kategori
        </h2>

        <p class="text-gray-500 mt-1">
            Kelola kategori UMKM TanjungKatalog.
        </p>
    </div>

    <a
        href="{{ route('admin.categories.create') }}"
        class="inline-flex items-center justify-center rounded-xl bg-[#326AAB] px-5 py-3 text-sm font-medium text-white hover:bg-[#28598f]"
    >
        + Tambah Kategori
    </a>

</div>

@if (session('success'))
    <div class="mb-6 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-6 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
        {{ session('error') }}
    </div>
@endif

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

    <div class="overflow-x-auto">

        <table class="min-w-full">

            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>

                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">
                        Nama
                    </th>

                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">
                        Jumlah UMKM
                    </th>

                    <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase">
                        Aksi
                    </th>

                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse ($categories as $category)

                    <tr class="hover:bg-gray-50">

                        <td class="px-6 py-4">
                            <div class="font-medium">
                                {{ $category->name }}
                            </div>

                            <div class="text-sm text-gray-400 mt-1">
                                {{ $category->slug }}
                            </div>
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $category->umkms_count }} UMKM
                        </td>

                        <td class="px-6 py-4">

                            <div class="flex items-center justify-end gap-2">

                                <a
                                    href="{{ route('admin.categories.edit', $category) }}"
                                    class="px-3 py-2 rounded-lg text-sm font-medium text-[#326AAB] hover:bg-blue-50"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('admin.categories.destroy', $category) }}"
                                    onsubmit="return confirm('Hapus kategori ini?')"
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
                            colspan="3"
                            class="px-6 py-12 text-center text-gray-500"
                        >
                            Belum ada kategori.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection