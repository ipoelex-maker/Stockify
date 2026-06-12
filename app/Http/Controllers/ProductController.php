<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'supplier'])->latest()->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers  = Supplier::all();
        return view('products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'supplier_id' => 'required',
            'name'        => 'required',
            'sku'         => 'required|unique:products',
            'buy_price'   => 'required|numeric|min:0',
            'sell_price'  => 'required|numeric|min:0',
            'min_stock'   => 'required|integer|min:0',
        ]);

        $image = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
            'name'        => $request->name,
            'sku'         => $request->sku,
            'stock'       => $request->stock ?? 0,
            'min_stock'   => $request->min_stock,
            'buy_price'   => $request->buy_price,
            'sell_price'  => $request->sell_price,
            'description' => $request->description,
            'image'       => $image,
        ]);

        return redirect()->route('products.index')
            ->with('success', '✅ Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers  = Supplier::all();
        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required',
            'supplier_id' => 'required',
            'name'        => 'required',
            'sku'         => 'required|unique:products,sku,' . $product->id,
            'buy_price'   => 'required|numeric|min:0',
            'sell_price'  => 'required|numeric|min:0',
            'min_stock'   => 'required|integer|min:0',
        ]);

        $image = $product->image;
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
            'name'        => $request->name,
            'sku'         => $request->sku,
            'stock'       => $request->stock ?? $product->stock,
            'min_stock'   => $request->min_stock,
            'buy_price'   => $request->buy_price,
            'sell_price'  => $request->sell_price,
            'description' => $request->description,
            'image'       => $image,
        ]);

        return redirect()->route('products.index')
            ->with('success', '✅ Produk berhasil diupdate.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
            ->with('success', '🗑️ Produk berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | IMPORT CSV
    |--------------------------------------------------------------------------
    */
    public function importForm()
    {
        return view('products.import');
    }

    public function importCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file   = $request->file('file');
        $handle = fopen($file->getPathname(), 'r');

        // Skip header row
        fgetcsv($handle);

        $success = 0;
        $errors  = [];
        $row     = 2;

        while (($data = fgetcsv($handle)) !== false) {

            if (count($data) < 7) {
                $errors[] = "Baris {$row}: kolom tidak lengkap";
                $row++;
                continue;
            }

            [$name, $sku, $categoryName, $supplierName, $buyPrice, $sellPrice, $minStock] = $data;
            $stock = $data[7] ?? 0;

            // Skip baris kosong
            if (empty(trim($name))) { $row++; continue; }

            // Cari atau buat category & supplier
            $category = Category::firstOrCreate(['name' => trim($categoryName)]);
            $supplier = Supplier::firstOrCreate(['name' => trim($supplierName)]);

            // Cek duplikat SKU
            if (Product::where('sku', trim($sku))->exists()) {
                $errors[] = "Baris {$row}: SKU '{$sku}' sudah ada, dilewati.";
                $row++;
                continue;
            }

            try {
                Product::create([
                    'name'        => trim($name),
                    'sku'         => trim($sku),
                    'category_id' => $category->id,
                    'supplier_id' => $supplier->id,
                    'buy_price'   => (float) str_replace(',', '', $buyPrice),
                    'sell_price'  => (float) str_replace(',', '', $sellPrice),
                    'min_stock'   => (int) $minStock,
                    'stock'       => (int) $stock,
                ]);
                $success++;
            } catch (\Exception $e) {
                $errors[] = "Baris {$row}: " . $e->getMessage();
            }

            $row++;
        }

        fclose($handle);

        $message = "✅ {$success} produk berhasil diimport.";
        if (!empty($errors)) {
            $message .= ' ⚠️ ' . count($errors) . ' baris dilewati.';
        }

        return redirect()->route('products.index')
            ->with('success', $message)
            ->with('import_errors', $errors);
    }

    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD TEMPLATE CSV
    |--------------------------------------------------------------------------
    */
    public function downloadTemplate()
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template-import-produk.csv"',
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header
            fputcsv($handle, ['Nama Produk', 'SKU', 'Kategori', 'Supplier', 'Harga Beli', 'Harga Jual', 'Stok Minimum', 'Stok Awal']);

            // Contoh data
            fputcsv($handle, ['Laptop Asus VivoBook', 'ASUS-VB-001', 'Elektronik', 'PT Sumber Makmur', '5000000', '6500000', '5', '10']);
            fputcsv($handle, ['Mouse Logitech M185', 'LOG-M185-001', 'Elektronik', 'PT Sumber Makmur', '80000', '120000', '3', '20']);

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}