<?php

namespace App\Http\Resources\API\V1\b2b\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\V1\b2b\Order\OrderResource;
use App\Http\Resources\API\V1\b2b\Home\Item\ItemResource;

class PackagesResouce extends JsonResource
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
            'iccid'                   =>   $this['iccid'],
            'status_package'          =>   getValueByIDLookups($this['status_package']),
            'getItem'                 =>   $this->ItemResource($this),
            'order_data'              =>   new OrderResource($this['order_data']),
        ];
    }


    public function ItemResource($data)
    {
        return [
                'id'                     =>   $data['getItem']['id'],
                'capacity'               =>   $data['getItem']['capacity'] ,
                'plan_type'              =>   $data['getItem']['plan_type'] ,
                'validaty'               =>   $data['getItem']['validaty'] ,
                'sub_category_id'        =>   $data['getItem']['sub_category_id'] ,
                'sub_category_name'      =>   $data['getSubCategory']['name'],
                'coverages'              =>   json_decode($data['getItem']['coverages']) ,
                'created_at'             =>   formatDate( $data['getItem']['created_at']) ,
                'updated_at'             =>   formatDate( $data['getItem']['updated_at']) ,
        ];

    }

}
