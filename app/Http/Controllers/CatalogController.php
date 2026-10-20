<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($this->stringInput($request, 'q'));
        $categorySlug = $this->stringInput($request, 'category');

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
            ->when($categorySlug !== '', function ($query) use ($categorySlug) {
                $query->whereHas('category', function ($categoryQuery) use ($categorySlug) {
                    $categoryQuery->where('slug', $categorySlug);
                });
            })
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::query()
            ->ordered()
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

    public function products(Request $request): View
    {
        $search = trim($this->stringInput($request, 'q'));
        $categorySlug = $this->stringInput($request, 'category');
        $sortOptions = [
            'terbaru' => 'Terbaru',
            'termurah' => 'Harga terendah',
            'termahal' => 'Harga tertinggi',
            'nama' => 'Nama A-Z',
        ];
        $sort = $this->stringInput($request, 'sort');

        if (! array_key_exists($sort, $sortOptions)) {
            $sort = 'terbaru';
        }

        $products = Product::query()
            ->published()
            ->with('umkm.category')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subquery) use ($search) {
                    $subquery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhereHas('umkm', fn ($umkmQuery) => $umkmQuery
                            ->where('name', 'like', "%{$search}%"));
                });
            })
            ->when($categorySlug !== '', function ($query) use ($categorySlug) {
                $query->whereHas('umkm.category', fn ($categoryQuery) => $categoryQuery
                    ->where('slug', $categorySlug));
            })
            ->when($sort === 'termurah', fn ($query) => $query
                ->orderByRaw('price IS NULL')
                ->orderBy('price'))
            ->when($sort === 'termahal', fn ($query) => $query
                ->orderByRaw('price IS NULL')
                ->orderByDesc('price'))
            ->when($sort === 'nama', fn ($query) => $query->orderBy('name'))
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::query()
            ->withCount([
                'products' => fn ($query) => $query
                    ->where('products.status', 'published')
                    ->where('umkms.status', 'published'),
            ])
            ->ordered()
            ->get();

        $totalProducts = $categories->sum('products_count');
        $activeCategory = $categories->firstWhere('slug', $categorySlug);

        return view('catalog.products.index', compact(
            'products',
            'categories',
            'activeCategory',
            'totalProducts',
            'search',
            'categorySlug',
            'sort',
            'sortOptions',
        ));
    }

    private function stringInput(Request $request, string $key): string
    {
        $value = $request->input($key);

        return is_string($value) ? $value : '';
    }

    public function showProduct(Product $product): View
    {
        $product->load(['umkm.category', 'images']);

        abort_unless(
            $product->status === 'published'
                && $product->umkm?->status === 'published',
            404
        );

        return view('catalog.products.show', compact('product'));
    }
}
