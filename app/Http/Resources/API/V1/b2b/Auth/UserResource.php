<?php

namespace App\Http\Resources\API\V1\b2b\Auth;

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
        parent::toArray($request);
        return [
            'id'                      => $this->id,
            'email'                   => $this->email,
            'usrename'                => $this->usrename,
            'name'                    => $this->name,
            'last_login'              => formatDate($this->last_login),
            'enable_notification'     => $this->enable_notification,
            'access_token'            => auth()->user()->createToken('b2b_b2c')->accessToken
        ];
    }
}
