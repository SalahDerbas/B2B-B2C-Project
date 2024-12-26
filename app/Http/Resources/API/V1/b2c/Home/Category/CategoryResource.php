<?php

namespace App\Http\Resources\API\V1\b2c\Home\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'id'               =>   $this->id,
            'name'             =>   $this->name,
            'description'      =>   $this->description,
            'hasSubCategory'   =>   $this->hasSubCategory,
            'created_at'       =>   formatDate($this->created_at) ,
            'updated_at'       =>   formatDate($this->updated_at) ,

        ];
    }
}
