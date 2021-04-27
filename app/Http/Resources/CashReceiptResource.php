<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CashReceiptResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'customer_name' => $this->customer->name,
            'user' => new UserResource($this->whenLoaded('user')),
            'amount' => $this->amount,
            'status' => $this->status,
            'date' => $this->date->format('d-M-Y'),
            'note' => $this->note,
            'created_at' => $this->created_at->format('d-m-Y H:i:s')
        ];
    }
}
