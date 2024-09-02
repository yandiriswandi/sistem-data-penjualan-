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

                            <form method="POST" class="needs-validation" novalidate
                                action="{{ route('purchase.update', ['id' => $purchase->id]) }}" method="POST"
                                id="purchase-form">
                                @csrf
                                @method('PUT')

                                <div class="container">
                                    <div id="items-container">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="date">Tanggal</label>
                                                    <input type="date" class="form-control" id="date" name="date"
                                                        readonly value="{{ old('date', $purchase->date) }}"
                                                        placeholder="Select a date" value="{{ old('date') }}" required>
                                                    @error('date')
                                                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="total_item">Total Barang</label>
                                                    <input type="number" name="total_item"
                                                        value="{{ old('total_item', $purchase->total_item) }}"
                                                        class="form-control @error('total_item') is-invalid @enderror"
                                                        id="total_item" placeholder="Total barang"
                                                        value="{{ old('total_item') }}" required readonly>
                                                    @error('total_item')
                                                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="discount">Diskon</label>
                                                    <input type="number" name="discount"
                                                        class="form-control @error('discount') is-invalid @enderror"
                                                        readonly id="discount" placeholder="Diskon"
                                                        value="{{ old('discount') }}" required
                                                        value="{{ old('discount', $purchase->discount) }}">
                                                    @error('discount')
                                                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="total_price">Total Harga</label>
                                                    <input type="number" name="total_price"
                                                        value="{{ old('total_price', $purchase->total_price) }}"
                                                        class="form-control @error('total_price') is-invalid @enderror"
                                                        id="total_price" placeholder="Harga Beli" readonly
                                                        value="{{ old('total_price') }}" required>
                                                    @error('total_price')
                                                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="supplier_id">Supllier</label>
                                                    <div>
                                                        <select id="supplier_id" name="supplier_id" disabled
                                                            class="form-control  @error('supplier_id') is-invalid @enderror"
                                                            required>
                                                            <option value="">Select supplier</option>
                                                            @foreach ($suppliers as $supplier)
                                                                <option value="{{ $supplier->id }}"
                                                                    {{ old('supplier_id', $purchase->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                                                    {{-- {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}> --}}
                                                                    {{ $supplier->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('supplier_id')
                                                            <span
                                                                class="invalid-feedback text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <table id="example1" class="table table-hover text-nowrap w-100"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Produk</th>
                                                    <th>Jumlah</th>
                                                    <th>Harga Satuan</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($purchase->products as $d)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $d->name ?? '' }}</td>
                                                        <th>{{ $d->pivot->quantity }}</th>
                                                        <th>{{ $d->pivot->price }}</th>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let itemIndex = 0;

        document.getElementById('add-item').addEventListener('click', function() {
            itemIndex++;
            const newItemRow = document.createElement('div');
            newItemRow.className = 'item-row';
            newItemRow.setAttribute('data-index', itemIndex);
            newItemRow.innerHTML = `
            <div class="form-group">
                <label for="product_${itemIndex}">Produk</label>
                <select name="items[${itemIndex}][id]" class="form-control product-select" data-index="${itemIndex}" required>
                    <option value="">Pilih Produk</option>
                    @foreach ($products as $product)
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

        document.getElementById('items-container').addEventListener('change', function(event) {
            if (event.target.classList.contains('product-select')) {
                const index = event.target.getAttribute('data-index');
                updateTotalPrice(index);
                enableQuantityInput(index);
                calculateSummary();
            }
            if (event.target.classList.contains('quantity-input')) {
                const index = event.target.getAttribute('data-index');
                updateTotalPrice(index);
                calculateSummary();
            }
        });

        document.getElementById('items-container').addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-item')) {
                const index = event.target.getAttribute('data-index');
                // Use a more reliable selector to find the correct item-row
                const itemRow = document.querySelector(`.item-row[data-index="${index}"]`);
                if (itemRow) {
                    itemRow.remove();
                    calculateSummary();
                }
            }
        });

        document.getElementById('discount').addEventListener('input', calculateSummary);

        function updateTotalPrice(index) {
            const quantity = parseInt(document.querySelector(`.quantity-input[data-index="${index}"]`).value) ||
                0;
            const price = parseFloat(document.querySelector(
                `.product-select[data-index="${index}"] option:checked`).getAttribute('data-price')) || 0;
            const totalPrice = quantity * price;

            document.querySelector(`.total-price[data-index="${index}"]`).value = totalPrice.toFixed(2);
            document.querySelector(`.price-input[data-index="${index}"]`).value = price;
        }

        function enableQuantityInput(index) {
            const quantityInput = document.querySelector(`.quantity-input[data-index="${index}"]`);
            const productSelect = document.querySelector(`.product-select[data-index="${index}"]`);

            quantityInput.disabled = !productSelect.value;
        }

        function calculateSummary() {
            let totalItem = 0;
            let totalPrice = 0;

            document.querySelectorAll('.item-row').forEach(function(row, index) {
                const quantity = parseInt(document.querySelector(
                    `.quantity-input[data-index="${index}"]`).value) || 0;
                const price = parseFloat(document.querySelector(`.total-price[data-index="${index}"]`)
                    .value) || 0;

                totalItem += quantity;
                totalPrice += price;
            });

            const discount = parseFloat(document.getElementById('discount').value) || 0;
            const finalPrice = totalPrice - discount;

            document.getElementById('total_item').value = totalItem;
            document.getElementById('total_price').value = finalPrice.toFixed(2);
        }
    });
</script>
