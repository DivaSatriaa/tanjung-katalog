@extends('layouts.public')

@section('title', $post->title)

@section('meta_description', $post->summary())

@section('og_type', 'article')

@if ($post->cover_image)
    @section('meta_image', asset('storage/' . $post->cover_image))
@endif

@section('content')

<article class="mx-auto max-w-3xl px-5 py-8 sm:py-12">

    <nav class="flex flex-wrap items-center gap-2 text-sm text-gray-500" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="transition hover:text-[#326AAB]">Beranda</a>
        <span class="text-gray-300">/</span>
        <a href="{{ route('posts.index') }}" class="transition hover:text-[#326AAB]">Berita</a>
    </nav>

    <header class="mt-6">
        <time datetime="{{ $post->published_at->toDateString() }}" class="text-sm font-semibold uppercase tracking-wider text-[#6EA8C7]">
            {{ $post->published_at->translatedFormat('l, j F Y') }}
        </time>

        <h1 class="mt-3 text-3xl font-extrabold leading-tight tracking-tight text-[#174875] sm:text-4xl">
            {{ $post->title }}
        </h1>

        @if ($post->excerpt)
            <p class="mt-4 text-lg leading-8 text-gray-600">
                {{ $post->excerpt }}
            </p>
        @endif
    </header>

    @if ($post->cover_image)
        <figure class="mt-8 overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">
            <img
                src="{{ asset('storage/' . $post->cover_image) }}"
                alt="{{ $post->title }}"
                class="h-auto w-full object-cover"
            >
        </figure>
    @endif

    <div class="mt-8 space-y-5 text-base leading-8 text-gray-700">
        @foreach (preg_split('/\R{2,}/', trim($post->body)) as $paragraph)
            <p class="whitespace-pre-line break-words">{{ $paragraph }}</p>
        @endforeach
    </div>

    <div class="mt-10 flex flex-wrap items-center gap-3 border-t border-gray-200 pt-6">
        <a
            href="{{ route('posts.index') }}"
            class="inline-flex items-center gap-2 rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-600 transition hover:border-[#326AAB] hover:text-[#326AAB]"
        >
            <span aria-hidden="true">&larr;</span>
            Semua berita
        </a>

        <a
            href="https://wa.me/?text={{ rawurlencode($post->title . ' — ' . route('posts.show', $post->slug)) }}"
            target="_blank"
            rel="noopener noreferrer"
            class="inline-flex items-center gap-2 rounded-xl bg-[#16865A] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#116B47]"
        >
            Bagikan ke WhatsApp
        </a>
    </div>

</article>

@if ($otherPosts->isNotEmpty())
    <section class="mx-auto max-w-7xl px-5 pb-6 lg:px-8">
        <h2 class="text-2xl font-extrabold tracking-tight text-[#174875]">
            Berita lainnya
        </h2>

        <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($otherPosts as $otherPost)
                <x-post-card :post="$otherPost" />
            @endforeach
        </div>
    </section>
@endif

@endsection
