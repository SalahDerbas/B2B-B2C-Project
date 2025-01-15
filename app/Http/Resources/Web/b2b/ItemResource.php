<?php

namespace App\Http\Resources\Web\b2b;

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
        parent::toArray($request);
        return [
            'id'             =>  $this->id,
            'name'           =>  $this->getSubCategory->name,
            'capacity'       =>  $this->capacity,
            'plan_type'      =>  $this->plan_type,
            'validaty'       =>  $this->validaty,
            'final_price'    =>  $this->getItemSource->getPaymentPriceB2b->final_price,
            'created_at'     =>  $this->created_at,

        ];
    }
}
