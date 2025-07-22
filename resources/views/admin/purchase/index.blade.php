@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Halaman Pembelian ke Supplier</h1>
        </section>

    @section('content')
        <div class="content-wrapper">
            <section class="content-header">
                <h1>Halaman Pembelian ke Supplier</h1>
            </section>

            <section class="content">
                <form method="GET" action="{{ route('purchase.index') }}">
                    <div class="form-group">
                        <label for="supplier_id">Pilih Supplier:</label>
                        <select name="supplier_id" class="form-control" onchange="this.form.submit()">
                            <option value="">-- Pilih Supplier --</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>

                @if ($products && count($products))
                    <form method="POST" action="{{ route('purchase.exportPdf') }}">
                        @csrf
                        <input type="hidden" name="supplier_id" value="{{ request('supplier_id') }}">
                        <table class="table table-bordered mt-4">
                            <thead>
                                <tr>
                                    <th>Pilih</th>
                                    <th>Nama Produk</th>
                                    <th>Jumlah Pembelian</th>
                                    <th>Stok</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td><input type="checkbox" name="product_ids[]" value="{{ $product->id }}"></td>
                                        <td>{{ $product->title }}</td>
                                        <td>
                                            <input type="number" name="quantities[]" class="form-control" value="1"
                                                min="1">
                                        </td>
                                        <td>{{ $product->stock }}</td>
                                        <td>Rp{{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                                        <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                        <button type="submit" class="btn btn-danger mt-3">Cetak PDF</button>
                    </form>
                @endif
            </section>
        </div>
    @endsection
</div>
@endsection
