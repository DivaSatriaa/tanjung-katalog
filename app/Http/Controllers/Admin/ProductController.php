<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Umkm;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    private const MAX_GALLERY_IMAGES = 8;

    /**
     * Display all products.
     */
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:150'],
            'umkm_id' => ['nullable', 'integer', 'exists:umkms,id'],
            'status' => ['nullable', 'in:draft,published'],
        ]);

        $search = trim($validated['q'] ?? '');
        $umkmId = $validated['umkm_id'] ?? '';
        $status = $validated['status'] ?? '';

        $query = Product::with('umkm')
            ->when($search !== '', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->when($umkmId !== '', function ($query) use ($umkmId) {
                $query->where('umkm_id', $umkmId);
            })
            ->when($status !== '', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest();

        $products = $query->paginate(10)->withQueryString();
        $umkms = Umkm::orderBy('name')->get();

        return view('admin.products.index', compact(
            'products',
            'umkms',
            'search',
            'umkmId',
            'status'
        ));
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
            'gallery' => ['nullable', 'array', 'max:'.self::MAX_GALLERY_IMAGES],
            'gallery.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'remove_gallery' => ['nullable', 'array'],
            'remove_gallery.*' => ['integer'],
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('products', 'public');
        }

        $product = Product::create([
            'umkm_id' => $validated['umkm_id'],
            'name' => $validated['name'],
            'slug' => Product::uniqueSlugFor($validated['name'], null, 'produk'),
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'] ?? null,
            'image' => $imagePath,
            'is_featured' => $request->boolean('is_featured'),
            'status' => $validated['status'],
        ]);

        $this->storeGalleryImages($request, $product);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Show the edit form.
     */
    public function edit(Product $product): View
    {
        $product->load('images');

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
            'gallery' => ['nullable', 'array', 'max:'.self::MAX_GALLERY_IMAGES],
            'gallery.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'remove_gallery' => ['nullable', 'array'],
            'remove_gallery.*' => ['integer'],
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
            $slug = Product::uniqueSlugFor($validated['name'], $product, 'produk');
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

        $this->removeGalleryImages($product, $validated['remove_gallery'] ?? []);

        if (! $this->storeGalleryImages($request, $product)) {
            return redirect()
                ->route('admin.products.edit', $product)
                ->with('error', 'Sebagian foto galeri tidak disimpan karena galeri maksimal berisi '.self::MAX_GALLERY_IMAGES.' foto.');
        }

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

        Storage::disk('public')->delete($product->images()->pluck('path')->all());

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Simpan foto galeri baru tanpa melebihi batas jumlah foto.
     *
     * @return bool false bila ada foto yang tidak disimpan karena batas tercapai
     */
    private function storeGalleryImages(Request $request, Product $product): bool
    {
        $files = $request->file('gallery', []);

        if ($files === []) {
            return true;
        }

        $existingCount = $product->images()->count();
        $nextOrder = (int) $product->images()->max('sort_order') + 1;
        $availableSlots = max(0, self::MAX_GALLERY_IMAGES - $existingCount);

        foreach (array_slice($files, 0, $availableSlots) as $file) {
            $product->images()->create([
                'path' => $file->store('products/gallery', 'public'),
                'sort_order' => $nextOrder++,
            ]);
        }

        return count($files) <= $availableSlots;
    }

    /**
     * Hapus foto galeri yang dipilih, hanya milik produk ini.
     *
     * @param  array<int, int|string>  $imageIds
     */
    private function removeGalleryImages(Product $product, array $imageIds): void
    {
        if ($imageIds === []) {
            return;
        }

        $images = $product->images()->whereKey($imageIds)->get();

        Storage::disk('public')->delete($images->pluck('path')->all());

        $product->images()->whereKey($images->modelKeys())->delete();
    }
}
