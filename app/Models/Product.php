<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'brand_id',
        'product_name',
        'sale_unit',
        'sale_price',
        'retail_price',
        'classification',
        'product_type',
        'formulation',
        'barcode',
        'prescription',
        'description',
        'image_url',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function productSupply()
    {
        return $this->hasMany(ProductSupply::class);
    }
}
