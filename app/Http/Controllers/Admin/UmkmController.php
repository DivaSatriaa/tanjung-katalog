<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Umkm;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UmkmController extends Controller
{
    /**
     * Display a listing of UMKM.
     */
    public function index(): View
    {
        $umkms = Umkm::with('category')
            ->withCount('products')
            ->latest()
            ->get();

        return view('admin.umkms.index', compact('umkms'));
    }

    /**
     * Show the form for creating a new UMKM.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.umkms.create', compact('categories'));
    }

    /**
     * Store a newly created UMKM.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:150'],
            'owner_name' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:30'],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'instagram' => ['nullable', 'string', 'max:100'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'cover_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],
            'is_featured' => ['nullable', 'boolean'],
            'status' => ['required', 'in:draft,published'],
        ]);

        $imagePath = null;

        if ($request->hasFile('cover_image')) {
            $imagePath = $request->file('cover_image')->store('umkm', 'public');
        }

        Umkm::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'owner_name' => $validated['owner_name'] ?? null,
            'description' => $validated['description'] ?? null,
            'address' => $validated['address'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'whatsapp' => $validated['whatsapp'] ?? null,
            'instagram' => $validated['instagram'] ?? null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'cover_image' => $imagePath,
            'is_featured' => $request->boolean('is_featured'),
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.umkms.index')
            ->with('success', 'UMKM berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified UMKM.
     */
    public function edit(Umkm $umkm): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.umkms.edit', compact('umkm', 'categories'));
    }

    /**
     * Update the specified UMKM.
     */
    public function update(Request $request, Umkm $umkm): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:150'],
            'owner_name' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:30'],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'instagram' => ['nullable', 'string', 'max:100'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'cover_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],
            'is_featured' => ['nullable', 'boolean'],
            'status' => ['required', 'in:draft,published'],
        ]);

        $imagePath = $umkm->cover_image;

        if ($request->hasFile('cover_image')) {
            if ($umkm->cover_image) {
                Storage::disk('public')->delete($umkm->cover_image);
            }

            $imagePath = $request->file('cover_image')->store('umkm', 'public');
        }

        $umkm->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'owner_name' => $validated['owner_name'] ?? null,
            'description' => $validated['description'] ?? null,
            'address' => $validated['address'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'whatsapp' => $validated['whatsapp'] ?? null,
            'instagram' => $validated['instagram'] ?? null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'cover_image' => $imagePath,
            'is_featured' => $request->boolean('is_featured'),
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.umkms.index')
            ->with('success', 'UMKM berhasil diperbarui.');
    }

    /**
     * Remove the specified UMKM.
     */
    public function destroy(Umkm $umkm): RedirectResponse
    {
        if ($umkm->cover_image) {
            Storage::disk('public')->delete($umkm->cover_image);
        }

        $umkm->delete();

        return redirect()
            ->route('admin.umkms.index')
            ->with('success', 'UMKM berhasil dihapus.');
    }
}
