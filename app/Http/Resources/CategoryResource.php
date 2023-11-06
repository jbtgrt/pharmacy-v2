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
            'type' => $this->type,
            'category_name' => $this->category_name,
            'description' => $this->description,
            'data' => json_decode($this->data),
            'created_at' => (new DateTime($this->created_at))->format('Y-m-d')
        ];
    }
}
