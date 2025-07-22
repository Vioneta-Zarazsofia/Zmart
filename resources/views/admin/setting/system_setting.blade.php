@extends('admin.layouts.app')
@section('style')
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>System Setting</h1>
                    </div>
                </div>
            </div>
            <selection class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            @include('admin.layouts._message')
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <form action=""method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Website Name<span style="color:red">*</span></label>
                                            <input type="text" class="form-control"
                                                value="{{ $getRecord->website_name ?? '' }}" name="website_name"
                                                placeholder="Website Name">
                                        </div>
                                        <div class="form-group">
                                            <label>Logo<span style="color:red">*</span></label>
                                            <input type="file" class="form-control" name="logo">
                                            @if (!empty($getRecord->getLogo()))
                                                <img src="{{ $getRecord->getLogo() }}" alt="Logo"
                                                    style="width: 100px; height: 100px; margin-top: 10px;">
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label>Favicon<span style="color:red">*</span></label>
                                            <input type="file" class="form-control" name="favicon">
                                            @if (!empty($getRecord->getFavicon()))
                                                <img src="{{ $getRecord->getFavicon() }}" alt="Favicon"
                                                    style="width: 100px; height: 100px; margin-top: 10px;">
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label>Footer Description<span style="color:red">*</span></label>
                                            <textarea class="form-control" name="footer_description" placeholder="Footer Description">{{ $getRecord->footer_description ?? '' }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Footer Payment Icon<span style="color:red">*</span></label>
                                            <input type="file" class="form-control" name="footer_payment_icon">
                                            @if (!empty($getRecord->getFooterPayment()))
                                                <img src="{{ $getRecord->getFooterPayment() }}" alt="Footer Payment Icon"
                                                    style="width: 100px; height: 100px; margin-top: 10px;">
                                            @endif
                                        </div>
                                        <hr />
                                        <div class="form-group">
                                            <label>Address<span style="color:red">*</span></label>
                                            <textarea class="form-control" name="address" placeholder="Address">{{ $getRecord->address ?? '' }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Phone<span style="color:red">*</span></label>
                                            <input type="text" class="form-control" name="phone"
                                                value="{{ $getRecord->phone ?? '' }}" placeholder="Phone">
                                        </div>
                                        <div class="form-group">
                                            <label>Phone 2<span style="color:red">*</span></label>
                                            <input type="text" class="form-control"
                                                value="{{ $getRecord->phone_2 ?? '' }}" name="phone_2"
                                                placeholder="Phone 2">
                                        </div>
                                        <div class="form-group">
                                            <label>Submit Contact Email<span style="color:red">*</span></label>
                                            <input type="email" class="form-control"
                                                value="{{ $getRecord->submit_contact_email ?? '' }}"
                                                name="submit_contact_email" placeholder="Submit Contact Email">
                                        </div>
                                        <div class="form-group">
                                            <label>Email<span style="color:red">*</span></label>
                                            <input type="email" class="form-control"
                                                value="{{ $getRecord->email ?? '' }}" name="email" placeholder="Email">
                                        </div>
                                        <div class="form-group">
                                            <label>Email 2<span style="color:red">*</span></label>
                                            <input type="email" class="form-control"
                                                value="{{ $getRecord->email_2 ?? '' }}" name="email_2"
                                                placeholder="Email 2">
                                        </div>
                                        <div class="form-group">
                                            <label>Working Hours<span style="color:red">*</span></label>
                                            <textarea class="form-control" name="working_hours" placeholder="Working Hours">{{ $getRecord->working_hours ?? '' }}</textarea>
                                        </div>
                                        <hr>
                                        <h4>Contact Page Content</h4>

                                        <div class="form-group">
                                            <label>Contact Page Title</label>
                                            <input type="text" class="form-control" name="contact_title"
                                                value="{{ $getRecord->contact_title ?? '' }}">
                                        </div>

                                        <div class="form-group">
                                            <label>Contact Page Description</label>
                                            <textarea class="form-control" name="contact_description">{{ $getRecord->contact_description ?? '' }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Contact Page Header Image</label>
                                            <input type="file" class="form-control" name="contact_image">
                                            @if (!empty($getRecord->contact_image))
                                                <img src="{{ asset('upload/setting/' . $getRecord->contact_image) }}"
                                                    style="width: 150px; height: auto; margin-top: 10px;">
                                            @endif
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection
@section('script')
@endsection
