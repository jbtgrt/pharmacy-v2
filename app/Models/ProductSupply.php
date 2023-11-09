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
        'product_id',
        'product_name',
        'name',
        'description',
        'image_url',
        'expires_at',
        'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
