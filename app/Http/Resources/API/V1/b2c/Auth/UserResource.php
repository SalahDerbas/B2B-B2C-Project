<?php

namespace App\Http\Resources\API\V1\b2c\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Passport\PersonalAccessTokenResult;
use Laravel\Passport\PersonalAccessTokenFactory;

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
            'phone'                   => $this->phone,
            'country_id'              => $this->country_id,
            'photo'                   => $this->photo,
            'last_login'              => formatDate($this->last_login),
            'enable_notification'     => $this->enable_notification,
            'fcm_token'               => $this->fcm_token,
            'verify'                  => is_null($this->email_verified_at) ? False : True,
            'access_token'            => auth()->user()->createToken('b2b_b2c')->accessToken

        ];
    }
}
