@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header mb-4">
            <h1 class="display-6 fw-bold">Detail Purchase Order</h1>
        </section>

        <section class="content">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4 mb-2">
                            <div class="p-3 bg-light rounded shadow-sm h-100">
                                <h6 class="fw-semibold mb-1 text-muted">Supplier</h6>
                                <div class="fs-5">{{ $purchase->supplier->name }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="p-3 bg-light rounded shadow-sm h-100">
                                <h6 class="fw-semibold mb-1 text-muted">Tanggal</h6>
                                <div class="fs-5">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="p-3 bg-light rounded shadow-sm h-100">
                                <h6 class="fw-semibold mb-1 text-muted">Status</h6>
                                <span class="badge px-3 py-2 fs-6 bg-{{ $purchase->status == 'completed' ? 'success' : ($purchase->status == 'pending' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($purchase->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-hover align-middle shadow-sm">
                            <thead class="table-primary">
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th>Produk</th>
                                    <th style="width: 15%;">Qty</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @php $grandTotal = 0; @endphp
                                @foreach ($purchase->items as $item)
                                    @php
                                        $lineTotal = $item->qty * $item->price;
                                        $grandTotal += $lineTotal;
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->product->title ?? '-' }}</td>
                                        <td>{{ $item->qty }}</td>

                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                    <a href="{{ route('purchase.index') }}" class="btn btn-secondary mt-3">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
