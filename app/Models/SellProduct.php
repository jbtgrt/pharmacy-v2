<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'sale_unit',
        'original_price',
        'discount',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Method to find product by ID
    public function findProductById($productId)
    {
        return $this->product()->find($productId);
    }
}
