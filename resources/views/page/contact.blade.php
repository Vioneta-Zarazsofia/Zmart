@extends('layouts.app')
@section('content')
    <main class="main">
        <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $getStemSettingApp->contact_title ?? 'Contact' }}
                    </li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->
        <div class="container">
            <div class="page-header page-header-big text-center"
                style="background-image: url('{{ !empty($getStemSettingApp->contact_image) ? asset('upload/setting/' . $getStemSettingApp->contact_image) : asset('assets/images/default-contact.jpg') }}');">
                <h1 class="page-title text-white">{{ $getStemSettingApp->contact_title ?? 'Contact' }}</h1>

                </h1>
            </div><!-- End .page-header -->
        </div><!-- End .container -->

        <div class="page-content pb-0">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mb-2 mb-lg-0">
                        {!! $getStemSettingApp->contact_description !!}
                        <hr />
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="contact-info">
                                    <h3>Kantor</h3>

                                    <ul class="contact-list">
                                        @if (!empty($getStemSettingApp->address))
                                            <li>
                                                <i class="icon-map-marker"></i>
                                                {{ $getStemSettingApp->address }}
                                            </li>
                                        @endif
                                        @if (!empty($getStemSettingApp->phone))
                                            <li>
                                                <i class="icon-whatsapp"></i>
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $getStemSettingApp->phone) }}"
                                                    target="_blank">
                                                    {{ $getStemSettingApp->phone }}
                                                </a>
                                            </li>
                                        @endif
                                        @if (!empty($getStemSettingApp->phone_2))
                                            <li>
                                                <i class="icon-whatsapp"></i>
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $getStemSettingApp->phone_2) }}"
                                                    target="_blank">
                                                    {{ $getStemSettingApp->phone_2 }}
                                                </a>
                                            </li>
                                        @endif
                                        @if (!empty($getStemSettingApp->email))
                                            <li>
                                                <i class="icon-envelope"></i>
                                                <a
                                                    href="mailto:{{ $getStemSettingApp->email }}">{{ $getStemSettingApp->email }}</a>
                                            </li>
                                        @endif
                                        @if (!empty($getStemSettingApp->email_2))
                                            <li>
                                                <i class="icon-envelope"></i>
                                                <a
                                                    href="mailto:{{ $getStemSettingApp->email_2 }}">{{ $getStemSettingApp->email_2 }}</a>
                                            </li>
                                        @endif
                                    </ul>
                                </div><!-- End .contact-info -->
                            </div><!-- End .col-sm-7 -->

                            <div class="col-sm-5">
                                <div class="contact-info">
                                    <h3>Jam Kerja</h3>
                                    <ul class="contact-list">
                                        @if (!empty($getStemSettingApp->working_hours))
                                            <li>
                                                <i class="icon-clock-o"></i>
                                                {{ $getStemSettingApp->working_hours }}
                                            </li>
                                        @endif
                                    </ul><!-- End .contact-list -->
                                </div><!-- End .contact-info -->
                            </div><!-- End .col-sm-5 -->
                        </div><!-- End .row -->
                    </div><!-- End .col-lg-6 -->
                    <div class="col-lg-6">

                        <h2 class="title mb-1">Ada Pertanyaan?</h2><!-- End .title mb-2 -->
                        <p class="mb-2">Gunakan formulir di bawah ini untuk menghubungi tim kami</p>
                        <br style="paddding-top: 10px; padding-bottom: 10px;" />
                        @include('layouts._message')
                        <br />
                        <form action="#" class="contact-form mb-3" autocomplete="off" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="cname" class="sr-only">Name</label>
                                    <input type="text" class="form-control" name="name" id="cname"
                                        placeholder="Name *" required>
                                </div><!-- End .col-sm-6 -->

                                <div class="col-sm-6">
                                    <label for="cemail" class="sr-only">Email</label>
                                    <input type="email" class="form-control" name="email" id="cemail"
                                        placeholder="Email *" required>
                                </div><!-- End .col-sm-6 -->
                            </div><!-- End .row -->

                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="cphone" class="sr-only">Phone</label>
                                    <input type="tel" class="form-control" name="phone" id="cphone"
                                        placeholder="Phone"required>
                                </div><!-- End .col-sm-6 -->

                                <div class="col-sm-6">
                                    <label for="csubject" class="sr-only">Subject</label>
                                    <input type="text" class="form-control" name="subject" id="csubject"
                                        placeholder="Subject" required>
                                </div><!-- End .col-sm-6 -->
                            </div><!-- End .row -->

                            <label for="cmessage" class="sr-only">Message</label>
                            <textarea class="form-control" cols="30" rows="4" name="message" id="cmessage" required
                                placeholder="Message *"></textarea>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="verification">{{$first_number}} + {{$second_number}} = ?</label>
                                        <input type="text" class="form-control" name="verification" id="verification"
                                            placeholder="verification *">
                                    </div><!-- End .col-sm-6 -->


                                </div>

                            <button type="submit" class="btn btn-outline-primary-2 btn-minwidth-sm">
                                <span>SUBMIT</span>
                                <i class="icon-long-arrow-right"></i>
                            </button>
                        </form><!-- End .contact-form -->
                    </div><!-- End .col-lg-6 -->
                </div><!-- End .row -->
            </div><!-- End .container -->

        </div><!-- End .page-content -->
    </main><!-- End .main -->
@endsection
