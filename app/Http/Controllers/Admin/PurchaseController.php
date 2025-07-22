<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\SupplierModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class PurchaseController extends Controller
{
public function index(Request $request)
    {
        $suppliers = SupplierModel::all();
        $products = [];
        $data['header_title'] = 'Pembelian Produk';

        if ($request->supplier_id) {
            $products = ProductModel::where('supplier_id', $request->supplier_id)->get();
        }

        return view('admin.purchase.index', compact('suppliers', 'products'),$data);
    }

public function exportPdf(Request $request)
{
    $productIds = $request->product_ids ?? [];
    $quantities = $request->quantities ?? [];
    $supplier = SupplierModel::findOrFail($request->supplier_id);

    $products = [];

    foreach ($productIds as $index => $productId) {
        $product = ProductModel::find($productId);
        if ($product) {
            $product->purchase_quantity = $quantities[$index] ?? 1;
            $products[] = $product;
        }
    }

    $pdf = PDF::loadView('admin.purchase.pdf', compact('products', 'supplier'));
    $filename = 'daftar-pembelian-' . Str::slug($supplier->name) . '.pdf';
    return $pdf->download($filename);
}

}
