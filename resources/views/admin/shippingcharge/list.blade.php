@extends('admin.layouts.app')

@section('style')
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-6">
                        <h1>Daftar Biaya Pengiriman</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ url('admin/shipping_charge/add') }}" class="btn btn-primary">
                            Tambah Biaya Pengiriman Baru
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                @include('admin.layouts._message')

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Biaya Pengiriman</h3>
                    </div>

                    <div class="card-body p-0">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getRecord as $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>Rp{{ number_format($value->price, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($value->status == 0)
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-secondary">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                                        <td>
                                            <a href="{{ url('admin/shipping_charge/edit/' . $value->id) }}"
                                                class="btn btn-sm btn-primary">Edit</a>
                                            <a href="{{ url('admin/shipping_charge/delete/' . $value->id) }}"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus?')">Delete</a>
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
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('script')
@endsection
