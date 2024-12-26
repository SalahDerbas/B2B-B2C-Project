<?php

namespace App\Http\Resources\API\V1\b2c\Home;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\V1\b2c\Home\Category\CategoryResource;
use App\Http\Resources\API\V1\b2c\Home\Item\ItemsResource;
use App\Http\Resources\API\V1\b2c\Home\Category\SubCategoryResource;

class HomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $globalId = getValueLookups('C-Global');
        parent::toArray($request);
        return [
            'id'                =>   $this->id,
            'name'              =>   $this->name,
            'description'       =>   $this->description,
            'created_at'        =>   formatDate($this->created_at) ,
            'updated_at'        =>   formatDate($this->updated_at) ,
            'subs'              =>   ($this->id == $globalId) ? ItemsResource::collection($this->subs) : SubCategoryResource::collection($this->subs),
        ];
    }
}
