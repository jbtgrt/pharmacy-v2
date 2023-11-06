<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerOrder extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'product_name',
        'price',
        'quantity',
        'total',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class);
    }

     public function product()
    {
        return $this->belongsTo(SupplierProduct::class);
    }

}
