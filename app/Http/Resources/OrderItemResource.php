<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'quantity' => $this->item_quantity,
            'price_at_purchase' => $this->item_price,
            'product' => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
