<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id' => $this->prdt_id,
            'name' => $this->prdt_name,
            'description' => $this->prdt_description,
            'price' => $this->prdt_price,
            'stock' => $this->stock_quantity,
        ];
    }
}
