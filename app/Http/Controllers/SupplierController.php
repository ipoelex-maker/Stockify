<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->get();
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'nullable|regex:/^[0-9+\-\s()]+$/|max:20',
            'email' => 'nullable|email|max:255',
        ], [
            'phone.regex' => 'Nomor telepon hanya boleh berisi angka, +, -, atau spasi.',
        ]);

        Supplier::create([
            'name'    => $request->name,
            'address' => $request->address,
            'phone'   => $request->phone,
            'email'   => $request->email,
        ]);

        return redirect()->route('suppliers.index')
            ->with('success', '✅ Supplier berhasil ditambahkan.');
    }

    public function show(Supplier $supplier)
    {
        //
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'nullable|regex:/^[0-9+\-\s()]+$/|max:20',
            'email' => 'nullable|email|max:255',
        ], [
            'phone.regex' => 'Nomor telepon hanya boleh berisi angka, +, -, atau spasi.',
        ]);

        $supplier->update([
            'name'    => $request->name,
            'address' => $request->address,
            'phone'   => $request->phone,
            'email'   => $request->email,
        ]);

        return redirect()->route('suppliers.index')
            ->with('success', '✅ Supplier berhasil diupdate.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')
            ->with('success', '🗑️ Supplier berhasil dihapus.');
    }
}