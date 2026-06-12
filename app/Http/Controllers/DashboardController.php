<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | TOTAL DATA
        |--------------------------------------------------------------------------
        */

        $totalProducts = Product::count();

        $totalCategories = Category::count();

        $totalSuppliers = Supplier::count();

        $totalStock = Product::sum('stock');

        /*
        |--------------------------------------------------------------------------
        | TODAY
        |--------------------------------------------------------------------------
        */

        $todayStockIn = StockIn::whereDate('date', today())->sum('qty');

        $todayStockOut = StockOut::whereDate('date', today())->sum('qty');

        /*
        |--------------------------------------------------------------------------
        | LOW STOCK
        |--------------------------------------------------------------------------
        */

        $lowStocks = Product::whereColumn('stock', '<=', 'min_stock')
                        ->latest()
                        ->get();

        /*
        |--------------------------------------------------------------------------
        | RECENT ACTIVITY
        |--------------------------------------------------------------------------
        */

        $recentStockIns = StockIn::with('product')
                            ->latest()
                            ->take(5)
                            ->get();

        $recentStockOuts = StockOut::with('product')
                            ->latest()
                            ->take(5)
                            ->get();

        /*
        |--------------------------------------------------------------------------
        | BEST SELLER — produk dengan total stock out terbanyak bulan ini
        |--------------------------------------------------------------------------
        */

        $bestSeller = StockOut::with('product')
            ->selectRaw('product_id, SUM(qty) as total_out')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->groupBy('product_id')
            ->orderByDesc('total_out')
            ->first();

        $bestSellerName  = $bestSeller?->product?->name ?? 'Belum ada data';
        $bestSellerTotal = $bestSeller?->total_out ?? 0;

        $totalStockOutMonth = StockOut::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('qty');

        $bestSellerPct = $totalStockOutMonth > 0
            ? round(($bestSellerTotal / $totalStockOutMonth) * 100)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | STOCK IN BULAN INI — pengganti Monthly Revenue
        |--------------------------------------------------------------------------
        */

        $monthlyStockIn = StockIn::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('qty');

        $avgStockIn = StockIn::selectRaw('SUM(qty) as total')
            ->where('date', '>=', now()->subMonths(3))
            ->value('total') ?: 1;

        $monthlyStockInPct = min(round(($monthlyStockIn / $avgStockIn) * 100), 100);

        /*
        |--------------------------------------------------------------------------
        | PERFORMANCE — berdasarkan kondisi stok
        |--------------------------------------------------------------------------
        */

        $lowStockCount     = Product::whereColumn('stock', '<=', 'min_stock')->count();
        $totalProductCount = Product::count() ?: 1;
        $healthPct         = max(0, round((1 - $lowStockCount / $totalProductCount) * 100));

        $performanceLabel = match(true) {
            $healthPct >= 90 => 'Excellent',
            $healthPct >= 70 => 'Good',
            $healthPct >= 50 => 'Fair',
            default          => 'Critical',
        };

        /*
        |--------------------------------------------------------------------------
        | CHART DATA — Stock In vs Stock Out per bulan (tahun ini)
        |--------------------------------------------------------------------------
        */

        $months = collect(range(1, 12))->map(fn($m) => str_pad($m, 2, '0', STR_PAD_LEFT));

        $stockInPerMonth = StockIn::selectRaw('MONTH(date) as month, SUM(qty) as total')
            ->whereYear('date', now()->year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $stockOutPerMonth = StockOut::selectRaw('MONTH(date) as month, SUM(qty) as total')
            ->whereYear('date', now()->year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $chartLabels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

        $chartStockIn  = range(1, 12) ? collect(range(1, 12))->map(fn($m) => (int) ($stockInPerMonth[$m] ?? 0))->values()->toArray() : [];
        $chartStockOut = collect(range(1, 12))->map(fn($m) => (int) ($stockOutPerMonth[$m] ?? 0))->values()->toArray();

        /*
        |--------------------------------------------------------------------------
        | ROLE-BASED VIEW
        |--------------------------------------------------------------------------
        */
        $role = auth()->user()->roles->first()?->name ?? 'staff';

        return view('dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalSuppliers',
            'totalStock',
            'todayStockIn',
            'todayStockOut',
            'lowStocks',
            'recentStockIns',
            'recentStockOuts',
            'chartLabels',
            'chartStockIn',
            'chartStockOut',
            'bestSellerName',
            'bestSellerPct',
            'monthlyStockIn',
            'monthlyStockInPct',
            'healthPct',
            'performanceLabel',
            'role',
        ));
    }
}