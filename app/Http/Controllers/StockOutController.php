<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockOut;
use Illuminate\Http\Request;

class StockOutController extends Controller
{
    public function index()
    {
        $stockOuts = StockOut::with('product')->latest()->get();
        return view('stock-outs.index', compact('stockOuts'));
    }

    public function create()
    {
        $products = Product::all();
        return view('stock-outs.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'qty'        => 'required|integer|min:1',
            'date'       => 'required',
        ]);

        $product = Product::find($request->product_id);

        /*
        |--------------------------------------------------------------------------
        | VALIDASI STOK TIDAK MENCUKUPI
        |--------------------------------------------------------------------------
        */
        if ($product->stock < $request->qty) {
            return back()
                ->withInput()
                ->with('error', "🚫 Stok tidak mencukupi! Stok {$product->name} saat ini hanya {$product->stock} unit.");
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDASI MIN STOK — stok setelah keluar tidak boleh di bawah min_stock
        |--------------------------------------------------------------------------
        */
        $stockAfter = $product->stock - $request->qty;
        $minStock   = $product->min_stock ?? 0;

        if ($stockAfter < $minStock) {
            return back()
                ->withInput()
                ->with('error', "🚫 Tidak bisa! Stok {$product->name} setelah dikurangi akan menjadi {$stockAfter} unit, di bawah batas minimum ({$minStock} unit). Maksimal bisa dikeluarkan: " . ($product->stock - $minStock) . " unit.");
        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN STOCK OUT
        |--------------------------------------------------------------------------
        */
        StockOut::create([
            'product_id' => $request->product_id,
            'qty'        => $request->qty,
            'date'       => $request->date,
            'note'       => $request->note,
        ]);

        $product->decrement('stock', $request->qty);

        return redirect()->route('stock-outs.index')
            ->with('success', "✅ Barang keluar berhasil dicatat. Sisa stok {$product->name}: " . ($stockAfter) . " unit.");
    }

    public function destroy(StockOut $stockOut)
    {
        $stockOut->product->increment('stock', $stockOut->qty);
        $stockOut->delete();

        return redirect()->route('stock-outs.index')
            ->with('success', '🗑️ Data berhasil dihapus dan stok dikembalikan.');
    }
}