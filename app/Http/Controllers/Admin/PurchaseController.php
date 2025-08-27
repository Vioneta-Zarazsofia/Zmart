<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\SupplierModel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PurchaseController extends Controller

{
    public function index(Request $request)
{
    $suppliers = SupplierModel::all();
    $products = collect();
    $data['header_title'] = 'Pembelian Produk';

    if ($request->supplier_id) {
        $products = ProductModel::where('supplier_id', $request->supplier_id)->get();
    }

    $purchases = Purchase::with('supplier')
        ->orderBy('purchase_date','desc')
        ->get();

    return view('admin.purchase.index', compact('suppliers','products','purchases'))->with($data);
}

public function exportPdf(Request $request)
{
    $productIds = $request->product_ids ?? [];
    $quantities = $request->quantities ?? [];
    $supplier = SupplierModel::findOrFail($request->supplier_id);

    $products = [];

    foreach ($productIds as $productId) {
    $product = ProductModel::find($productId);
    if ($product) {
        $product->purchase_quantity = $quantities[$productId] ?? 1;
        $products[] = $product;
    }
}


    $pdf = PDF::loadView('admin.purchase.pdf', compact('products', 'supplier'));
    $filename = 'daftar-pembelian-'
        . Str::slug($supplier->name, '-')
        . '-' . now()->format('Y-m-d')
        . '.pdf';
    return $pdf->download($filename);
}

public function store(Request $request)
{
    $purchase = Purchase::create([
        'supplier_id'   => $request->supplier_id,
        'purchase_date' => $request->purchase_date ?? now(),
        'status'        => 'pending',
        'notes'         => $request->notes,
    ]);

    $productIds = $request->product_ids ?? [];
    $quantities = $request->quantities ?? [];
    $prices     = $request->purchase_price ?? [];

    foreach ($productIds as $productId) {
        $qty   = $quantities[$productId] ?? 0;
        $price = $prices[$productId] ?? 0;

        if ($qty > 0) {
            PurchaseItem::create([
                'purchase_id'  => $purchase->id,
                'product_id'   => $productId,
                'qty'          => $qty,
                'price'        => $price,
            ]);
        }
    }

    // Langsung generate PDF setelah simpan
    return $this->downloadPdf($purchase->id);
}
public function downloadPdf($id)
{
    $purchase = Purchase::with(['supplier', 'items.product'])->findOrFail($id);

    $fileName = 'Purchase_Order_' . $purchase->id . '_' . now()->format('Y-m-d') . '.pdf';
    $pdf = Pdf::loadView('admin.purchase.pdf', compact('purchase'))->setPaper('a4', 'portrait');

    return $pdf->download($fileName);
}
public function show($id)
{
    $purchase = Purchase::with(['supplier', 'items.product'])->findOrFail($id);
    return view('admin.purchase.show', compact('purchase'));
}

    // konfirmasi penerimaan barang
public function confirm($id)
{
    $purchase = Purchase::with('items')->findOrFail($id);

    if ($purchase->status !== 'confirmed') {
        foreach ($purchase->items as $item) {
            $product = ProductModel::find($item->product_id);
            if ($product) {
                $product->stock += $item->qty; // pastikan sesuai field 'qty'
                $product->save();
            }
        }

        $purchase->update(['status' => 'confirmed']);
    }

    return redirect()->back()->with('success', 'Pembelian berhasil dikonfirmasi, stok diperbarui!');
}


}