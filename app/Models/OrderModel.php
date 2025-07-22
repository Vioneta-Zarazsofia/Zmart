<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use App\Models\Courier;
use App\Models\OrderItemModel;
use Illuminate\Support\Facades\Auth;

class OrderModel extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
          'user_id', 'order_number', 'total_amount', 'payment_method', 'is_payment',
    'paid_at', 'completed_time', 'rejected_time',
    'courier_id', 'delivered_time', 'estimated_arrival', 'subdistrict ','village '
    ];
      public function scopeForUser($query)
    {
        return $query->where('user_id', Auth::id());
    }
public function getOrderItem()
{
    return $this->hasMany(OrderItemModel::class, 'order_id', 'id');
}

    // //use part

    // static public function getTotalOrderUser($user_id)
    // {
    //     return self::select('id')
    //     ->where('user_id', '=', $user_id)
    //     ->where('is_payment', '=', 1)
    //     ->where('is_delete', '=', 0)
    //     ->count();
    // }
    //  static public function getTotalTodayOrderUser($user_id)
    // {
    //     return self::select('id')
    //     ->where('user_id', '=', $user_id)
    //     ->where('is_payment', '=', 1)
    //     ->where('is_delete', '=', 0)
    //     ->whereDate('created_at', '=', date('Y-m-d'))
    //     ->count();
    // }
    // static public function getTotalAmountUser($user_id)
    // {
    //     return self::where('user_id', '=', $user_id)
    //     ->where('is_payment', '=', 1)
    //     ->where('is_delete', '=', 0)
    //     ->sum('total_amount');
    // }
    // static public function getTotalTodayAmountUser($user_id)
    // {
    //     return self::where('user_id', '=', $user_id)
    //     ->where('is_payment', '=', 1)
    //     ->where('is_delete', '=', 0)
    //     ->whereDate('created_at', '=', date('Y-m-d'))
    //     ->sum('total_amount');
    // }
    // // 0: terverifikasi, 1: selesai, 3: ditolak
    // static public function getTotalOrderUserStatus($user_id, $status)
    // {
    //     return self::select('id')
    //     ->where('user_id', '=', $user_id)
    //     ->where('is_payment', '=', 1)
    //     ->where('is_delete', '=', 0)
    //     ->where('status', '=', $status)
    //     ->count();
    // }

        //end user part
    static public function getTotalOrder()
    {
        return self::where('is_done', 1)
            ->where('is_delete', 0)
            ->count();
    }

    static public function getTotalTodayOrder()
    {
        return self::where('is_done', 1)
            ->where('is_delete', 0)
            ->whereDate('created_at', date('Y-m-d'))
            ->count();
    }

    static public function getTotalAmount()
    {
        return self::where('is_done', 1)
            ->where('is_delete', 0)
            ->sum('total_amount');
    }

    static public function getTotalTodayAmount()
    {
        return self::where('is_done', 1)
            ->where('is_delete', 0)
            ->whereDate('created_at', date('Y-m-d'))
            ->sum('total_amount');
    }

    static public function getTotalOrderMonth($start_date, $end_date)
    {
        return self::where('is_done', 1)
            ->where('is_delete', 0)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->count();
    }

    static public function getTotalOrderAmountMonth($start_date, $end_date)
    {
        return self::where('is_done', 1)
            ->where('is_delete', 0)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->sum('total_amount');
    }

    public static function getSingle($id)
    {
        return self::find($id);
    }

    public static function getLatesOrders()
{
    return self::with('courier')
        ->where(function ($query) {
            $query->whereNull('is_done')
                  ->orWhere('is_done', '!=', 1);
        })
        ->orderBy('created_at', 'desc')
        ->take(10)
        ->get();
}

   static public function getRecordUser($user_id)
{
    return self::with('courier')
        ->where('user_id', '=', $user_id)
        ->where('is_delete', '=', 0)
        ->orderBy('id', 'desc')
        ->paginate(20);
}
static public function getSingleUser($user_id, $id)
{
    return self::with('courier')
        ->where('user_id', '=', $user_id)
        ->where('id', '=', $id)
        ->where('is_payment', '=', 1)
        ->where('is_delete', '=', 0)
        ->first();
}


    public static function getRecord()
{
    $query = self::query();
    if (Request::filled('id')) {
        $query->where('id', Request::get('id'));
    }

    if (Request::filled('name')) {
        $query->where('name', 'like', '%' . Request::get('name') . '%');
    }


    if (Request::filled('email')) {
        $query->where('email', 'like', '%' . Request::get('email') . '%');
    }

    if (Request::filled('address')) {
        $query->where(function($q) {
            $address = Request::get('address');
            $q->where('address', 'like', '%' . $address . '%')
              ->orWhere('address', 'like', '%' . $address . '%')
              ->orWhere('city', 'like', '%' . $address . '%')
              ->orWhere('postcode', 'like', '%' . $address . '%');
        });
    }

    if (Request::filled('phone')) {
        $query->where('phone', 'like', '%' . Request::get('phone') . '%');
    }
    if (Request::filled('from_date')) {
        $query->whereDate('created_at', '>=', Request::get('from_date'));
    }
    if (Request::filled('to_date')) {
        $query->whereDate('created_at', '<=', Request::get('to_date'));
    }

    // Filter tetap
    $query->where('is_delete', 0)
          ->whereIn('status', ['waiting_verification', 'rejected'])
          ->orderBy('created_at', 'desc');

    return $query->paginate(30);
}

    public function courier()
    {
        return $this->belongsTo(Courier::class, 'courier_id');
    }

    public function items()
{
    return $this->hasMany(OrderItemModel::class, 'order_id');
}
public function reduceStockIfNeeded()
{
    if ($this->is_payment == 1 && !$this->stock_deducted) {
        foreach ($this->items as $item) {
            $product = ProductModel::find($item->product_id);
            if ($product) {
                $product->stock -= $item->quantity;
                $product->save();
            }
        }
        $this->stock_deducted = true;
        $this->save();
    }
}



}
