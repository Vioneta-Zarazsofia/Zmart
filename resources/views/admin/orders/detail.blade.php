@extends('admin.layouts.app')

@section('content')
    <style>
        .card-custom {
            border: 1px solid #e3e6f0;
            border-radius: 0.5rem;
            background: #fff;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .card-header-custom {
            background: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            padding: 1rem 1.25rem;
            font-weight: 600;
            border-radius: 0.5rem 0.5rem 0 0;
        }

        .badge-success {
            background: #28a745;
            color: #fff;
        }

        .badge-danger {
            background: #dc3545;
            color: #fff;
        }

        .badge-warning {
            background: #ffc107;
            color: #212529;
        }

        .badge-dark {
            background: #343a40;
            color: #fff;
        }

        .badge-primary {
            background: #007bff;
            color: #fff;
        }

        .table thead th {
            vertical-align: middle;
        }
    </style>
    <div class="content-wrapper">
        <section class="content-header mb-4">
            <div class="container-fluid">
                <h1 class="mb-2">📦 Detail Pesanan <small class="text-muted">#{{ $order->id }}</small></h1>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                @include('admin.layouts._message')

                <div class="row g-4">
                    {{-- Informasi Pembeli --}}
                    <div class="col-md-6">
                        <div class="card-custom h-100">
                            <div class="card-header-custom bg-primary text-white" style="font-size: 1.2rem;">👤 Informasi
                                Pembeli</div>
                            <div class="card-body p-3">
                                <p><strong>Nama:</strong> {{ $order->name }}</p>
                                <p><strong>Email:</strong> {{ $order->email }}</p>
                                <p><strong>Telp:</strong> {{ $order->phone }}</p>
                                <p><strong>Alamat:</strong><br>
                                    {{ $order->address }}<br>
                                    {{ $order->village ?? '-' }}, Kec. {{ $order->subdistrict ?? '-' }}<br>
                                    - {{ $order->postcode }}
                                </p>
                            </div>
                        </div>
                    </div>
                    {{-- Informasi Kurir --}}
                    <div class="col-md-6">
                        <div class="card-custom h-100">
                            <div class="card-header-custom bg-info text-white" style="font-size: 1.2rem;">🚚 Informasi Kurir
                            </div>
                            <div class="card-body p-3">
                                <p><strong>Kurir:</strong> {{ $order->courier_name ?? 'Belum tersedia' }}</p>
                                <p><strong>No. Telp Kurir:</strong>
                                    @if ($order->courier && $order->courier->phone)
                                        {{ $order->courier->phone }}
                                    @else
                                        <span class="text-muted">Belum tersedia</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <br />
                    {{-- Informasi Penolakan --}}
                    @if (in_array($order->is_payment, [2, 4]))
                        <div class="col-md-12">
                            <div class="card-custom">
                                <div class="card-header-custom bg-danger text-white" style="font-size: 1.2rem;">❗ Informasi
                                    Penolakan</div>
                                <div class="card-body p-3">
                                    <p><strong>Catatan Penolakan:</strong> {{ $order->rejection_note ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <br />

                {{-- Ringkasan Pesanan --}}
                <div class="card-custom mb-4">
                    <div class="card-header-custom bg-info text-white" style="font-size: 1.2rem;">📊 Ringkasan Pesanan</div>
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>ID Transaksi:</strong> {{ $order->order_number }}</p>
                                <p><strong>Metode Pembayaran:</strong> {{ ucfirst($order->payment_method) }}</p>
                                <p><strong>Status Pemesanan:</strong>
                                    @switch($order->is_payment)
                                        @case(1)
                                            <span class="badge badge-success">✔ Terverifikasi</span>
                                            @if ($order->is_done)
                                                <span class="badge badge-primary">✅ Selesai</span>
                                            @endif
                                        @break

                                        @case(2)
                                            <span class="badge badge-danger">❌ Ditolak Admin</span>
                                        @break

                                        @case(3)
                                            <span class="badge badge-primary">✅ Selesai</span>
                                        @break

                                        @case(4)
                                            <span class="badge badge-dark">🚫 Dibatalkan</span>
                                        @break

                                        @default
                                            <span class="badge badge-warning">⏳ Menunggu</span>
                                    @endswitch
                                </p>
                                <p><strong>Catatan Produk:</strong> {{ $order->note ?? '-' }}</p>
                                @if ($order->is_payment == 2)
                                    <p><strong>Alasan Penolakan:</strong> {{ $order->rejection_note ?? '-' }}</p>
                                @endif
                                <p><strong>Ongkir:</strong> Rp {{ number_format($order->shipping_amount, 0, ',', '.') }}
                                </p>
                                <p><strong>Diskon:</strong> Rp
                                    {{ number_format($order->discount_amount ?? 0, 0, ',', '.') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Total Pembayaran:</strong> <span class="fs-5 text-success">Rp
                                        {{ number_format($order->total_amount, 0, ',', '.') }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Update Kurir --}}
                @if (empty($order->is_done) && $order->is_payment != 4 && $order->is_payment != 2)
                    <div class="card-custom mb-4">
                        <div class="card-header-custom bg-warning" style="font-size: 1.2rem;">
                            <i class="fas fa-shipping-fast"></i> Update Pengiriman & Verifikasi
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ url('admin/orders/update-shipping/' . $order->id) }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label>Kurir</label>
                                        <select name="courier_id" class="form-control" required>
                                            <option value="" disabled selected>Pilih Kurir</option>
                                            @foreach ($couriers as $courier)
                                                <option value="{{ $courier->id }}"
                                                    {{ $order->courier_id == $courier->id ? 'selected' : '' }}
                                                    {{ $courier->total_barang >= 80 ? 'disabled' : '' }}>
                                                    {{ $courier->name }} - {{ $courier->total_barang }} barang hari ini
                                                    {{ $courier->total_barang >= 80 ? '(Penuh)' : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label>Tanggal Pengiriman</label>
                                        <input type="date" name="delivered_time" class="form-control"
                                            value="{{ old('delivered_time', optional($order->delivered_time)->format('Y-m-d')) }}"
                                            required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Estimasi Tiba</label>
                                        <input type="date" name="estimated_arrival" class="form-control"
                                            value="{{ old('estimated_arrival', optional($order->estimated_arrival)->format('Y-m-d')) }}"
                                            required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success mt-2">
                                    <i class="fas fa-save mr-1"></i> Update & Verifikasi Sekarang
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
                {{-- Total Barang Dibawa per Kurir Hari Ini --}}
                <div class="card-custom mb-4">
                    <div class="card-header-custom bg-primary text-white" style="font-size: 1.2rem;">
                        📦 Total Barang Dibawa Kurir Hari Ini
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover align-middle text-sm">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th>Nama Kurir</th>
                                    <th>Total Barang (Qty)</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($couriers as $courier)
                                    <tr class="text-center align-middle">
                                        <td>{{ $courier->name }}</td>
                                        <td>{{ $courier->total_barang }}</td>
                                        <td>
                                            @if ($courier->total_barang >= 80)
                                                <span class="badge badge-danger">Maksimal (80)</span>
                                            @else
                                                <span class="badge badge-success">Tersedia</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Tidak ada data
                                            kurir.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Detail Produk --}}
                <div class="card-custom mb-4">
                    <div class="card-header-custom bg-success text-white" style="font-size: 1.2rem;">
                        <i class="fas fa-shopping-cart"></i> Detail Produk
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover align-middle text-sm">
                            <thead class="table-success text-center">
                                <tr>
                                    <th style="width: 120px;">Gambar</th>
                                    <th>Nama Produk</th>
                                    <th>Qty</th>
                                    <th>Harga / Dus</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($order->items as $item)
                                    @php
                                        $product = $item->product;
                                        $productImage = $product?->getImageSingle($product->id);
                                        $imageUrl = $productImage?->getLogo() ?? asset('images/default.png');
                                    @endphp
                                    <tr class="text-center align-middle">
                                        <td>
                                            <img src="{{ $imageUrl }}" alt="Gambar Produk" class="img-thumbnail"
                                                style="max-width: 100px;">
                                        </td>
                                        <td class="text-start">
                                            <strong>{{ $product->title ?? 'Produk tidak ditemukan' }}</strong><br>
                                            <a href="{{ url($product->slug ?? '#') }}" target="_blank"
                                                class="text-muted text-decoration-underline">
                                                Lihat Produk
                                            </a>
                                        </td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-box-open fa-2x mb-2"></i><br>
                                            Tidak ada produk dalam pesanan ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Waktu Proses --}}
                <div class="card-custom mb-4">
                    <div class="card-header-custom bg-secondary text-white" style="font-size: 1.2rem;">
                        <i class="fas fa-clock"></i> Waktu Proses
                    </div>
                    <div class="card-body row">
                        @php
                            $times = [
                                'Dibuat' => $order->created_at,
                                'Deadline Pembayaran' => $order->payment_deadline,
                                'Waktu Pembayaran' => $order->paid_at,
                                'Dikirim' => $order->delivered_time,
                                'Estimasi Tiba' => $order->estimated_arrival,
                                'Selesai' => $order->completed_time,
                                'Update Terakhir' => $order->updated_at,
                            ];
                        @endphp

                        @foreach ($times as $label => $value)
                            <div class="col-md-6 mb-2">
                                <strong>{{ $label }}:</strong><br>
                                {{ $value ? \Carbon\Carbon::parse($value)->format('d-m-Y H:i') : '-' }}
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Tombol Kembali --}}
                <div class="text-end mt-4 mb-5">
                    <a href="{{ url('admin/orders/waiting') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
