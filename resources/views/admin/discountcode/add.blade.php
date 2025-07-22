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
                        <h1>Tambah Kode Diskon Baru</h1>
                    </div>
                </div>
            </div>
            <selection class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <form action=""method="post">
                                    {{ csrf_field() }}
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Nama Kode Diskon<span style="color:red">*</span></label>
                                            <input type="text" class="form-control" required value="{{ old('name') }}"
                                                name="name" placeholder="Discount Code Name">
                                        </div>

                                        <div class="form-group">
                                            <label>Jenis<span style="color:red">*</span></label>
                                            <select class="form-control" name="type" required>
                                                <option {{ (old('type') == 'Amount') ? 'selected' : '' }} value="Amount">
                                                    Amount
                                                </option>
                                                <option {{ (old('type') == 'Percent') ? 'selected' : '' }} value="Percent">
                                                    Percent
                                                </option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Percent / Amount <span style="color:red">*</span></label>
                                            <input type="text" class="form-control" required value="{{ old('percent_amount') }}"
                                                name="percent_amount" placeholder="Percent / Amount">
                                        </div>

                                        <div class="form-group">
                                            <label>Expire Date <span style="color:red">*</span></label>
                                            <input type="date" class="form-control" required value="{{ old('expire_date') }}"
                                                name="expire_date">
                                        </div>

                                        <div class="form-group">
                                            <label>Status<span style="color:red">*</span></label>
                                            <select class="form-control" name="status" required>
                                                <option {{ old('status') == 0 ? 'selected' : '' }} value="0">Active
                                                </option>
                                                <option {{ old('status') == 1 ? 'selected' : '' }} value="1">Inactive
                                                </option>
                                            </select>
                                        </div>


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
