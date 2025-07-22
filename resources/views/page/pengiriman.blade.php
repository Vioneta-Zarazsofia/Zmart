@extends('layouts.app')

@section('style')
    @include('page.faq-style')
@endsection

@section('content')
    <main class="main">
        @include('page.faq-breadcrumb', ['title' => 'Pengiriman'])

        <div class="container faq-section">
            <h2 class="text-center mb-4 fw-bold">Informasi Pengiriman</h2>

            <p class="text-center mb-4" style="font-size: 1.2rem; color: #555;">
                Kami menyediakan 3 jenis layanan pengiriman langsung oleh kurir Bukit Zaitun.
            </p>

            <div class="accordion-faq">
                <div class="accordion-faq-item">
                    <div class="accordion-faq-header">
                        <span>Express</span>
                        <span class="arrow">@include('page.faq-arrow')</span>
                    </div>
                    <div class="accordion-faq-body">
                        Estimasi waktu pengiriman: <strong>1-2 hari kerja</strong>. Prioritas utama kami dengan waktu
                        tercepat.
                    </div>
                </div>
                <div class="accordion-faq-item">
                    <div class="accordion-faq-header">
                        <span>Prioritas</span>
                        <span class="arrow">@include('page.faq-arrow')</span>
                    </div>
                    <div class="accordion-faq-body">
                        Estimasi waktu pengiriman: <strong>2-3 hari kerja</strong>. Opsi cepat dengan tarif lebih terjangkau
                        dari Express.
                    </div>
                </div>
                <div class="accordion-faq-item">
                    <div class="accordion-faq-header">
                        <span>Standar</span>
                        <span class="arrow">@include('page.faq-arrow')</span>
                    </div>
                    <div class="accordion-faq-body">
                        Estimasi waktu pengiriman: <strong>3-5 hari kerja</strong>. Opsi hemat untuk wilayah yang lebih
                        luas.
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
