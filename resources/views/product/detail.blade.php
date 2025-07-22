@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets ecom/css/plugins/nouislider/nouislider.css') }}" />
@endsection
@section('content')
    <main class="main">
        <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
            <div class="container d-flex align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('') }}">Home</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ url($getProduct->getCategory->slug) }}">{{ $getProduct->getCategory->name }}</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ url($getProduct->getCategory->slug . '/' . $getProduct->getSubCategory->slug) }}">{{ $getProduct->getSubCategory->name }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $getProduct->title }}</li>
                </ol>

            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content">
            <div class="container">
                <div class="product-details-top mb-2">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="product-gallery">
                                <figure class="product-main-image">
                                    @php
                                        $getProductImage = $getProduct->getImageSingle($getProduct->id);
                                    @endphp
                                    @if (!empty($getProductImage) && !empty($getProductImage->getLogo()))
                                        <img id="product-zoom" src="{{ $getProductImage->getLogo() }}"
                                            data-zoom-image="{{ $getProductImage->getLogo() }}" alt="product image">

                                        <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                            <i class="icon-arrows"></i>
                                        </a>
                                    @endif
                                </figure>

                                <div id="product-zoom-gallery" class="product-image-gallery">
                                    @foreach ($getProduct->getImage as $image)
                                        <a class="product-gallery-item" href="#" data-image="{{ $image->getLogo() }}"
                                            data-zoom-image="{{ $image->getLogo() }}">
                                            <img src="{{ $image->getLogo() }}" alt="product side">
                                        </a>
                                    @endforeach

                                </div><!-- End .product-image-gallery -->
                            </div><!-- End .product-gallery -->
                        </div><!-- End .col-md-6 -->

                        <div class="col-md-6">
                            <div class="product-details">
                                <h1 class="product-title">{{ $getProduct->title }}</h1>
                                <!-- End .product-title -->

                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val"
                                            style="width: {{ $getProduct->getReviewRating($getProduct->id) }}%;"></div>
                                    </div><!-- End .ratings -->

                                    <a class="ratings-text" href="#product-review-link" id="review-link">(
                                        {{ $getProduct->getTotalReview() }} Reviews )</a>
                                </div><!-- End .rating-container -->

                                <div class="product-price">
                                    Rp <span id="getTotalPrice">{{ number_format($getProduct->price, 0, ',', '.') }}</span>
                                </div><!-- End .product-price -->
                                <div class="product-stock mb-2">
                                    <strong>Stok Tersedia:</strong>
                                    {{ $getProduct->stock > 0 ? $getProduct->stock : 'Habis' }}
                                </div>



                                <div class="product-content">
                                    <p>{{ $getProduct->description }} </p>
                                </div><!-- End .product-content -->

                                <form action="{{ url('product/add-to-cart') }}" method="post">
                                    {{ @csrf_field() }}
                                    <input type="hidden" name="product_id" value="{{ $getProduct->id }}">
                                    {{-- @if (!empty($getProduct->getColor->count()))
                                    <div class="details-filter-row details-row-size">
                                        <label>Color:</label>
                                        <div class="select-custom">
                                            <select name="color_id" id="color_id" required class="form-control">
                                                <option value="">Select a color</option>
                                                @foreach ($getProduct->getColor as $color)
                                                    <option value="{{ $color->getColor->id }}">
                                                        {{ $color->getColor->name }}</option>
                                                @endforeach
                                            </select>
                                        </div><!-- End .select-custom -->
                                    </div><!-- End .details-filter-row -->
                                @endif --}}

                                    {{-- @if (!empty($getProduct->getSize->count()))
                                    <div class="details-filter-row details-row-size">
                                        <label for="size">Size:</label>
                                        <div class="select-custom">
                                            <select name="size_id" id="size" required class="form-control getSizePrice">
                                                <option data-price="0 " value="">
                                                    Select a size
                                                </option>
                                                @foreach ($getProduct->getSize as $size)
                                                    <option data-price="{{!empty ($size->price) ? $size->price : 0}}" value="{{ $size->id }}">
                                                        {{ $size->name }} @if (!empty($size->price))
                                                            (Rp {{ number_format($size->price, 0, ',', '.') }})
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif --}}

                                    <div class="details-filter-row details-row-size">
                                        <label for="qty">Qty:</label>
                                        <div class="product-details-quantity">
                                            <input type="number" id="qty" class="form-control" value="1"
                                                min="1" max="{{ $getProduct->stock }}" name="qty" step="1"
                                                {{ $getProduct->stock <= 0 ? 'disabled' : '' }}>

                                        </div><!-- End .product-details-quantity -->
                                    </div><!-- End .details-filter-row -->

                                    <div class="product-details-action">
                                        @if ($getProduct->stock > 0)
                                            <button style="background:#fff; color:#c96;" type="submit"
                                                class="btn-product btn-cart">Keranjang</button>
                                        @else
                                            <button style="background:#ddd; color:#999;" type="button" disabled
                                                class="btn-product btn-cart">Stok Habis</button>
                                        @endif


                                        <div class="details-action-wrapper">
                                            @if (!empty(Auth::check()))
                                                <a href="javascript:;"
                                                    class="add_to_wishlist add_to_wishlist {{ $getProduct->id }} {{ !empty($getProduct->checkWishlist($getProduct->id)) ? 'btn-wishlist-add' : '' }} btn-product btn-wishlist"
                                                    title="Wishlist" id="{{ $getProduct->id }}"><span>Add to
                                                        Wishlist</span></a>
                                            @else
                                                <a href="#signin-modal" data-toggle="modal" class="btn-product btn-wishlist"
                                                    title="Wishlist"><span>Add to
                                                        Wishlist</span></a>
                                            @endif

                                        </div>
                                    </div><!-- End .product-details-action -->
                                </form>

                                <div class="product-details-footer">
                                    <div class="product-cat">
                                        <span>Category:</span>
                                        <a
                                            href="{{ url($getProduct->getCategory->slug) }}">{{ $getProduct->getCategory->name }}</a>
                                        <a
                                            href="{{ url($getProduct->getCategory->slug . '/' . $getProduct->getSubCategory->slug) }}">{{ $getProduct->getSubCategory->name }}</a>
                                    </div><!-- End .product-cat -->

                                    {{-- <div class="social-icons social-icons-sm">
                                        <span class="social-label">Share:</span>
                                        <a href="#" class="social-icon" title="Facebook" target="_blank"><i
                                                class="icon-facebook-f"></i></a>
                                        <a href="#" class="social-icon" title="Twitter" target="_blank"><i
                                                class="icon-twitter"></i></a>
                                        <a href="#" class="social-icon" title="Instagram" target="_blank"><i
                                                class="icon-instagram"></i></a>
                                        <a href="#" class="social-icon" title="Pinterest" target="_blank"><i
                                                class="icon-pinterest"></i></a>
                                    </div> --}}
                                </div><!-- End .product-details-footer -->
                            </div><!-- End .product-details -->
                        </div><!-- End .col-md-6 -->
                    </div><!-- End .row -->
                </div><!-- End .product-details-top -->
            </div><!-- End .container -->

            <div class="product-details-tab product-details-extended">
                <div class="container">
                    <ul class="nav nav-pills justify-content-center" role="tablist">
                        {{-- <li class="nav-item">
                            <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab"
                                role="tab" aria-controls="product-desc-tab" aria-selected="true">Deskripsi</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab"
                                role="tab" aria-controls="product-info-tab" aria-selected="false">Informasi
                                tambahan</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" id="product-shipping-link" data-toggle="tab"
                                href="#product-shipping-tab" role="tab" aria-controls="product-shipping-tab"
                                aria-selected="false">Pengiriman & Pengembalian</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link" id="product-review-link" data-toggle="tab" href="#product-review-tab"
                                role="tab" aria-controls="product-review-tab" aria-selected="false">Reviews
                                ({{ $getProduct->getTotalReview() }})</a>
                        </li>
                    </ul>
                </div><!-- End .container -->

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel"
                        aria-labelledby="product-desc-link">
                        <div class="product-desc-content">
                            {{-- <div class="container" style="margin-top: 20px;">
                                {!! $getProduct->description !!}
                            </div><!-- End .container --> --}}
                        </div><!-- End .product-desc-content -->
                    </div><!-- .End .tab-pane -->
                    <div class="tab-pane fade" id="product-info-tab" role="tabpanel"
                        aria-labelledby="product-info-link">
                        <div class="product-desc-content" style="margin-top: 20px;">
                            <div class="container">
                                {!! $getProduct->additional_information !!}
                            </div><!-- End .container -->
                        </div><!-- End .product-desc-content -->
                    </div><!-- .End .tab-pane -->
                    <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel"
                        aria-labelledby="product-shipping-link">
                        <div class="product-desc-content" style="margin-top: 20px;">
                            <div class="container">
                                {!! $getProduct->shipping_return !!}
                            </div><!-- End .container -->
                        </div><!-- End .product-desc-content -->
                    </div><!-- .End .tab-pane -->
                    <div class="tab-pane fade" id="product-review-tab" role="tabpanel"
                        aria-labelledby="product-review-link">
                        <div class="reviews">
                            <div class="container">
                                <h3>Reviews ({{ $getProduct->getTotalReview() }})</h3>
                                @foreach ($getReviewProduct as $review)
                                    <div class="review">
                                        <div class="row no-gutters">
                                            <div class="col-auto">
                                                <h4><a href="#">{{ $review->name }}</a></h4>
                                                <div class="ratings-container">
                                                    <div class="ratings">
                                                        <div class="ratings-val"
                                                            style="width: {{ $review->getPercent() }}%;"></div>
                                                    </div>
                                                </div>
                                                <span
                                                    class="review-date">{{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }}</span>
                                            </div>

                                            <div class="col">
                                                <h4>{{ $review->review }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                {!! $getReviewProduct->appends(request()->except('page'))->links() !!}
                            </div>
                        </div>

                    </div><!-- .End .tab-pane -->
                </div><!-- End .tab-content -->
            </div><!-- End .product-details-tab -->

            <div class="container">
                <h2 class="title text-center mb-4">Anda Mungkin Juga Menyukai</h2><!-- End .title text-center -->
                <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                    data-owl-options='{
                    "nav": false,
                    "dots": true,
                    "margin": 20,
                    "loop": false,
                    "responsive": {
                        "0": {
                            "items":1
                        },
                        "480": {
                            "items":2
                        },
                        "768": {
                            "items":3
                        },
                        "992": {
                            "items":4
                        },
                        "1200": {
                            "items":4,
                            "nav": true,
                            "dots": false
                        }
                    }
                }'>

                    @foreach ($getRelatedProduct as $value)
                        @php
                            $getProductImage = $value->getImageSingle($value->id);
                        @endphp

                        <div class="product product-7">
                            <figure class="product-media">
                                <a href="{{ url($value->slug) }}">
                                    @if (!empty($getProductImage) && !empty($getProductImage->getLogo()))
                                        <img style =" height:280px; width: 100%; object-fit:cover;"
                                            src="{{ $getProductImage->getLogo() }}" alt="{{ $value->title }}"
                                            class="product-image">
                                    @endif

                                </a>

                                <div class="product-action-vertical">
                                    @if (!empty(Auth::check()))
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
                                </div><!-- End .product-action-vertical -->
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a
                                        href="{{ url($value->category_slug . '/' . $value->sub_category_slug) }}">{{ $value->sub_category_name }}</a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a href="{{ url($value->slug) }}">{{ $value->title }}</a></h3>
                                <div class="product-price">
                                    Rp{{ number_format($value->price, 0, ',', '.') }}
                                </div><!-- End .product-price -->
                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 20%;"></div>
                                        <!-- End .ratings-val -->
                                    </div><!-- End .ratings -->
                                    <span class="ratings-text">({{ $getProduct->getTotalReview() }} Reviews )</span>
                                </div><!-- End .rating-container -->
                            </div><!-- End .product-body -->
                        </div><!-- End .product -->
                    @endforeach

                </div><!-- End .owl-carousel -->
            </div><!-- End .container -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->
@endsection
@section('script')
    <script src="{{ asset('assets ecom/js/bootstrap-input-spinner.js') }}"></script>
    <script src="{{ asset('assets ecom/js/jquery.elevateZoom.min.js') }}"></script>
    <script src="{{ asset('assets ecom/js/bootstrap-input-spinner.js') }}"></script>

    <script type="text/javascript">
        $('.getSizePrice').change(function() {
            var product_price = {{ $getProduct->price }};
            var price = $('option:selected', this).data('price');
            var total = parseFloat(price) + parseFloat(product_price);
            $('#getTotalPrice').html(total.toFixed(0));
        });
        document.addEventListener('DOMContentLoaded', function() {
            const qtyInput = document.getElementById('qty');
            const maxStock = {{ $getProduct->stock }};

            if (qtyInput) {
                qtyInput.addEventListener('input', function() {
                    if (parseInt(this.value) > maxStock) {
                        this.value = maxStock;
                    }
                });
            }
        });
    </script>
@endsection
