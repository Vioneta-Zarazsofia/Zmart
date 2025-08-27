@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header mb-4">
            <h1 class="display-4">Tambah Pembelian ke Supplier</h1>
        </section>

        <section class="content">

            {{-- FORM PILIH SUPPLIER --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('purchase.index') }}">
                        <div class="form-group mb-0">
                            <label class="font-weight-bold">Pilih Supplier</label>
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
                </div>
            </div>

            {{-- FORM TAMBAH PEMBELIAN --}}
            @if ($products->count())
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <strong>Form Tambah Pembelian</strong>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('purchase.store') }}">
                            @csrf
                            <input type="hidden" name="supplier_id" value="{{ request('supplier_id') }}">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Pilih</th>
                                            <th>Nama Produk</th>
                                            <th>Qty</th>
                                            <th>Harga Beli (Rp)</th>
                                            <th>Stok Saat Ini</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-center">
                                                    <input type="checkbox" name="product_ids[]" value="{{ $product->id }}">
                                                </td>
                                                <td>{{ $product->title }}</td>
                                                <td style="max-width: 80px;">
                                                    <input type="number" name="quantities[{{ $product->id }}]"
                                                        value="1" min="1" class="form-control form-control-sm">
                                                </td>
                                                <td>{{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                                                <td>{{ $product->stock }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <button type="submit" class="btn btn-success mt-3">
                                <i class="fa fa-save"></i> Simpan Pembelian &amp; Download PDF
                            </button>
                        </form>
                    </div>
                </div>
            @else
                @if (request('supplier_id'))
                    <div class="alert alert-warning">Supplier ini tidak memiliki produk.</div>
                @endif
            @endif

            {{-- Daftar Purchase Order --}}
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h2 class="mb-0 h5">Daftar Purchase Order</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Supplier</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($purchases as $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $p->supplier->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($p->purchase_date)->format('d/m/Y') }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $p->status == 'pending' ? 'badge-warning' : 'badge-success' }}">
                                                {{ ucfirst($p->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($p->status == 'pending')
                                                <a href="{{ route('purchase.confirm', $p->id) }}"
                                                    class="btn btn-success btn-sm mb-1">Konfirmasi Terima</a>
                                            @endif
                                            <a href="{{ route('purchase.show', $p->id) }}" class="btn btn-info btn-sm">
                                                <i class="fa fa-eye"></i> Detail
                                            </a>


                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada purchase order.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection
