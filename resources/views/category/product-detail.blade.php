@extends('layout.main')
{{-- {{ dd($category,$supplier) }} --}}
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Detail Product</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item"><a href="/barang">Barang</a></li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="text-right">
                                    <a href="/products" class="btn btn-warning btn-sm"><i
                                            class="fa-solid fa-arrow-rotate-left"></i>
                                        Back
                                    </a>
                                </div>
                            </div>
                            <form class="needs-validation" novalidate
                                action="{{ route('product.update', ['id' => $product->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" name="name" disabled
                                                    value="{{ old('name', $product->name) }}"
                                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                                    placeholder="Name Barang" required>
                                                @error('name')
                                                    <span class="invalid-feedback text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="code">Kode</label>
                                                <input type="text" name="code" disabled
                                                    value="{{ old('code', $product->code) }}"
                                                    class="form-control @error('code') is-invalid @enderror" id="code"
                                                    placeholder="Kode Barang" required>
                                                @error('code')
                                                    <span class="invalid-feedback text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="category">Category:</label>
                                                <div>
                                                    <select id="category" name="category_id" disabled
                                                        class="form-control  @error('category_id') is-invalid @enderror"
                                                        required>
                                                        <option value="">Select Category</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_id')
                                                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="code">Merk</label>
                                                <input type="text" name="brand" disabled
                                                    value="{{ old('brand', $product->brand) }}"
                                                    class="form-control @error('brand') is-invalid @enderror" id="brand"
                                                    placeholder="Merk" required>
                                                @error('brand')
                                                    <span class="invalid-feedback text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="suppliers">Suppliers:</label>
                                                @foreach ($suppliers as $supplier)
                                                    <div>
                                                        <input type="checkbox" id="supplier{{ $supplier->id }}" disabled
                                                            name="suppliers[]" value="{{ $supplier->id }}"
                                                            {{ old('suppliers', $product->suppliers->pluck('id')->toArray()) ? (in_array($supplier->id, old('suppliers', $product->suppliers->pluck('id')->toArray())) ? 'checked' : '') : '' }}>
                                                        <label
                                                            for="supplier{{ $supplier->id }}">{{ $supplier->name }}</label>
                                                    </div>
                                                @endforeach
                                                {{-- <input type="hidden" name="suppliers" value=""> --}}
                                                @error('suppliers')
                                                    <span class="text-danger" style="font-size: 80%">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="stock">Stock</label>
                                                <input type="number" min="1" name="stock" disabled
                                                    value="{{ old('stock', $product->stock) }}"
                                                    class="form-control @error('stock') is-invalid @enderror" id="stock"
                                                    placeholder="Stock" required>
                                                @error('stock')
                                                    <span class="invalid-feedback text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="price">Harga Beli</label>
                                                <input type="number" value="{{ old('stock', $product->price) }}" disabled
                                                    name="price" class="form-control @error('price') is-invalid @enderror"
                                                    id="price" placeholder="Harga Beli" required>
                                                @error('price')
                                                    <span class="invalid-feedback text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name">Harga Jual</label>
                                                <input type="text" name="selling_price"
                                                    value="{{ old('selling_price', $product->selling_price) }}" disabled
                                                    class="form-control @error('selling_price') is-invalid @enderror"
                                                    id="selling_price" placeholder="Harga Jual" required>
                                                @error('selling_price')
                                                    <span class="invalid-feedback text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="note">Note</label>
                                                <textarea disabled name="note" id="note" class="form-control @error('note') is-invalid @enderror"
                                                    cols="10" rows="5" placeholder="Enter your note here">{{ old('note', $product->note) }}</textarea>
                                                @error('note')
                                                    <span class="invalid-feedback text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.content -->
                </div>
            </div>
        </div>
    </div>
@endsection
