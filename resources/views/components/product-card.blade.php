@props(['product'])

<article class="group flex h-full flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-[#CFE5E2] hover:shadow-lg">

    {{-- Product Image --}}
    <a
        href="{{ route('product.show', $product->slug) }}"
        class="relative block overflow-hidden"
        aria-label="Lihat Produk {{ $product->name }}"
    >
        <div class="aspect-square overflow-hidden bg-gradient-to-br from-[#EAF4F7] to-[#CFE5E2]">

            @if ($product->image)
                <img
                    src="{{ asset('storage/' . $product->image) }}"
                    alt="{{ $product->name }}"
                    loading="lazy"
                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                >
            @else
                <div class="flex h-full w-full flex-col items-center justify-center text-[#326AAB]">
                    <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/70 shadow-sm transition duration-500 group-hover:scale-110 group-hover:rotate-3 [&_svg]:h-7 [&_svg]:w-7">
                        <x-category-icon :category="$product->umkm->category" />
                    </span>

                    <span class="mt-2 px-2 text-center text-xs font-semibold">
                        {{ $product->umkm->category->name }}
                    </span>
                </div>
            @endif

        </div>

        {{-- Featured Badge --}}
        @if ($product->is_featured)
            <span class="absolute left-3 top-3 rounded-full bg-white/95 px-3 py-1.5 text-xs font-semibold text-[#326AAB] shadow-sm">
                ★ Pilihan
            </span>
        @endif
    </a>

    {{-- Product Information --}}
    <div class="flex flex-1 flex-col p-4 sm:p-5">

        <p class="line-clamp-1 text-xs font-medium text-gray-500">
            {{ $product->umkm->name }}
        </p>

        <h3 class="mt-2 line-clamp-2 text-sm font-bold leading-5 text-[#174875] transition group-hover:text-[#326AAB] sm:text-base sm:leading-6">
            <a href="{{ route('product.show', $product->slug) }}">
                {{ $product->name }}
            </a>
        </h3>

        @if ($product->description)
            <p class="mt-2 line-clamp-2 text-xs leading-5 text-gray-500 sm:text-sm">
                {{ $product->description }}
            </p>
        @endif

        <div class="mt-auto pt-5">

            <div class="border-t border-gray-100 pt-4">
                <p class="text-xs text-gray-400">
                    Harga
                </p>

                <p class="mt-1 text-base font-extrabold text-[#326AAB] sm:text-lg">
                    @if ($product->price !== null)
                        Rp{{ number_format((float) $product->price, 0, ',', '.') }}
                    @else
                        <span class="text-sm font-semibold">
                            Hubungi penjual
                        </span>
                    @endif
                </p>
            </div>

            <a
                href="{{ route('product.show', $product->slug) }}"
                class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-xl border border-[#326AAB]/25 px-3 py-2.5 text-xs font-semibold text-[#326AAB] transition hover:border-[#326AAB] hover:bg-[#326AAB] hover:text-white sm:text-sm"
            >
                Lihat Produk
                <span class="arrow-nudge" aria-hidden="true">→</span>
            </a>

        </div>

    </div>

</article>
