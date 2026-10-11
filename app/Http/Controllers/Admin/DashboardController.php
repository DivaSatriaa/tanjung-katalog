<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Umkm;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalUmkms = Umkm::count();
        $publishedUmkms = Umkm::where('status', 'published')->count();
        $draftUmkms = Umkm::where('status', 'draft')->count();

        $totalProducts = Product::count();
        $publishedProducts = Product::where('status', 'published')->count();
        $draftProducts = Product::where('status', 'draft')->count();

        $totalCategories = Category::count();

        return view('admin.dashboard', compact(
            'totalUmkms',
            'publishedUmkms',
            'draftUmkms',
            'totalProducts',
            'publishedProducts',
            'draftProducts',
            'totalCategories'
        ));
    }
}
