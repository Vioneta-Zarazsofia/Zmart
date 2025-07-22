<?php

namespace App\Models;
use App\Models\SupplierModel;
use App\Models\PurchaseRequestItem;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    protected $fillable = ['supplier_id'];

    public function supplier()
    {
        return $this->belongsTo(SupplierModel::class, 'supplier_id');
    }

    public function items()
    {
        return $this->hasMany(PurchaseRequestItem::class);
    }
}