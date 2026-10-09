
@extends('admin.layouts.app')

@section('title', 'Tambah UMKM')

@section('content')
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Tambah UMKM</h2>
        <p class="mt-1 text-gray-500">
            Tambahkan data usaha ke katalog TanjungKatalog.
        </p>
    </div>

    <div class="max-w-4xl">
        @include('admin.umkms._form')
    </div>
@endsection
