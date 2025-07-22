<!DOCTYPE html>
<html lang="en">


<!-- molla/index-2.html  22 Nov 2019 09:55:32 GMT -->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ !empty($meta_title) ? $meta_title : '' }}</title>

    @if (!empty($meta_description))
        <meta name="description" content="{{ $meta_description }}">
    @endif

    @if (!empty($meta_keywords))
        <meta name="keywords" content="{{ $meta_keywords }}">
    @endif

    @php
        $getStemSettingApp = App\Models\SystemSettingModel::getSingle();
    @endphp
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ $getStemSettingApp->getFavicon() }}" sizes="32x32">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{ asset('assets ecom/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets ecom/css/plugins/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets ecom/css/plugins/magnific-popup/magnific-popup.css') }}">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{ asset('assets ecom/css/style.css') }}">
    @yield('style')
    <style type="text/css">
        .btn-wishlist-add::before {
            content: "\f233" !important;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">

        @include('layouts._header')

        @yield('content')

        @include('layouts._footer')

    </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

    @include('layouts._mobile_menu')

    <!-- Sign in / Register Modal -->
    <div class="modal fade" id="signin-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>

                    <div class="form-box">
                        <div class="form-tab">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin"
                                        role="tab" aria-controls="signin" aria-selected="true">Sign In</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="register-tab" data-toggle="tab" href="#register"
                                        role="tab" aria-controls="register" aria-selected="false">Register</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="tab-content-5">
                                <div class="tab-pane fade show active" id="signin" role="tabpanel"
                                    aria-labelledby="signin-tab">
                                    <form action="" id="SubmitFormLogin" method="post">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="signin-email">Email Address <span
                                                    style="color:red">*</span></label>
                                            <input type="email" class="form-control" id="signin-email" name="email"
                                                required autocomplete="username">
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="signin-password">Password <span
                                                    style="color:red">*</span></label>
                                            <input type="password" class="form-control" id="signin-password"
                                                name="password" required autocomplete="current-password">
                                        </div><!-- End .form-group -->

                                        <div class="form-footer d-flex align-items-center justify-content-between">
                                            <button type="submit" class="btn btn-outline-primary-2">
                                                <span>LOG IN</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="is_remember" class="custom-control-input"
                                                    id="signin-remember">
                                                <label class="custom-control-label" for="signin-remember">Remember
                                                    Me</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .form-footer -->
                                        <div class="text-right mt-2">
                                            <a href="{{ url('forgot-password') }}" class="forgot-link">Forgot Your
                                                Password?</a>
                                        </div>
                                    </form>
                                </div><!-- .End .tab-pane -->
                                <div class="tab-pane fade" id="register" role="tabpanel"
                                    aria-labelledby="register-tab">
                                    <form action="" id="SubmitFormRegister" method="post">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="register-name">Name <span style="color:red">*</span></label>
                                            <input type="text" class="form-control" id="register-name"
                                                name="name" required autocomplete="name">
                                        </div><!-- End .form-group -->
                                        <div class="form-group">
                                            <label for="register-email">Email address <span
                                                    style="color:red">*</span></label>
                                            <input type="email" class="form-control" id="register-email"
                                                name="email" required autocomplete="email">
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="register-password">Password <span
                                                    style="color:red">*</span></label>
                                            <input type="password" class="form-control" id="register-password"
                                                name="password" required autocomplete="new-password">
                                        </div><!-- End .form-group -->

                                        <div class="form-footer d-flex align-items-center justify-content-between">
                                            <button type="submit" class="btn btn-outline-primary-2">
                                                <span>SIGN UP</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="register-policy" required>
                                                <label class="custom-control-label" for="register-policy">I agree to
                                                    the <a href="{{ url('privacy-policy') }}">privacy policy</a> <span
                                                        style="color:red">*</span></label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .form-footer -->
                                    </form>
                                </div><!-- .End .tab-pane -->
                            </div><!-- End .tab-content -->
                        </div><!-- End .form-tab -->
                    </div><!-- End .form-box -->
                </div><!-- End .modal-body -->
            </div><!-- End .modal-content -->
        </div><!-- End .modal-dialog -->
    </div><!-- End .modal -->

    {{-- <div class="container newsletter-popup-container mfp-hide" id="newsletter-popup-form">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="row no-gutters bg-white newsletter-popup-content">
                    <div class="col-xl-3-5col col-lg-7 banner-content-wrap">
                        <div class="banner-content text-center">
                            <img src="{{ asset('assets ecom/images/popup/newsletter/logo.png') }}" class="logo"
                                alt="logo" width="60" height="15">
                            <h2 class="banner-title">get <span>25<light>%</light></span> off</h2>
                            <p>Subscribe to the Molla eCommerce newsletter to receive timely updates from your favorite
                                products.</p>
                            <form action="#">
                                <div class="input-group input-group-round">
                                    <input type="email" class="form-control form-control-white"
                                        placeholder="Your Email Address" aria-label="Email Adress" required>
                                    <div class="input-group-append">
                                        <button class="btn" type="submit"><span>go</span></button>
                                    </div><!-- .End .input-group-append -->
                                </div><!-- .End .input-group -->
                            </form>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="register-policy-2" required>
                                <label class="custom-control-label" for="register-policy-2">Do not show this popup
                                    again</label>
                            </div><!-- End .custom-checkbox -->
                        </div>
                    </div>
                    <div class="col-xl-2-5col col-lg-5 ">
                        <img src="{{ asset('assets ecom/images/popup/newsletter/img-1.jpg') }}" class="newsletter-img"
                            alt="newsletter">
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Plugins JS File -->
    <script src="{{ asset('assets ecom/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets ecom/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets ecom/js/jquery.hoverIntent.min.js') }}"></script>
    <script src="{{ asset('assets ecom/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets ecom/js/superfish.min.js') }}"></script>
    <script src="{{ asset('assets ecom/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets ecom/js/jquery.magnific-popup.min.js') }}"></script>
    @yield('script')
    <!-- Main JS File -->
    <script src="{{ asset('assets ecom/js/main.js') }}"></script>
    <script type="text/javascript">
        $('body').delegate('#SubmitFormLogin', 'submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: "{{ url('auth_login') }}",
                data: $(this).serialize(),
                dataType: "json",
                success: function(data) {
                    if (data.status == true) {
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                },
                error: function(data) {}
            });

        });

        $('body').delegate('#SubmitFormRegister', 'submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: "{{ url('auth_register') }}",
                data: $(this).serialize(),
                dataType: "json",
                success: function(data) {
                    alert(data.message);
                    if (data.status === true) {
                        location.reload();
                    }
                },
                error: function(data) {}
            });

        });
        $('body').delegate('.add_to_wishlist', 'click', function(e) {
            var product_id = $(this).attr('id');
            $.ajax({
                type: 'post',
                url: "{{ url('add_to_wishlist') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    product_id: product_id,
                },
                dataType: "json",
                success: function(data) {
                    if (data.is_wislist == 0) {
                        $('.add_to_wishlist.' + product_id).removeClass('btn-wishlist-add');
                    } else {
                        $('.add_to_wishlist.' + product_id).addClass('btn-wishlist-add');

                    }

                },

            });

        });
    </script>
</body>

</html>
