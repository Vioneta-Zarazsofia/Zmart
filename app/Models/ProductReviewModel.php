<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReviewModel extends Model
{
    use HasFactory;
    protected $table = 'product_review';

    static function getSingle($id)
    {
        return self::find($id);
    }
    public static function getReview($product_id, $order_id, $user_id)
{
    return self::select('*')
        ->where('product_id', $product_id)
        ->where('order_id', $order_id)
        ->where('user_id', $user_id)
        ->first();
}
public static function getReviewProduct ($product_id)
{
    return self::select('product_review.*','users.name')
        ->join('users', 'users.id', '=', 'product_review.user_id')
        ->where('product_review.product_id', $product_id)
        ->orderBy('product_review.id', 'DESC')
        ->paginate(20);
}
public static function getRatingAVG($product_id)
{
    return self::where('product_id', $product_id)->avg('rating');
}

public function getPercent(){
    $reting = $this->rating;
    if($reting == 1){
        return 20;
    }
    elseif($reting == 2){
        return 40;
    }
    elseif($reting == 3){
        return 60;
    }
    elseif($reting == 4){
        return 80;
    }
    elseif($reting == 5){
        return 100;
    }
    else{
        return 0;
    }
}

}
