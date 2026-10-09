
@extends('admin.layouts.app')

@section('title', 'Tambah Produk')

@section('content')
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Tambah Produk</h2>

        <p class="mt-1 text-gray-500">
            Tambahkan produk ke katalog UMKM TanjungKatalog.
        </p>
    </div>

    <div class="max-w-4xl">
        @include('admin.products._form')
    </div>
@endsection
