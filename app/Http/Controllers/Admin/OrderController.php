<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderModel;
use App\Models\Courier;
use Illuminate\Support\Facades\DB;
use App\Models\ProductModel;
use Carbon\Carbon;
class OrderController extends Controller
{
    public function waiting(Request $request)
    {
        $data['header_title'] = 'Daftar Pesanan';
        $query = OrderModel::query();

        if ($request->filled('id')) $query->where('id', $request->id);
        if ($request->filled('name')) $query->where('name', 'like', '%' . $request->name . '%');
        if ($request->filled('email')) $query->where('email', 'like', '%' . $request->email . '%');
        if ($request->filled('phone')) $query->where('phone', 'like', '%' . $request->phone . '%');
        if ($request->filled('address')) {
            $query->where(function ($q) use ($request) {
            $q->where('address', 'like', '%' . $request->address . '%')
            ->orWhere('village', 'like', '%' . $request->address . '%')
            ->orWhere('subdistrict', 'like', '%' . $request->address . '%');
        });
    }
        if ($request->filled('from_date')) $query->whereDate('created_at', '>=', $request->from_date);
        if ($request->filled('to_date')) $query->whereDate('created_at', '<=', $request->to_date);
        $data['orders'] = $query->with('courier')->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('admin.orders.waiting', $data);
    }

  public function verify($id)
    {
        $order = OrderModel::with('items')->findOrFail($id);
        $order->is_payment = 1;
        $order->rejection_note = null;
        $order->save();

        $order->reduceStockIfNeeded();
        if (!$order->stock_deducted) {
            foreach ($order->items as $item) {
                $product = ProductModel::find($item->product_id);
                if ($product) {
                    $product->stock -= $item->quantity;
                    $product->save();
                }
            }
            $order->stock_deducted = true;
        }

        $order->save();
        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }


public function reject(Request $request, $id)
    {
        $order = OrderModel::with('items')->findOrFail($id);
        $order->is_payment = 2;
        $order->rejection_note = $request->rejection_reason;

        if ($order->stock_deducted && !$order->stock_restocked) {
            foreach ($order->items as $item) {
                $product = ProductModel::find($item->product_id);
                if ($product) {
                    $product->stock += $item->quantity;
                    $product->save();
                }
            }
            $order->stock_restocked = true;
        }

        $order->save();
        return redirect()->back()->with('error', 'Pembayaran ditolak dan stok dikembalikan.');
    }
public function markDone($id)
{
    DB::beginTransaction();

    try {
        $order = OrderModel::with('getOrderItem')->findOrFail($id);

        if ($order->is_done == 1) {
            return back()->with('error', 'Pesanan sudah ditandai selesai.');
        }

        // Kurangi stok jika belum pernah dikurangi
        if (!$order->stock_deducted) {
            foreach ($order->getOrderItem as $item) {
                $product = ProductModel::find($item->product_id);
                if ($product && $product->stock >= $item->qty) {
                    $product->stock -= $item->qty;
                    $product->save();
                } else {
                    return back()->with('error', 'Stok tidak mencukupi untuk menyelesaikan pesanan.');
                }
            }
            $order->stock_deducted = true;
        }

        // Hapus log pengiriman dari courier_delivery_log
        DB::table('courier_delivery_log')
            ->where('order_id', $order->id)
            ->delete();

        // Tandai order sebagai selesai
        $order->is_done = 1;
        $order->is_payment = 3;
        $order->save();

        DB::commit();
        return back()->with('success', 'Pesanan berhasil ditandai selesai. Pengiriman kurir dikurangi.');
    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}




public function cancelVerify($id)
    {
        $order = OrderModel::with('items')->findOrFail($id);
        $order->is_payment = 0;
        $order->courier_id = null;
        $order->courier_name = null;
        $order->delivered_time = null;
        $order->estimated_arrival = null;
        $order->paid_at = null;
        $order->status = null;

        if ($order->stock_deducted && !$order->stock_restocked) {
            foreach ($order->items as $item) {
                $product = ProductModel::find($item->product_id);
                if ($product) {
                    $product->stock += $item->quantity;
                    $product->save();
                }
            }
            $order->stock_restocked = true;
        }

        $order->save();
        return redirect()->back()->with('warning', 'Verifikasi dibatalkan dan stok dikembalikan.');
    }

    public function cancelReject($id)
    {
        $order = OrderModel::findOrFail($id);
        $order->is_payment = 0;
        $order->rejection_note = null;
        $order->save();

        return redirect()->back()->with('warning', 'Penolakan dibatalkan.');
    }

public function detail($id)
{
    $data['header_title'] = 'Detail Pesanan';
    $data['order'] = OrderModel::with(['items.product', 'courier'])->findOrFail($id);

    // Daftar kurir + jumlah barang dibawa hari ini
    $data['couriers'] = DB::table('couriers')
        ->leftJoin('courier_delivery_log', function ($join) {
            $join->on('couriers.id', '=', 'courier_delivery_log.courier_id')
                ->whereDate('courier_delivery_log.delivered_date', Carbon::today());
        })
        ->select(
            'couriers.id',
            'couriers.name',
            DB::raw('COALESCE(SUM(courier_delivery_log.quantity), 0) as total_barang')
        )
        ->groupBy('couriers.id', 'couriers.name')
        ->get();

    return view('admin.orders.detail', $data);
}


    public function updateShipping(Request $request, $id)
{
    $request->validate([
        'courier_id' => 'required|exists:couriers,id',
        'delivered_time' => 'required|date',
        'estimated_arrival' => 'required|date|after_or_equal:delivered_time',
    ]);

    $order = OrderModel::with('items')->findOrFail($id);
    $courier = Courier::findOrFail($request->courier_id);

    $order->courier_id = $courier->id;
    $order->courier_name = $courier->name;
    $order->delivered_time = $request->delivered_time;
    $order->estimated_arrival = $request->estimated_arrival;
    $order->is_payment = 1;
    $order->status = 'confirmed';
    $order->save();

    // Catat barang yang dikirim oleh kurir
    foreach ($order->items as $item) {
        DB::table('courier_delivery_log')->insert([
            'courier_id' => $courier->id,
            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'quantity' => $item->quantity, // Barang ditambahkan
            'delivered_date' => Carbon::today(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return redirect()->route('admin.orders.waiting')->with('success', 'Pengiriman disimpan dan stok dikurangi.');
}
}
