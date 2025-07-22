<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\DiscountCodeModel;
use App\Models\ShippingChargeModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Stripe\Climate\Order;
use App\Mail\OrderInvoiceMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class PaymentController extends Controller
{

    public function apply_discount_code(Request $request)
    {
       $getDiscount = DiscountCodeModel::CheckDiscount($request->discountcode);
       if(!empty($getDiscount))
       {

            $total = Cart::getSubTotal();
            if($getDiscount->type == 'Amount')
            {
                $discount_amount = $getDiscount->percent_amount;
                $payable_total = $total - $getDiscount->percent_amount;
            }
            else
            {
                $discount_amount = ($total * $getDiscount->percent_amount) / 100;
                $payable_total = $total - $discount_amount;
            }

            $json['status'] =true;
            $json['discount_amount'] = number_format($discount_amount, 2);
            $json['payable_total'] = $payable_total;
            $json['message'] = 'Kode diskon berhasil diterapkan.';
       }
       else
       {
            $json['status'] =false;
            $json['discount_amount'] = '0.00';
            $json['payable_total'] = Cart::getSubTotal();
            $json['message'] = 'Kode diskon tidak valid. Silakan coba lagi.';
       }
       echo json_encode($json);
    }
    public function checkout(Request $request)
    {
        $data['meta_title'] = 'Checkout';
        $data['meta_description'] = '';
        $data['meta_keyword'] = '';
        $data['getShipping'] = ShippingChargeModel::getRecordActive();

        return view('payment.checkout', $data);
    }
    public function cart(Request $request)
    {
        $data['meta_title'] = 'Cart';
        $data['meta_description'] = '';
        $data['meta_keyword'] = '';

        return view('payment.cart', $data);
    }
    public function cart_delete($id)
    {
        Cart::remove($id);
        return redirect()->back();
    }
    public function add_to_cart(Request $request)
    {
        $getProduct = ProductModel::getSingle($request->product_id);
        $total = $getProduct->price;

        Cart::add([
            'id' => $getProduct->id,
            'name' => 'Product',
            'quantity' => $request->qty,
            'price' => $total,
            'attributes' => array()
        ]);
        return redirect()->back();
    }
    public function update_cart(Request $request)
    {
        foreach ($request->cart as $cart)
        {
            Cart::update($cart['id'], array(
            'quantity' => array(
                'relative' => false,
                'value' => $cart['qty']
            )
            ));
        }
        return redirect()->back();
    }
    public function place_order(Request $request)
    {
        $validate = 0;
        $message = '';
        if(!empty(Auth::check()))
        {
            $user_id = Auth::user()->id;
        }
        else
        {
                    if(!empty($request->is_create))
        {
            $checkEmail = User::checkEmail($request->email);
            if(!empty($checkEmail))
            {
                $message = 'Email sudah terdaftar. Silakan masuk atau gunakan email lain.';
                $validate = 1;
            }
            else
            {
                $save = new User();
                $save->name = trim($request->name);
                $save->email = trim($request->email);
                $save->password = Hash::make($request->password);
                $save->save();

                $user_id = $save->id;

            }
        }
        else
        {
            $user_id = '';
        }
        }


        if(empty($validate))
        {
        $getShipping = ShippingChargeModel::getSingle($request->shipping_id);
        $payable_total = Cart::getSubTotal();
        $discount_amount = 0;
        $discount_code = '';
        if(!empty($request->discount_code))
        {
            $getDiscount = DiscountCodeModel::CheckDiscount($request->discount_code);
            if(!empty($getDiscount))
            {
            $discount_code = $getDiscount->code;
                if($getDiscount->type == 'Amount')
            {
                $discount_amount = $getDiscount->percent_amount;
                $payable_total = $payable_total - $getDiscount->percent_amount;
            }
            else
            {
                $discount_amount = ($payable_total * $getDiscount->percent_amount) / 100;
                $payable_total = $payable_total - $discount_amount;
            }
            }
        }

        $shipping_amount = !empty($getShipping->price) ? $getShipping->price : 0;
        $total_amount = $payable_total + $shipping_amount;

        $order = new OrderModel();
        if(!empty($user_id))
        {
            $order->user_id = trim($user_id);
        }
        $order->order_number = mt_rand(100000, 999999);
        $order->name = trim($request->name);
        $order->address = trim($request->address);
        $order->subdistrict = trim($request->subdistrict);
        $order->village = trim($request->village);
        $order->postcode = trim($request->postcode);
        $order->phone = trim($request->phone);
        $order->email = trim($request->email);
        $order->note = trim($request->note);
        $order->discount_amount = trim($discount_amount);
        $order->discount_code = trim($discount_code);
        $order->shipping_id = trim ($request->shipping_id);
        $order->shipping_amount = trim ($shipping_amount);
        $order->total_amount = trim ($total_amount);
        $order->payment_method = trim ($request->payment_method);
        $order->save();

        foreach (Cart::getContent() as $cart)
        {
            $order_item = new OrderItemModel();
            $order_item->order_id = $order->id;
            $order_item->product_id = $cart->id;
            $order_item->quantity = $cart->quantity;
            $order_item->price = $cart->price;
            $order_item->total_price = $cart->price;
            $order_item->save();

        }
        $json['status'] = true;
        $json['message'] = "Pesanan Anda berhasil diproses. Terima kasih telah berbelanja di toko kami!";
        $json['redirect'] = url('checkout/payment?order_id=' . base64_encode($order->id));

        }
        else{
            $json['status'] = false;
            $json['message'] =$message;
        }
            echo json_encode($json);
    }
    // public function checkout_payment(Request $request)
    // {
    //     if(!empty(Cart::getSubTotal()) && !empty($request->order_id))
    //     {
    //         $order_id = base64_decode($request->order_id);
    //         $getOrder = OrderModel::getSingle($order_id);
    //         if(!empty($getOrder))
    //         {
    //             if ($getOrder->payment_method == 'cash')
    //             {
    //                 $getOrder->is_payment = 1;
    //                 $getOrder->save();

    //                 Cart::clear();
    //                 return redirect('cart')->with('success', "Pesanan Anda telah berhasil dilakukan dan pembayaran Anda telah diterima. Terima kasih telah berbelanja di toko kami!");
    //             }
    //             else if($getOrder->payment_method == 'paypal')
    //             {
    //                 $query = array();
    //                 $quary['business'] = "vipulbusiness@gmail.com";
    //                 $quary['cmd'] = '_xclick';
    //                 $quary['item_name'] = "E-Commerce";
    //                 $query['no_shipping'] = 1;
    //                 $quary['item_number'] = $getOrder->id;
    //                 $quary['amount'] = $getOrder->total_amount;
    //                 $quary['currency_code'] = 'USD';
    //                 $quary['return'] = url('paypal/success-payment');
    //                 $quary['cancel_return'] = url('checkout');

    //                 $query_string = http_build_query($quary);

    //                 header('Location: https://www.sandbox.paypal.com/cgi-bin/webscr?' . $query_string);

    //                 exit();
    //             }
    //             else if ($getOrder->payment_method == 'stripe')
    //             {

    //             }
    //         }
    //         else
    //         {
    //             abort(404);
    //         }
    //     }

    //     else
    //     {
    //         abort(404);
    //     }
    //
    public function checkout_payment(Request $request)
{
    if (!empty(Cart::getSubTotal()) && !empty($request->order_id)) {
        $order_id = base64_decode($request->order_id);
        $getOrder = OrderModel::getSingle($order_id);

        if (!empty($getOrder)) {
            if ($getOrder->payment_method == 'cash') {
                $getOrder->is_payment = 1;
                $getOrder->save();
                Cart::clear();
                return redirect('cart')->with('success', "Pesanan Anda telah berhasil dilakukan dan pembayaran Anda telah diterima.");
            } elseif ($getOrder->payment_method == 'bri') {
                $getOrder->is_payment = 0;
                $getOrder->payment_deadline = now()->addHours(24);
                $getOrder->status = 'pending';
                $getOrder->save();
                Cart::clear();

                return redirect()->route('payment.confirm.form', $getOrder->id)
                    ->with('success', 'Silakan lakukan pembayaran dalam waktu 24 jam.');
            }
        } else {
            abort(404);
        }
    } else {
        abort(404);
    }
}

    // public function paypal_success_payment(Request $request)
    // {
    //     if(!empty($request->item_number)&& !empty($request->st)&& $request->st == 'completed')
    //     {
    //         $getOrder = OrderModel::getSingle($$request->item_number);
    //         if(!empty($getOrder))
    //         {
    //             $getOrder->is_payment = 1;
    //             $getOrder->transaction_id = $request->txn;
    //             $getOrder->payment_data = json_encode($request->all());
    //             $getOrder->save();

    //             Cart::clear();
    //             return redirect('cart')->with('success', "Pesanan Anda telah berhasil dilakukan dan pembayaran Anda telah diterima. Terima kasih telah berbelanja di toko kami!");
    //         }
    //         else
    //         {
    //             abort(404);
    //         }
    //     }
    //     else
    //     {
    //         abort(404);
    //     }
    //     {

    //     }
    // }
   public function confirmPaymentForm($order_id)
    {
        $order = OrderModel::findOrFail($order_id);
        return view('payment.confirm', compact('order'));
    }

public function submitPaymentProof(Request $request, $order_id)
{
    $request->validate([
        'payment_proof' => 'required|image|mimes:jpeg,jpg,png|max:2048',
    ]);

    $order = OrderModel::findOrFail($order_id);

    if ($request->hasFile('payment_proof')) {
        $file = $request->file('payment_proof');
        $filename = time() . '_' . $file->getClientOriginalName(); // contoh: 1720801932_bukti.jpg
        $destinationPath = public_path('uploads/payment_proofs'); // akan disimpan di /public/uploads/payment_proofs

        // Pastikan folder ada, kalau belum buat
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $file->move($destinationPath, $filename);
        $order->payment_proof = 'uploads/payment_proofs/' . $filename;
        $order->status = 'waiting_verification';
        $order->paid_at = Carbon::now();

        Mail::to($order->email)->send(new OrderInvoiceMail($order));
        $order->save();
    }

    return redirect('cart')->with('success', 'Bukti pembayaran berhasil diunggah. Tunggu verifikasi admin.');
}

}
