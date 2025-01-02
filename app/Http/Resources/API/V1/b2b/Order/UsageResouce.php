<?php

namespace App\Http\Resources\API\V1\b2b\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsageResouce extends JsonResource
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
            'remaining'               =>   $this['usagePackage']['remaining'],
            'total'                   =>   $this['usagePackage']['total'],
            'status'                  =>   $this['usagePackage']['status'],
            'expired_at'              =>   formatDate( $this['usagePackage']['expired_at']) ,
            'getItem'                 =>   $this->ItemResource($this),
        ];
    }

    public function ItemResource($data)
    {
        return [
                'id'                     =>   $data['getItemSource']['getItem']['id'],
                'capacity'               =>   $data['getItemSource']['getItem']['capacity'] ,
                'plan_type'              =>   $data['getItemSource']['getItem']['plan_type'] ,
                'validaty'               =>   $data['getItemSource']['getItem']['validaty'] ,
                'sub_category_id'        =>   $data['getItemSource']['getItem']['sub_category_id'] ,
                'sub_category_name'      =>   $data['getItemSource']['getItem']['getSubCategory']['name'],
                'coverages'              =>   json_decode($data['getItemSource']['getItem']['coverages']) ,
                'created_at'             =>   formatDate( $data['getItemSource']['getItem']['created_at']) ,
                'updated_at'             =>   formatDate( $data['getItemSource']['getItem']['updated_at']) ,
        ];

    }
}
