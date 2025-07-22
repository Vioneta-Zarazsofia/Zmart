@extends('layouts.app')
@section('style')
@endsection
@section('content')
    <main class="main">
        <div class="page-header text-center">
            <div class="container">
                <h1 class="page-title">Change Password</h1>
            </div><!-- End .container -->
        </div><!-- End .page-header -->


        <div class="page-content">
            <div class="dashboard">
                <div class="container">
                    <br />
                    <div class="row">
                        @include('user._sidebar')

                        <div class="col-md-8 col-lg-9">
                            <div class="tab-content">
                                @include('layouts._message')
                                <form action="" method="post">
                                    {{ csrf_field() }}

                                    <div class="form-group">
                                        <label>Password Lama *</label>
                                        <input type="password" name="old_password" class="form-control" required>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Password Baru *</label>
                                            <input type="password" name="password" class="form-control" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Konfirmasi Password Baru*</label>
                                            <input type="password" name="cpassword" class="form-control" required>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block mt-3">
                                        Update Password
                                        <i class="icon-long-arrow-right"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        </p>
                    </div><!-- .End .tab-pane -->
                </div>
            </div><!-- End .col-lg-9 -->
        </div><!-- End .row -->
        </div><!-- End .container -->
        </div><!-- End .dashboard -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->
@endsection
@section('script')
@endsection
