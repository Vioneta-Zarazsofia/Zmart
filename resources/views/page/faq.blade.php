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
                    <li class="breadcrumb-item active" aria-current="page">FAQ</li>
                </ol>
            </div>
        </nav>

        <div class="container faq-section">
            <h2 class="text-center mb-4 fw-bold">Frequently Asked Questions</h2>

            <p class="text-center mb-4" style="font-size: 1.2rem; color: #555;">
                Di sini Anda dapat menemukan jawaban atas pertanyaan umum yang sering diajukan oleh pelanggan kami.
                Jika Anda tidak menemukan jawaban yang Anda cari, silakan hubungi kami melalui WhatsApp.
            </p>

            <div class="accordion-faq">
                @foreach ($faqs as $faq)
                    <div class="accordion-faq-item">
                        <div class="accordion-faq-header">
                            <span>{{ $faq->question }}</span>
                            <span class="arrow">
                                <svg fill="#555" viewBox="0 0 24 24">
                                    <path d="M12 15.5L5 8.5l1.4-1.4L12 12.7l5.6-5.6L19 8.5z" />
                                </svg>
                            </span>
                        </div>
                        <div class="accordion-faq-body">
                            {!! nl2br(e($faq->answer)) !!}
                        </div>
                    </div>
                @endforeach

                @if ($faqs->isEmpty())
                    <div class="alert alert-info text-center">Belum ada FAQ yang tersedia.</div>
                @endif
            </div>
        </div>
        <div class="cta cta-display bg-image pt-4 pb-4"
            style="background-image: url('{{ asset('assets ecom/images/backgrounds/cta/bg-7.jpg') }}');">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-9 col-xl-7">
                        <div class="row no-gutters flex-column flex-sm-row align-items-sm-center">
                            <div class="col">
                                <h3 class="cta-title text-white">Jika Anda Memiliki Pertanyaan Lain</h3>
                                <!-- End .cta-title -->
                                <p class="cta-desc text-white">Silakan hubungi kami untuk informasi lebih lanjut.</p>
                                <!-- End .cta-desc -->
                            </div><!-- End .col -->

                            <div class="col-auto">
                                <a href="{{ url('contact') }}" target="_blank" class="btn btn-outline-white">
                                    <span>Contact Us</span>
                                    <i class="icon-long-arrow-right"></i>
                                </a>
                            </div><!-- End .col-auto -->
                        </div><!-- End .row no-gutters -->
                    </div><!-- End .col-md-10 col-lg-9 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .cta -->
    </main>
@endsection

@section('script')
    @include('page.faq-script')
@endsection
