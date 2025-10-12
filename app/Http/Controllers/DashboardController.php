<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\PenerimaanBarang;
use App\Models\PengeluaranBarang;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Products::count();
        $lowStock = Products::where('stok', '<=', 'stok_minimal')->count();

        $recentPenerimaan = PenerimaanBarang::with('items.product')->orderBy('created_at', 'desc')->limit(5)->get();
        $recentPengeluaran = PengeluaranBarang::with('items.product')->orderBy('created_at', 'desc')->limit(5)->get();

        return view('dashboard.index', compact('totalProducts', 'lowStock', 'recentPenerimaan', 'recentPengeluaran'));
    }
}
