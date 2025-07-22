@extends('layouts.app')

@section('style')
    <style type="text/css">
        .bx-btn {
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('content')
    <main class="main">
        <div class="page-header text-center">
            <div class="container">
                <h1 class="page-title">Dashboard</h1>
            </div>
        </div>

        <div class="page-content">
            <div class="dashboard">
                <div class="container">
                    <br />
                    <div class="row">
                        @include('user._sidebar')

                        <div class="col-md-8 col-lg-9">
                            <div class="tab-content">
                                <div class="row">
                                    @php
                                        $boxes = [
                                            ['label' => 'Total Order', 'value' => $TotalOrder],
                                            ['label' => 'Today Order', 'value' => $TotalTodayOrder],
                                            [
                                                'label' => 'Total Amount',
                                                'value' => 'Rp ' . number_format($TotalAmount, 0, ',', '.'),
                                            ],
                                            [
                                                'label' => 'Today Amount',
                                                'value' => 'Rp ' . number_format($TotalTodayAmount, 0, ',', '.'),
                                            ],
                                            ['label' => 'Terverifikasi', 'value' => $TotalTerverifikasi],
                                            ['label' => 'Selesai', 'value' => $TotalSelesai],
                                            ['label' => 'Menunggu Verifikasi', 'value' => $TotalMenunggu],
                                            ['label' => 'Ditolak', 'value' => $TotalDitolak],
                                            ['label' => 'Pesanan Dibatalkan', 'value' => $TotalDibatalkan],
                                        ];
                                    @endphp

                                    @foreach ($boxes as $box)
                                        <div class="col-md-3 mb-3">
                                            <div class="bx-btn">
                                                <div style="font-size: 20px; font-weight: bold;">{{ $box['value'] }}</div>
                                                <div style="font-size: 16px;">{{ $box['label'] }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div><!-- .tab-content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
@endsection
