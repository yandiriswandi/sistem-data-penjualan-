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

            // Update quantity produk
            $product = Product::find($item['id']);
            $product->stock += $item['quantity'];
            $product->save();
        }
        // dd($purchase);

        // Redirect atau response sesuai kebutuhan
        return redirect()->route('purchase')->with('success', 'Purchase added successfully.');
    }

    public function edit(Request $request, $id)
    {
        $purchase = Purchase::with(['supplier', 'products'])->find($id);

        // Ambil semua kategori dan supplier untuk ditampilkan dalam dropdown
        $products = Product::all();
        $suppliers = Supplier::all();
        // dd($product);

        return view('purchase.purchase-edit', compact('purchase', 'products', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $purchase = Purchase::find($id);
    
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
    
        // Mengembalikan stok lama
        foreach ($purchase->products as $product) {
            $originalQuantity = $product->pivot->quantity;
            $product->stock -= $originalQuantity;
            $product->save();
        }
    
        // Update data pembelian
        $data = [
            'date' => $validatedData['date'],
            'total_item' => $validatedData['total_item'],
            'discount' => $validatedData['discount'],
            'total_price' => $validatedData['total_price'],
            'supplier_id' => $validatedData['supplier_id'],
        ];
        $purchase->update($data);
    
        // Menyinkronkan produk dengan pembelian baru dan mengupdate stok produk
        $syncData = [];
        foreach ($validatedData['items'] as $item) {
            $syncData[$item['id']] = [
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ];
    
            // Update quantity produk
            $product = Product::find($item['id']);
            $product->stock += $item['quantity'];
            $product->save();
        }
    
        $purchase->products()->sync($syncData);
    
        // Redirect atau response sesuai kebutuhan
        return redirect()->route('purchase')->with('success', 'Purchase updated successfully.');
    }
    

    public function detail(Request $request, $id)
    {
        $purchase = Purchase::with(['supplier', 'products'])->find($id);

        // Ambil semua kategori dan supplier untuk ditampilkan dalam dropdown
        $products = Product::all();
        $suppliers = Supplier::all();
        // dd($product);

        return view('purchase.purchase-detail', compact('purchase', 'products', 'suppliers'));
    }

    public function delete(Request $request, $id)
    {
        $data = Purchase::find($id);

        if ($data) {
            $data->forceDelete();
        }
        $message = 'Purchase has been deleted!';

        return redirect()->route('purchase')->with('success', $message);
    }
}
