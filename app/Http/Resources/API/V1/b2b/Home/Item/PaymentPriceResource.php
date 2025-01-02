<?php

namespace App\Http\Resources\API\V1\b2b\Home\Item;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentPriceResource extends JsonResource
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
            'id'                  =>   $this->id,
            'payment_id'          =>   $this->payment_id,
            'final_price'         =>   $this->final_price,
            'payment_name'        =>   $this->getPayment->name,
            'payment_photo'       =>   $this->getPayment->photo,

        ];
    }
}
