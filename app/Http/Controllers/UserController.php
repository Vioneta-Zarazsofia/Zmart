<?php

namespace App\Http\Controllers;
use App\Models\OrderModel;
use App\Models\ProductReviewModel;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\ProductWishlistModel;
use Carbon\Carbon;

class UserController extends Controller
{

   public function dashboard()
{
    $userId = Auth::id();
    $today = now()->toDateString();

    // Ambil hanya pesanan dengan status terverifikasi atau selesai
    $validOrders = OrderModel::where('user_id', $userId)
        ->whereIn('is_payment', [1, 3])
        ->get();

    $TotalOrder = $validOrders->count();
    $TotalTodayOrder = $validOrders->where('created_at', '>=', $today)->count();
    $TotalAmount = $validOrders->sum('total_amount');
    $TotalTodayAmount = $validOrders->where('created_at', '>=', $today)->sum('total_amount');

    // Status lain tetap dihitung
    $TotalTerverifikasi = OrderModel::where('user_id', $userId)->where('is_payment', 1)->count();
    $TotalSelesai = OrderModel::where('user_id', $userId)->where('is_payment', 3)->count();
    $TotalMenunggu = OrderModel::where('user_id', $userId)->where('is_payment', 0)->count();
    $TotalDitolak = OrderModel::where('user_id', $userId)->where('is_payment', 2)->count();
    $TotalDibatalkan = OrderModel::where('user_id', $userId)->where('is_payment', 4)->count();


    return view('user.dashboard', compact(
        'TotalOrder',
        'TotalTodayOrder',
        'TotalAmount',
        'TotalTodayAmount',
        'TotalTerverifikasi',
        'TotalSelesai',
        'TotalMenunggu',
        'TotalDitolak',
        'TotalDibatalkan'
    ));
}

    public function orders()
{
    $data['orders'] = OrderModel::getRecordUser(Auth::user()->id);
    $data['meta_title'] = 'Orders';
    return view('user.orders', $data);
}

public function orders_detail($id)
{
   $data['order'] = OrderModel::where('id', $id)
    ->where('user_id', Auth::id())
    ->with(['items.product', 'courier'])
    ->first();

if (!$data['order']) {
    return redirect('user/orders')->with('error', 'Pesanan tidak ditemukan.');
}


    $data['meta_title'] = 'Order Detail';
    $data['meta_description'] = '';
    $data['meta_keyword'] = '';

    return view('user.orders_detail', $data);
}
public function cancelOrder($id)
{
    $order = OrderModel::where('user_id', Auth::id())->findOrFail($id);

    if ($order->is_payment == 0) {
        $order->is_payment = 4; // Status 4 = Dibatalkan
        $order->rejection_note = 'Dibatalkan oleh pelanggan';
        $order->save();

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    return back()->with('error', 'Pesanan tidak dapat dibatalkan.');
}


public function markOrderDone($id)
{
    $order = OrderModel::where('user_id', Auth::id())->findOrFail($id);

    if ($order->is_payment == 1) {
        $order->is_done = 1;
        $order->is_payment = 3;
        $order->completed_time = now();
        $order->save();
    }

    return back()->with('success', 'Pesanan ditandai selesai.');
}


    public function edit_profile()
    {
        $data['meta_title'] ='Edit Profile';
        $data['meta_description'] = '';
        $data['meta_keyword'] = '';
        $data['getRecord'] = User::getSingle(Auth::user()->id);
        return view('user.edit_profile', $data);
    }
    public function update_profile(Request $request)
    {
        $user = User::getSingle(Auth::user()->id);
        $user->name = trim($request->name);
        $user->address = trim($request->address);
        $user->subdistrict = trim($request->subdistrict);
        $user->village = trim($request->village);
        $user->postcode = trim($request->postcode);
        $user->phone = trim($request->phone);
        $user->email = trim($request->email);
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function change_password()
    {
        $data['meta_title'] ='Change Password';
        $data['meta_description'] = '';
        $data['meta_keyword'] = '';
        return view('user.change_password', $data);
    }
    public function update_password(Request $request)
    {
        $user = User::getSingle(Auth::user()->id);
        if(Hash::check($request->old_password, $user->password)){
            if($request->password == $request->cpassword){
                $user->password = Hash::make($request->password);
                $user->save();
                return redirect()->back()->with('success', 'Password berhasil diubah.');
            }
            else{
                return redirect()->back()->with('error', 'Password baru dan konfirmasi password tidak cocok.');
            }
        }
        else{
            return redirect()->back()->with('error', 'Password lama tidak sesuai.');
        }
    }
    /**
     * Toggle product wishlist status for the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function add_to_wishlist(Request $request)
    {
        $check = ProductWishlistModel::checkAlready($request->product_id, Auth::user()->id);
        if (empty($check)) {
            $save = new ProductWishlistModel();
            $save->product_id = $request->product_id;
            $save->user_id = Auth::user()->id;
            $save->save();

            $json['is_wishlist'] = 1;
        } else {
            ProductWishlistModel::DeleteRecord($request->product_id, Auth::user()->id);
            $json['is_wishlist'] = 0;
        }

        $json['status'] = 'true';
        echo json_encode($json);
    }
    public function submit_review(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:product,id',
        'order_id' => 'required|exists:orders,id',
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'required|string|max:1000',
    ]);

    $review = new ProductReviewModel;
    $review->product_id = $request->product_id;
    $review->order_id = $request->order_id;
    $review->user_id = auth()->id();
    $review->rating = $request->rating;
    $review->review = $request->review;
    $review->save();

    return redirect()->back()->with('success', 'Review berhasil dikirim.');
}

}
