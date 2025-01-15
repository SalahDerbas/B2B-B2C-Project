<?php

namespace App\Http\Resources\Web\b2b;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillingResource extends JsonResource
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
            'number_id'     =>  $this->number_id,
            'amount'        =>  $this->amount,
            'issue_date'    =>  formatDate($this->issue_date),
            'due_date'      =>  formatDate($this->due_date),
            'email'         =>  $this->getUser->email,
            'payment'       =>  $this->getPayment->name,
            'status'        =>  $this->getStatus->value,
        ];
    }
}
