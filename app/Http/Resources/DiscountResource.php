<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Nette\Utils\DateTime;

class DiscountResource extends JsonResource
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
            'label' => $this->label,
            'type' => $this->type,
            'amount' => $this->amount,
            'start_date' => $this->start_date,
            'start_date_display' => $this->formatDate($this->start_date),
            'end_date' => $this->end_date,
            'end_date_display' => $this->formatDate($this->end_date),
            'purchase_quantity' => $this->purchase_quantity,
            'created_at' => $this->created_at,
        ];
    }

    private function formatDate($date)
    {
        $dateTime = DateTime::from($date);
        return $dateTime->format('d M Y');
    }
}
