@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">
            Halo, {{ auth()->user()->name }}
        </h2>

        <p class="mt-1 text-gray-500">
            Ringkasan katalog TanjungKatalog per {{ now()->translatedFormat('l, j F Y') }}.
        </p>
    </div>

    <div class="flex flex-wrap gap-2">
        <a href="{{ route('admin.umkms.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-[#326AAB] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#28598f]">
            <x-icon name="plus" class="h-4 w-4" />
            UMKM
        </a>
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-[#326AAB] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#28598f]">
            <x-icon name="plus" class="h-4 w-4" />
            Produk
        </a>
        <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center gap-2 rounded-xl border border-[#326AAB] bg-white px-4 py-2.5 text-sm font-semibold text-[#326AAB] transition hover:bg-[#EAF4F7]">
            <x-icon name="plus" class="h-4 w-4" />
            Berita
        </a>
    </div>
</div>

{{-- Statistik --}}
@php
    $statCards = [
        ['label' => 'UMKM', 'icon' => 'store', 'total' => $stats['umkms']['total'], 'note' => $stats['umkms']['published'] . ' terbit', 'url' => route('admin.umkms.index')],
        ['label' => 'Produk', 'icon' => 'box', 'total' => $stats['products']['total'], 'note' => $stats['products']['published'] . ' terbit', 'url' => route('admin.products.index')],
        ['label' => 'Kategori', 'icon' => 'tag', 'total' => $stats['categories'], 'note' => 'Pengelompokan UMKM', 'url' => route('admin.categories.index')],
        ['label' => 'Berita', 'icon' => 'news', 'total' => $stats['posts']['total'], 'note' => $stats['posts']['published'] . ' terbit', 'url' => route('admin.posts.index')],
    ];
@endphp

<div class="grid grid-cols-2 gap-4 xl:grid-cols-4">
    @foreach ($statCards as $card)
        <a href="{{ $card['url'] }}" class="group rounded-2xl border border-gray-100 bg-white p-5 shadow-sm transition hover:border-[#CFE5E2] hover:shadow-md">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-gray-500">{{ $card['label'] }}</p>
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAF4F7] text-[#326AAB]">
                    <x-icon :name="$card['icon']" />
                </span>
            </div>
            <p class="mt-3 text-3xl font-bold text-gray-900">{{ $card['total'] }}</p>
            <p class="mt-1 text-sm text-gray-500">{{ $card['note'] }}</p>
        </a>
    @endforeach
</div>

<div class="mt-8 grid gap-6 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.3fr)]">

    {{-- Perlu dilengkapi --}}
    <section class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:p-6">
        <h3 class="text-lg font-semibold text-gray-900">Perlu dilengkapi</h3>
        <p class="mt-1 text-sm text-gray-500">Data yang membuat katalog belum tampil maksimal.</p>

        <ul class="mt-5 divide-y divide-gray-100">
            @foreach ($checklist as $item)
                <li>
                    <a href="{{ $item['url'] }}" class="flex items-center justify-between gap-4 py-3 transition hover:text-[#326AAB]">
                        <span class="min-w-0">
                            <span class="block text-sm font-medium text-gray-800">{{ $item['label'] }}</span>
                            <span class="block text-xs text-gray-500">{{ $item['description'] }}</span>
                        </span>

                        @if ($item['count'] > 0)
                            <span class="shrink-0 rounded-full bg-amber-50 px-3 py-1 text-sm font-semibold text-amber-700">{{ $item['count'] }}</span>
                        @else
                            <span class="shrink-0 rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">Beres</span>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    </section>

    {{-- Terbaru --}}
    <section class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:p-6">
        <div class="flex items-center justify-between gap-4">
            <h3 class="text-lg font-semibold text-gray-900">Produk terbaru</h3>
            <a href="{{ route('admin.products.index') }}" class="text-sm font-semibold text-[#326AAB] hover:underline">Lihat semua</a>
        </div>

        <ul class="mt-4 divide-y divide-gray-100">
            @forelse ($latestProducts as $product)
                <li class="flex items-center gap-3 py-3">
                    <div class="h-11 w-11 shrink-0 overflow-hidden rounded-lg bg-[#CFE5E2]">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full w-full items-center justify-center text-[#326AAB]">
                                <x-icon name="box" class="h-5 w-5" />
                            </div>
                        @endif
                    </div>

                    <div class="min-w-0 flex-1">
                        <a href="{{ route('admin.products.edit', $product) }}" class="block truncate text-sm font-medium text-gray-900 hover:text-[#326AAB]">
                            {{ $product->name }}
                        </a>
                        <p class="truncate text-xs text-gray-500">{{ $product->umkm?->name }}</p>
                    </div>

                    <x-admin.status-badge :status="$product->status" />
                </li>
            @empty
                <li class="py-6 text-center text-sm text-gray-500">
                    Belum ada produk.
                    <a href="{{ route('admin.products.create') }}" class="font-semibold text-[#326AAB] hover:underline">Tambah produk pertama</a>
                </li>
            @endforelse
        </ul>

        <div class="mt-6 flex items-center justify-between gap-4 border-t border-gray-100 pt-5">
            <h3 class="text-lg font-semibold text-gray-900">UMKM terbaru</h3>
            <a href="{{ route('admin.umkms.index') }}" class="text-sm font-semibold text-[#326AAB] hover:underline">Lihat semua</a>
        </div>

        <ul class="mt-4 divide-y divide-gray-100">
            @forelse ($latestUmkms as $umkm)
                <li class="flex items-center gap-3 py-3">
                    <div class="h-11 w-11 shrink-0 overflow-hidden rounded-lg bg-[#CFE5E2]">
                        @if ($umkm->cover_image)
                            <img src="{{ asset('storage/' . $umkm->cover_image) }}" alt="" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full w-full items-center justify-center text-[#326AAB]">
                                <x-icon name="store" class="h-5 w-5" />
                            </div>
                        @endif
                    </div>

                    <div class="min-w-0 flex-1">
                        <a href="{{ route('admin.umkms.edit', $umkm) }}" class="block truncate text-sm font-medium text-gray-900 hover:text-[#326AAB]">
                            {{ $umkm->name }}
                        </a>
                        <p class="truncate text-xs text-gray-500">{{ $umkm->category?->name }} · {{ $umkm->products_count }} produk</p>
                    </div>

                    <x-admin.status-badge :status="$umkm->status" />
                </li>
            @empty
                <li class="py-6 text-center text-sm text-gray-500">
                    Belum ada UMKM.
                    <a href="{{ route('admin.umkms.create') }}" class="font-semibold text-[#326AAB] hover:underline">Tambah UMKM pertama</a>
                </li>
            @endforelse
        </ul>
    </section>

</div>

@endsection
