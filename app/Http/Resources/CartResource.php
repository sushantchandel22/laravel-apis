<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'cart' => [
                'id' => $this->id,
                'user_id' => $this->user_id,
                'status' => $this->status,
               'cart_products' => CartProductResource::collection($this->cartProducts),
            ]
        ];
    }
}
