<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\Umkm;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()
            ->withCount([
                'umkms' => fn ($query) => $query
                    ->where('status', 'published'),
            ])
            ->ordered()
            ->get();

        $featuredUmkms = Umkm::query()
            ->where('status', 'published')
            ->with('category')
            ->withCount([
                'products' => fn ($query) => $query
                    ->where('status', 'published'),
            ])
            ->orderByDesc('is_featured')
            ->latest()
            ->take(3)
            ->get();

        $latestProducts = Product::query()
            ->where('status', 'published')
            ->whereHas('umkm', fn ($query) => $query
                ->where('status', 'published'))
            ->with('umkm.category')
            ->latest()
            ->take(4)
            ->get();

        $totalUmkms = Umkm::query()
            ->where('status', 'published')
            ->count();

        $totalProducts = Product::query()
            ->where('status', 'published')
            ->whereHas('umkm', fn ($query) => $query
                ->where('status', 'published'))
            ->count();

        $latestPosts = Post::query()
            ->published()
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('home', compact(
            'latestPosts',
            'categories',
            'featuredUmkms',
            'latestProducts',
            'totalUmkms',
            'totalProducts',
        ));
    }
}
