<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockOut;
use Illuminate\Http\Request;

class StockOutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stockOuts = StockOut::with('product')
                    ->latest()
                    ->get();

        return view('stock-outs.index', compact('stockOuts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();

        return view('stock-outs.create', compact('products'));
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
        | AMBIL PRODUCT
        |--------------------------------------------------------------------------
        */

        $product = Product::find($request->product_id);

        /*
        |--------------------------------------------------------------------------
        | VALIDASI STOCK
        |--------------------------------------------------------------------------
        */

        if ($product->stock < $request->qty) {

            return back()->with('error', 'Stock tidak mencukupi');
        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN STOCK OUT
        |--------------------------------------------------------------------------
        */

        StockOut::create([
            'product_id' => $request->product_id,
            'qty' => $request->qty,
            'date' => $request->date,
            'note' => $request->note,
        ]);

        /*
        |--------------------------------------------------------------------------
        | KURANGI STOCK
        |--------------------------------------------------------------------------
        */

        $product->decrement('stock', $request->qty);

        return redirect()->route('stock-outs.index')
            ->with('success', 'Barang keluar berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockOut $stockOut)
    {
        /*
        |--------------------------------------------------------------------------
        | KEMBALIKAN STOCK
        |--------------------------------------------------------------------------
        */

        $stockOut->product->increment('stock', $stockOut->qty);

        $stockOut->delete();

        return redirect()->route('stock-outs.index')
            ->with('success', 'Data berhasil dihapus');
    }
}