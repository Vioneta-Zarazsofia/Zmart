@extends('admin.layouts.app')
@section('style')
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Daftar Kode Diskon</h1>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ url('admin/discountcode/add') }}" class="btn btn-primary float-sm-right">Tambah Kode
                            Diskon Baru</a>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            @include('admin.layouts._message')
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Daftar Kode Diskon</h3>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama</th>
                                                <th>Tipe</th>
                                                <th>Percent / Amount</th>
                                                <th>Expire Date</th>
                                                <th>Status</th>
                                                <th>Created Date</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($getRecord as $value)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $value->name }}</td>
                                                    <td>{{ $value->type }}</td>
                                                    <td>{{ $value->percent_amount }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($value->expire_date)) }}</td>
                                                    <td>
                                                        @if ($value->status == 0)
                                                            <span class="badge badge-success">Aktif</span>
                                                        @else
                                                            <span class="badge badge-secondary">Nonaktif</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                                                    <td>
                                                        <a href="{{ url('admin/discountcode/edit/' . $value->id) }}"
                                                            class="btn btn-primary ">Edit</a>
                                                        <a href="{{ url('admin/discountcode/delete/' . $value->id) }}"
                                                            class="btn btn-danger">Delete</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </section>
    </div>
@endsection
@section('script')
@endsection
