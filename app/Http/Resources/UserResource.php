<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_name' => $this->user_name,
            'user_email' => $this->user_email,
<<<<<<< HEAD
=======
            'status' => $this->status,
>>>>>>> 141a7ee (Updated project with new controllers, requests, factories, and migrations)
            'mobile' => $this->mobile,
            'shipping_address' => [
                'line1' => $this->shipping_address_line_1,
                'line2' => $this->shipping_address_line_2,
                'city' => $this->shipping_city,
                'state' => $this->shipping_state,
                'postal_code' => $this->shipping_postal_code,
                'country' => $this->shipping_country,
            ],
            'created_at' => $this->created_at->toDateTimeString(),
<<<<<<< HEAD
=======
            'deleted_at' => $this->when($this->trashed(), $this->deleted_at),
>>>>>>> 141a7ee (Updated project with new controllers, requests, factories, and migrations)
        ];
    }
}
