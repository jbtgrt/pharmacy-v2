<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Nette\Utils\DateTime;

class CategoryResource extends JsonResource
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
            'category_name' => $this->category_name,
            'details_data' => json_decode($this->details_data),
            'created_at' => (new DateTime($this->created_at))->format('Y-m-d')
        ];
    }
}
