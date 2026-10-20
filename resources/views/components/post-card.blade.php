@props(['post'])

<article class="group flex h-full flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-[#CFE5E2] hover:shadow-lg">

    <a href="{{ route('posts.show', $post->slug) }}" class="block overflow-hidden" aria-label="Baca berita {{ $post->title }}">
        <div class="aspect-[16/10] overflow-hidden bg-gradient-to-br from-[#EAF4F7] to-[#CFE5E2]">
            @if ($post->cover_image)
                <img
                    src="{{ asset('storage/' . $post->cover_image) }}"
                    alt="{{ $post->title }}"
                    loading="lazy"
                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                >
            @else
                <div class="flex h-full w-full items-center justify-center text-[#326AAB]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 5a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v14a1 1 0 0 0 1 1H6a2 2 0 0 1-2-2V5Z"/>
                        <path d="M17 8h2a1 1 0 0 1 1 1v9a2 2 0 0 1-2 2"/>
                        <path d="M8 8h5M8 12h5M8 16h3"/>
                    </svg>
                </div>
            @endif
        </div>
    </a>

    <div class="flex flex-1 flex-col p-5">
        <time datetime="{{ $post->published_at?->toDateString() }}" class="text-xs font-semibold uppercase tracking-wider text-[#6EA8C7]">
            {{ $post->published_at?->translatedFormat('j F Y') }}
        </time>

        <h3 class="mt-2 line-clamp-2 text-lg font-bold leading-snug text-[#174875] transition group-hover:text-[#326AAB]">
            <a href="{{ route('posts.show', $post->slug) }}">
                {{ $post->title }}
            </a>
        </h3>

        <p class="mt-2 line-clamp-3 text-sm leading-6 text-gray-500">
            {{ $post->summary() }}
        </p>

        <a
            href="{{ route('posts.show', $post->slug) }}"
            class="mt-auto inline-flex items-center gap-2 pt-5 text-sm font-semibold text-[#326AAB] transition hover:gap-3"
        >
            Baca selengkapnya
            <span aria-hidden="true">&rarr;</span>
        </a>
    </div>

</article>
