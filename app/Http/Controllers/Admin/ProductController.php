<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Umkm;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display all products.
     */
    public function index(): View
    {
        $products = Product::with('umkm')
            ->latest()
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the create form.
     */
    public function create(): View
    {
        $umkms = Umkm::orderBy('name')->get();

        return view('admin.products.create', compact('umkms'));
    }

    /**
     * Store a new product.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'umkm_id' => ['required', 'exists:umkms,id'],
            'name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],
            'is_featured' => ['nullable', 'boolean'],
            'status' => ['required', 'in:draft,published'],
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('products', 'public');
        }

        Product::create([
            'umkm_id' => $validated['umkm_id'],
            'name' => $validated['name'],
            'slug' => $this->makeUniqueSlug($validated['name']),
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'] ?? null,
            'image' => $imagePath,
            'is_featured' => $request->boolean('is_featured'),
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Show the edit form.
     */
    public function edit(Product $product): View
    {
        $umkms = Umkm::orderBy('name')->get();

        return view(
            'admin.products.edit',
            compact('product', 'umkms')
        );
    }

    /**
     * Update an existing product.
     */
    public function update(
        Request $request,
        Product $product
    ): RedirectResponse {
        $validated = $request->validate([
            'umkm_id' => ['required', 'exists:umkms,id'],
            'name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],
            'is_featured' => ['nullable', 'boolean'],
            'status' => ['required', 'in:draft,published'],
        ]);

        $imagePath = $product->image;

        if ($request->hasFile('image')) {
            $newImagePath = $request->file('image')
                ->store('products', 'public');

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $imagePath = $newImagePath;
        }

        $slug = $product->slug;

        if ($validated['name'] !== $product->name) {
            $slug = $this->makeUniqueSlug(
                $validated['name'],
                $product
            );
        }

        $product->update([
            'umkm_id' => $validated['umkm_id'],
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'] ?? null,
            'image' => $imagePath,
            'is_featured' => $request->boolean('is_featured'),
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Delete a product.
     */
    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Generate a unique slug.
     */
    private function makeUniqueSlug(
        string $name,
        ?Product $except = null
    ): string {
        $base = Str::slug($name) ?: 'produk';
        $slug = $base;
        $suffix = 2;

        while (
            Product::query()
                ->where('slug', $slug)
                ->when(
                    $except,
                    fn ($query) => $query->where(
                        'id',
                        '!=',
                        $except->id
                    )
                )
                ->exists()
        ) {
            $slug = $base . '-' . $suffix;
            $suffix++;
        }

        return $slug;
    }
}
