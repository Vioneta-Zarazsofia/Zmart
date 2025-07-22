@extends('admin.layouts.app')
@section('style')
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Daftar Customer ( Total : {{ $getRecord->total() }})</h1>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            @include('admin.layouts._message')
                            <form method="get">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Pencarian Customer</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <label>ID</label>
                                                <input type="text" name="id" placeholder="ID" class="form-control"
                                                    value="{{ request('id') }}">
                                            </div>
                                            <div class="col-md-2">
                                                <label>Nama</label>
                                                <input type="text" name="name" placeholder="Name" class="form-control"
                                                    value="{{ request('name') }}">
                                            </div>
                                            <div class="col-md-2">
                                                <label>Email</label>
                                                <input type="text" name="email" placeholder="Email"
                                                    class="form-control" value="{{ request('email') }}">
                                            </div>
                                            <div class="col-md-2">
                                                <label>From Date</label>
                                                <input type="date" name="from_date" class="form-control"
                                                    value="{{ request('from_date') }}">
                                            </div>
                                            <div class="col-md-2">
                                                <label>To Date</label>
                                                <input type="date" name="to_date" class="form-control"
                                                    value="{{ request('to_date') }}">
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fas fa-search mr-1"></i>
                                                Cari</button>
                                            <a href="{{ url('admin/customer/list') }}" class="btn btn-secondary"><i
                                                    class="fas fa-sync-alt mr-1"></i> Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Daftar Customer</h3>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                {{-- <th>Status</th> --}}
                                                <th>Tanggal Dibuat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($getRecord as $value)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $value->name }}</td>
                                                    <td>{{ $value->email }}</td>
                                                    {{-- <td>
                                                        @if ($value->status == 0)
                                                            <span class="badge badge-success">Aktif</span>
                                                        @else
                                                            <span class="badge badge-secondary">Nonaktif</span>
                                                        @endif
                                                    </td> --}}
                                                    <td>{{ $value->created_at->format('d-m-Y H:i:s') }}</td>
                                                    <td>
                                                        <a href="{{ url('admin/customer/delete/' . $value->id) }}"
                                                            class="btn btn-danger">Delete</a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                    <div style="padding: 10px; float: right;">
                                        {!! $getRecord->appends(request()->except('page'))->links() !!}
                                    </div>
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
