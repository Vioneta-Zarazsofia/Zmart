@extends('layouts.app')

@section('style')
    @include('page.faq-style')
@endsection

@section('content')
    <main class="main">
        @include('page.faq-breadcrumb', ['title' => 'Pengembalian'])

        <div class="container faq-section">
            <h2 class="text-center mb-4 fw-bold">Kebijakan Pengembalian</h2>

            <p class="text-center mb-4" style="font-size: 1.2rem; color: #555;">
                Kami menerima pengembalian dalam kondisi tertentu untuk memastikan kepuasan pelanggan.
            </p>

            <div class="accordion-faq">
                <div class="accordion-faq-item">
                    <div class="accordion-faq-header">
                        <span>Kapan saya bisa melakukan pengembalian?</span>
                        <span class="arrow">@include('page.faq-arrow')</span>
                    </div>
                    <div class="accordion-faq-body">
                        Jika produk yang diterima rusak atau tidak sesuai pesanan, pengembalian dapat dilakukan maksimal <strong>2x24 jam</strong> setelah barang diterima.
                    </div>
                </div>
                <div class="accordion-faq-item">
                    <div class="accordion-faq-header">
                        <span>Bagaimana prosedur pengembalian?</span>
                        <span class="arrow">@include('page.faq-arrow')</span>
                    </div>
                    <div class="accordion-faq-body">
                        1. Hubungi CS kami via WhatsApp<br>
                        2. Kirimkan foto produk dan bukti pembelian<br>
                        3. Kami akan memverifikasi dan mengatur proses penjemputan/pengembalian.
                    </div>
                </div>
                <div class="accordion-faq-item">
                    <div class="accordion-faq-header">
                        <span>Apa saja syaratnya?</span>
                        <span class="arrow">@include('page.faq-arrow')</span>
                    </div>
                    <div class="accordion-faq-body">
                        Produk harus dalam kondisi seperti saat diterima. Pengembalian tidak berlaku untuk kerusakan akibat kesalahan penggunaan.
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
