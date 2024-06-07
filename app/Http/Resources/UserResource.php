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
            'username'=>$this->username,
            'email' => $this->email,
            'name' => [
                "firstname"=>$this->firstname,
                "lastname"=>$this->lastname,
            ],
            'address' => $this->when($this->address, function () {
                return [
                    "street"=>$this->address->street,
                    "city"=>$this->address->city,
                    'zipcode'=>$this->address->zipcode,
                    'geolocation'=>[
                        'lang'=>$this->address->longitude,
                        'lat'=>$this->address->latitude,
                    ],
                    'phone'=>$this->address->phone,
                ];
            }),
        ];
    }
}