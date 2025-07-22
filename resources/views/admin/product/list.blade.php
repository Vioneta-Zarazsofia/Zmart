@extends('admin.layouts.app')
@section('style')
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Daftar Produk</h1>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ url('admin/product/add') }}" class="btn btn-primary float-sm-right">Tambah Produk Baru</a>
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
                                    <h3 class="card-title">Daftar Produk</h3>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Created By</th>
                                                <th>Status</th>
                                                <th>Created Date</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($getRecord as $value)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $value->title }}</td>
                                                    <td>{{ $value->created_by_name }}</td>
                                                    <td>
                                                        @if ($value->status == 0)
                                                            <span class="badge badge-success">Aktif</span>
                                                        @else
                                                            <span class="badge badge-secondary">Nonaktif</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                                                    <td>
                                                        <a href="{{ url('admin/product/edit/' . $value->id) }}"
                                                            class="btn btn-primary ">Edit</a>
                                                        <a href="{{ url('admin/product/delete/' . $value->id) }}"
                                                            class="btn btn-danger">Delete</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div style="padding: 10px; float: right;">
                                        {!! $getRecord->appends(request()->except('page'))->links() !!}
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
