@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-900">
        Halo, {{ auth()->user()->name }} 👋
    </h2>

    <p class="mt-1 text-gray-500">
        Selamat datang di Admin TanjungKatalog.
        Berikut ringkasan data katalog saat ini.
    </p>
</div>

{{-- Ringkasan data --}}
<div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">

    {{-- Total UMKM --}}
    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
        <p class="text-sm font-medium text-gray-500">Total UMKM</p>
        <p class="mt-3 text-3xl font-bold text-gray-900">
            {{ $totalUmkms }}
        </p>
        <p class="mt-2 text-sm text-gray-500">Semua status</p>
    </div>

    {{-- UMKM Published --}}
    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
        <p class="text-sm font-medium text-gray-500">UMKM Terpublikasi</p>
        <p class="mt-3 text-3xl font-bold text-green-600">
            {{ $publishedUmkms }}
        </p>
        <p class="mt-2 text-sm text-gray-500">Tampil di katalog publik</p>
    </div>

    {{-- UMKM Draft --}}
    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
        <p class="text-sm font-medium text-gray-500">UMKM Draft</p>
        <p class="mt-3 text-3xl font-bold text-amber-600">
            {{ $draftUmkms }}
        </p>
        <p class="mt-2 text-sm text-gray-500">Belum dipublikasikan</p>
    </div>

    {{-- Kategori --}}
    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
        <p class="text-sm font-medium text-gray-500">Total Kategori</p>
        <p class="mt-3 text-3xl font-bold text-[#326AAB]">
            {{ $totalCategories }}
        </p>
        <p class="mt-2 text-sm text-gray-500">Kategori UMKM</p>
    </div>

    {{-- Total Produk --}}
    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
        <p class="text-sm font-medium text-gray-500">Total Produk</p>
        <p class="mt-3 text-3xl font-bold text-gray-900">
            {{ $totalProducts }}
        </p>
        <p class="mt-2 text-sm text-gray-500">Semua status</p>
    </div>

    {{-- Produk Published --}}
    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
        <p class="text-sm font-medium text-gray-500">Produk Terpublikasi</p>
        <p class="mt-3 text-3xl font-bold text-green-600">
            {{ $publishedProducts }}
        </p>
        <p class="mt-2 text-sm text-gray-500">Produk berstatus published</p>
    </div>

    {{-- Produk Draft --}}
    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
        <p class="text-sm font-medium text-gray-500">Produk Draft</p>
        <p class="mt-3 text-3xl font-bold text-amber-600">
            {{ $draftProducts }}
        </p>
        <p class="mt-2 text-sm text-gray-500">Produk belum dipublikasikan</p>
    </div>

</div>

{{-- Pintasan admin --}}
<div class="mt-10">
    <h3 class="mb-4 text-lg font-bold text-gray-900">
        Pengelolaan Katalog
    </h3>

    <div class="grid gap-4 sm:grid-cols-3">

        <a
            href="{{ route('admin.umkms.index') }}"
            class="rounded-2xl border border-gray-200 bg-white p-5 transition hover:border-[#326AAB] hover:shadow-sm"
        >
            <h4 class="font-semibold text-gray-900">Kelola UMKM</h4>
            <p class="mt-2 text-sm text-gray-500">
                Tambah, edit, dan atur publikasi UMKM.
            </p>
            <span class="mt-4 inline-block text-sm font-semibold text-[#326AAB]">
                Buka data UMKM →
            </span>
        </a>

        <a
            href="{{ route('admin.products.index') }}"
            class="rounded-2xl border border-gray-200 bg-white p-5 transition hover:border-[#326AAB] hover:shadow-sm"
        >
            <h4 class="font-semibold text-gray-900">Kelola Produk</h4>
            <p class="mt-2 text-sm text-gray-500">
                Atur produk, harga, foto, dan status.
            </p>
            <span class="mt-4 inline-block text-sm font-semibold text-[#326AAB]">
                Buka data produk →
            </span>
        </a>

        <a
            href="{{ route('admin.categories.index') }}"
            class="rounded-2xl border border-gray-200 bg-white p-5 transition hover:border-[#326AAB] hover:shadow-sm"
        >
            <h4 class="font-semibold text-gray-900">Kelola Kategori</h4>
            <p class="mt-2 text-sm text-gray-500">
                Atur kategori untuk mengelompokkan UMKM.
            </p>
            <span class="mt-4 inline-block text-sm font-semibold text-[#326AAB]">
                Buka kategori →
            </span>
        </a>

    </div>
</div>

@endsection
