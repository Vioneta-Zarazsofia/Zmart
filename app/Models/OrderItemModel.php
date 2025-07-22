<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductReviewModel;

class OrderItemModel extends Model
{
    use HasFactory;
    protected $table = 'orders_item';
    public function order()
    {
        return $this->belongsTo(OrderModel::class, 'order_id');
    }
    public function product()
{
    return $this->belongsTo(ProductModel::class, 'product_id');
}
    public function getReview($product_id, $order_id)
    {
        return ProductReviewModel::getReview($product_id, $order_id, auth()->id());
    }

}
