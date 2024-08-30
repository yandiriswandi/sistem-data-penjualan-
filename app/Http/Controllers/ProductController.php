<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function products()
    {
        $data = Product::orderBy('name', 'asc')->get();
        // $data = Product::all();
        return view('product.product', compact('data'));
    }

    public function detail(Request $request, $id)
    {
        $product = Product::with(['category', 'suppliers'])->find($id);

        // Ambil semua kategori dan supplier untuk ditampilkan dalam dropdown
        $categories = Category::all();
        $suppliers = Supplier::all();
        // dd($product);

        return view('product.product-detail', compact('product', 'categories', 'suppliers'));
    }

    public function productAdd()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('product.product-add', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $validator = $request->validate([
            'name' => 'required|max:100',
            'category_id' => 'required|exists:categories,id',
            'code' => 'required|unique:products,code',
            'suppliers' => 'required|array|min:1',  // memastikan bahwa setidaknya satu supplier dipilih
            'suppliers.*' => 'exists:suppliers,id', // memastikan setiap nilai adalah ID supplier yang valid
            'stock' => 'required',
            'brand' => 'required',
            'price' => 'required',
            'selling_price' => 'required',
            'note' => 'max:1000',
        ]);
        // if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        // $photo      = $request->file('photo');
        // $filename   = date('Y-m-d') . $photo->getClientOriginalName();
        // $path       = 'photo-user/' . $filename;

        // Storage::disk('public')->put($path, file_get_contents($photo));

        // $data['name']              = $request->name;
        // $data['category_id']       = $request->category_id;
        // $data['stock']             = $request->stock;
        // $data['price']             = $request->price;
        // $data['note']              = $request->note;
        $data = [
            'name' => $request->name,
            'code' => $request->code,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
            'price' => $request->price,
            'selling_price' => $request->selling_price,
            'brand' => $request->brand,
            'note' => $request->note,
        ];
        $product = Product::create($data);
        $product->suppliers()->attach($request->suppliers);
        $message = 'Product ' . $product->name . ' created successfully!';
        return redirect()->route('product')->with('success', $message);
    }

    public function edit(Request $request, $id)
    {
        $product = Product::with(['category', 'suppliers'])->find($id);

        // Ambil semua kategori dan supplier untuk ditampilkan dalam dropdown
        $categories = Category::all();
        $suppliers = Supplier::all();
        // dd($product);

        return view('product.product-edit', compact('product', 'categories', 'suppliers'));
    }


    public function update(Request $request, $id)
    {
        // dd($request->all());
        $product = Product::find($id);
        $validator = $request->validate([
            'name' => 'required|max:100',
            'category_id' => 'required|exists:categories,id',
            'code' => 'required|unique:products,code,' . $id,
            'suppliers' => 'required|array|min:1',  // memastikan bahwa setidaknya satu supplier dipilih
            'suppliers.*' => 'exists:suppliers,id', // memastikan setiap nilai adalah ID supplier yang valid
            'stock' => 'required',
            'brand' => 'required',
            'price' => 'required',
            'selling_price' => 'required',
            'note' => 'max:1000',
        ]);

        $data = [
            'name' => $request->name,
            'code' => $request->code,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
            'brand' => $request->brand,
            'price' => $request->price,
            'selling_price' => $request->selling_price,
            'note' => $request->note,
        ];
        $product->update($data);
        $product->suppliers()->sync($request->input('suppliers', []));

        $message = "Product " . $product->name . " updated successfully!";
        return redirect()->route('product')->with('success', $message);
    }

    public function delete(Request $request, $id)
    {
        $data = Product::find($id);

        if ($data) {
            $data->forceDelete();
        }
        $message = 'Product has been deleted!';

        return redirect()->route('product')->with('success', $message);
    }
}
