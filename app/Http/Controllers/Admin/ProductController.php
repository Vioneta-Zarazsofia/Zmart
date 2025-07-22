<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\CategoryModel;
use App\Models\BrandModel;
use App\Models\SubCategoryModel;
use App\Models\ProductImageModel;
use App\Models\SupplierModel;

class ProductController extends Controller
{
    public function list()
    {
        $data['getRecord'] = ProductModel::getRecord();
        $data['header_title'] = 'Daftar Produk';
        return view('admin.product.list', $data);
    }

    public function add()
    {
        $data['getCategory'] = CategoryModel::all();
        $data['getBrand'] = BrandModel::all();
        $data['getSuppliers'] = SupplierModel::all();
        $data['header_title'] = 'Tambah Produk';
        return view('admin.product.add', $data);
    }

    public function insert(Request $request)
    {
        $title = trim($request->title);
        $product = new ProductModel();
        $product->title = $title;
        $product->created_by = Auth::guard('admin')->user()->id;
        $product->save();

        // Slug
        $slug = Str::slug($title, "-");
        $checkSlug = ProductModel::checkSlug($slug);

        $product->slug = empty($checkSlug) ? $slug : $slug . '-' . $product->id;
        $product->save();

        return redirect('admin/product/list')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $product = ProductModel::with(['getImage'])->findOrFail($id);
        $getCategory = CategoryModel::all();
        $getSubCategory = SubCategoryModel::where('category_id', $product->category_id)->get();
        $getBrand = BrandModel::all();
        $getSuppliers = SupplierModel::all();
        $data['header_title'] = 'Edit Produk';

        return view('admin.product.edit', array_merge(
            compact('product', 'getCategory', 'getSubCategory', 'getBrand', 'getSuppliers'),
            $data
        ));
    }

    public function update($product_id, Request $request)
    {
        $product = ProductModel::getSingle($product_id);
        if (!$product) {
            abort(404);
        }

        $product->title = trim($request->title);
        $product->sku = trim($request->sku);
        $product->category_id = trim($request->category_id);
        $product->sub_category_id = trim($request->sub_category_id);
        $product->brand_id = trim($request->brand_id);
        $product->purchase_price = trim($request->purchase_price);
        $product->price = trim($request->price);
        $product->stock = trim($request->stock);
        $product->supplier_id = trim($request->supplier_id);
        $product->description = trim($request->description);
        $product->additional_information = trim($request->additional_information);
        $product->status = trim($request->status);
        $product->save();

        // Upload gambar baru
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $value) {
                if ($value->isValid()) {
                    $extension = $value->getClientOriginalExtension();
                    $filename = strtolower($product->id . Str::random(20)) . '.' . $extension;
                    $value->move(public_path('upload/product'), $filename);

                    $imageUpload = new ProductImageModel();
                    $imageUpload->image_name = $filename;
                    $imageUpload->image_extension = $extension;
                    $imageUpload->product_id = $product->id;
                    $imageUpload->save();
                }
            }
        }

        return redirect()->back()->with('success', 'Produk berhasil diperbarui');
    }

    public function delete($id)
    {
        $product = ProductModel::findOrFail($id);
        $product->delete();

        return redirect('admin/product/list')->with('success', 'Produk berhasil dihapus');
    }

    public function image_delete($id)
    {
        $image = ProductImageModel::getSingle($id);
        if ($image && file_exists(public_path('upload/product/' . $image->image_name))) {
            unlink(public_path('upload/product/' . $image->image_name));
        }
        $image->delete();

        return redirect()->back()->with('success', 'Gambar berhasil dihapus');
    }

    public function product_image_sortable(Request $request)
    {
        if (!empty($request->photo_id)) {
            foreach ($request->photo_id as $index => $photo_id) {
                $image = ProductImageModel::getSingle($photo_id);
                if ($image) {
                    $image->order_by = $index + 1;
                    $image->save();
                }
            }
        }

        return response()->json(['success' => true]);
    }
}