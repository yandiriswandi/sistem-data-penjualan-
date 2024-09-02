<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function purchases()
    {
        $data = Purchase::all();
        // $data = Product::all();
        return view('purchase.purchase', compact('data'));
    }
    public function purchasesAdd()
    {
        $suppliers   = Supplier::all();
        $products    = Product::all();
        return view('purchase.purchase-add', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'total_item' => 'required|integer',
            'discount' => 'nullable|numeric',
            'total_price' => 'required|numeric',
            'supplier_id' => 'required|exists:suppliers,id',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer',
            'items.*.price' => 'required|numeric',
        ]);

        // Buat pembelian baru
        $purchase = Purchase::create([
            'date' => $validatedData['date'],
            'total_item' => $validatedData['total_item'],
            'discount' => $validatedData['discount'],
            'total_price' => $validatedData['total_price'],
            'supplier_id' => $validatedData['supplier_id'],
        ]);

        // Menambahkan produk ke pembelian dengan data pivot
        foreach ($validatedData['items'] as $item) {
            $purchase->products()->attach($item['id'], [
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }
        // dd($purchase);

        // Redirect atau response sesuai kebutuhan
        return redirect()->route('purchase')->with('success', 'Purchase added successfully.');
    }

    public function edit(Request $request, $id)
    {
        $purchase = Purchase::with(['supplier','products'])->find($id);

        // Ambil semua kategori dan supplier untuk ditampilkan dalam dropdown
        $products = Product::all();
        $suppliers = Supplier::all();
        // dd($product);

        return view('purchase.purchase-edit', compact('purchase', 'products', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'total_item' => 'required|integer',
            'discount' => 'nullable|numeric',
            'total_price' => 'required|numeric',
            'supplier_id' => 'required|exists:suppliers,id',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer',
            'items.*.price' => 'required|numeric',
        ]);

        // Buat pembelian baru
        $purchase = Purchase::create([
            'date' => $validatedData['date'],
            'total_item' => $validatedData['total_item'],
            'discount' => $validatedData['discount'],
            'total_price' => $validatedData['total_price'],
            'supplier_id' => $validatedData['supplier_id'],
        ]);

        // Menambahkan produk ke pembelian dengan data pivot
        foreach ($validatedData['items'] as $item) {
            $purchase->products()->attach($item['id'], [
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }
        // dd($purchase);

        // Redirect atau response sesuai kebutuhan
        return redirect()->route('purchase')->with('success', 'Purchase added successfully.');
    }
}
