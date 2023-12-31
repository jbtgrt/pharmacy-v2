<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Nette\Utils\DateTime;

class RoleResource extends JsonResource
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
            'role' => $this->role,
            'description' => $this->description,
            'created_at' => (new DateTime($this->created_at))->format('Y-m-d')
        ];
    }
}
