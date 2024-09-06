<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function supplier()
    {
        $data = Supplier::orderBy('name', 'asc')->get();
        // $data = Product::all();
        return view('supplier.supplier', compact('data'));
    }  //
}
