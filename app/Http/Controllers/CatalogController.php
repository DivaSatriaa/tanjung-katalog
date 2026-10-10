<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('q', ''));
        $categorySlug = $request->input('category');

        $umkms = Umkm::query()
            ->where('status', 'published')
            ->with('category')
            ->withCount([
                'products' => fn ($query) => $query
                    ->where('status', 'published'),
            ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subquery) use ($search) {
                    $subquery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($categorySlug, function ($query) use ($categorySlug) {
                $query->whereHas('category', function ($categoryQuery) use ($categorySlug) {
                    $categoryQuery->where('slug', $categorySlug);
                });
            })
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::query()
            ->orderBy('name')
            ->get();

        return view('catalog.umkm.index', compact(
            'umkms',
            'categories',
            'search',
            'categorySlug',
        ));
    }

    public function show(Umkm $umkm): View
    {
        abort_unless($umkm->status === 'published', 404);

        $umkm->load('category');

        $umkm->load([
            'products' => fn ($query) => $query
                ->where('status', 'published')
                ->latest(),
        ]);

        return view('catalog.umkm.show', compact('umkm'));
    }
}
