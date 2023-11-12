<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Nette\Utils\DateTime;
use Illuminate\Support\Facades\URL;

class ProductSupplyResource extends JsonResource
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
            'product_name' => $this->product_name,
            'category_id' => $this->category_id,
            'category_name' => $this->category_name,
            'brand_id' => $this->brand_id,
            'brand_name' => $this->brand_name,
            'supplier_id' => $this->supplier_id,
            'batch_no' => $this->batch_no,
            'unit_cost' => $this->unit_cost,
            'quantity' => $this->quantity,
            'total_cost' => $this->total_cost,
            'storage_location' => $this->storage_location,
            'notes' => $this->notes,
            'product_description' => $this->product_description,
            'purchase_description' => $this->description,
            'date_received' => $this->date_received,
            'expires_at' => $this->expires_at,
            'image' => $this->image_url ? URL::to($this->image_url) : URL::to('images/products/not-available.jpeg'),
            'status' => $this->status,
            'created_at' => (new DateTime($this->created_at))->format('Y-m-d')
        ];
    }
}
