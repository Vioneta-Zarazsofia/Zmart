@extends('layouts.app')

@section('style')
    @include('page.faq-style')
@endsection

@section('content')
    <main class="main">
        <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Metode Pembayaran</li>
                </ol>
            </div>
        </nav>

        <div class="container faq-section">
            <h2 class="text-center mb-4 fw-bold">Metode Pembayaran</h2>

            <p class="text-center mb-4" style="font-size: 1.2rem; color: #555;">
                Kami menyediakan 2 metode pembayaran yang praktis dan aman. Silakan pilih yang sesuai dengan preferensi
                Anda.
            </p>

            <div class="accordion-faq">
                <div class="accordion-faq-item">
                    <div class="accordion-faq-header">
                        <span>Transfer Bank (Manual)</span>
                        <span class="arrow">
                            <svg fill="#555" viewBox="0 0 24 24">
                                <path d="M12 15.5L5 8.5l1.4-1.4L12 12.7l5.6-5.6L19 8.5z" />
                            </svg>
                        </span>
                    </div>
                    <div class="accordion-faq-body">
                        Silakan transfer ke rekening berikut:<br><br>
                        <strong>Bank BRI</strong><br>
                        No. Rekening: <strong>6441 0101 7045 534</strong><br>
                        Atas Nama: <strong>VIONETA ZARAZSOFIA</strong><br><br>
                        Kirim bukti pembayaran melalui halaman konfirmasi pembayaran.
                    </div>
                </div>

                <div class="accordion-faq-item">
                    <div class="accordion-faq-header">
                        <span>Cash on Delivery (COD)</span>
                        <span class="arrow">
                            <svg fill="#555" viewBox="0 0 24 24">
                                <path d="M12 15.5L5 8.5l1.4-1.4L12 12.7l5.6-5.6L19 8.5z" />
                            </svg>
                        </span>
                    </div>
                    <div class="accordion-faq-body">
                        Bayar langsung saat barang tiba di lokasi Anda. Harap pastikan nomor telepon aktif untuk memudahkan
                        komunikasi dengan kurir.
                    </div>
                </div>
            </div>
        </div>

        <div class="cta cta-display bg-image pt-4 pb-4"
            style="background-image: url('{{ asset('assets ecom/images/backgrounds/cta/bg-7.jpg') }}');">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-9 col-xl-7">
                        <div class="row no-gutters flex-column flex-sm-row align-items-sm-center">
                            <div class="col">
                                <h3 class="cta-title text-white">Ada pertanyaan mengenai pembayaran?</h3>
                                <p class="cta-desc text-white">Hubungi tim kami sekarang juga melalui tombol Contact Us di
                                    samping.</p>
                            </div>
                            <div class="col-auto">
                                <a href="{{ url('contact') }}" target="_blank" class="btn btn-outline-white">
                                    <span>Contact Us</span>
                                    <i class="icon-long-arrow-right"></i>
                                </a>
                            </div><!-- End .col-auto -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    @include('page.faq-script')
@endsection
