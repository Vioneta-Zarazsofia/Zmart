@extends('admin.layouts.app')
@section('style')
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-2 mb-3">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body d-flex align-items-center">
                                <span
                                    class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center mr-3"
                                    style="width:48px;height:48px;">
                                    <i class="fas fa-shopping-bag fa-lg"></i>
                                </span>
                                <div>
                                    <div class="small text-muted">Total Pembelian</div>
                                    <div class="h5 mb-0 font-weight-bold">{{ $TotalOrder }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-2 mb-3">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body d-flex align-items-center">
                                <span
                                    class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center mr-3"
                                    style="width:48px;height:48px;">
                                    <i class="fas fa-calendar-day fa-lg"></i>
                                </span>
                                <div>
                                    <div class="small text-muted">Pembelian Hari Ini</div>
                                    <div class="h5 mb-0 font-weight-bold">{{ $TotalTodayOrder }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-2 mb-3">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body d-flex align-items-center">
                                <span
                                    class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center mr-3"
                                    style="width:48px;height:48px;">
                                    <i class="fas fa-money-bill-wave fa-lg"></i>
                                </span>
                                <div>
                                    <div class="small text-muted">Jumlah Total</div>
                                    <div class="h5 mb-0 font-weight-bold">Rp {{ number_format($TotalAmount, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-2 mb-3">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body d-flex align-items-center">
                                <span
                                    class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mr-3"
                                    style="width:48px;height:48px;">
                                    <i class="fas fa-shopping-cart fa-lg"></i>
                                </span>
                                <div>
                                    <div class="small text-muted">Jumlah Hari Ini</div>
                                    <div class="h5 mb-0 font-weight-bold">Rp
                                        {{ number_format($TotalTodayAmount, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-2 mb-3">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body d-flex align-items-center">
                                <span
                                    class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mr-3"
                                    style="width:48px;height:48px;">
                                    <i class="fas fa-user fa-lg"></i>
                                </span>
                                <div>
                                    <div class="small text-muted">Total Customer</div>
                                    <div class="h5 mb-0 font-weight-bold">{{ $TotalCustomer }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-2 mb-3">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body d-flex align-items-center">
                                <span
                                    class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center mr-3"
                                    style="width:48px;height:48px;">
                                    <i class="fas fa-user-plus fa-lg"></i>
                                </span>
                                <div>
                                    <div class="small text-muted">Customer Hari Ini</div>
                                    <div class="h5 mb-0 font-weight-bold">{{ $TotalTodayCustomer }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Penjualan Bulanan Card -->
                        <div class="card mb-4 shadow-sm border-0">
                            <div
                                class="card-header bg-white border-0 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                                <div class="d-flex align-items-center mb-2 mb-md-0">
                                    <span
                                        class="rounded-circle bg-gradient-primary text-white d-flex align-items-center justify-content-center mr-3"
                                        style="width:44px;height:44px;">
                                        <i class="fas fa-chart-bar fa-lg"></i>
                                    </span>
                                    <h3 class="card-title mb-0 font-weight-bold text-primary">Penjualan Bulanan</h3>
                                </div>
                                <div class="ml-md-auto mt-2 mt-md-0">
                                    <select class="form-control ChangeYear" style="width: 120px; min-width: 100px;">
                                        @for ($i = 2023; $i <= date('Y'); $i++)
                                            <option {{ $year == $i ? 'selected' : '' }} value="{{ $i }}">
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="card-body pb-3">
                                <div class="row align-items-center mb-3">
                                    <div class="col-12 col-md-6 mb-2 mb-md-0">
                                        <span class="text-muted small">Total Penjualan Tahun Ini</span>
                                        <div class="h4 font-weight-bold text-success mt-1">Rp
                                            {{ number_format($TotalAmount, 0, ',', '.') }}</div>
                                    </div>

                                </div>
                                <div class="position-relative mb-2"
                                    style="background: linear-gradient(90deg, #f8fafc 0%, #e9ecef 100%); border-radius: 8px; padding: 16px;">
                                    <canvas id="sales-chart-order" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            {{-- Container untuk Grafik Pembelian Supplier --}}
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card shadow-sm border-0 mb-4">
                                        <div class="card-header d-flex justify-content-between align-items-center bg-white">
                                            <h4 class="text-primary font-weight-bold mb-0">Grafik Pembelian Produk per Bulan
                                                per Supplier - {{ $year }}</h4>
                                            <select class="form-control ChangeYear w-auto" style="min-width: 120px;">
                                                @for ($y = date('Y') - 5; $y <= date('Y'); $y++)
                                                    <option value="{{ $y }}"
                                                        {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="card-body">
                                            <div style="height: 400px;">
                                                <canvas id="supplierChart"></canvas>
                                            </div>
                                            <div class="mt-2 text-muted small">
                                                * Setiap warna mewakili kombinasi Supplier - Produk tertentu
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Tabel Detail Pembelian --}}
                                    <div class="card shadow-sm border-0">
                                        <div class="card-header bg-white border-bottom-0">
                                            <h4 class="mb-0">Detail Pembelian Produk per Bulan per Supplier</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm mb-0">
                                                    <thead class="bg-light text-dark text-center">
                                                        <tr>
                                                            <th>Bulan</th>
                                                            <th>Nama Supplier</th>
                                                            <th>Nama Produk</th>
                                                            <th>Jumlah Dibeli</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($purchaseDetail as $item)
                                                            <tr>
                                                                <td>{{ \Carbon\Carbon::create()->month($item->bulan)->locale('id')->translatedFormat('F') }}
                                                                </td>
                                                                <td>{{ $item->supplier }}</td>
                                                                <td>{{ $item->produk }}</td>
                                                                <td class="text-center">{{ $item->jumlah_dibeli }}</td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="4" class="text-center text-muted py-3">
                                                                    Tidak ada data pembelian.</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.card -->
                        <div class="card">
                            <div class="card-header border-0">
                                <h3 class="card-title">Pesanan Terbaru</h3>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-bordered mb-0 align-middle">
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
                                            @forelse ($getLatesOrders as $order)
                                                <tr>
                                                    <td>{{ $order->id }}</td>
                                                    <td>{{ $order->order_number }}</td>
                                                    <td>{{ $order->name }}</td>
                                                    <td>{{ $order->email }}</td>
                                                    <td>
                                                        {{ $order->address }}<br>
                                                        {{ $order->village ?? '-' }}, Kec.
                                                        {{ $order->subdistrict ?? '-' }}<br>
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
                                                                <img src="{{ asset($order->payment_proof) }}"
                                                                    alt="Bukti Transfer"
                                                                    class="img-fluid rounded shadow-sm"
                                                                    style="max-height: 250px;">
                                                            </a>
                                                        @else
                                                            <p class="text-danger">Belum ada bukti pembayaran</p>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (isset($order->is_done) && $order->is_done == 1)
                                                            <span class="badge badge-primary">
                                                                <i class="fas fa-check-double"></i> Selesai
                                                            </span>
                                                        @elseif ($order->is_payment == 1)
                                                            <span class="badge badge-success">
                                                                <i class="fas fa-check-circle"></i> Terverifikasi
                                                            </span>
                                                        @elseif ($order->is_payment == 2)
                                                            <span class="badge badge-danger">
                                                                <i class="fas fa-times-circle"></i> Ditolak
                                                            </span>
                                                        @else
                                                            <span class="badge badge-warning">
                                                                <i class="fas fa-clock"></i> Menunggu
                                                            </span>
                                                        @endif
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
                                                        <div class="d-flex flex-column gap-1">
                                                            <a href="{{ url('admin/orders/detail/' . $order->id) }}"
                                                                class="btn btn-info btn-sm mb-1">
                                                                <i class="fas fa-info-circle mr-1"></i> Detail
                                                            </a>
                                                            @if (!empty($order->is_done))
                                                                {{-- Selesai: tidak ada tombol lain --}}
                                                            @elseif ($order->is_payment == 0)
                                                                <form
                                                                    action="{{ url('admin/orders/verify/' . $order->id) }}"
                                                                    method="POST" class="d-inline-block mb-1">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-success btn-sm">
                                                                        <i class="fas fa-check mr-1"></i> Verifikasi
                                                                    </button>
                                                                </form>
                                                                <button type="button" class="btn btn-danger btn-sm mb-1"
                                                                    data-toggle="modal"
                                                                    data-target="#rejectModal{{ $order->id }}">
                                                                    <i class="fas fa-times-circle mr-1"></i> Tolak
                                                                </button>
                                                                <div class="modal fade"
                                                                    id="rejectModal{{ $order->id }}" tabindex="-1"
                                                                    role="dialog" aria-labelledby="rejectModalLabel"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered"
                                                                        role="document">
                                                                        <form
                                                                            action="{{ url('admin/orders/reject/' . $order->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <div class="modal-content">
                                                                                <div
                                                                                    class="modal-header bg-danger text-white">
                                                                                    <h5 class="modal-title"
                                                                                        id="rejectModalLabel">
                                                                                        Tolak Pembayaran
                                                                                    </h5>
                                                                                    <button type="button"
                                                                                        class="close text-white"
                                                                                        data-dismiss="modal"
                                                                                        aria-label="Close">
                                                                                        <span
                                                                                            aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <p>Berikan alasan penolakan pembayaran:
                                                                                    </p>
                                                                                    <textarea name="rejection_reason" class="form-control" rows="3" required></textarea>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="submit"
                                                                                        class="btn btn-danger">Tolak</button>
                                                                                    <button type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-dismiss="modal">Batal</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            @elseif ($order->is_payment == 1)
                                                                <form
                                                                    action="{{ url('admin/orders/mark-done/' . $order->id) }}"
                                                                    method="POST" class="d-inline-block mt-1">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                                        <i class="fas fa-check-double mr-1"></i> Tandai
                                                                        Selesai
                                                                    </button>
                                                                </form>
                                                                <form
                                                                    action="{{ url('admin/orders/cancel-verify/' . $order->id) }}"
                                                                    method="POST" class="d-inline-block mt-1">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-warning btn-sm">
                                                                        <i class="fas fa-undo mr-1"></i> Batal Verifikasi
                                                                    </button>
                                                                </form>
                                                            @elseif ($order->is_payment == 2)
                                                                <form
                                                                    action="{{ url('admin/orders/cancel-reject/' . $order->id) }}"
                                                                    method="POST" class="d-inline-block">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-warning btn-sm">
                                                                        <i class="fas fa-undo mr-1"></i> Batal Tolak
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="17" class="text-center text-muted py-4">
                                                        <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                                        Tidak ada pesanan menunggu verifikasi.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection
@section('script')
    <script>
        $('.ChangeYear').change(function() {
            var year = $(this).val();
            window.location.href = "{{ url('admin/dashboard') }}?year=" + year;
        });
        // Chart Pembelian Produk per Bulan per Supplier
        const purchaseData = @json($purchasePerMonth);

        // Ambil bulan unik
        const months = [...new Set(purchaseData.map(item => item.bulan))];

        // Buat kombinasi supplier + produk
        const suppliers = [...new Set(purchaseData.map(item =>
            (item.supplier_name ?? '') + ' - ' + (item.product_name ?? '')
        ))];

        const colors = ['#007bff', '#dc3545', '#ffc107', '#28a745', '#6f42c1',
            '#fd7e14', '#20c997', '#6610f2', '#17a2b8', '#e83e8c'
        ];

        const datasets = suppliers.map((supplier, index) => {
            const monthlyData = Array(12).fill(0);

            purchaseData.forEach(item => {
                const key = (item.supplier_name ?? '') + ' - ' + (item.product_name ?? '');
                if (key === supplier) {
                    const monthIndex = parseInt(item.bulan.split('-')[1]) - 1;
                    monthlyData[monthIndex] = parseFloat(item.total_qty ?? 0);
                }
            });

            return {
                label: supplier,
                data: monthlyData,
                backgroundColor: colors[index % colors.length],
                borderWidth: 1
            };
        });


        const ctx = document.getElementById('supplierChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                    'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
                ],
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const val = context.raw || 0;
                                return val.toLocaleString('id-ID') + ' pcs'; // contoh: 141 pcs
                            }
                        }
                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('id-ID') + ' pcs';
                            }
                        }
                    }
                }
            }

        });


        var $salesChart = $('#sales-chart-order');

        var salesChart = new Chart($salesChart, {
            type: 'bar',
            data: {
                labels: [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ],
                datasets: [{
                        label: 'Customer',
                        backgroundColor: '#007bff',
                        borderColor: '#007bff',
                        borderWidth: 2,
                        data: [{{ $getTotalCustomerMonth }}],
                        barPercentage: 0.8,
                        categoryPercentage: 0.7
                    },
                    {
                        label: 'Pesanan',
                        backgroundColor: '#6c757d',
                        borderColor: '#6c757d',
                        borderWidth: 2,
                        data: [{{ $getTotalOrderMonth }}],
                        barPercentage: 0.8,
                        categoryPercentage: 0.7
                    },
                    {
                        label: 'Jumlah (Rp)',
                        backgroundColor: '#dc3545',
                        borderColor: '#dc3545',
                        borderWidth: 2,
                        data: [{{ $getTotalOrderAmountMonth }}],
                        barPercentage: 0.8,
                        categoryPercentage: 0.7
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                tooltips: {
                    mode: 'index',
                    intersect: false
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                legend: {
                    display: true
                },
                scales: {
                    xAxes: [{
                        stacked: false,
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            fontColor: '#495057',
                            fontStyle: 'bold'
                        }
                    }],
                    yAxes: [{
                        stacked: false,
                        gridLines: {
                            display: true,
                            color: 'rgba(0, 0, 0, .1)',
                            zeroLineColor: 'transparent'
                        },
                        ticks: {
                            beginAtZero: true,
                            fontColor: '#495057',
                            fontStyle: 'bold',
                            callback: function(value) {
                                if (value >= 1000000) return 'Rp ' + value / 1000000 + ' jt';
                                if (value >= 1000) return 'Rp ' + value / 1000 + ' rb';
                                return 'Rp ' + value;
                            }
                        }
                    }]
                }
            }
        });
    </script>
@endsection
