@extends('layouts.public')

@section('title', 'Berita')

@section('meta_description', 'Kabar, kegiatan, dan informasi terbaru seputar UMKM Kelurahan Tanjung Mas, Semarang.')

@section('content')

<section class="border-b border-[#CFE5E2] bg-gradient-to-br from-white via-[#F5F2EB] to-[#CFE5E2]/70">
    <div class="mx-auto max-w-7xl px-5 py-12 sm:py-16 lg:px-8">

        <nav class="flex flex-wrap items-center gap-2 text-sm text-gray-500" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="transition hover:text-[#326AAB]">Beranda</a>
            <span class="text-gray-300">/</span>
            <span class="font-semibold text-[#326AAB]">Berita</span>
        </nav>

        <h1 class="mt-6 text-3xl font-extrabold tracking-tight text-[#174875] sm:text-4xl lg:text-5xl">
            Berita &amp; Kegiatan
        </h1>

        <p class="mt-4 max-w-2xl text-sm leading-7 text-gray-600 sm:text-base">
            Kabar terbaru, pelatihan, dan kegiatan pelaku UMKM di Kelurahan Tanjung Mas.
        </p>

    </div>
</section>

<section class="mx-auto max-w-7xl px-5 py-10 sm:py-12 lg:px-8">

    @if ($posts->isEmpty())
        <div class="rounded-2xl border border-dashed border-[#CFE5E2] bg-white p-10 text-center">
            <h2 class="text-lg font-bold text-[#174875]">Belum ada berita</h2>
            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                Berita dan kegiatan UMKM Tanjung Mas akan ditampilkan di sini.
            </p>
            <a href="{{ route('product.index') }}" class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-[#326AAB] hover:underline">
                Jelajahi katalog produk
                <span aria-hidden="true">&rarr;</span>
            </a>
        </div>
    @else
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($posts as $post)
                <x-post-card :post="$post" />
            @endforeach
        </div>

        @if ($posts->hasPages())
            <div class="mt-10">
                {{ $posts->links() }}
            </div>
        @endif
    @endif

</section>

@endsection
