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
            'unit_id' => $this->unit_id,
            'unit_name' => $this->unit_name,
            'staff_id' => $this->staff_id,
            'supplier_id' => $this->supplier_id,
            'staff_name' => $this->staff_fname.' '.$this->staff_lname,
            'supplier_name' => $this->supplier_fname.' '.$this->supplier_lname,
            'batch_no' => $this->batch_no,
            
            'unit_quantity' => $this->unit_quantity,
            'quantity_per_unit' => $this->quantity_per_unit,
            'unit_cost' => $this->unit_cost,
            'total_cost' => $this->total_cost,
            'batch_stocks' => $this->batch_stocks,
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
