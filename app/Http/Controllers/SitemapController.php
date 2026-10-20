<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Product;
use App\Models\Umkm;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $staticUrls = [
            route('home'),
            route('product.index'),
            route('umkm.index'),
            route('peta.index'),
            route('posts.index'),
        ];

        $umkms = Umkm::query()
            ->where('status', 'published')
            ->get(['slug', 'updated_at']);

        $products = Product::query()
            ->published()
            ->get(['slug', 'updated_at']);

        $posts = Post::query()
            ->published()
            ->get(['slug', 'updated_at']);

        return response()
            ->view('sitemap', compact('staticUrls', 'umkms', 'products', 'posts'))
            ->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        $lines = [
            'User-agent: *',
            'Disallow: /admin',
            '',
            'Sitemap: '.route('sitemap'),
        ];

        return response(implode("\n", $lines)."\n")
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
