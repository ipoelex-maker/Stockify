<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use Illuminate\Http\Request;

class StockInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stockIns = StockIn::with('product')
                    ->latest()
                    ->get();

        return view('stock-ins.index', compact('stockIns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();

        return view('stock-ins.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'qty' => 'required|integer|min:1',
            'date' => 'required',
        ]);

        /*
        |--------------------------------------------------------------------------
        | SIMPAN STOCK IN
        |--------------------------------------------------------------------------
        */

        StockIn::create([
            'product_id' => $request->product_id,
            'qty' => $request->qty,
            'date' => $request->date,
            'note' => $request->note,
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE STOCK PRODUCT
        |--------------------------------------------------------------------------
        */

        $product = Product::find($request->product_id);

        $product->increment('stock', $request->qty);

        return redirect()->route('stock-ins.index')
            ->with('success', 'Barang masuk berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockIn $stockIn)
    {
        /*
        |--------------------------------------------------------------------------
        | KURANGI STOCK SAAT DELETE
        |--------------------------------------------------------------------------
        */

        $stockIn->product->decrement('stock', $stockIn->qty);

        $stockIn->delete();

        return redirect()->route('stock-ins.index')
            ->with('success', 'Data berhasil dihapus');
    }
}