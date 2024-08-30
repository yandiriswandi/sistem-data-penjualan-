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
        // $data = Product::all();
        return view('purchase.purchase-add', compact('suppliers', 'products'));
    }
}
