<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'receipts' => CashReceiptResource::collection($this->whenLoaded('receipts')),
            'created_at' => $this->created_at->format('d-M-Y')
        ];
    }
}
