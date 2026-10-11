<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use Illuminate\View\View;

class MapController extends Controller
{
    public function index(): View
    {
        $umkms = Umkm::query()
            ->where('status', 'published')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->with('category')
            ->withCount([
                'products' => fn ($query) => $query
                    ->where('status', 'published'),
            ])
            ->orderBy('name')
            ->get();

        $mapPoints = $umkms->map(fn (Umkm $umkm) => [
            'name' => $umkm->name,
            'slug' => $umkm->slug,
            'category' => $umkm->category?->name ?? 'UMKM',
            'address' => $umkm->address,
            'latitude' => (float) $umkm->latitude,
            'longitude' => (float) $umkm->longitude,
            'products_count' => $umkm->products_count,
            'url' => route('umkm.show', $umkm->slug),
        ])->values();

        return view('map.index', compact('mapPoints'));
    }
}
