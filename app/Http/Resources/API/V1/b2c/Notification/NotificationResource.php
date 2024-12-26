<?php

namespace App\Http\Resources\API\V1\b2c\Notification;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
                'id'                     => $this->id,
                'title'                  => $this->title,
                'body'                   => $this->body,
                'user_id'                => $this->user_id,
                'created_at'             => formatDate($this->created_at) ,
                'updated_at'             => formatDate($this->updated_at) ,
        ];
    }
}
