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
                      
                               <div>
                                <div class="container">
                                    <h2>Tambah Data Pembelian</h2>
                                    <form  method="POST" id="purchase-form">
                                        @csrf
                                
                                        <div id="items-container">
                                            <div class="item-row">
                                                <div class="form-group">
                                                    <label for="product_0">Produk</label>
                                                    <select name="items[0][id]" class="form-control product-select" data-index="0" required>
                                                        <option value="">Pilih Produk</option>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="quantity_0">Kuantitas</label>
                                                    <input type="number" name="items[0][quantity]" class="form-control quantity-input" data-index="0" min="1" disabled required>
                                                </div>
                                                <input type="hidden" name="items[0][price]" class="price-input" data-index="0">
                                                <div class="form-group">
                                                    <label>Total Harga</label>
                                                    <input type="text" class="form-control total-price" data-index="0" readonly>
                                                </div>
                                                <button type="button" class="btn btn-danger remove-item" data-index="0">Hapus</button>
                                                <hr>
                                            </div>
                                        </div>
                                
                                        <button type="button" class="btn btn-primary" id="add-item">Tambah Item</button>
        <button type="submit" class="btn btn-success">Simpan</button>
                                    </form>
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
                        
                        </div>
                    </div>
                    <!-- /.content -->
                </div>
            </div>
        </div>
    </div>

@endsection
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let itemIndex = 0;

        document.getElementById('add-item').addEventListener('click', function () {
            itemIndex++;
            const newItemRow = document.createElement('div');
            newItemRow.className = 'item-row';
            newItemRow.innerHTML = `
                <div class="form-group">
                    <label for="product_${itemIndex}">Produk</label>
                    <select name="items[${itemIndex}][id]" class="form-control product-select" data-index="${itemIndex}" required>
                        <option value="">Pilih Produk</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity_${itemIndex}">Kuantitas</label>
                    <input type="number" name="items[${itemIndex}][quantity]" class="form-control quantity-input" data-index="${itemIndex}" min="1" disabled required>
                </div>
                <input type="hidden" name="items[${itemIndex}][price]" class="price-input" data-index="${itemIndex}">
                <div class="form-group">
                    <label>Total Harga</label>
                    <input type="text" class="form-control total-price" data-index="${itemIndex}" readonly>
                </div>
                <button type="button" class="btn btn-danger remove-item" data-index="${itemIndex}">Hapus</button>
                <hr>
            `;
            document.getElementById('items-container').appendChild(newItemRow);
        });

        document.getElementById('items-container').addEventListener('change', function (event) {
            if (event.target.classList.contains('product-select')) {
                const index = event.target.getAttribute('data-index');
                updateTotalPrice(index);
                enableQuantityInput(index);
            }
            if (event.target.classList.contains('quantity-input')) {
                const index = event.target.getAttribute('data-index');
                updateTotalPrice(index);
            }
        });

        document.getElementById('items-container').addEventListener('click', function (event) {
            if (event.target.classList.contains('remove-item')) {
                const index = event.target.getAttribute('data-index');
                document.querySelector(`.item-row:nth-child(${parseInt(index) + 1})`).remove();
            }
        });

        function updateTotalPrice(index) {
            const quantity = parseInt(document.querySelector(`.quantity-input[data-index="${index}"]`).value) || 0;
            const price = parseFloat(document.querySelector(`.product-select[data-index="${index}"] option:checked`).getAttribute('data-price')) || 0;
            const totalPrice = quantity * price;

            document.querySelector(`.total-price[data-index="${index}"]`).value = totalPrice.toFixed(2);
            document.querySelector(`.price-input[data-index="${index}"]`).value = price;
        }

        function enableQuantityInput(index) {
            const quantityInput = document.querySelector(`.quantity-input[data-index="${index}"]`);
            const productSelect = document.querySelector(`.product-select[data-index="${index}"]`);

            quantityInput.disabled = !productSelect.value;
        }
    });
</script>
