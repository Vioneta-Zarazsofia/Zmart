@extends('layouts.app')

@section('style')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('content')
    <main class="main">
        <div class="page-header text-center">
            <div class="container">
                <h1 class="page-title">Edit Profile</h1>
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
                                @include('layouts._message')
                                <form action="{{ url('user/update-profile') }}" method="POST">
                                    @csrf
                                    <label>Nama *</label>
                                    <input type="text" name="name" value="{{ $getRecord->name }}" class="form-control"
                                        required>

                                    <div class="form-group">
                                        <label>Email *</label>
                                        <input type="email" name="email" value="{{ $getRecord->email }}"
                                            class="form-control" readonly>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Kecamatan *</label>
                                            <select id="subdistrict" name="subdistrict" class="form-control" required>
                                                <option value="">Pilih Kecamatan</option>
                                            </select>

                                        </div>
                                        <div class="col-sm-6">
                                            <label>Kelurahan/Desa *</label>
                                            <select id="village" name="village" class="form-control" required>
                                                <option value="">Pilih Kelurahan</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-sm-6">
                                            <label>Alamat *</label>
                                            <input type="text" name="address" value="{{ $getRecord->address }}"
                                                class="form-control" placeholder="Nomor rumah dan nama jalan" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Kode Pos *</label>
                                            <input type="text" name="postcode" value="{{ $getRecord->postcode }}"
                                                class="form-control" required>
                                        </div>

                                    </div>
                                    <label>Phone *</label>
                                    <input type="tel" name="phone" value="{{ $getRecord->phone }}"
                                        class="form-control" required>


                                    <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block mt-3">
                                        Submit
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            const kotaNgawiId = 3521;
            const selectedsubdistrict = "{{ $getRecord->subdistrict }}"; // ini NAMA dari database
            const selectedvillage = "{{ $getRecord->village }}"; // ini NAMA dari database

            // Step 1: Load Kecamatan (subdistrict)
            $.get(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kotaNgawiId}.json`, function(
                districts) {
                $('#subdistrict').html('<option value="">Pilih Kecamatan</option>');
                districts.forEach(function(d) {
                    $('#subdistrict').append(
                        `<option value="${d.name}" data-id="${d.id}" ${selectedsubdistrict == d.name ? 'selected' : ''}>${d.name}</option>`
                    );
                });

                // Trigger load village jika ada subdistrict tersimpan
                if (selectedsubdistrict) {
                    $('#subdistrict').trigger('change');
                }
            });

            // Step 2: Load Kelurahan saat kecamatan dipilih
            $('#subdistrict').on('change', function() {
                const id = $(this).find(':selected').data('id'); // ambil ID dari data-id
                $('#village').html('<option value="">Memuat...</option>');

                if (!id) {
                    $('#village').html('<option value="">Pilih Kelurahan</option>');
                    return;
                }

                // Fetch kelurahan dari API
                $.get(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${id}.json`, function(
                    villages) {
                    $('#village').html('<option value="">Pilih Kelurahan</option>');
                    villages.forEach(function(v) {
                        $('#village').append(
                            `<option value="${v.name}" ${selectedvillage == v.name ? 'selected' : ''}>${v.name}</option>`
                        );
                    });
                });
            });
        });
    </script>
@endsection
