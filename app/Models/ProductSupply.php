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
        'unit_id',
        'batch_no',
        'unit_quantity',
        'quantity_per_unit',
        'unit_cost',
        'total_cost',
        'batch_stocks',
        'cost_per_piece',
        'date_received',
        'expires_at',
        'storage_location',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
