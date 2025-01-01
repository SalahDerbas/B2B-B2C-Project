<?php

namespace App\Http\Resources\API\V1\b2c\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'validity'                          => $this['validity'].' Days',
            'package'                           => $this['package'],
            'data'                              => $this['data'],
            'manual_installation'               => $this['manual_installation'],
            'qrcode_installation'               => $this['qrcode_installation'],
            'iccid'                             => collect($this['sims'][0])['iccid'],
            'qrcode'                            => collect($this['sims'][0])['qrcode'],
            'qrcode_url'                        => collect($this['sims'][0])['qrcode_url'],
            'direct_apple_installation_url'     => collect($this['sims'][0])['direct_apple_installation_url'],

        ];
    }
}
