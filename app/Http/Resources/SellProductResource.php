<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class SellProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'supply_id' => $this->supply_id,
            'category_id' => $this->category_id,
            'product_name' => $this->product_name,
            'image' => $this->image_url ? URL::to($this->image_url) : URL::to('images/products/not-available.jpeg'),
            'original_price' => $this->original_price,
            'discount' => json_decode($this->discount),
            'discount_data' => $this->discount_data,
            'discount_label' => $this->discount_label,
            'cost_per_piece' => $this->cost_per_piece,
            'batch_no' => $this->batch_no,
            'batch_stocks' => $this->batch_stocks,
        ];
    }
}
