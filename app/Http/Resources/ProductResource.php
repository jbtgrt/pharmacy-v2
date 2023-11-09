<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Nette\Utils\DateTime;
use Illuminate\Support\Facades\URL;

class ProductResource extends JsonResource
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
            'category_id' => $this->category_id,
            'category_name' => $this->category_name,
            'brand_id' => $this->brand_id,
            'brand_name' => $this->brand_name,
            'unit_id' => $this->unit_id,
            'unit_name' => $this->unit_name,
            'product_name' => $this->product_name,
            'product_code' => $this->product_code,
            'product_price' => $this->product_price,
            'description' => $this->description,
            'image' => $this->image_url ? URL::to($this->image_url) : 'products/not-available.jpeg',
            'expires_at' => $this->expires_at,
            'status' => $this->status,
            'created_at' => (new DateTime($this->created_at))->format('Y-m-d')
        ];
    }
}
