<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderModel;
use App\Models\User;
use App\Models\ProductModel;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $year = $request->year ?? date('Y');
        $data['year'] = $year;

        $data['TotalOrder'] = OrderModel::getTotalOrder();
        $data['TotalTodayOrder'] = OrderModel::getTotalTodayOrder();
        $data['TotalAmount'] = OrderModel::getTotalAmount();
        $data['TotalTodayAmount'] = OrderModel::getTotalTodayAmount();
        $data['TotalCustomer'] = User::getTotalCustomer();
        $data['TotalTodayCustomer'] = User::getTotalTodayCustomer();
        $data['getLatesOrders'] = OrderModel::getLatesOrders();

        $getTotalCustomerMonth = '';
        $getTotalOrderMonth = '';
        $getTotalOrderAmountMonth = '';
        $getTotalPurchaseAmountMonth = '';

        $totalAmount = 0;
        $totalPurchaseAmount = 0;

        for ($month = 1; $month <= 12; $month++) {
            $startDate = "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-01";
            $endDate = date("Y-m-t", strtotime($startDate));

            $customer = User::getTotalCustomerMonth($startDate, $endDate);
            $getTotalCustomerMonth .= $customer . ',';

            $order = OrderModel::getTotalOrderMonth($startDate, $endDate);
            $getTotalOrderMonth .= $order . ',';

            $orderpayment = OrderModel::getTotalOrderAmountMonth($startDate, $endDate);
            $getTotalOrderAmountMonth .= $orderpayment . ',';
            $totalAmount += $orderpayment;

            $purchaseAmount = ProductModel::getTotalPurchaseAmountMonth($startDate, $endDate);
            $getTotalPurchaseAmountMonth .= $purchaseAmount . ',';
            $totalPurchaseAmount += $purchaseAmount;
        }

        // Grafik: Pembelian Produk per Bulan per Supplier
       $purchasePerMonth = DB::table('purchases')
    ->join('purchase_items', 'purchases.id', '=', 'purchase_items.purchase_id')
    ->join('product', 'purchase_items.product_id', '=', 'product.id')
    ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
    ->selectRaw("
        DATE_FORMAT(purchases.purchase_date, '%Y-%m') as bulan,
        suppliers.name as supplier_name,
        product.title as product_name,
        SUM(purchase_items.qty) as total_qty
    ")
    ->whereYear('purchases.purchase_date', $year)
    ->where('purchases.status', 'confirmed')
    ->groupBy('bulan', 'supplier_name', 'product_name')
    ->orderBy('bulan')
    ->get();





        // Detail untuk Tabel Real-Time di Cart
        $purchaseDetail = DB::table('purchases')
    ->join('purchase_items', 'purchases.id', '=', 'purchase_items.purchase_id')
    ->join('product', 'purchase_items.product_id', '=', 'product.id')
    ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
    ->selectRaw('
        MONTH(purchases.purchase_date) as bulan,
        suppliers.name as supplier,
        product.title as produk,
        SUM(purchase_items.price * purchase_items.qty) as total_pembelian,
        SUM(purchase_items.qty) as jumlah_dibeli
    ')
    ->whereYear('purchases.purchase_date', $year)
    ->where('purchases.status', 'confirmed')
    ->groupBy('bulan', 'supplier', 'produk')
    ->orderBy('bulan')
    ->get();


        $data['purchasePerMonth'] = $purchasePerMonth;
        $data['purchaseDetail'] = $purchaseDetail;

        $data['getTotalCustomerMonth'] = rtrim($getTotalCustomerMonth, ',');
        $data['getTotalOrderMonth'] = rtrim($getTotalOrderMonth, ',');
        $data['getTotalOrderAmountMonth'] = rtrim($getTotalOrderAmountMonth, ',');
        $data['getTotalPurchaseAmountMonth'] = rtrim($getTotalPurchaseAmountMonth, ',');
        $data['totalAmount'] = $totalAmount;
        $data['totalPurchaseAmount'] = $totalPurchaseAmount;
        $data['header_title'] = 'Dashboard';

        return view('admin.dashboard', $data);
    }
}
