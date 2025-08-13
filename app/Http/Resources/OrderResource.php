<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\OrderItemResource;
class OrderResource extends JsonResource
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
            'order_id' => $this->order_id,
            'total' => $this->total_amount,
            'status' => $this->status,
            'ordered_at' => $this->created_at->toDateTimeString(),
            // PROBLEM #3: You are trying to use "OrderItemResource" (with the 'r')
            // This does NOT match what you imported in Problem #1.
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
        ];

    }
}
