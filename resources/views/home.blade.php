@extends('layouts.app')

@section('content')
    <main class="main">

        {{-- Produk --}}
        <div class="page-content my-5">
            <div class="container">
            <div class="products mb-5">
                <div class="row justify-content-center mb-4 align-items-center">
                <div class="col-md-8">
                    <h1 class="title text-left mb-0" style="font-size:2.5rem;">Produk Terbaru</h1>
                </div>
                <div class="col-md-4 text-md-end mt-2 mt-md-0">
                    <span class="text-muted">Produk-produk terbaru kami tersedia di sini!</span>
                </div>
                </div>
                    <div class="row g-4 justify-content-center">
                        @foreach ($products as $value)
                            @php
                                $getProductImage = $value->getImageSingle($value->id);
                            @endphp
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
                                <div class="product product-7 text-center shadow-sm rounded-4 w-100 h-100 bg-white p-3 position-relative"
                                    style="transition: box-shadow 0.2s;">
                                    <figure class="product-media mb-3" style="overflow:hidden; border-radius:12px;">
                                        <a href="{{ url($value->slug) }}">
                                            @if (!empty($getProductImage) && !empty($getProductImage->getLogo()))
                                                <img style="height:200px; width:100%; object-fit:cover; transition:transform 0.3s;"
                                                    class="product-image" src="{{ $getProductImage->getLogo() }}"
                                                    alt="{{ $value->title }}">
                                            @else
                                                <img style="height:200px; width:100%; object-fit:cover; transition:transform 0.3s;"
                                                    class="product-image"
                                                    src="{{ asset('assets ecom/images/no-image.png') }}" alt="No Image">
                                            @endif
                                        </a>
                                        <div class="product-action-vertical">
                                            @if (Auth::check())
                                                <a href="javascript:;" data-toggle="modal"
                                                    class="add_to_wishlist add_to_wishlist {{ $value->id }} btn-product-icon btn-wishlist btn-expandable {{ !empty($value->checkWishlist($value->id)) ? 'btn-wishlist-add' : '' }}"
                                                    id="{{ $value->id }}" title="Wishlist"><span>add to
                                                        wishlist</span></a>
                                            @else
                                                <a href="#signin-modal" data-toggle="modal"
                                                    class="btn-product-icon btn-wishlist btn-expandable"
                                                    title="Wishlist"><span>add to
                                                        wishlist</span></a>
                                            @endif
                                        </div>
                                    </figure>
                                    <div class="product-body">
                                        <div class="product-cat mb-1">
                                            <a href="{{ url($value->category_slug . '/' . $value->sub_category_slug) }}"
                                                class="text-secondary small">
                                                {{ $value->sub_category_name }}
                                            </a>
                                        </div>
                                        <h3 class="product-title mb-2" style="font-size:1.1rem;">
                                            <a href="{{ url($value->slug) }}" class="text-dark">{{ $value->title }}</a>
                                        </h3>
                                        <div class="product-price mb-2 fw-bold text-primary" style="font-size:1.1rem;">
                                            Rp{{ number_format($value->price, 0, ',', '.') }}
                                        </div>
                                        <div class="ratings-container">
                                            <div class="ratings">
                                                <div class="ratings-val"
                                                    style="width: {{ $value->getReviewRating($value->id) }}%;">
                                                </div>
                                            </div>
                                            <span class="ratings-text">
                                                ({{ $value->getTotalReview() }} Reviews)
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Diskon Promo --}}
        @if ($activeDiscounts->count() > 0)
            @php $discount = $activeDiscounts->first(); @endphp
            <div class="bg-image pt-4 pb-4"
                style="background-image: url('{{ asset('assets ecom/images/backgrounds/cta/bg-6.jpg') }}'); background-size: cover; background-position: center;">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 text-center">
                            <h2 class="text-white mb-4">Kode Diskon Tersedia</h2>
                            <div class="p-4 bg-white rounded-4 shadow-sm border-dashed position-relative"
                                style="border: 2px dashed #FFC107;">
                                <div class="text-center">
                                    <h4 class="text-dark mb-2">{{ $discount->name }}</h4>
                                    <span class="badge bg-success mb-2" style="font-size:1rem;">
                                        Diskon {{ $discount->percent_amount }}%
                                    </span>
                                    <p class="text-muted small mb-0">
                                        Berlaku hingga {{ date('d M Y', strtotime($discount->expire_date)) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </main>

@endsection
