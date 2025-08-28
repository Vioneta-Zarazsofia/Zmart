@extends('layouts.app')

@section('style')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('content')
    <main class="main">
        <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">Checkout<span>Shop</span></h1>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                </ol>
            </div>
        </nav>

        <div class="page-content">
            <div class="checkout">
                <div class="container">
                    <form action="{{ url('checkout/place_order') }}" id="SubmitForm" method="POST">
                        @csrf
                        <div class="row">
                            {{-- === FORM KIRI === --}}
                            <div class="col-lg-9">
                                <label>Nama *</label>
                                <input type="text" name="name" class="form-control" required
                                    value="{{ Auth::user()->name ?? '' }}">
                                <label>Phone *</label>
                                <input type="tel" name="phone" class="form-control" required
                                    value="{{ Auth::user()->phone ?? '' }}" placeholder="Masukkan nomor telepon aktif">

                                <label>Kecamatan *</label>
                                <select id="subdistrict" name="subdistrict" class="form-control" required>
                                    <option value="">Pilih Kecamatan</option>
                                </select>

                                <label>Kelurahan/Desa *</label>
                                <select id="village" name="village" class="form-control" required>
                                    <option value="">Pilih Kelurahan</option>
                                </select>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Alamat *</label>
                                        <input type="text" name="address" class="form-control"
                                            placeholder="Nomor rumah dan nama jalan" required
                                            value="{{ Auth::user()->address ?? '' }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Kode Pos *</label>
                                        <input type="text" name="postcode" class="form-control" required
                                            value="{{ Auth::user()->postcode ?? '' }}">
                                    </div>
                                </div>


                                <label>Email *</label>
                                <input type="email" name="email" class="form-control" required
                                    value="{{ Auth::user()->email ?? '' }}">

                                @if (!Auth::check())
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="is_create" class="custom-control-input createAccount"
                                            id="checkout-create-acc">
                                        <label class="custom-control-label" for="checkout-create-acc">Buat akun?</label>
                                    </div>

                                    <div id="showPassword" style="display: none;">
                                        <label>Password *</label>
                                        <input type="text" id="inputPassword" name="password" class="form-control">
                                    </div>
                                @endif

                                <label>Catatan pesanan (opsional)</label>
                                <textarea class="form-control" name="note" rows="4" placeholder="Contoh: Tolong kirim siang hari"></textarea>
                            </div>

                            {{-- === FORM KANAN (RINGKASAN PESANAN) === --}}
                            <aside class="col-lg-3">
                                <div class="summary">
                                    <h3 class="summary-title">Pesanan Anda</h3>

                                    <table class="table table-summary">
                                        <thead>
                                            <tr>
                                                <th>Produk</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (Cart::getContent() as $cart)
                                                @php
                                                    $product = App\Models\ProductModel::getSingle($cart->id);
                                                @endphp
                                                <tr>
                                                    <td><a href="{{ url($product->slug) }}">{{ $product->title }}</a></td>
                                                    <td>Rp{{ number_format($cart->price * $cart->quantity, 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach

                                            <tr class="summary-subtotal">
                                                <td>Subtotal:</td>
                                                <td>Rp{{ number_format(Cart::getSubTotal(), 0, ',', '.') }}</td>
                                            </tr>

                                            <tr>
                                                <td colspan="2">
                                                    <div class="cart-discount">
                                                        <div class="input-group">
                                                            <input type="text" name="discount_code" id="getDiscountCode"
                                                                class="form-control" placeholder="Discount Code">
                                                            <div class="input-group-append">
                                                                <button type="button" id="ApplyDiscount"
                                                                    class="btn btn-outline-primary-2">
                                                                    <i class="icon-long-arrow-right"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Diskon:</td>
                                                <td>Rp<span id="getDiscountAmount">0</span></td>
                                            </tr>

                                            <tr class="summary-shipping">
                                                <td>Pengiriman:</td>
                                                <td></td>
                                            </tr>
                                            @foreach ($getShipping as $shipping)
                                                <tr class="summary-shipping-row">
                                                    <td>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" name="shipping_id"
                                                                id="shipping{{ $shipping->id }}"
                                                                class="custom-control-input getShippingCharge"
                                                                data-price="{{ $shipping->price }}"
                                                                value="{{ $shipping->id }}" required>
                                                            <label class="custom-control-label"
                                                                for="shipping{{ $shipping->id }}">{{ $shipping->name }}</label>
                                                        </div>
                                                    </td>
                                                    <td>Rp{{ number_format($shipping->price, 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach

                                            <tr class="summary-total">
                                                <td>Total:</td>
                                                <td><span
                                                        id="getPayableTotal">Rp{{ number_format(Cart::getSubTotal(), 0, ',', '.') }}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <input type="hidden" id="getShippingChargeTotal" value="0">
                                    <input type="hidden" id="PayableTotal" value="{{ Cart::getSubTotal() }}">

                                    <div class="custom-control custom-radio">
                                        <input type="radio" value="cash" id="Cashondelivery" name="payment_method"
                                            required class="custom-control-input">
                                        <label class="custom-control-label" for="Cashondelivery">Cash on Delivery
                                            (COD)</label>
                                    </div>

                                    <div class="custom-control custom-radio">
                                        <input type="radio" value="bri" id="BRI" name="payment_method"
                                            required class="custom-control-input" onchange="toggleBankInfo(this)">
                                        <label class="custom-control-label" for="BRI">Transfer Bank BRI</label>
                                    </div>

                                    <div id="bank-info" style="display: none; margin-top: 10px;">
                                        <p>Silakan transfer ke rekening:</p>
                                        <ul>
                                            <li>Bank: BRI</li>
                                            <li>No. Rekening: <strong>644101008958538</strong></li>
                                            <li>Atas Nama: <strong>MALIKI</strong></li>
                                        </ul>
                                    </div>

                                    <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block mt-3">
                                        <span class="btn-text">Pesan Sekarang</span>
                                        <span class="btn-hover-text">Lanjut ke Pembayaran</span>
                                    </button>
                                </div>
                            </aside>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            const kotaNgawiId = 3521;
            const userSubdistrict = "{{ Auth::user()->subdistrict ?? '' }}";
            const userVillage = "{{ Auth::user()->village ?? '' }}";

            // Load subdistricts (kecamatan)
            $.get(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kotaNgawiId}.json`, function(
                districts) {
                $('#subdistrict').html('<option value="">Pilih Kecamatan</option>');
                districts.forEach(function(d) {
                    const selected = d.name === userSubdistrict ? 'selected' : '';
                    $('#subdistrict').append(
                        `<option value="${d.name}" data-id="${d.id}" ${selected}>${d.name}</option>`
                    );
                });

                if (userSubdistrict) {
                    const selectedId = $('#subdistrict option:selected').data('id');
                    loadVillages(selectedId, userVillage);
                }
            });

            // Event on change subdistrict
            $('#subdistrict').on('change', function() {
                const id = $(this).find(':selected').data('id');
                loadVillages(id);
            });

            // Function load villages (kelurahan)
            function loadVillages(subdistrictId, selectedVillage = '') {
                $('#village').html('<option value="">Memuat...</option>');
                if (!subdistrictId) {
                    $('#village').html('<option value="">Pilih Kelurahan</option>');
                    return;
                }

                $.get(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${subdistrictId}.json`, function(
                    villages) {
                    $('#village').html('<option value="">Pilih Kelurahan</option>');
                    villages.forEach(function(v) {
                        const selected = v.name === selectedVillage ? 'selected' : '';
                        $('#village').append(
                            `<option value="${v.name}" ${selected}>${v.name}</option>`
                        );
                    });
                });
            }

            // Toggle password saat create account
            $('.createAccount').on('click', function() {
                $('#showPassword').toggle(this.checked);
                $('#inputPassword').prop('required', this.checked);
            });

            // Hitung total setelah memilih ongkir
            $('.getShippingCharge').on('click', function() {
                const price = parseFloat($(this).data('price'));
                const subtotal = parseFloat($('#PayableTotal').val());
                const total = subtotal + price;
                $('#getPayableTotal').html('Rp' + total.toLocaleString('id-ID'));
                $('#getShippingChargeTotal').val(price);
            });

            // Apply discount
            $('#ApplyDiscount').on('click', function() {
                const code = $('#getDiscountCode').val();
                $.post("{{ url('checkout/apply_discount_code') }}", {
                    discountcode: code,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('#getDiscountAmount').html(data.discount_amount);
                    const shipping = parseFloat($('#getShippingChargeTotal').val());
                    const total = parseFloat(data.payable_total) + shipping;
                    $('#getPayableTotal').html('Rp' + total.toLocaleString('id-ID'));
                    $('#PayableTotal').val(data.payable_total);
                    if (!data.status) alert(data.message);
                }, 'json');
            });

            // Toggle info bank transfer
            window.toggleBankInfo = function(radio) {
                $('#bank-info').toggle(radio.checked);
            };
        });

        // Submit form AJAX
        $('body').delegate('#SubmitForm', 'submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: "{{ url('checkout/place_order') }}",
                data: new FormData(this),
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(data) {
                    if (data.status == false) {
                        alert(data.message);
                    } else {
                        window.location.href = data.redirect;
                    }
                },
                error: function(data) {
                    alert('Terjadi kesalahan pada server');
                }
            });
        });
    </script>
@endsection
