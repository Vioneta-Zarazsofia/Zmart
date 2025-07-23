<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DiscountCodeModel;
use App\Models\ProductModel;

class HomeController extends Controller
{
    public function home()
    {
        // Check if the user is authenticated and has the 'customer' role
        if (auth()->check() && auth()->user()->role === 'customer') {
            $data['products'] = ProductModel::with(['getImage', 'getCategory', 'getSubCategory'])
                ->where('status', 0)
                ->where('is_delete', 0)
                ->latest()
                ->take(20)
                ->get();

            $data['activeDiscounts'] = DiscountCodeModel::where('status', 0)
                ->where('is_delete', 0)
                ->whereDate('expire_date', '>=', now())
                ->get();

            return view('home', $data);
        } else {
            // Redirect to login or another page if not a customer
            return redirect()->route('login')->with('error', 'Silakan login sebagai customer untuk mengakses halaman ini.');
        }
    }


    public function payment_methods()
    {
        return view('page.metode_pembayaran');
    }
    public function returns()
    {
        return view('page.pengembalian');
    }
    public function shipping()
    {
        return view('page.pengiriman');
    }
    public function terms_conditions()
    {
        return view('page.syarat_ketentuan');
    }
    public function privacy_policy()
    {
        return view('page.kebijakan_privasi');
    }

}