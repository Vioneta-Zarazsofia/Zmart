@extends('admin.layouts.app')
@section('style')
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Daftar Brand</h1>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ url('admin/brand/add') }}" class="btn btn-primary float-sm-right">Tambah Brand Baru</a>
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
                                    <h3 class="card-title">Daftar Brand</h3>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama</th>
                                                <th>Slug</th>
                                                <th>Meta Title</th>
                                                <th>Meta Description</th>
                                                <th>Meta Keywords</th>
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
                                                    <td>{{ $value->name }}</td>
                                                    <td>{{ $value->slug }}</td>
                                                    <td>{{ $value->meta_title }}</td>
                                                    <td>{{ $value->meta_description }}</td>
                                                    <td>{{ $value->meta_keywords }}</td>
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
                                                        <a href="{{ url('admin/brand/edit/' . $value->id) }}"
                                                            class="btn btn-primary ">Edit</a>
                                                        <a href="{{ url('admin/brand/delete/' . $value->id) }}"
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
