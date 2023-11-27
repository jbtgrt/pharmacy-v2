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
            'batch_no' => $this->batch_no,
            'category_id' => $this->category_id,
            'category_name' => $this->category_name,
            'brand_id' => $this->brand_id,
            'brand_name' => $this->brand_name,
            'barcode' => $this->barcode,
            'product_name' => $this->product_name,
            'classification' => $this->classification,
            'product_type' => $this->product_type,
            'formulation' => $this->formulation,
            'description' => $this->description,
            'image' => $this->image_url ? URL::to($this->image_url) : URL::to('images/products/not-available.jpeg'),
            'status' => $this->status,
            'created_at' => (new DateTime($this->created_at))->format('Y-m-d')
        ];
    }
}
