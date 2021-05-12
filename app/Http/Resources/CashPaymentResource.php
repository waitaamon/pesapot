<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CashPaymentResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'supplier' => new SupplierResource($this->whenLoaded('supplier')),
            'supplier_name' => $this->supplier->name,
            'supplier_id' => $this->supplier->id,
            'user' => new UserResource($this->whenLoaded('user')),
            'amount' => $this->amount,
            'status' => $this->status,
            'date' => $this->date->format('d-M-Y'),
            'note' => $this->note,
            'created_at' => $this->created_at->format('d-m-Y H:i:s')
        ];
    }
}
