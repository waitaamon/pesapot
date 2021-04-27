<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'payments' => CashPaymentResource::collection($this->whenLoaded('payments')),
            'created_at' => $this->created_at->format('d-M-Y')
        ];
    }
}
