@extends('admin.layouts.app')

@section('title', 'Berita')

@section('content')

<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Berita</h2>
        <p class="mt-1 text-gray-500">
            Kabar dan kegiatan UMKM yang tampil di halaman Berita.
        </p>
    </div>

    <a
        href="{{ route('admin.posts.create') }}"
        class="inline-flex items-center justify-center rounded-xl bg-[#326AAB] px-5 py-3 text-sm font-medium text-white transition hover:bg-[#28598f]"
    >
        + Tulis Berita
    </a>
</div>

<form
    method="GET"
    action="{{ route('admin.posts.index') }}"
    class="mb-6 rounded-2xl border border-gray-100 bg-white p-5 shadow-sm"
>
    <div class="grid gap-4 md:grid-cols-[minmax(0,1fr)_220px]">
        <div>
            <label for="q" class="mb-2 block text-sm font-medium text-gray-700">Cari Berita</label>
            <input id="q" name="q" type="search" value="{{ $search }}" placeholder="Judul berita..." class="px-4 py-3">
        </div>

        <div>
            <label for="status" class="mb-2 block text-sm font-medium text-gray-700">Status</label>
            <select id="status" name="status" class="px-4 py-3">
                <option value="">Semua status</option>
                <option value="published" @selected($status === 'published')>Terbit</option>
                <option value="draft" @selected($status === 'draft')>Draf</option>
            </select>
        </div>
    </div>

    <div class="mt-5 flex flex-wrap gap-3">
        <button type="submit" class="rounded-xl bg-[#326AAB] px-5 py-3 text-sm font-medium text-white transition hover:bg-[#28598f]">
            Cari &amp; Filter
        </button>
        <a href="{{ route('admin.posts.index') }}" class="rounded-xl border border-gray-300 px-5 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
            Reset
        </a>
    </div>
</form>

<div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="border-b border-gray-100 bg-gray-50">
                <tr>
                    <th class="px-4 py-4 text-left text-xs font-semibold uppercase text-gray-500 md:px-6">Berita</th>
                    <th class="hidden px-4 py-4 text-left text-xs font-semibold uppercase text-gray-500 md:table-cell md:px-6">Tanggal Terbit</th>
                    <th class="hidden px-4 py-4 text-left text-xs font-semibold uppercase text-gray-500 md:table-cell md:px-6">Status</th>
                    <th class="px-4 py-4 text-right text-xs font-semibold uppercase text-gray-500 md:px-6">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse ($posts as $post)
                    <tr class="transition hover:bg-gray-50">
                        <td class="px-4 py-4 md:px-6">
                            <div class="flex items-center gap-4">
                                <div class="h-12 w-16 shrink-0 overflow-hidden rounded-xl bg-[#CFE5E2] md:h-14 md:w-20">
                                    @if ($post->cover_image)
                                        <img src="{{ asset('storage/' . $post->cover_image) }}" alt="" class="h-full w-full object-cover">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center text-[#326AAB]">
                                            <x-icon name="news" class="h-6 w-6" />
                                        </div>
                                    @endif
                                </div>

                                <div class="min-w-0">
                                    <p class="line-clamp-2 font-medium text-gray-900">{{ $post->title }}</p>
                                    <p class="mt-1 text-xs text-gray-500 md:hidden">
                                        {{ $post->published_at?->translatedFormat('j M Y') ?? 'Belum dijadwalkan' }}
                                    </p>
                                    <x-admin.status-badge :status="$post->status" class="mt-2 md:hidden" />
                                </div>
                            </div>
                        </td>

                        <td class="hidden px-4 py-4 text-sm text-gray-600 md:table-cell md:px-6">
                            @if ($post->published_at)
                                {{ $post->published_at->translatedFormat('j M Y, H:i') }}
                                @if ($post->status === 'published' && $post->published_at->isFuture())
                                    <span class="mt-1 block text-xs text-amber-600">Terjadwal</span>
                                @endif
                            @else
                                <span class="text-gray-400">&mdash;</span>
                            @endif
                        </td>

                        <td class="hidden px-4 py-4 md:table-cell md:px-6">
                            <x-admin.status-badge :status="$post->status" />
                        </td>

                        <td class="px-4 py-4 md:px-6">
                            <div class="flex items-center justify-end gap-2">
                                @if ($post->isPublished())
                                    <a href="{{ route('posts.show', $post->slug) }}" target="_blank" rel="noopener" class="hidden rounded-lg px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 sm:inline-flex">
                                        Lihat
                                    </a>
                                @endif

                                <a href="{{ route('admin.posts.edit', $post) }}" class="rounded-lg px-3 py-2 text-sm font-medium text-[#326AAB] hover:bg-blue-50">
                                    Edit
                                </a>

                                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Hapus berita ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center">
                            <x-icon name="news" class="mx-auto h-10 w-10 text-gray-300" />
                            <p class="mt-3 font-medium text-gray-700">
                                {{ $search !== '' || $status !== '' ? 'Berita tidak ditemukan.' : 'Belum ada berita.' }}
                            </p>
                            <a href="{{ route('admin.posts.create') }}" class="mt-2 inline-block text-sm font-semibold text-[#326AAB] hover:underline">
                                Tulis berita pertama
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if ($posts->hasPages())
    <div class="mt-6">
        {{ $posts->links() }}
    </div>
@endif

@endsection
