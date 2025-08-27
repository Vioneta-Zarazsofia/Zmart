<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierModel extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

    // Tambahkan properti fillable
    protected $fillable = [
        'name',
        'phone',
        'status',
    ];

 public function purchases()
    {
        return $this->hasMany(Purchase::class, 'supplier_id');
    }

    public function products()
    {
        return $this->hasMany(ProductModel::class);
    }
}
