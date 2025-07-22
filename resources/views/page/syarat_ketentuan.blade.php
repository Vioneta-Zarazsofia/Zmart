@extends('layouts.app')

@section('style')
    @include('page.faq-style')
@endsection

@section('content')
    <main class="main">
        @include('page.faq-breadcrumb', ['title' => 'Syarat & Ketentuan'])

        <div class="container faq-section">
            <h2 class="text-center mb-4 fw-bold">Syarat & Ketentuan</h2>

            <p class="text-center mb-4" style="font-size: 1.2rem; color: #555;">
                Ketentuan ini mengatur penggunaan layanan kami dan berlaku untuk seluruh pengguna.
            </p>

            <div class="accordion-faq">
                <div class="accordion-faq-item">
                    <div class="accordion-faq-header">
                        <span>Informasi Produk</span>
                        <span class="arrow">@include('page.faq-arrow')</span>
                    </div>
                    <div class="accordion-faq-body">
                        Informasi produk dapat berubah sewaktu-waktu. Pastikan Anda membaca detail dengan teliti sebelum melakukan pemesanan.
                    </div>
                </div>
                <div class="accordion-faq-item">
                    <div class="accordion-faq-header">
                        <span>Ketepatan Data Pelanggan</span>
                        <span class="arrow">@include('page.faq-arrow')</span>
                    </div>
                    <div class="accordion-faq-body">
                        Pelanggan bertanggung jawab atas data yang diinput, termasuk nama, alamat, dan nomor telepon.
                    </div>
                </div>
                <div class="accordion-faq-item">
                    <div class="accordion-faq-header">
                        <span>Pembatalan Pesanan</span>
                        <span class="arrow">@include('page.faq-arrow')</span>
                    </div>
                    <div class="accordion-faq-body">
                        Kami berhak membatalkan pesanan jika terjadi kesalahan sistem, kecurangan, atau pelanggaran kebijakan.
                    </div>
                </div>
            </div>
        </div>

        @include('page.faq-cta')
    </main>
@endsection

@section('script')
    @include('page.faq-script')
@endsection
