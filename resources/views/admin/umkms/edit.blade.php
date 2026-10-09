
@extends('admin.layouts.app')

@section('title', 'Edit UMKM')

@section('content')
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Edit UMKM</h2>
        <p class="mt-1 text-gray-500">
            Perbarui informasi {{ $umkm->name }}.
        </p>
    </div>

    <div class="max-w-4xl">
        @include('admin.umkms._form')
    </div>
@endsection
