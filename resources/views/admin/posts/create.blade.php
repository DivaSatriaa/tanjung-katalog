@extends('admin.layouts.app')

@section('title', 'Tulis Berita')

@section('content')
    <div class="mb-8">
        <a href="{{ route('admin.posts.index') }}" class="text-sm font-medium text-gray-500 hover:text-[#326AAB]">&larr; Kembali ke daftar berita</a>
        <h2 class="mt-3 text-2xl font-bold text-gray-900">Tulis Berita</h2>
        <p class="mt-1 text-gray-500">Bagikan kabar atau kegiatan UMKM Tanjung Mas.</p>
    </div>

    <div class="max-w-4xl">
        @include('admin.posts._form')
    </div>
@endsection
