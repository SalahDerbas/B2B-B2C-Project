<?php

namespace App\Http\Resources\API\V1\b2c\Home\Item;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemsResource extends JsonResource
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
            'id'                     =>   $this->id,
            'capacity'               =>   $this->capacity ,
            'plan_type'              =>   $this->plan_type ,
            'validaty'               =>   $this->validaty ,
            'sub_category_id'        =>   $this->sub_category_id ,
            'sub_category_name'      =>   $this->getSubCategory->name,
            'item_source_id'         =>   $this->getItemSource->id,
            'source_id'              =>   $this->getItemSource->source_id,
            'cost_price'             =>   $this->getItemSource->cost_price,
            'coverages'              =>   json_decode($this->coverages) ,
            'created_at'             =>   formatDate($this->created_at) ,
            'updated_at'             =>   formatDate($this->updated_at) ,
        ];
    }
}
