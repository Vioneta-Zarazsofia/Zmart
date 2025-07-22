@extends('admin.layouts.app')
@section('style')
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Contact Us</h1>
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
                                        <h3 class="card-title">Contact Us Search</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <label>ID</label>
                                                <input type="text" name="id" class="form-control"
                                                    value="{{ request('id') }}">
                                            </div>
                                            <div class="col-md-2">
                                                <label>Nama</label>
                                                <input type="text" name="name" class="form-control"
                                                    value="{{ request('name') }}">
                                            </div>
                                            <div class="col-md-2">
                                                <label>Email</label>
                                                <input type="text" name="email" class="form-control"
                                                    value="{{ request('email') }}">
                                            </div>
                                            <div class="col-md-2">
                                                <label>Phone</label>
                                                <input type="text" name="phone" class="form-control"
                                                    value="{{ request('phone') }}">
                                            </div>
                                            <div class="col-md-2">
                                                <label>Subject</label>
                                                <input type="text" name="subject" class="form-control"
                                                    value="{{ request('subject') }}">
                                            </div>

                                        </div>
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fas fa-search mr-1"></i>
                                                Cari</button>
                                            <a href="{{ url('admin/contactus') }}" class="btn btn-secondary"><i
                                                    class="fas fa-sync-alt mr-1"></i> Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Contact Us</h3>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Login Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Subject</th>
                                                <th>Message</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($getRecord as $value)
                                                <tr>
                                                    <td>{{ $value->id }}</td>
                                                    <td>{{ !empty($value->getUser) ? $value->getUser->name : '' }}</td>
                                                    <td>{{ $value->email }}</td>
                                                    <td>{{ $value->phone }}</td>
                                                    <td>{{ $value->subject }}</td>
                                                    <td>{{ $value->message }}</td>
                                                    <td>{{ $value->created_at->format('d-m-Y H:i:s') }}</td>

                                                    <td>
                                                        <a href="{{ url('admin/contactus/delete/' . $value->id) }}"
                                                            class="btn btn-danger ">Delete</a>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center">
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
