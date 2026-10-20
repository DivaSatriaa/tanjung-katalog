<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\Umkm;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'umkms' => [
                'total' => Umkm::count(),
                'published' => Umkm::where('status', 'published')->count(),
            ],
            'products' => [
                'total' => Product::count(),
                'published' => Product::where('status', 'published')->count(),
            ],
            'categories' => Category::count(),
            'posts' => [
                'total' => Post::count(),
                'published' => Post::query()->published()->count(),
            ],
        ];

        $checklist = [
            [
                'label' => 'UMKM tanpa lokasi peta',
                'description' => 'Tidak muncul di halaman Peta UMKM.',
                'count' => Umkm::query()
                    ->where(fn ($query) => $query->whereNull('latitude')->orWhereNull('longitude'))
                    ->count(),
                'url' => route('admin.umkms.index'),
            ],
            [
                'label' => 'UMKM tanpa foto sampul',
                'description' => 'Kartu UMKM menampilkan gambar pengganti.',
                'count' => Umkm::whereNull('cover_image')->count(),
                'url' => route('admin.umkms.index'),
            ],
            [
                'label' => 'UMKM tanpa nomor WhatsApp',
                'description' => 'Pengunjung tidak bisa menghubungi penjual.',
                'count' => Umkm::query()
                    ->where(fn ($query) => $query->whereNull('whatsapp')->orWhere('whatsapp', ''))
                    ->count(),
                'url' => route('admin.umkms.index'),
            ],
            [
                'label' => 'Produk tanpa foto',
                'description' => 'Produk dengan foto lebih menarik pengunjung.',
                'count' => Product::whereNull('image')->count(),
                'url' => route('admin.products.index'),
            ],
            [
                'label' => 'Produk masih draf',
                'description' => 'Belum tampil di katalog publik.',
                'count' => Product::where('status', 'draft')->count(),
                'url' => route('admin.products.index', ['status' => 'draft']),
            ],
        ];

        $latestProducts = Product::query()
            ->with('umkm')
            ->latest()
            ->take(5)
            ->get();

        $latestUmkms = Umkm::query()
            ->with('category')
            ->withCount('products')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'checklist', 'latestProducts', 'latestUmkms'));
    }
}
