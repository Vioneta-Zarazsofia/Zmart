@extends('layouts.app')

@section('style')
    @include('page.faq-style')
@endsection

@section('content')
    <main class="main">
        @include('page.faq-breadcrumb', ['title' => 'Kebijakan Privasi'])

        <div class="container faq-section">
            <h2 class="text-center mb-4 fw-bold">Kebijakan Privasi</h2>

            <p class="text-center mb-4" style="font-size: 1.2rem; color: #555;">
                Kami menjaga dan melindungi privasi data Anda sebagai pengguna.
            </p>

            <div class="accordion-faq">
                <div class="accordion-faq-item">
                    <div class="accordion-faq-header">
                        <span>Pengumpulan Data</span>
                        <span class="arrow">@include('page.faq-arrow')</span>
                    </div>
                    <div class="accordion-faq-body">
                        Data yang kami kumpulkan digunakan untuk proses transaksi dan layanan pelanggan.
                    </div>
                </div>
                <div class="accordion-faq-item">
                    <div class="accordion-faq-header">
                        <span>Keamanan Data</span>
                        <span class="arrow">@include('page.faq-arrow')</span>
                    </div>
                    <div class="accordion-faq-body">
                        Informasi Anda disimpan dengan sistem yang aman dan tidak dibagikan ke pihak ketiga tanpa izin.
                    </div>
                </div>
                <div class="accordion-faq-item">
                    <div class="accordion-faq-header">
                        <span>Hak Akses</span>
                        <span class="arrow">@include('page.faq-arrow')</span>
                    </div>
                    <div class="accordion-faq-body">
                        Anda dapat meminta penghapusan atau pembaruan data pribadi kapan saja melalui CS kami.
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
