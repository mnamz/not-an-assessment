<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            'name' => $this->name,
            'price' => $this->price,
            'details' => $this->details,
            'image' => $this->image,
            'restaurant_id' => $this->restaurant_id,
            'restaurant' => new RestaurantResource($this->whenLoaded('restaurant')),
        ];
    }
}
