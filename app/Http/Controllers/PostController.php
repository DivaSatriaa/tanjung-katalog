<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::query()
            ->published()
            ->latest('published_at')
            ->latest('id')
            ->paginate(9);

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post): View
    {
        abort_unless($post->isPublished(), 404);

        $otherPosts = Post::query()
            ->published()
            ->whereKeyNot($post->getKey())
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('posts.show', compact('post', 'otherPosts'));
    }
}
