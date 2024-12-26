<?php

namespace App\Http\Resources\API\Message;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'message'      => $this['message'],
            'code'         => $this['code'],
        ];
    }
}
