@extends('admin.layouts.app')
@section('style')
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-6">
                        <h1>Daftar Kurir</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ url('admin/courier/add') }}" class="btn btn-primary">Tambah Kurir</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                @include('admin.layouts._message')
                <div class="card">
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>No. Telepon</th>
                                    <th>Email</th>
                                    <th>Alamat</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($couriers as $courier)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $courier->name }}</td>
                                        <td>{{ $courier->phone }}</td>
                                        <td>{{ $courier->email ?? '-' }}</td>
                                        <td>{{ $courier->address ?? '-' }}</td>
                                        <td>
                                            @if ($courier->status == 0)
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-secondary">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td class="action-btns">
                                            <a href="{{ url('admin/courier/edit/' . $courier->id) }}"
                                                class="btn btn-primary ">Edit</a>
                                            <a href="{{ url('admin/courier/delete/' . $courier->id) }}"
                                                class="btn btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Data kurir tidak ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
@endsection
