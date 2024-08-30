@extends('layout.main')
{{-- {{ dd($category,$supplier) }} --}}
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('title')</h1>
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
                            <form class="needs-validation" novalidate action="{{ route('product.store') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" name="name"
                                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                                    placeholder="Name Barang" value="{{ old('name') }}" required>
                                                @error('name')
                                                    <span class="invalid-feedback text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="code">Kode</label>
                                                <input type="text" name="code"
                                                    class="form-control @error('code') is-invalid @enderror" id="code"
                                                    placeholder="Kode Barang" value="{{ old('code') }}" required>
                                                @error('code')
                                                    <span class="invalid-feedback text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="category">Category:</label>
                                                <div>
                                                    <select id="category" name="category_id"
                                                        class="form-control  @error('category_id') is-invalid @enderror"
                                                        required>
                                                        <option value="">Select Category</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                                <label for="brand">Merk</label>
                                                <input type="text" name="brand"
                                                    class="form-control @error('brand') is-invalid @enderror" id="brand"
                                                    placeholder="Merk" value="{{ old('brand') }}" required>
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
                                                        <input type="checkbox"
                                                            class="@error('suppliers') is-invalid @enderror"
                                                            id="supplier{{ $supplier->id }}" name="suppliers[]"
                                                            value="{{ $supplier->id }}"
                                                            {{ is_array(old('suppliers')) && in_array($supplier->id, old('suppliers')) ? 'checked' : '' }}>
                                                        <label
                                                            for="supplier{{ $supplier->id }}">{{ $supplier->name }}</label>
                                                    </div>
                                                @endforeach
                                                @error('suppliers')
                                                    <span class="text-danger" style="font-size: 80%">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="stock">Stock</label>
                                                <input type="number" min="1" name="stock"
                                                    class="form-control @error('stock') is-invalid @enderror" id="stock"
                                                    placeholder="Stock" value="{{ old('stock') }}" required>
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
                                                <input type="number" name="price"
                                                    class="form-control @error('price') is-invalid @enderror" id="price"
                                                    placeholder="Harga Beli" value="{{ old('price') }}" required>
                                                @error('price')
                                                    <span class="invalid-feedback text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="selling_price">Harga Jual</label>
                                                <input type="number" name="selling_price"
                                                    class="form-control @error('price') is-invalid @enderror" id="selling_price"
                                                    placeholder="Harga Jual" value="{{ old('selling_price') }}" required>
                                                @error('selling_price')
                                                    <span class="invalid-feedback text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="note">Note</label>
                                                <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror" cols="10"
                                                    rows="5" placeholder="note">{{ old('note') }}</textarea>
                                                @error('note')
                                                    <span class="invalid-feedback text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-dark mr-1" type="reset"><i
                                            class="fa-solid fa-arrows-rotate"></i>
                                        Reset</button>
                                    <button class="btn btn-success" type="submit"><i
                                            class="fa-solid fa-floppy-disk"></i>
                                        Save</button>
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
