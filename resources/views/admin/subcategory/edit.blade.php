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
                        <h1>Edit Kategori</h1>
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
                                            <label for="category_id">Nama Kategori<span style="color:red">*</span></label>
                                            <select class="form-control" id="category_id" name="category_id" required>
                                                <option value="">Select</option>
                                                @foreach ($getCategory as $value)
                                                    <option {{ $value->id == $getRecord->category_id ? 'selected' : '' }}
                                                        value="{{ $value->id }}"
                                                        {{ old('category_id') == $value->id ? 'selected' : '' }}>
                                                        {{ $value->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div style="color:red">{{ $errors->first('category_id') }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Sub Kategori<span style="color:red">*</span></label>
                                            <input type="text" class="form-control" required
                                                value="{{ old('name', $getRecord->name) }}" name="name"
                                                placeholder="Sub Category Name">
                                        </div>
                                        <div class="form-group">
                                            <label>Slug<span style="color:red">*</span></label>
                                            <input type="text" class="form-control" required
                                                value="{{ old('slug', $getRecord->slug) }}" name="slug"
                                                placeholder="Slug Ex. URL">
                                            <div style="color:red">{{ $errors->first('slug') }}</div>
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
                                        <hr>
                                        <div class="form-group">
                                            <label>Meta Title<span style="color:red">*</span></label>
                                            <input type="text" class="form-control" name="meta_title" required
                                                value="{{ old('meta_title', $getRecord->meta_title) }}"
                                                placeholder="Meta Title"></input>
                                        </div>

                                        <div class="form-group">
                                            <label>Meta Description</label>
                                            <textarea class="form-control" placeholder="Meta Description" name="meta_description">{{ old('meta_description', $getRecord->meta_description) }}
                                            </textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Meta Keywords</label>
                                            <input type="text" class="form-control"
                                                value="{{ old('meta_keywords', $getRecord->meta_keywords) }}"
                                                name="meta_keywords" placeholder="Meta Keywords">
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
