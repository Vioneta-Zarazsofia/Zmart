@extends('admin.layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1>Edit Produk</h1>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                @include('admin.layouts._message')

                <div class="card card-primary">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">

                            {{-- Informasi Produk --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Produk <span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control" required
                                            value="{{ old('title', $product->title) }}" placeholder="Masukkan nama produk">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>SKU <span class="text-danger">*</span></label>
                                        <input type="text" name="sku" class="form-control" required
                                            value="{{ old('sku', $product->sku) }}" placeholder="Masukkan SKU">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kategori <span class="text-danger">*</span></label>
                                        <select name="category_id" class="form-control" id="ChangeCategory" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($getCategory as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Sub Kategori <span class="text-danger">*</span></label>
                                        <select name="sub_category_id" class="form-control" id="getSubCategory" required>
                                            <option value="">-- Pilih Sub Kategori --</option>
                                            @foreach ($getSubCategory as $subcategory)
                                                <option value="{{ $subcategory->id }}"
                                                    {{ $product->sub_category_id == $subcategory->id ? 'selected' : '' }}>
                                                    {{ $subcategory->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Brand</label>
                                        <select name="brand_id" class="form-control">
                                            <option value="">-- Pilih Brand --</option>
                                            @foreach ($getBrand as $brand)
                                                <option value="{{ $brand->id }}"
                                                    {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Tambahan Supplier dan Stock --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Supplier</label>
                                        <select name="supplier_id" class="form-control">
                                            <option value="">-- Pilih Supplier --</option>
                                            @foreach ($getSuppliers as $supplier)
                                                <option value="{{ $supplier->id }}"
                                                    {{ $product->supplier_id == $supplier->id ? 'selected' : '' }}>
                                                    {{ $supplier->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Stok Produk</label>
                                        <input type="number" name="stock" class="form-control"
                                            value="{{ old('stock', $product->stock) }}" placeholder="Jumlah stok tersedia">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="purchase_price">Harga Beli (Dari Supplier)</label>
                                        <input type="number" name="purchase_price" class="form-control"
                                            value="{{ old('purchase_price', $product->purchase_price ?? 0) }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Harga Jual (Untuk Customer) (Rp) <span class="text-danger">*</span></label>
                                        <input type="number" name="price" class="form-control" required
                                            value="{{ $product->price }}" placeholder="Harga">
                                    </div>
                                </div>

                            </div>

                            {{-- Upload Gambar --}}
                            <div class="form-group">
                                <label>Upload Gambar</label>
                                <input type="file" name="image[]" class="form-control" multiple accept="image/*">
                            </div>

                            @if ($product->getImage->count())
                                <div class="row" id="sortable">
                                    @foreach ($product->getImage as $image)
                                        <div class="col-md-2 sortable_image" id="{{ $image->id }}">
                                            <img src="{{ $image->getLogo() }}" class="img-fluid mb-2"
                                                style="height:100px; object-fit:cover;">
                                            <a href="{{ url('admin/product/image_delete/' . $image->id) }}"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Hapus gambar ini?')">Hapus</a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <hr>

                            {{-- Deskripsi --}}
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="description" class="form-control" rows="2">{{ $product->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Informasi Tambahan</label>
                                <textarea name="additional_information" class="form-control editor">{{ $product->additional_information }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Status Produk</label>
                                <select name="status" class="form-control" required>
                                    <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Aktif</option>
                                    <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Tidak Aktif
                                    </option>
                                </select>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/sortable/jquery-ui.js') }}"></script>

    <script>
        $(function() {
            $('.editor').summernote({
                height: 120
            });

            $("#sortable").sortable({
                update: function(event, ui) {
                    let photo_id = [];
                    $('.sortable_image').each(function() {
                        photo_id.push($(this).attr('id'));
                    });

                    $.post("{{ url('admin/product_image_sortable') }}", {
                        photo_id: photo_id,
                        _token: "{{ csrf_token() }}"
                    });
                }
            });

            $('#ChangeCategory').on('change', function() {
                var id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "{{ url('admin/get_sub_category') }}",
                    data: {
                        "id": id,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(data) {
                        $('#getSubCategory').html(data.html);
                    },
                    error: function(data) {
                        console.error(data);
                    }
                });
            });
        });
    </script>
@endsection
