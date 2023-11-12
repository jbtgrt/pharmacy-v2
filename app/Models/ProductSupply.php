<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSupply extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'staff_id',
        'supplier_id',
        'product_id',
        'category_id',
        'brand_id',
        'batch_no',
        'unit_cost',
        'quantity',
        'total_cost',
        'date_received',
        'expires_at',
        'storage_location',
        'notes'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
