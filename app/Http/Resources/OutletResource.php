<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class OutletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'outletId' => $this->id,
            'outletName' => $this->name,
            'outletPicture'=>$this->picture,
            'outletAddress'=>$this->address,
            'outletLatitude'=>$this->latitude,
            'outletLongitude'=>$this->longitude,
            'brandId'=>$this->brand_id,

        ];
    }
}
