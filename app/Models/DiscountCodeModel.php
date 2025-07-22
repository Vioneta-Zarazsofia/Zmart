<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCodeModel extends Model
{
    use HasFactory;
    protected $table = 'discountcode';

    static function getSingle($id)
    {
        return self::find($id);
    }

    static public function getRecord()
    {

        return self::select('discountcode.*')
            ->where('discountcode.is_delete', '=', 0)
            ->orderBy('discountcode.id', 'desc')
            ->paginate(20);
    }
    static public function CheckDiscount($discountcode)
    {
        return self::select('discountcode.*')
            ->where('discountcode.is_delete', '=', 0)
            ->where('discountcode.status', '=', 0)
            ->where('discountcode.name', '=', $discountcode)
            ->where('discountcode.expire_date', '>=', date('Y-m-d'))
            ->first();
    }

}