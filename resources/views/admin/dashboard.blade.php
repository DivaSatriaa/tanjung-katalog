@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="mb-8">
    <h2 class="text-2xl font-bold">
        Halo, {{ auth()->user()->name }} 👋
    </h2>

    <p class="text-gray-500 mt-1">
        Selamat datang di Admin TanjungKatalog.
    </p>
</div>

<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

        <p class="text-sm text-gray-500">
            Total UMKM
        </p>

        <p class="text-3xl font-bold mt-2">
            0
        </p>

    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

        <p class="text-sm text-gray-500">
            Total Produk
        </p>

        <p class="text-3xl font-bold mt-2">
            0
        </p>

    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

        <p class="text-sm text-gray-500">
            Kategori
        </p>

        <p class="text-3xl font-bold mt-2">
            {{ \App\Models\Category::count() }}
        </p>

    </div>

</div>

@endsection
