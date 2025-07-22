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
                        <h1>Edit Biaya Pengiriman</h1>
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
                                            <label>Biaya Pengiriman <span style="color:red">*</span></label>
                                            <input type="text" class="form-control" required
                                                value="{{ old('name', $getRecord->name) }}" name="name"
                                                placeholder="Shipping Charge Name">
                                        </div>

                                        <div class="form-group">
                                            <label>Harga <span style="color:red">*</span></label>
                                            <input type="text" class="form-control" required
                                                value="{{ old('price', $getRecord->price) }}" name="price"
                                                placeholder="Price">
                                        </div>

                                        <div class="form-group">
                                            <label>Status<span style="color:red">*</span></label>
                                            <select class="form-control" name="status" required>
                                                <option {{ old('status', $getRecord->status) == 0 ? 'selected' : '' }}
                                                    value="0">Active
                                                </option>
                                                <option {{ old('status', $getRecord->status) == 1 ? 'selected' : '' }}
                                                    value="1">Inactive
                                                </option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        <button type="update" class="btn btn-primary">Update</button>
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
