<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of posts.
     */
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:150'],
            'status' => ['nullable', 'in:draft,published'],
        ]);

        $search = trim($validated['q'] ?? '');
        $status = $validated['status'] ?? '';

        $posts = Post::query()
            ->when($search !== '', fn ($query) => $query->where('title', 'like', "%{$search}%"))
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.posts.index', compact('posts', 'search', 'status'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create(): View
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created post.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePost($request);

        Post::create([
            'title' => $validated['title'],
            'slug' => Post::uniqueSlugFor($validated['title'], null, 'berita'),
            'excerpt' => $validated['excerpt'] ?? null,
            'body' => $validated['body'],
            'cover_image' => $request->hasFile('cover_image')
                ? $request->file('cover_image')->store('posts', 'public')
                : null,
            'status' => $validated['status'],
            'published_at' => $this->resolvePublishedAt($validated),
        ]);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post): View
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified post.
     */
    public function update(Request $request, Post $post): RedirectResponse
    {
        $validated = $this->validatePost($request);

        $coverImage = $post->cover_image;

        if ($request->boolean('remove_cover_image') && $coverImage) {
            Storage::disk('public')->delete($coverImage);
            $coverImage = null;
        }

        if ($request->hasFile('cover_image')) {
            if ($coverImage) {
                Storage::disk('public')->delete($coverImage);
            }

            $coverImage = $request->file('cover_image')->store('posts', 'public');
        }

        $post->update([
            'title' => $validated['title'],
            'slug' => $validated['title'] === $post->title
                ? $post->slug
                : Post::uniqueSlugFor($validated['title'], $post, 'berita'),
            'excerpt' => $validated['excerpt'] ?? null,
            'body' => $validated['body'],
            'cover_image' => $coverImage,
            'status' => $validated['status'],
            'published_at' => $this->resolvePublishedAt($validated, $post),
        ]);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified post.
     */
    public function destroy(Post $post): RedirectResponse
    {
        if ($post->cover_image) {
            Storage::disk('public')->delete($post->cover_image);
        }

        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatePost(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'excerpt' => ['nullable', 'string', 'max:300'],
            'body' => ['required', 'string'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'status' => ['required', 'in:draft,published'],
            'published_at' => ['nullable', 'date'],
        ]);
    }

    /**
     * Tentukan tanggal terbit: berita terbit tanpa tanggal memakai waktu sekarang.
     *
     * @param  array<string, mixed>  $validated
     */
    private function resolvePublishedAt(array $validated, ?Post $post = null): ?Carbon
    {
        if (! empty($validated['published_at'])) {
            return Carbon::parse($validated['published_at']);
        }

        if ($validated['status'] !== 'published') {
            return null;
        }

        return $post?->published_at ?? now();
    }
}
