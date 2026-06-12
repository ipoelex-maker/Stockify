<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockOpname;
use App\Models\StockOpnameItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockOpnameController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Daftar semua sesi opname
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $opnames = StockOpname::with('creator')
            ->latest()
            ->get();

        return view('stock-opnames.index', compact('opnames'));
    }

    /*
    |--------------------------------------------------------------------------
    | Form opname baru — load semua produk + stok sistem saat ini
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $products = Product::with('category')->orderBy('name')->get();

        return view('stock-opnames.create', compact('products'));
    }

    /*
    |--------------------------------------------------------------------------
    | Simpan hasil opname
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'date'                    => 'required|date',
            'notes'                   => 'nullable|string',
            'apply_adjustment'        => 'nullable|boolean',
            'physical_stock'          => 'required|array',
            'physical_stock.*'        => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($request) {

            $opname = StockOpname::create([
                'date'       => $request->date,
                'notes'      => $request->notes,
                'status'     => 'completed',
                'created_by' => auth()->id(),
            ]);

            foreach ($request->physical_stock as $productId => $physicalStock) {
                $product     = Product::find($productId);
                $systemStock = $product->stock;
                $difference  = $physicalStock - $systemStock;

                StockOpnameItem::create([
                    'stock_opname_id' => $opname->id,
                    'product_id'      => $productId,
                    'system_stock'    => $systemStock,
                    'physical_stock'  => $physicalStock,
                    'difference'      => $difference,
                ]);

                // Kalau apply adjustment dicentang, update stok produk
                if ($request->boolean('apply_adjustment') && $difference !== 0) {
                    $product->update(['stock' => $physicalStock]);
                }
            }
        });

        return redirect()->route('stock-opnames.index')
            ->with('success', '✅ Stock opname berhasil disimpan.');
    }

    /*
    |--------------------------------------------------------------------------
    | Detail hasil opname
    |--------------------------------------------------------------------------
    */
    public function show(StockOpname $stockOpname)
    {
        $stockOpname->load('items.product', 'creator');

        return view('stock-opnames.show', compact('stockOpname'));
    }

    /*
    |--------------------------------------------------------------------------
    | Hapus opname
    |--------------------------------------------------------------------------
    */
    public function destroy(StockOpname $stockOpname)
    {
        $stockOpname->delete();

        return redirect()->route('stock-opnames.index')
            ->with('success', '🗑️ Data opname berhasil dihapus.');
    }
}