@extends('admin.layouts.app')

@section('style')
    <style>
        .table-hover tbody tr:hover {
            background-color: #f2f2f2;
            cursor: pointer;
        }

        .table td,
        .table th {
            vertical-align: middle !important;
        }

        .payment-proof-img {
            max-height: 50px;
            object-fit: cover;
        }
    </style>
@endsection

@section('content')
    @php
        function getPaymentStatus($status)
        {
            return match ($status) {
                0 => ['Menunggu', 'warning', 'fas fa-clock'],
                1 => ['Terverifikasi', 'success', 'fas fa-check-circle'],
                2 => ['Ditolak', 'danger', 'fas fa-times-circle'],
                3 => ['Selesai', 'primary', 'fas fa-check-double'],
                4 => ['Dibatalkan', 'secondary', 'fas fa-ban'],
                default => ['Tidak Diketahui', 'secondary', 'fas fa-question'],
            };
        }
    @endphp

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1>Daftar Seluruh Pemesanan Masuk (Total: {{ $orders->count() }})</h1>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                @include('admin.layouts._message')

                <form method="get">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Pencarian Pesanan</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-1">
                                    <label>ID</label>
                                    <input type="text" name="id" class="form-control" value="{{ request('id') }}">
                                </div>
                                <div class="col-md-2">
                                    <label>Nama</label>
                                    <input type="text" name="name" class="form-control" value="{{ request('name') }}">
                                </div>

                                <div class="col-md-2">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control"
                                        value="{{ request('email') }}">
                                </div>
                                <div class="col-md-2">
                                    <label>Phone</label>
                                    <input type="text" name="phone" class="form-control"
                                        value="{{ request('phone') }}">
                                </div>
                                <div class="col-md-3">
                                    <label>Alamat</label>
                                    <input type="text" name="address" class="form-control"
                                        value="{{ request('address') }}">
                                </div>
                                <div class="col-md-2">
                                    <label>From Date</label>
                                    <input type="date" name="from_date" class="form-control"
                                        value="{{ request('from_date') }}">
                                </div>
                                <div class="col-md-2">
                                    <label>To Date</label>
                                    <input type="date" name="to_date" class="form-control"
                                        value="{{ request('to_date') }}">
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-search mr-1"></i>
                                    Cari</button>
                                <a href="{{ url('admin/orders/waiting') }}" class="btn btn-secondary"><i
                                        class="fas fa-sync-alt mr-1"></i> Reset</a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Seluruh Pemesanan</h3>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-sm">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Order Number</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Alamat</th>
                                        <th>Phone</th>
                                        <th>Total</th>
                                        <th>Kurir</th>
                                        <th>Telp Kurir</th>
                                        <th>Metode</th>
                                        <th>Bukti Bayar</th>
                                        <th>Status</th>
                                        <th>Catatan Penolakan</th>
                                        <th>Pengiriman</th>
                                        <th>Estimasi Tiba</th>
                                        <th>Created Date</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orders as $order)
                                        @php
                                            if (
                                                $order->is_payment == 2 &&
                                                $order->rejection_note == 'Dibatalkan oleh pelanggan'
                                            ) {
                                                $label = 'Dibatalkan Customer';
                                                $color = 'secondary';
                                                $icon = 'fas fa-user-slash';
                                            } else {
                                                [$label, $color, $icon] = getPaymentStatus($order->is_payment);
                                            }
                                        @endphp

                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->name }}</td>
                                            <td>{{ $order->email }}</td>
                                            <td>
                                                {{ $order->address }}<br>
                                                {{ $order->village ?? '-' }}, Kec. {{ $order->subdistrict ?? '-' }}<br>
                                                - {{ $order->postcode }}
                                            </td>
                                            <td>{{ $order->phone }}</td>
                                            <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                            <td>{{ $order->courier_name ?? '-' }}</td>
                                            <td>
                                                @if ($order->courier && $order->courier->phone)
                                                    <a
                                                        href="tel:{{ $order->courier->phone }}">{{ $order->courier->phone }}</a>
                                                @else
                                                    <span class="text-muted">Tidak ada</span>
                                                @endif
                                            </td>

                                            <td>{{ ucfirst($order->payment_method ?? '-') }}</td>
                                            <td>
                                                @if ($order->payment_proof)
                                                    <a href="{{ asset($order->payment_proof) }}" target="_blank">
                                                        <img src="{{ asset($order->payment_proof) }}" alt="Bukti Transfer"
                                                            class="img-fluid rounded shadow-sm" style="max-height: 250px;">
                                                    </a>
                                                @else
                                                    <p class="text-danger">Belum ada bukti pembayaran</p>
                                                @endif

                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $color }}">
                                                    <i class="{{ $icon }}"></i> {{ $label }}
                                                </span>
                                            </td>
                                            <td>{{ $order->rejection_note ?? '-' }}</td>
                                            <td>
                                                @if ($order->delivered_time)
                                                    {{ \Carbon\Carbon::parse($order->delivered_time)->format('d M Y') }}
                                                @else
                                                    <span class="text-muted">Belum ada</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($order->estimated_arrival)
                                                    {{ \Carbon\Carbon::parse($order->estimated_arrival)->format('d M Y') }}
                                                @else
                                                    <span class="text-muted">Belum ada</span>
                                                @endif
                                            </td>
                                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                            <td>
                                                <a href="{{ url('admin/orders/detail/' . $order->id) }}"
                                                    class="btn btn-info btn-sm mb-1">
                                                    <i class="fas fa-info-circle mr-1"></i> Detail
                                                </a>

                                                @if ($order->is_payment == 0)
                                                    <form action="{{ url('admin/orders/verify/' . $order->id) }}"
                                                        method="POST" class="d-inline-block mb-1">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm">
                                                            <i class="fas fa-check mr-1"></i> Verifikasi
                                                        </button>
                                                    </form>

                                                    <button type="button" class="btn btn-danger btn-sm mb-1"
                                                        data-toggle="modal" data-target="#rejectModal{{ $order->id }}">
                                                        <i class="fas fa-times-circle mr-1"></i> Tolak
                                                    </button>

                                                    <div class="modal fade" id="rejectModal{{ $order->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <form action="{{ url('admin/orders/reject/' . $order->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-danger text-white">
                                                                        <h5 class="modal-title" id="rejectModalLabel">
                                                                            Tolak Pembayaran</h5>
                                                                        <button type="button" class="close text-white"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Berikan alasan penolakan pembayaran:</p>
                                                                        <textarea name="rejection_reason" class="form-control" rows="3" required></textarea>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit"
                                                                            class="btn btn-danger">Tolak</button>
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Batal</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @elseif ($order->is_payment == 1)
                                                    <form action="{{ url('admin/orders/mark-done/' . $order->id) }}"
                                                        method="POST" class="d-inline-block mt-1">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-check-double mr-1"></i> Tandai Selesai
                                                        </button>
                                                    </form>

                                                    <form action="{{ url('admin/orders/cancel-verify/' . $order->id) }}"
                                                        method="POST" class="d-inline-block mt-1">
                                                        @csrf
                                                        <button type="submit" class="btn btn-warning btn-sm">
                                                            <i class="fas fa-undo mr-1"></i> Batal Verifikasi
                                                        </button>
                                                    </form>
                                                @elseif ($order->is_payment == 2)
                                                    <form action="{{ url('admin/orders/cancel-reject/' . $order->id) }}"
                                                        method="POST" class="d-inline-block">
                                                        @csrf
                                                        <button type="submit" class="btn btn-warning btn-sm">
                                                            <i class="fas fa-undo mr-1"></i> Batal Tolak
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="15" class="text-center text-muted py-4">
                                                <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                                Tidak ada pesanan menunggu verifikasi.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center mt-4">
                                {!! $orders->appends(request()->except('page'))->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
