@extends('layouts.app')

@section('style')
    <style>
        .table th,
        .table td {
            padding: 0.75rem 1rem;
            vertical-align: middle !important;
        }

        .badge {
            padding: 0.4em 0.6em;
            border-radius: 6px;
            font-size: 0.85rem;
        }

        .badge-success {
            background-color: #28a745;
            color: #fff;
        }

        .badge-danger {
            background-color: #dc3545;
            color: #fff;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #000;
        }

        .badge-primary {
            background-color: #007bff;
            color: #fff;
        }

        .img-thumbnail {
            max-width: 60px;
            max-height: 60px;
            border-radius: 6px;
        }

        .table-wrapper {
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
            overflow: auto;
        }
    </style>
@endsection

@section('content')
    <main class="main">
        <div class="page-header text-center">
            <div class="container">
                <h1 class="page-title">📦 Daftar Pesanan Anda</h1>
            </div>
        </div>

        <div class="page-content">
            <div class="dashboard">
                <div class="container py-4">
                    <div class="row">
                        @include('user._sidebar')

                        <div class="col-md-8 col-lg-9">
                            <div class="table-wrapper">
                                <table class="table table-sm table-hover table-bordered align-middle mb-0 text-center">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No. Order</th>
                                            <th>Total</th>
                                            <th>Metode</th>
                                            <th>Bukti</th>
                                            <th>Status</th>
                                            <th>Dikirim</th>
                                            <th>Estimasi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($orders as $order)
                                            <tr>
                                                <td>{{ $order->order_number }}</td>
                                                <td class="text-nowrap">Rp
                                                    {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                                <td>{{ ucfirst($order->payment_method ?? '-') }}</td>
                                                <td>
                                                    @if ($order->payment_proof)
                                                        <a href="{{ asset($order->payment_proof) }}" target="_blank">
                                                            <img src="{{ asset($order->payment_proof) }}"
                                                                alt="Bukti Transfer" class="img-fluid rounded shadow-sm"
                                                                style="max-height: 250px;">
                                                        </a>
                                                    @else
                                                        <p class="text-danger">Belum ada bukti pembayaran</p>
                                                    @endif

                                                </td>
                                                <td>
                                                    @if ($order->is_payment == 4)
                                                        <span class="badge badge-dark text-white">Dibatalkan</span>
                                                    @elseif (isset($order->is_done) && $order->is_done == 1)
                                                        <span class="badge badge-primary text-white">Selesai</span>
                                                    @elseif ($order->is_payment == 1)
                                                        <span class="badge badge-success text-white">Terverifikasi</span>
                                                    @elseif ($order->is_payment == 2)
                                                        <span class="badge badge-danger text-white">Ditolak</span>
                                                    @else
                                                        <span class="badge badge-warning">Menunggu</span>
                                                    @endif

                                                </td>
                                                <td>
                                                    {{ $order->delivered_time ? \Carbon\Carbon::parse($order->delivered_time)->format('d M Y') : '-' }}
                                                </td>
                                                <td>
                                                    {{ $order->estimated_arrival ? \Carbon\Carbon::parse($order->estimated_arrival)->format('d M Y') : '-' }}
                                                </td>
                                                <td class="d-flex flex-column gap-2 align-items-center"
                                                    style="min-width: 130px;">
                                                    <a href="{{ url('user/orders/detail/' . $order->id) }}"
                                                        class="btn btn-sm btn-info rounded-pill px-3 py-2 mb-2 text-center"
                                                        style="font-size: 1rem; min-width: 110px;">
                                                        <i class="fas fa-info-circle"></i> <span
                                                            class="d-inline-block text-center w-100">Detail</span>
                                                    </a>

                                                    @if ($order->is_payment == 1 && $order->is_done != 1)
                                                        <form action="{{ url('user/orders/mark-done/' . $order->id) }}"
                                                            method="POST" class="w-100">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-sm btn-success rounded-pill px-3 py-2 mb-2 text-center w-100"
                                                                style="font-size: 1rem; min-width: 110px;">
                                                                <i class="fas fa-check-circle"></i> <span
                                                                    class="d-inline-block text-center w-100">Selesai</span>
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @if ($order->is_payment == 0)
                                                        <form action="{{ route('user.orders.cancel', $order->id) }}"
                                                            method="POST" class="w-100"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-sm btn-outline-danger rounded-pill px-3 py-2 text-center w-100"
                                                                style="font-size: 1rem; min-width: 110px;">
                                                                <i class="fas fa-times-circle"></i> <span
                                                                    class="d-inline-block text-center w-100">Batalkan</span>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center text-muted py-4">
                                                    <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                                    Tidak ada pesanan.
                                                </td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-4">
                                    {!! $orders->appends(request()->except('page'))->links() !!}
                                </div>
                            </div> <!-- End .table-wrapper -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
@endsection
