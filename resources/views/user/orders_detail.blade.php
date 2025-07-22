@extends('layouts.app')

@section('style')
    <style>
        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 0.5rem;
            color: #333;
        }

        .card-custom {
            border: 1px solid #e6e6e6;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        .card-header-custom {
            background: #f8f9fa;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #e6e6e6;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
        }

        .badge-success {
            background-color: #28a745;
            color: #fff;
            padding: 4px 10px;
            border-radius: 5px;
            font-size: 0.8rem;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
            padding: 4px 10px;
            border-radius: 5px;
            font-size: 0.8rem;
        }

        .badge-danger {
            background-color: #dc3545;
            color: #fff;
            padding: 4px 10px;
            border-radius: 5px;
            font-size: 0.8rem;
        }

        .table td,
        .table th {
            vertical-align: middle !important;
        }

        .table th {
            background: #f1f1f1;
        }
    </style>
@endsection

@section('content')
    <main class="main">
        <div class="page-header text-center py-4">
            <div class="container">
                <h1 class="page-title">🧾 Detail Pemesanan</h1>
            </div>
        </div>
        <br />

        <div class="page-content pb-5">
            <div class="container">
                <div class="row g-4">
                    {{-- Sidebar --}}
                    @include('user._sidebar')

                    <div class="col-md-8 col-lg-9">
                        {{-- Informasi Pembeli & Kurir --}}
                        @include('layouts._message')
                        <div class="row g-4">
                            {{-- Informasi Pembeli --}}
                            {{-- Informasi Pembeli --}}
                            <div class="col-md-6">
                                <div class="card-custom">
                                    <div class="card-header-custom" style="font-size: 1.8rem;">👤 Informasi Pembeli</div>
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
                                <div class="card-custom">
                                    <div class="card-header-custom" style="font-size: 1.8rem;">📦 Informasi Kurir</div>
                                    <div class="card-body p-3">
                                        <p><strong>Kurir:</strong> {{ $order->courier_name ?? 'Belum tersedia' }}</p>
                                        <strong>No. Telp Kurir:</strong>
                                        @if ($order->courier && $order->courier->phone)
                                            {{ $order->courier->phone }}
                                        @else
                                            <span class="text-muted">Belum tersedia</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Informasi Penolakan --}}
                            @if (in_array($order->is_payment, [2, 4]))
                                <div class="col-md-12"> {{-- gunakan col-md-12 jika ingin full width, atau col-md-6 jika ingin setengah --}}
                                    <div class="card-custom">
                                        <div class="card-header-custom" style="font-size: 1.8rem;">📦 Informasi Penolakan
                                        </div>
                                        <div class="card-body p-3">
                                            <p><strong>Catatan Penolakan:</strong> {{ $order->rejection_note ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Ringkasan Pesanan --}}
                        <div class="card-custom mb-4">
                            <div class="card-header-custom" style="font-size: 1.8rem;">📊 Ringkasan Pesanan</div>
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>ID Transaksi:</strong> {{ $order->order_number }}</p>
                                        <p><strong>Metode Pembayaran:</strong> {{ ucfirst($order->payment_method) }}</p>
                                        <p><strong>Status Pemesanan:</strong>
                                            @switch($order->is_payment)
                                                @case(1)
                                                    <span class="badge-success">✔ Terverifikasi</span>
                                                    @if ($order->is_done)
                                                        <span class="badge badge-primary">✅ Selesai</span>
                                                    @endif
                                                @break

                                                @case(2)
                                                    <span class="badge-danger">❌ Ditolak Admin</span>
                                                @break

                                                @case(3)
                                                    <span class="badge badge-primary">✅ Selesai</span>
                                                @break

                                                @case(4)
                                                    <span class="badge badge-dark text-white">🚫 Dibatalkan</span>
                                                @break

                                                @default
                                                    <span class="badge-warning">⏳ Menunggu</span>
                                            @endswitch
                                        </p>
                                        <p><strong>Catatan Produk:</strong> {{ $order->note ?? '-' }}</p>
                                        @if ($order->is_payment == 2)
                                            <p><strong>Alasan Penolakan:</strong> {{ $order->rejection_note ?? '-' }}</p>
                                        @endif
                                        <p><strong>Ongkir:</strong> Rp
                                            {{ number_format($order->shipping_amount, 0, ',', '.') }}</p>
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

                        {{-- Produk --}}
                        <div class="card-custom mb-4">
                            <div class="card-header-custom" style="font-size: 1.8rem;">🛍️ Detail Produk</div>
                            <div class="card-body table-responsive p-3">
                                <table class="table table-bordered text-center align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Gambar</th>
                                            <th>Nama Produk</th>
                                            <th>Qty</th>
                                            <th>Harga/Dus</th>
                                            @if ($order->is_payment == 3)
                                                <th>Review</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($order->items as $item)
                                            @php
                                                $product = $item->product;
                                                $imageUrl =
                                                    $product?->getImageSingle($product->id)?->getLogo() ??
                                                    asset('images/default.png');
                                            @endphp
                                            <tr>
                                                <td>
                                                    <img src="{{ $imageUrl }}"
                                                        style="max-width: 140px; margin: 0 12px;" class="img-thumbnail">
                                                </td>
                                                <td class="text-start">
                                                    <strong>{{ $product->title ?? 'Produk tidak ditemukan' }}</strong><br>
                                                    <a href="{{ url($product->slug ?? '#') }}"
                                                        class="text-muted small">Lihat Produk</a>
                                                </td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                                @if ($order->is_payment == 3)
                                                    <td>
                                                        @if ($product)
                                                            @php
                                                                $getReview = $item->getReview($product->id, $order->id);
                                                            @endphp

                                                            @if ($getReview)
                                                                Rating: {{ $getReview->rating }}<br>
                                                                Review: {{ $getReview->review }}
                                                            @else
                                                                <button class="btn btn-sm btn-primary MakeReview"
                                                                    id="{{ $product->id }}"
                                                                    data-order="{{ $order->id }}"
                                                                    style="padding: 6px 18px; font-size: 1rem; min-width: unset; width: auto;">
                                                                    ✍️ Review
                                                                </button>
                                                            @endif
                                                        @else
                                                            <span class="text-muted">Produk tidak tersedia</span>
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="{{ $order->is_payment == 3 ? 5 : 4 }}" class="text-muted">
                                                    Tidak ada produk</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>



                        {{-- Waktu Proses --}}
                        <div class="card-custom">
                            <div class="card-header-custom" style="font-size: 1.8rem;">🕒 Waktu Proses</div>
                            <div class="card-body row p-3">
                                @php
                                    $times = [
                                        'Dibuat' => $order->created_at,
                                        'Deadline Pembayaran' => $order->payment_deadline,
                                        'Waktu Pembayaran' => $order->paid_at,
                                        'Estimasi Tiba' => $order->estimated_arrival,
                                        'Dikirim' => $order->delivered_time,
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
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Modal -->
    {{-- Modal Review --}}
    <div class="modal fade" id="MakeReviewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ url('user/make-review') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Berikan Review</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body" style="padding: 20px;">
                        <input type="hidden" id="getProductId" name="product_id">
                        <input type="hidden" id="getOrderId" name="order_id">

                        <div class="form-group mb-3">
                            <label>Rating *</label>
                            <select class="form-control" name="rating" required>
                                <option value="" disabled selected>Pilih rating</option>
                                <option value="1">1 Bintang</option>
                                <option value="2">2 Bintang</option>
                                <option value="3">3 Bintang</option>
                                <option value="4">4 Bintang</option>
                                <option value="5">5 Bintang</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Review</label>
                            <textarea class="form-control" name="review" required rows="4" placeholder="Tulis review Anda..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('body').on('click', '.MakeReview', function() {
            var product_id = $(this).attr('id');
            var order_id = $(this).data('order');

            $('#getProductId').val(product_id);
            $('#getOrderId').val(order_id);

            $('#MakeReviewModal').modal('show');
        });
    </script>
@endsection
